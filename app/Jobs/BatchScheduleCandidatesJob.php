<?php

namespace App\Jobs;

use App\Models\TestConfig;
use App\Models\Candidate;
use App\Models\Centre;
use App\Models\Subject;
use App\Models\ScheduledCandidate;
use App\Models\CandidateSubject;
use App\Models\Scheduling;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class BatchScheduleCandidatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $params;
    public $timeout = 1800; // 30 minutes
    public $tries = 1;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function handle()
    {
        // Set high memory limit for large files
        ini_set('memory_limit', '4G');
        
        $filePath = $this->params['file_path'];
        $configId = $this->params['config_id'];
        
        try {
            Log::info('Starting batch processing job', ['config_id' => $configId]);
            
            $testConfig = TestConfig::find($configId);
            if (!$testConfig) {
                throw new Exception('Test configuration not found');
            }

            // Process file using chunked reading to minimize memory usage
            $this->processLargeFile($filePath, $configId, $testConfig);
            
            // Clean up temporary file
            Storage::delete($filePath);
            
            Log::info('Batch processing completed successfully', ['config_id' => $configId]);
            
        } catch (Exception $e) {
            Log::error('Batch processing job failed', [
                'config_id' => $configId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Clean up on failure
            Storage::delete($filePath);
            throw $e;
        }
    }

    private function processLargeFile($filePath, $configId, TestConfig $testConfig)
    {
        $fullPath = Storage::path($filePath);
        $processedCount = 0;
        $errorCount = 0;
        
        // Use streaming to read Excel file in chunks
        Excel::filter('chunk')->load($fullPath)->chunk(1000, function($results) use (&$processedCount, &$errorCount, $configId, $testConfig) {
            
            DB::beginTransaction();
            
            try {
                // Process this chunk
                $result = $this->processChunk($results, $configId, $testConfig);
                $processedCount += $result['processed'];
                $errorCount += $result['errors'];
                
                DB::commit();
                
                // Log progress every 1000 records
                Log::info("Processed chunk: {$processedCount} total candidates", [
                    'config_id' => $configId,
                    'errors' => $errorCount
                ]);
                
            } catch (Exception $e) {
                DB::rollBack();
                Log::error('Error processing chunk', [
                    'config_id' => $configId,
                    'error' => $e->getMessage()
                ]);
                throw $e;
            }
        });
        
        Log::info('Large file processing completed', [
            'config_id' => $configId,
            'processed' => $processedCount,
            'errors' => $errorCount
        ]);
    }

    private function processChunk($results, $configId, TestConfig $testConfig)
    {
        $processedCount = 0;
        $errorCount = 0;
        
        // Pre-load reference data for this chunk
        $indexings = [];
        $centreNames = [];
        
        foreach ($results as $row) {
            if (!empty($row->indexing)) $indexings[] = trim($row->indexing);
            if (!empty($row->centre)) $centreNames[] = trim($row->centre);
        }
        
        // Load candidates and centres for this chunk
        $candidates = Candidate::select('id', 'indexing')
            ->whereIn('indexing', $indexings)
            ->get()
            ->keyBy('indexing');
            
        $centres = Centre::select('id', 'name')
            ->with(['venues' => function($query) {
                $query->select('id', 'centre_id')->limit(1);
            }])
            ->whereIn('name', $centreNames)
            ->get()
            ->keyBy('name');
            
        $subjects = Subject::select('id', 'subject_code')
            ->get()
            ->keyBy('subject_code');
        
        $scheduledCandidatesData = [];
        $candidateSubjectsData = [];
        $scheduleCache = [];
        
        foreach ($results as $row) {
            try {
                $candidateIndexing = trim($row->indexing);
                $centreName = trim($row->centre);
                $papers = isset($row->paper) ? trim($row->paper) : '';
                
                if (empty($candidateIndexing) || empty($centreName)) {
                    continue;
                }
                
                // Validate candidate exists
                if (!$candidates->has($candidateIndexing)) {
                    $errorCount++;
                    continue;
                }
                
                $candidate = $candidates->get($candidateIndexing);
                
                // Validate centre exists
                if (!$centres->has($centreName) || empty($centres->get($centreName)->venues)) {
                    $errorCount++;
                    continue;
                }
                
                $centre = $centres->get($centreName);
                $venueId = $centre->venues[0]->id;
                
                // Get or create schedule
                $scheduleKey = $configId . '_' . $venueId;
                if (!isset($scheduleCache[$scheduleKey])) {
                    $schedule = $this->findOrCreateSchedule($configId, $venueId, $this->params['default_date'], $this->params['scheduling_mode']);
                    if (!$schedule) {
                        $errorCount++;
                        continue;
                    }
                    $scheduleCache[$scheduleKey] = $schedule;
                }
                
                $schedule = $scheduleCache[$scheduleKey];
                
                // Add to batch data
                $scheduledCandidatesData[] = [
                    'candidate_id' => $candidate->id,
                    'exam_type_id' => $testConfig->exam_type_id ?? 1,
                    'schedule_id' => $schedule->id,
                ];
                
                // Process papers
                if (!empty($papers)) {
                    $paperCodes = array_map('trim', explode(',', $papers));
                    foreach ($paperCodes as $paperCode) {
                        if ($subjects->has($paperCode)) {
                            $candidateSubjectsData[] = [
                                'candidate_id' => $candidate->id,
                                'schedule_id' => $schedule->id,
                                'subject_id' => $subjects->get($paperCode)->id,
                                'enabled' => 1
                            ];
                        }
                    }
                }
                
                $processedCount++;
                
            } catch (Exception $e) {
                $errorCount++;
                Log::warning('Error processing individual record', [
                    'indexing' => $candidateIndexing ?? 'unknown',
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        // Batch insert data
        if (!empty($scheduledCandidatesData)) {
            // Handle overwrite if specified
            if ($this->params['overwrite_existing_schedules']) {
                $candidateIds = array_column($scheduledCandidatesData, 'candidate_id');
                ScheduledCandidate::whereIn('candidate_id', $candidateIds)
                    ->where('exam_type_id', $testConfig->exam_type_id ?? 1)
                    ->delete();
            }
            
            // Insert scheduled candidates
            ScheduledCandidate::upsert($scheduledCandidatesData, ['candidate_id', 'exam_type_id', 'schedule_id']);
            
            // Insert candidate subjects if any
            if (!empty($candidateSubjectsData)) {
                $this->insertCandidateSubjects($candidateSubjectsData);
            }
        }
        
        return [
            'processed' => $processedCount,
            'errors' => $errorCount
        ];
    }

    private function insertCandidateSubjects($candidateSubjectsData)
    {
        // Get scheduled candidate IDs
        $candidateIds = array_unique(array_column($candidateSubjectsData, 'candidate_id'));
        $scheduleIds = array_unique(array_column($candidateSubjectsData, 'schedule_id'));
        
        $scheduledCandidates = ScheduledCandidate::select('id', 'candidate_id', 'schedule_id')
            ->whereIn('candidate_id', $candidateIds)
            ->whereIn('schedule_id', $scheduleIds)
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
        
        if (!empty($subjectsToInsert)) {
            CandidateSubject::upsert($subjectsToInsert, ['scheduled_candidate_id', 'subject_id']);
        }
    }

    private function findOrCreateSchedule($configId, $venueId, $defaultDate, $mode)
    {
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

        if ($mode === 'existing') {
            return null;
        }

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