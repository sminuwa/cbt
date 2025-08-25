<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Controller;
use App\Imports\Upload;
use App\Models\TestConfig;
use App\Models\Candidate;
use App\Models\Centre;
use App\Models\Subject;
use App\Models\ScheduledCandidate;
use App\Models\CandidateSubject;
use App\Models\Scheduling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class TestConfigControllerOptimized extends Controller
{
    public function batchScheduleCandidates(Request $request, $config_id)
    {
        // Set memory and execution limits for large files
        ini_set('memory_limit', '2G');
        ini_set('max_execution_time', 1200); // 10 minutes
        
        try {
            $request->validate([
                'file' => 'required|mimes:xls,xlsx,csv|max:51200', // Increased to 50MB
                'test_config_id' => 'required|exists:test_configs,id',
                'default_date' => 'nullable|date',
                'scheduling_mode' => 'required|in:auto,create,existing',
                'overwrite_existing_schedules' => 'nullable'
            ]);

            $testConfig = TestConfig::find($config_id);
            if (!$testConfig) {
                return response()->json([
                    'success' => false,
                    'message' => 'Test configuration not found.'
                ], 404);
            }

            // For very large files, use queue processing
            if ($request->file('file')->getSize() > 5 * 1024 * 1024) { // 5MB
                return $this->queueBatchProcessing($request, $config_id);
            }

            return $this->processInMemory($request, $config_id, $testConfig);

        } catch (Exception $e) {
            Log::error('Batch scheduling error: ' . $e->getMessage(), [
                'config_id' => $config_id,
                'file_size' => $request->file('file')->getSize()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error processing batch scheduling: ' . $e->getMessage()
            ], 500);
        }
    }

    private function processInMemory(Request $request, $config_id, TestConfig $testConfig)
    {
        $file = $request->file('file');
        $processedCount = 0;
        $errorCount = 0;
        $errors = [];

        DB::beginTransaction();
        
        try {
            // Load Excel data in chunks to reduce memory usage
            $sheets = Excel::toArray(new Upload, $file);
            
            if (empty($sheets) || empty($sheets[0])) {
                throw new Exception('No data found in Excel file');
            }

            $rows = $sheets[0];
            $titleRow = $rows[0];
            
            // Find column indexes
            $indexingCol = $this->searchColumnIndex($titleRow, 'indexing');
            $centreCol = $this->searchColumnIndex($titleRow, 'centre');
            $paperCol = $this->searchColumnIndex($titleRow, 'paper');
            
            if ($indexingCol === null || $centreCol === null) {
                throw new Exception('Required columns (indexing, centre) not found in Excel file');
            }

            // Pre-load all data to avoid N+1 queries
            $dataCollection = $this->preprocessExcelData($rows, $indexingCol, $centreCol, $paperCol);
            
            // Load subjects as keyed array for faster lookup
            $subjects = Subject::select('id', 'subject_code')
                ->get()
                ->keyBy('subject_code')
                ->toArray();
            
            // Load candidates in batches
            $candidates = Candidate::select('id', 'indexing')
                ->whereIn('indexing', $dataCollection['indexings'])
                ->get()
                ->keyBy('indexing')
                ->toArray();
                
            // Load centres with venues
            $centres = Centre::select('id', 'name')
                ->with(['venues' => function($query) {
                    $query->select('id', 'centre_id')->limit(1);
                }])
                ->whereIn('name', $dataCollection['centre_names'])
                ->get()
                ->keyBy('name');

            // Process in smaller batches to avoid memory issues
            $batchSize = 500;
            $totalRows = count($dataCollection['rows']);
            
            for ($offset = 0; $offset < $totalRows; $offset += $batchSize) {
                $batch = array_slice($dataCollection['rows'], $offset, $batchSize);
                
                $result = $this->processBatch(
                    $batch, 
                    $candidates, 
                    $centres, 
                    $subjects, 
                    $config_id, 
                    $testConfig, 
                    $request
                );
                
                $processedCount += $result['processed'];
                $errorCount += $result['errors'];
                $errors = array_merge($errors, $result['error_messages']);
                
                // Clear memory periodically
                if ($offset % 2000 === 0) {
                    gc_collect_cycles();
                }
            }

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => "Processed {$processedCount} candidates with {$errorCount} errors",
                'details' => [
                    'processed' => $processedCount,
                    'errors' => $errorCount,
                    'total' => $totalRows
                ],
                'error_details' => array_slice($errors, 0, 100) // Limit error details
            ]);
            
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function preprocessExcelData($rows, $indexingCol, $centreCol, $paperCol)
    {
        $indexings = [];
        $centreNames = [];
        $processedRows = [];
        
        foreach ($rows as $key => $row) {
            if ($key < 1 || empty($row[$indexingCol])) continue;
            
            $candidateIndexing = trim($row[$indexingCol]);
            $centreName = trim($row[$centreCol]);
            $papers = isset($row[$paperCol]) ? trim($row[$paperCol]) : '';
            
            $indexings[] = $candidateIndexing;
            $centreNames[] = $centreName;
            
            $processedRows[] = [
                'indexing' => $candidateIndexing,
                'centre' => $centreName,
                'papers' => $papers
            ];
        }
        
        return [
            'indexings' => array_unique($indexings),
            'centre_names' => array_unique($centreNames),
            'rows' => $processedRows
        ];
    }

    private function processBatch($batch, $candidates, $centres, $subjects, $config_id, $testConfig, $request)
    {
        $processedCount = 0;
        $errorCount = 0;
        $errors = [];
        
        $scheduledCandidatesData = [];
        $candidateSubjectsData = [];
        $scheduleCache = [];
        
        foreach ($batch as $row) {
            try {
                $candidateIndexing = $row['indexing'];
                $centreName = $row['centre'];
                $papers = $row['papers'];
                
                // Check if candidate exists (array lookup is faster than DB query)
                if (!isset($candidates[$candidateIndexing])) {
                    $errors[] = "Candidate not found: {$candidateIndexing}";
                    $errorCount++;
                    continue;
                }
                
                $candidate = $candidates[$candidateIndexing];
                
                // Check if centre exists
                if (!$centres->has($centreName)) {
                    $errors[] = "Centre not found: {$centreName}";
                    $errorCount++;
                    continue;
                }
                
                $centre = $centres->get($centreName);
                if (empty($centre->venues)) {
                    $errors[] = "No venues found for centre: {$centreName}";
                    $errorCount++;
                    continue;
                }
                
                $venueId = $centre->venues[0]->id;
                
                // Get or create schedule (cached)
                $scheduleKey = $config_id . '_' . $venueId;
                if (!isset($scheduleCache[$scheduleKey])) {
                    $schedule = $this->findOrCreateSchedule(
                        $config_id, 
                        $venueId, 
                        $request->default_date, 
                        $request->scheduling_mode
                    );
                    
                    if (!$schedule) {
                        $errors[] = "Could not create schedule for {$centreName}";
                        $errorCount++;
                        continue;
                    }
                    
                    $scheduleCache[$scheduleKey] = $schedule;
                } else {
                    $schedule = $scheduleCache[$scheduleKey];
                }
                
                // Prepare scheduled candidate data
                $scheduledCandidatesData[] = [
                    'candidate_id' => $candidate['id'],
                    'exam_type_id' => $testConfig->exam_type_id ?? 1,
                    'schedule_id' => $schedule->id,
                ];
                
                // Process papers
                if (!empty($papers)) {
                    $paperCodes = array_map('trim', explode(',', $papers));
                    foreach ($paperCodes as $paperCode) {
                        if (isset($subjects[$paperCode])) {
                            $candidateSubjectsData[] = [
                                'candidate_id' => $candidate['id'],
                                'schedule_id' => $schedule->id,
                                'subject_id' => $subjects[$paperCode]['id'],
                                'enabled' => 1
                            ];
                        }
                    }
                }
                
                $processedCount++;
                
            } catch (Exception $e) {
                $errors[] = "Error processing {$candidateIndexing}: " . $e->getMessage();
                $errorCount++;
            }
        }
        
        // Batch insert scheduled candidates
        if (!empty($scheduledCandidatesData)) {
            // Remove existing if overwriting
            if ($request->overwrite_existing_schedules) {
                $candidateIds = array_column($scheduledCandidatesData, 'candidate_id');
                ScheduledCandidate::whereIn('candidate_id', $candidateIds)
                    ->where('exam_type_id', $testConfig->exam_type_id ?? 1)
                    ->delete();
            }
            
            // Insert in chunks
            foreach (array_chunk($scheduledCandidatesData, 1000) as $chunk) {
                ScheduledCandidate::upsert($chunk, ['candidate_id', 'exam_type_id', 'schedule_id']);
            }
        }
        
        // Batch insert candidate subjects
        if (!empty($candidateSubjectsData)) {
            // Get scheduled candidate IDs for the subjects
            $candidateIds = array_unique(array_column($candidateSubjectsData, 'candidate_id'));
            $scheduledCandidates = ScheduledCandidate::select('id', 'candidate_id', 'schedule_id')
                ->whereIn('candidate_id', $candidateIds)
                ->get()
                ->keyBy(function($item) {
                    return $item->candidate_id . '_' . $item->schedule_id;
                });
            
            $subjectsToInsert = [];
            foreach ($candidateSubjectsData as $subjectData) {
                $key = $subjectData['candidate_id'] . '_' . $subjectData['schedule_id'];
                if ($scheduledCandidates->has($key)) {
                    $subjectsToInsert[] = [
                        'scheduled_candidate_id' => $scheduledCandidates->get($key)->id,
                        'subject_id' => $subjectData['subject_id'],
                        'schedule_id' => $subjectData['schedule_id'],
                        'enabled' => 1
                    ];
                }
            }
            
            foreach (array_chunk($subjectsToInsert, 1000) as $chunk) {
                CandidateSubject::upsert($chunk, ['scheduled_candidate_id', 'subject_id']);
            }
        }
        
        return [
            'processed' => $processedCount,
            'errors' => $errorCount,
            'error_messages' => $errors
        ];
    }

    private function queueBatchProcessing(Request $request, $config_id)
    {
        // For very large files, process via queue
        $filePath = $request->file('file')->store('temp');
        
        // Dispatch job to process in background
        \App\Jobs\BatchScheduleCandidatesJob::dispatch([
            'file_path' => $filePath,
            'config_id' => $config_id,
            'default_date' => $request->default_date,
            'scheduling_mode' => $request->scheduling_mode,
            'overwrite_existing_schedules' => $request->overwrite_existing_schedules
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Large file detected. Processing in background. You will be notified when complete.',
            'queued' => true
        ]);
    }

    private function searchColumnIndex($titleRow, $searchTerm)
    {
        foreach ($titleRow as $index => $value) {
            if (stripos(strtolower($value), strtolower($searchTerm)) !== false) {
                return $index;
            }
        }
        return null;
    }

    private function findOrCreateSchedule($configId, $venueId, $defaultDate, $mode)
    {
        // First try to find existing schedule
        $existingSchedule = Scheduling::where([
            'test_config_id' => $configId,
            'venue_id' => $venueId
        ])
        ->when($defaultDate, function($query, $date) {
            return $query->where('date', $date);
        })
        ->first();

        if ($existingSchedule) {
            return $existingSchedule;
        }

        // If mode is 'existing', don't create new schedules
        if ($mode === 'existing') {
            return null;
        }

        // Create new schedule
        if ($mode === 'create' || $mode === 'auto') {
            return Scheduling::create([
                'test_config_id' => $configId,
                'venue_id' => $venueId,
                'date' => $defaultDate ?: now()->addDays(7)->format('Y-m-d'),
                'maximum_batch' => 1,
                'no_per_schedule' => 50,
                'daily_start_time' => '08:00',
                'daily_end_time' => '17:00'
            ]);
        }

        return null;
    }
}