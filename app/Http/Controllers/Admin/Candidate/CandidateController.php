<?php

namespace App\Http\Controllers\Admin\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        // Get unique exam years for filter
        $examYears = Candidate::select('exam_year')->distinct()->orderBy('exam_year', 'desc')->pluck('exam_year');
        
        // Get test codes for filter dropdown
        $testCodes = \App\Models\TestCode::orderBy('name')->get();
        
        return view('pages.admin.candidate.manage', compact('examYears', 'testCodes'));
    }

    public function getData(Request $request)
    {
        $query = Candidate::with('testCode');
        
        // Apply filters
        if ($request->filled('exam_year')) {
            $query->where('exam_year', $request->exam_year);
        }

        if ($request->filled('programme_id')) {
            $query->where('programme_id', $request->programme_id);
        }

        // Handle DataTables search
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function($q) use ($search) {
                $q->where('indexing', 'like', "%{$search}%")
                  ->orWhere('firstname', 'like', "%{$search}%")
                  ->orWhere('surname', 'like', "%{$search}%")
                  ->orWhere('other_names', 'like', "%{$search}%");
            });
        }

        // Get total records count
        $totalRecords = $query->count();

        // Handle ordering
        if ($request->filled('order')) {
            $orderColumnIndex = $request->input('order.0.column');
            $orderDirection = $request->input('order.0.dir');
            
            $columns = ['id', 'passport', 'actions', 'indexing', 'firstname', 'gender', 'dob', 'programme_id', 'exam_year', 'attempt', 'enabled', 'registration_id'];
            
            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDirection);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Handle pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 50);
        
        $candidates = $query->skip($start)->take($length)->get();

        // Prepare data for DataTables
        $data = [];
        foreach ($candidates as $index => $candidate) {
            // Action buttons matching active.blade.php style
            $actionButtons = '
                <div class="btn-group dropend" role="group">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-popper-placement="right-start" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item view-candidate" data-id="'.$candidate->id.'" data-indexing="'.$candidate->indexing.'">
                            <i class="las la-eye"></i> View
                        </button>
                        <button class="dropdown-item edit-candidate" data-id="'.$candidate->id.'" data-indexing="'.$candidate->indexing.'">
                            <i class="las la-edit"></i> Edit
                        </button>
                        <button class="dropdown-item delete-candidate" data-id="'.$candidate->id.'" data-indexing="'.$candidate->indexing.'">
                            <i class="las la-trash"></i> Delete
                        </button>
                    </div>
                </div>';
            
            // Passport image
            $passportImage = '<img class="img-fluid table-avtar" src="' . $candidate->passport() . '" alt="Passport" style="border-radius: 50%; object-fit: cover;">';
            
            $data[] = [
                'DT_RowIndex' => "",
                'passport' => $passportImage,
                'actions' => $actionButtons,
                'indexing' => '<strong>' . $candidate->indexing . '</strong>',
                'fullname' => $candidate->fullname(),
                'gender' => $candidate->gender,
                'dob' => $candidate->dob,
                'test_code' => $candidate->testCode->name ?? 'N/A',
                'exam_year' => $candidate->exam_year,
                'attempt' => $candidate->attempt,
                'status' => $candidate->enabled 
                    ? '<span class="badge bg-success">Active</span>' 
                    : '<span class="badge bg-danger">Inactive</span>',
                'registration_id' => $candidate->registration_id
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ]);
    }

    public function pullCandidates(Request $request)
    {
        try {
            $headers = [
                'Authorization' => 'Bearer your-token-here',
                'Accept' => 'application/json',
                'Custom-Header' => 'custom-value'
            ];
            
            $response = Http::withHeaders($headers)->get('https://app.chprbn.gov.ng/push-candidate');
            
            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch candidates from external API'
                ], 500);
            }
            
            $candidates = $response->json();
            
            if (empty($candidates)) {
                return response()->json([
                    'success' => true,
                    'message' => 'No new candidates found to pull',
                    'count' => 0
                ]);
            }
            
            $updatedCount = 0;
            foreach(array_chunk($candidates, 500) as $candidateBatch){
                if(Candidate::upsert($candidateBatch, ['indexing'])) {
                    $updatedCount += count($candidateBatch);
                } else {
                    reset_auto_increment('candidates');
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => "Successfully pulled and updated {$updatedCount} candidates from external source",
                'count' => $updatedCount
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error pulling candidates: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $candidate = Candidate::with('testCode')->find($id);
            
            if (!$candidate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Candidate not found'
                ], 404);
            }

            // Get scheduling information using direct database query to avoid relationship issues
            $schedules = DB::table('candidates')
                ->join('scheduled_candidates', 'scheduled_candidates.candidate_id', '=', 'candidates.id')
                ->join('candidate_subjects', 'candidate_subjects.scheduled_candidate_id', '=', 'scheduled_candidates.id')
                ->join('schedulings', 'schedulings.id', '=', 'candidate_subjects.schedule_id')
                ->leftJoin('venues', 'venues.id', '=', 'schedulings.venue_id')
                ->leftJoin('centres', 'centres.id', '=', 'venues.centre_id')
                ->leftJoin('test_configs', 'test_configs.id', '=', 'schedulings.test_config_id')
                ->leftJoin('subjects', 'subjects.id', '=', 'candidate_subjects.subject_id')
                ->where('candidates.id', $id)
                ->select([
                    'centres.name as centre_name',
                    'venues.name as venue_name', 
                    'test_configs.session as test_session',
                    'subjects.name as subject_name',
                    'subjects.subject_code as subject_code',
                    'schedulings.date as schedule_date'
                ])
                ->get()
                ->map(function ($scheduling) {
                    return [
                        'centre' => $scheduling->centre_name ?? 'N/A',
                        'venue' => $scheduling->venue_name ?? 'N/A',
                        'test_config' => $scheduling->test_session ?? 'N/A',
                        'subject' => ($scheduling->subject_code ?? '') . ' - ' . ($scheduling->subject_name ?? 'N/A'),
                        'date' => $scheduling->schedule_date ?? 'N/A'
                    ];
                })
                ->toArray();

            $candidateData = [
                'id' => $candidate->id,
                'indexing' => $candidate->indexing,
                'firstname' => $candidate->firstname,
                'surname' => $candidate->surname,
                'other_names' => $candidate->other_names,
                'gender' => $candidate->gender,
                'dob' => $candidate->dob,
                'programme_id' => $candidate->programme_id,
                'test_code' => $candidate->testCode->name ?? 'N/A',
                'exam_year' => $candidate->exam_year,
                'attempt' => $candidate->attempt,
                'enabled' => $candidate->enabled,
                'registration_id' => $candidate->registration_id,
                'schedules' => $schedules,
                'nin' => $candidate->nin ?? '',
                'created_at' => $candidate->created_at ? $candidate->created_at->format('Y-m-d H:i:s') : 'N/A',
                'updated_at' => $candidate->updated_at ? $candidate->updated_at->format('Y-m-d H:i:s') : 'N/A'
            ];

            return response()->json([
                'success' => true,
                'candidate' => $candidateData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching candidate details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'indexing' => 'required|string|max:255|unique:candidates,indexing,' . $id,
                'firstname' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'other_names' => 'nullable|string|max:255',
                'gender' => 'required|in:Male,Female',
                'dob' => 'required|date',
                'programme_id' => 'required|exists:test_codes,id',
                'exam_year' => 'required|integer|min:2020|max:2030',
                'attempt' => 'required|integer|min:1|max:3',
                'enabled' => 'required|boolean',
                'registration_id' => 'nullable|integer'
            ]);

            $candidate = Candidate::find($id);
            
            if (!$candidate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Candidate not found'
                ], 404);
            }

            $candidate->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Candidate updated successfully',
                'candidate' => $candidate
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating candidate: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $candidate = Candidate::find($id);
            
            if (!$candidate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Candidate not found'
                ], 404);
            }

            $candidate->delete();

            return response()->json([
                'success' => true,
                'message' => 'Candidate deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting candidate: ' . $e->getMessage()
            ], 500);
        }
    }
}