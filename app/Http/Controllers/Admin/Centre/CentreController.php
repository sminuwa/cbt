<?php

namespace App\Http\Controllers\Admin\Centre;

use App\Http\Controllers\Controller;
use App\Models\Centre;
use App\Models\Venue;
use Illuminate\Http\Request;

class CentreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $centres = Centre::all();
        return view('pages.admin.centre.manage', compact('centres'));
    }

    public function getData(Request $request)
    {
        $query = Centre::with('venues');
        
        // Handle DataTables search
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        // Get total records count
        $totalRecords = $query->count();

        // Handle ordering
        if ($request->filled('order')) {
            $orderColumnIndex = $request->input('order.0.column');
            $orderDirection = $request->input('order.0.dir');
            
            $columns = ['id', 'actions', 'name', 'location', 'venues_count', 'status', 'created_at'];
            
            if (isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDirection);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Handle pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 50);
        
        $centres = $query->skip($start)->take($length)->get();

        // Prepare data for DataTables
        $data = [];
        foreach ($centres as $index => $centre) {
            // Action buttons matching candidates manage style
            $actionButtons = '
                <div class="btn-group dropend" role="group">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-popper-placement="right-start" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item view-centre" data-id="'.$centre->id.'">
                            <i class="las la-eye"></i> View
                        </button>
                        <button class="dropdown-item edit-centre" data-id="'.$centre->id.'">
                            <i class="las la-edit"></i> Edit
                        </button>
                        <button class="dropdown-item delete-centre" data-id="'.$centre->id.'" data-name="'.$centre->name.'">
                            <i class="las la-trash"></i> Delete
                        </button>
                    </div>
                </div>';
            
            $data[] = [
                'DT_RowIndex' => "",
                'actions' => $actionButtons,
                'name' => '<strong>' . $centre->name . '</strong>',
                'location' => $centre->location,
                'venues_count' => $centre->venues->count() . ' venues',
                'status' => $centre->status == 'Active' 
                    ? '<span class="badge bg-success">Active</span>' 
                    : '<span class="badge bg-danger">Inactive</span>',
                'created_at' => $centre->created_at ? $centre->created_at->format('Y-m-d H:i:s') : 'N/A'
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'centreLocation' => 'required|string|max:255',
            'api_key' => 'required|string|max:255',
            'secret_key' => 'required|string|max:255',
        ]);

        Centre::updateOrCreate(
            ['id' => $request->centreId],
            [
                'name' => $request->name, 
                'location' => $request->centreLocation, 
                'api_key' => $request->api_key, 
                'secret_key' => $request->secret_key, 
                'status' => 'Active'
            ]
        );

        return back()->with('success', 'Centre saved successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'api_key' => 'required|string|max:255',
            'secret_key' => 'required|string|max:255',
        ]);

        $centre = Centre::findOrFail($id);
        $centre->update([
            'name' => $request->name,
            'location' => $request->location,
            'api_key' => $request->api_key,
            'secret_key' => $request->secret_key,
            'status' => $request->status ?? 'Active'
        ]);

        return back()->with('success', 'Centre updated successfully.');
    }

    public function destroy($id)
    {
        $centre = Centre::findOrFail($id);
        $centre->delete();
        
        return response()->json(['success' => true, 'message' => 'Centre deleted successfully.']);
    }

    public function show($id)
    {
        $centre = Centre::with('venues')->findOrFail($id);
        
        // Get scheduled candidates for this centre organized by paper
        $scheduledCandidates = \Illuminate\Support\Facades\DB::table('candidates')
            ->join('scheduled_candidates', 'scheduled_candidates.candidate_id', '=', 'candidates.id')
            ->join('candidate_subjects', 'candidate_subjects.scheduled_candidate_id', '=', 'scheduled_candidates.id')
            ->join('schedulings', 'schedulings.id', '=', 'candidate_subjects.schedule_id')
            ->join('venues', 'venues.id', '=', 'schedulings.venue_id')
            ->join('subjects', 'subjects.id', '=', 'candidate_subjects.subject_id')
            ->leftJoin('test_configs', 'test_configs.id', '=', 'schedulings.test_config_id')
            ->where('venues.centre_id', $id)
            ->select([
                'candidates.id as candidate_id',
                'candidates.indexing',
                'candidates.firstname', 
                'candidates.surname',
                'candidates.other_names',
                'subjects.name as subject_name',
                'subjects.subject_code',
                'venues.name as venue_name',
                'schedulings.id as schedule_id',
                'schedulings.date as schedule_date',
                'schedulings.daily_start_time',
                'schedulings.daily_end_time',
                'test_configs.session as test_session'
            ])
            ->orderBy('subjects.subject_code')
            ->orderBy('candidates.indexing')
            ->get()
            ->groupBy('subject_code');

        $centreData = $centre->toArray();
        $centreData['scheduled_candidates'] = $scheduledCandidates;
        
        return response()->json($centreData);
    }

    public function deleteCandidate(Request $request)
    {
        try {
            $candidateId = $request->candidate_id;
            $scheduleId = $request->schedule_id;
            
            // Delete from candidate_subjects table
            $deleted = \Illuminate\Support\Facades\DB::table('candidate_subjects')
                ->join('scheduled_candidates', 'scheduled_candidates.id', '=', 'candidate_subjects.scheduled_candidate_id')
                ->where('scheduled_candidates.candidate_id', $candidateId)
                ->where('candidate_subjects.schedule_id', $scheduleId)
                ->delete();
                
            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Candidate removed from schedule successfully.'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove candidate from schedule.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing candidate: ' . $e->getMessage()
            ], 500);
        }
    }

    public function rescheduleCandidate(Request $request)
    {
        try {
            $candidateId = $request->candidate_id;
            $scheduleId = $request->schedule_id;
            $newCentreId = $request->new_centre_id;
            
            // First, get the current candidate's subject from the existing schedule
            $currentCandidateSubject = \Illuminate\Support\Facades\DB::table('candidate_subjects')
                ->join('scheduled_candidates', 'scheduled_candidates.id', '=', 'candidate_subjects.scheduled_candidate_id')
                ->where('scheduled_candidates.candidate_id', $candidateId)
                ->where('candidate_subjects.schedule_id', $scheduleId)
                ->select('candidate_subjects.subject_id', 'candidate_subjects.id as candidate_subject_id')
                ->first();
                
            if (!$currentCandidateSubject) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current candidate schedule not found.'
                ]);
            }
            
            // Get available schedules for the new centre and same subject
            $availableSchedules = \Illuminate\Support\Facades\DB::table('schedulings')
                ->join('venues', 'venues.id', '=', 'schedulings.venue_id')
                ->where('venues.centre_id', $newCentreId)
                ->whereNotIn('schedulings.id', [$scheduleId]) // Exclude current schedule
                ->select('schedulings.id', 'schedulings.date', 'schedulings.daily_start_time', 'schedulings.daily_end_time', 'venues.name as venue_name')
                ->distinct()
                ->get();
                
            if ($availableSchedules->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No available schedules found for the selected centre.'
                ]);
            }
            
            // For now, assign to the first available schedule
            // In a real implementation, you might want to let the user choose
            $newScheduleId = $availableSchedules->first()->id;
            
            // Update the candidate's schedule
            $updated = \Illuminate\Support\Facades\DB::table('candidate_subjects')
                ->where('id', $currentCandidateSubject->candidate_subject_id)
                ->update(['schedule_id' => $newScheduleId]);
                
            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Candidate rescheduled successfully to new centre.'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to reschedule candidate.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error rescheduling candidate: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAvailableCentres()
    {
        try {
            $centres = Centre::where('status', 'Active')
                ->select('id', 'name', 'location')
                ->orderBy('name')
                ->get();
                
            return response()->json($centres);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching centres: ' . $e->getMessage()
            ], 500);
        }
    }
}