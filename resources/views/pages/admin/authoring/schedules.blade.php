@php use App\Models\Centre;use App\Models\ExamsDate;use App\Models\Scheduling;use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    @if(session()->has('success'))
        @if(!session('success'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @else
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endif
    
    <div class="row mt-3">
        <div class="col-12 col-lg-12 col-xl-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-flex justify-content-between align-items-center">
                        <span>Test Schedules</span>
                        <div class="d-flex gap-2 align-items-center">
                            <div class="btn-group btn-group-xs" role="group">
                                <a href="{{ route('admin.test.config.dates', $config->id) }}" class="btn btn-xs btn-outline-secondary" title="Test Dates">
                                    <i class="las la-calendar"></i> Dates
                                </a>
                                <a href="{{ route('admin.test.config.subjects', $config->id) }}" class="btn btn-xs btn-outline-primary" title="Test Papers">
                                    <i class="las la-book"></i> Papers
                                </a>
                                <a href="{{ route('admin.test.config.composition', $config->id) }}" class="btn btn-xs btn-outline-success" title="Test Composition">
                                    <i class="las la-layer-group"></i> Composition
                                </a>
                                <a href="{{ route('admin.test.config.basics', $config->id) }}" class="btn btn-xs btn-outline-info" title="Test Config">
                                    <i class="las la-cog"></i> Config
                                </a>
                            </div>
                            <a href="{{ route('admin.test.config.index') }}" class="btn btn-info btn-xs text-light">
                                <i class="las la-arrow-left"></i> Panel
                            </a>
                        </div>
                    </h4>
                </div>
                <div class="card-body text-center">
                    <h5 class="text-muted">Manage Test Schedules</h5>
                    <h4 class="test-title">{{ $config->title }} - {{ $config->session }} - {{ $config->test_code->name ?? 'No Code' }} - {{ $config->test_type->name ?? 'No Type' }}</h4>
                    <div class="row justify-content-center ">
                        <div class="col-md-10">
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                @if($config->paper)
                                <div class="test-info-item">
                                    <i class="las la-file-alt text-primary me-2"></i>
                                    <span><strong>Paper:</strong> {{$config->paper}}</span>
                                </div>
                                @endif
                                @if($config->code)
                                <div class="test-info-item">
                                    <i class="las la-code text-primary me-2"></i>
                                    <span><strong>Code:</strong> {{$config->code}}</span>
                                </div>
                                @endif
                                @if($config->year)
                                <div class="test-info-item">
                                    <i class="las la-calendar text-primary me-2"></i>
                                    <span><strong>Year:</strong> {{$config->year}}</span>
                                </div>
                                @endif
                                @if($config->exam_type)
                                <div class="test-info-item">
                                    <i class="las la-graduation-cap text-primary me-2"></i>
                                    <span><strong>Type:</strong> {{$config->exam_type}}</span>
                                </div>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#scheduleAllCentersModal">
                            <i class="las la-calendar-plus"></i> Schedule All Centers
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                            <i class="las la-plus-circle"></i> Add Individual Schedule
                        </button>
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#batchScheduleCandidatesModal">
                            <i class="las la-upload"></i> Batch Schedule Candidates
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#batchRescheduleModal">
                            <i class="las la-calendar-alt"></i> Batch Reschedule
                        </button>
                        {{-- <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#transferScheduleModal">
                            <i class="las la-exchange-alt"></i> Transfer Schedule
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Existing Schedules
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="export-button-sample">
                    <thead>
                    <tr>
                        <th width="40">
                            <label class="custom-checkbox" id="selectAll-wrapper">
                                <input type="checkbox" id="selectAll">
                                <span class="checkmark"></span>
                            </label>
                        </th>
                        <th>Action</th>
                        <th>Centre</th>
                        <th class="text-nowrap">Candidates (S/P/P)</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($schedules as $schedule)
                        <tr>
                            <td>
                                <label class="custom-checkbox">
                                    <input type="checkbox" class="schedule-checkbox" value="{{$schedule->id}}" data-date="{{$schedule->date}}" data-centre="{{$schedule->venue->centre->name ?? ''}}">
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                            <td width="120">
                                <div class="btn-group dropend" role="group">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-popper-placement="right-start" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item modify" 
                                            data-id="{{$schedule->id}}" data-date="{{$schedule->date}}"
                                            data-venue="{{$schedule->venue->id}}" data-centre="{{$schedule->venue->centre->id}}"
                                            data-batch="{{$schedule->maximum_batch}}" data-count="{{$schedule->no_per_schedule}}"
                                            data-start="{{Carbon::parse($schedule->daily_start_time)->format('H:m')}}"
                                            data-end="{{Carbon::parse($schedule->daily_end_time)->format('H:m')}}"
                                            type="button">
                                            <i class="las la-edit"></i> Edit
                                        </button>
                                        <button class="dropdown-item schedule-candidates" 
                                            data-bs-toggle="modal" href="#schedule-candidates"
                                            data-id="{{$schedule->id}}"
                                            data-test_config_id="{{$schedule->test_config_id}}"
                                            type="button">
                                            <i class="las la-upload"></i> Upload Candidates
                                        </button>
                                        <button class="dropdown-item transfer-candidates-btn" 
                                            data-bs-toggle="modal" data-bs-target="#transferCandidatesModal"
                                            data-schedule-id="{{$schedule->id}}"
                                            data-schedule-centre="{{$schedule->venue->centre->name ?? ''}}"
                                            data-schedule-venue="{{$schedule->venue->name ?? ''}}"
                                            data-schedule-date="{{$schedule->date}}"
                                            type="button"
                                            title="Transfer Specific Candidates">
                                            <i class="las la-user-friends"></i> Transfer Candidates
                                        </button>
                                        <button class="dropdown-item transfer-schedule-btn" 
                                            data-bs-toggle="modal" data-bs-target="#transferScheduleModal"
                                            data-schedule-id="{{$schedule->id}}"
                                            data-schedule-centre="{{$schedule->venue->centre->name ?? ''}}"
                                            data-schedule-venue="{{$schedule->venue->name ?? ''}}"
                                            data-schedule-date="{{$schedule->date}}"
                                            type="button"
                                            title="Transfer Entire Schedule">
                                            <i class="las la-exchange-alt"></i> Transfer Schedule
                                        </button>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" 
                                            onclick="return confirm('Are you sure you want to delete this schedule?')"
                                            href="{{route('admin.test.config.schedules.delete',[$schedule->id])}}">
                                            <i class="las la-trash"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                            
                            <td>{{ $schedule->venue->centre->name ?? 'N/A' }}</td>
                            <td class="text-nowrap">
                                <span class="badge badge-primary">{{ $schedule->total_schedules ?? 0 }}/{{ $schedule->pull_status->total_candidate ?? 0 }}/{{ $schedule->total_pushed ?? 0 }}</span>
                            </td>
                            <td>{{  Carbon::parse($schedule->date)->format('D jS M, Y') }}</td>
                            <td>{{ date('g:i A', strtotime($schedule->date.' '.$schedule->daily_start_time)) }}</td>
                            <td>{{ date('g:i A', strtotime($schedule->date.' '.$schedule->daily_end_time)) }}</td>
                            
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Schedule All Centers Modal -->
    <div class="modal fade" id="scheduleAllCentersModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Schedule All Centers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="scheduleAllCentersForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="test_config_id" value="{{$config_id}}">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="all_test_date">Test Date:</label>
                                    <select class="form-control select2" id="all_test_date" name="date" required data-placeholder="Select Date">
                                        @php
                                            $dates = ExamsDate::where(['test_config_id'=>$config_id])->get();
                                        @endphp
                                        <option value="">Select Date</option>
                                        @foreach($dates as $date)
                                            <option value="{{$date->date}}">
                                                {{ Carbon::parse($date->date)->format('D, jS M, Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="all_batches">Batches per Center:</label>
                                    <input class="form-control" type="number" name="maximum_batch" id="all_batches" value="1" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="all_candidates_per_batch">Candidates per Batch:</label>
                                    <input class="form-control" type="number" name="no_per_schedule" id="all_candidates_per_batch" value="50" min="1" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="all_start_time">Start Time:</label>
                                    <input class="form-control" type="time" name="daily_start_time" id="all_start_time" value="08:00" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="all_end_time">End Time:</label>
                                    <input class="form-control" type="time" name="daily_end_time" id="all_end_time" value="17:00" required>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="overwrite_existing" name="overwrite_existing">
                                <label class="form-check-label" for="overwrite_existing">
                                    Overwrite existing schedules for this date
                                </label>
                            </div>
                        </div>

                        <div id="schedule_progress" class="mt-3" style="display: none;">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small class="text-muted">Processing centers...</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="scheduleAllBtn">Schedule All Centers</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Individual Schedule Modal -->
    <div class="modal fade" id="addScheduleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScheduleModalTitle">Add Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.test.config.schedules.store') }}" method="post" id="addScheduleForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="test_config_id" value="{{$config_id}}">
                        <input type="hidden" name="id" id="schedule_id">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exam-dates">Test Date:</label>
                                    <select class="form-control select2" id="exam-dates" name="date" required data-placeholder="Select Date">
                                        @php
                                            $dates = ExamsDate::where(['test_config_id'=>$config_id])->get();
                                        @endphp
                                        <option value="">Select Date</option>
                                        @foreach($dates as $date)
                                            <option value="{{$date->date}}">
                                                {{ Carbon::parse($date->date)->format('D, jS M, Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="centre">Institution/Centre:</label>
                                    @php
                                        $centres=Centre::all();
                                    @endphp
                                    <select class="form-control select2" id="centre" required data-placeholder="Select Centre">
                                        <option value="">Select Centre</option>
                                        @foreach($centres as $centre)
                                            <option value="{{ $centre->id }}">{{ $centre->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="venue">Venue:</label>
                                    <select class="form-control select2" name="venue_id" id="venue" required data-placeholder="Select Venue">
                                        <option value="">Select Venue</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="maximum_batch">Batches for this Schedule:</label>
                                    <input class="form-control" type="number" name="maximum_batch" id="maximum_batch"
                                           placeholder="Number of batches" value="1" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_per_schedule">Candidates per Batch:</label>
                                    <input class="form-control" type="number" name="no_per_schedule"
                                           id="no_per_schedule" placeholder="Number of candidates" min="1" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="daily_start_time">Daily Start Time:</label>
                                    <input class="form-control" type="time" name="daily_start_time"
                                           id="daily_start_time" value="08:00" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="daily_end_time">Daily End Time:</label>
                                    <input class="form-control" type="time" name="daily_end_time"
                                           id="daily_end_time" value="17:00" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveScheduleBtn">Save Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Batch Reschedule Modal -->
    <div class="modal fade" id="batchRescheduleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Batch Reschedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="batchRescheduleForm">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="las la-info-circle"></i> Select schedules from the table below and choose new date/time settings to reschedule them all at once.
                        </div>
                        
                        <div id="selectedSchedulesInfo" class="mb-3" style="display: none;">
                            <div class="card bg-light">
                                <div class="card-body p-3">
                                    <h6 class="card-title mb-2">Selected Schedules (<span id="selectedCount">0</span>):</h6>
                                    <div id="selectedSchedulesList" class="small"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="batch_new_date">New Test Date:</label>
                                    <select class="form-control select2" id="batch_new_date" name="new_date" required data-placeholder="Select New Date">
                                        @php
                                            $dates = ExamsDate::where(['test_config_id'=>$config_id])->get();
                                        @endphp
                                        <option value="">Select New Date</option>
                                        @foreach($dates as $date)
                                            <option value="{{$date->date}}">
                                                {{ Carbon::parse($date->date)->format('D, jS M, Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="batch_new_batches">New Batches per Schedule:</label>
                                    <input class="form-control" type="number" id="batch_new_batches" name="new_batches" min="1" placeholder="Leave empty to keep existing">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="batch_new_candidates">New Candidates per Batch:</label>
                                    <input class="form-control" type="number" id="batch_new_candidates" name="new_candidates" min="1" placeholder="Leave empty to keep existing">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="batch_new_start_time">New Start Time:</label>
                                    <input class="form-control" type="time" id="batch_new_start_time" name="new_start_time" placeholder="Leave empty to keep existing">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="batch_new_end_time">New End Time:</label>
                                    <input class="form-control" type="time" id="batch_new_end_time" name="new_end_time" placeholder="Leave empty to keep existing">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="update_all_fields" name="update_all_fields">
                                <label class="form-check-label" for="update_all_fields">
                                    Update all fields (if unchecked, only non-empty fields will be updated)
                                </label>
                            </div>
                        </div>

                        <div id="reschedule_progress" class="mt-3" style="display: none;">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small class="text-muted">Rescheduling schedules...</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning" id="batchRescheduleBtn" disabled>
                            <i class="las la-calendar-alt"></i> Reschedule Selected
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Batch Schedule Candidates Modal -->
    <div class="modal fade" id="batchScheduleCandidatesModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Batch Schedule Candidates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="batchScheduleCandidatesForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="test_config_id" value="{{$config_id}}">
                        
                        <!-- Instructions -->
                        <div class="alert alert-info mb-4">
                            <h6 class="alert-heading mb-2">
                                <i class="las la-info-circle"></i> Instructions
                            </h6>
                            <div class="small">
                                <p class="mb-2">Upload an Excel file to schedule multiple candidates at once. Your Excel file should contain these columns:</p>
                                <ul class="mb-2">
                                    <li><strong>indexing</strong> - Candidate index/registration number</li>
                                    <li><strong>centre</strong> - Centre name (must match existing centres)</li>
                                    <li><strong>paper</strong> - Paper/subject codes (comma-separated if multiple)</li>
                                </ul>
                                <p class="mb-0">
                                    <a href="{{ asset('assets/candidate_batch_schedule_template.xlsx') }}" class="btn btn-sm btn-outline-primary" download="candidate_batch_schedule_template.csv">
                                        <i class="las la-download"></i> Download Template
                                    </a>
                                </p>
                            </div>
                        </div>

                        <!-- File Upload Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="batch_schedule_file">Excel File <span class="text-danger">*</span></label>
                                    <input class="form-control" type="file" id="batch_schedule_file" name="file" 
                                           accept=".xls,.xlsx,.csv" required>
                                    <small class="form-text text-muted">Accepted formats: .xls, .xlsx (Max: 10MB)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="batch_schedule_date">Default Schedule Date</label>
                                    <select class="form-control select2" id="batch_schedule_date" name="default_date" data-placeholder="Select Default Date">
                                        @php
                                            $dates = ExamsDate::where(['test_config_id'=>$config_id])->get();
                                        @endphp
                                        <option value="">Select Default Date</option>
                                        @foreach($dates as $date)
                                            <option value="{{$date->date}}">
                                                {{ Carbon::parse($date->date)->format('D, jS M, Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Used when date is not specified in Excel</small>
                                </div>
                            </div>
                        </div>

                        <!-- Options Section -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="batch_schedule_mode">Scheduling Mode</label>
                                    <select class="form-control" id="batch_schedule_mode" name="scheduling_mode">
                                        <option value="auto">Auto-assign to available schedules</option>
                                        <option value="create">Create new schedules as needed</option>
                                        <option value="existing">Only use existing schedules</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="overwrite_existing_schedules" name="overwrite_existing_schedules">
                                        <label class="form-check-label" for="overwrite_existing_schedules">
                                            Overwrite existing candidate schedules
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Section -->
                        <div id="batch_schedule_progress" class="mt-4" style="display: none;">
                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <small class="text-muted d-block" id="progress_text">Processing candidates...</small>
                                    <div id="progress_details" class="mt-2" style="display: none;">
                                        <div class="small">
                                            <span class="text-success">✓ Processed: <span id="processed_count">0</span></span> | 
                                            <span class="text-danger">✗ Errors: <span id="error_count">0</span></span> | 
                                            <span class="text-info">➤ Total: <span id="total_count">0</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info" id="batchScheduleCandidatesBtn">
                            <i class="las la-upload"></i> Process Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade custom-modal" id="schedule-candidates">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Candidates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{route('admin.test.config.upload.list')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="test_config_id" id="test_config" required>
                        <input type="hidden" name="schedule_id" id="schedule" required>
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="mb-3">
                                    <label for="file" class="mb-2">Choose file...</label>
                                    <input class="form-control" type="file" id="file" name="file" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer submit-section text-end">
                        <button type="submit" class="btn btn-sm btn-info submit-btn text-light">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Transfer Candidates Modal -->
    <div class="modal fade" id="transferCandidatesModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transfer Specific Candidates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="transfer_candidates_schedule_id">
                    
                    <!-- Current Schedule Info -->
                    <div class="alert alert-info mb-4">
                        <h6 class="alert-heading mb-2">
                            <i class="las la-info-circle"></i> Source Schedule Details
                        </h6>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Centre:</strong> <span id="source_schedule_centre">-</span>
                            </div>
                            <div class="col-md-4">
                                <strong>Venue:</strong> <span id="source_schedule_venue">-</span>
                            </div>
                            <div class="col-md-4">
                                <strong>Date:</strong> <span id="source_schedule_date">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Transfer Options -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="candidate_target_centre">Target Centre <span class="text-danger">*</span></label>
                                @php
                                    $centres = Centre::all();
                                @endphp
                                <select class="form-control select2" id="candidate_target_centre" required data-placeholder="Select Target Centre">
                                    <option value="">Select Target Centre</option>
                                    @foreach($centres as $centre)
                                        <option value="{{ $centre->id }}">{{ $centre->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="candidate_target_venue">Target Venue</label>
                                <select class="form-control select2" id="candidate_target_venue" name="target_venue_id" data-placeholder="Select Target Venue">
                                    <option value="">Select Target Venue</option>
                                </select>
                                <small class="form-text text-muted">Select a target centre first to view available venues</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="candidate_transfer_mode">Transfer Mode <span class="text-danger">*</span></label>
                                <select class="form-control" id="candidate_transfer_mode" required>
                                    <option value="">Select Transfer Mode</option>
                                    <option value="auto_assign" selected>Auto-assign to available schedule at target centre</option>
                                    <option value="create_new">Create new schedule for transferred candidates</option>
                                    <option value="specific_schedule">Transfer to specific schedule (select below)</option>
                                </select>
                                <small class="form-text text-muted">Choose how candidates should be transferred to the target centre</small>
                            </div>
                        </div>
                    </div>

                    <!-- Target Schedules Section (shown when specific_schedule mode is selected) -->
                    <div id="target_schedules_section" class="row mb-4" style="display: none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="target_schedules_list">Available Target Schedules</label>
                                <div id="target_schedules_list" class="border p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                                    <p class="text-muted mb-0">Select a target centre first to view available schedules</p>
                                </div>
                                <input type="hidden" id="selected_target_schedule" name="target_schedule_id">
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter Candidates -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="candidate_search">Search Candidates</label>
                                <input type="text" class="form-control" id="candidate_search" placeholder="Search by name, index number, or exam number...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="candidate_filter">Filter by Status</label>
                                <select class="form-control" id="candidate_filter">
                                    <option value="all">All Candidates</option>
                                    <option value="scheduled">Scheduled Only</option>
                                    <option value="pulled">Pulled Only</option>
                                    <option value="pushed">Pushed Only</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Bulk Actions -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary" id="select_all_candidates">
                                <i class="las la-check-square"></i> Select All
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="deselect_all_candidates">
                                <i class="las la-square"></i> Deselect All
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info" id="select_scheduled_only">
                                <i class="las la-filter"></i> Select Scheduled
                            </button>
                        </div>
                        <div id="selected_candidates_count" class="text-muted">
                            <strong>0</strong> candidates selected
                        </div>
                    </div>

                    <!-- Candidates List -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Select Candidates to Transfer</h6>
                        </div>
                        <div class="card-body p-0">
                            <div id="candidates_loading" class="text-center p-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading candidates...</span>
                                </div>
                                <p class="mt-2 mb-0">Loading candidates...</p>
                            </div>
                            <div id="candidates_table_container" style="display: none;">
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-sm table-hover mb-0" id="candidates_table">
                                        <thead class="bg-light sticky-top">
                                            <tr>
                                                <th width="50">
                                                    <input type="checkbox" id="select_all_table_candidates" class="form-check-input">
                                                </th>
                                                <th>Index/Reg No.</th>
                                                <th>Name</th>
                                                <th>Exam Number</th>
                                                <th>Status</th>
                                                <th>Papers</th>
                                            </tr>
                                        </thead>
                                        <tbody id="candidates_table_body">
                                            <!-- Candidates will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="no_candidates_found" class="text-center p-4 text-muted" style="display: none;">
                                <i class="las la-user-slash la-3x mb-3"></i>
                                <p class="mb-0">No candidates found for this schedule</p>
                            </div>
                        </div>
                    </div>

                    <!-- Transfer Progress -->
                    <div id="candidate_transfer_progress" class="mt-4" style="display: none;">
                        <div class="progress mb-2">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small class="text-muted d-block" id="candidate_transfer_progress_text">Preparing transfer...</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="transferCandidatesBtn" disabled>
                        <i class="las la-user-friends"></i> Transfer Selected Candidates
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Transfer Schedule Modal -->
    <div class="modal fade" id="transferScheduleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transfer Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="transferScheduleForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="schedule_id" id="transfer_schedule_id">
                        
                        <!-- Current Schedule Info -->
                        <div class="alert alert-info mb-4">
                            <h6 class="alert-heading mb-2">
                                <i class="las la-info-circle"></i> Current Schedule Details
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Centre:</strong> <span id="current_schedule_centre">-</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Venue:</strong> <span id="current_schedule_venue">-</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Date:</strong> <span id="current_schedule_date">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Transfer Options -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="target_centre">Target Centre <span class="text-danger">*</span></label>
                                    @php
                                        $centres = Centre::all();
                                    @endphp
                                    <select class="form-control select2" id="target_centre" name="target_centre_id" required data-placeholder="Select Target Centre">
                                        <option value="">Select Target Centre</option>
                                        @foreach($centres as $centre)
                                            <option value="{{ $centre->id }}">{{ $centre->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="target_venue">Target Venue</label>
                                    <select class="form-control select2" id="target_venue" name="target_venue_id" data-placeholder="Select Target Venue">
                                        <option value="">Select Target Venue</option>
                                    </select>
                                    <small class="form-text text-muted">Select a target centre first to view available venues</small>
                                </div>
                            </div>
                        </div>

                        <!-- Transfer Mode Selection -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="transfer_mode">Transfer Mode <span class="text-danger">*</span></label>
                                    <select class="form-control" id="transfer_mode" name="transfer_mode" required>
                                        <option value="">Select Transfer Mode</option>
                                        <option value="auto_assign" selected>Auto-assign to existing or create new schedule</option>
                                        <option value="create_new">Always create new schedule at target venue</option>
                                        <option value="specific_venue">Transfer to specific venue (use venue selected above)</option>
                                    </select>
                                    <small class="form-text text-muted">Choose how candidates should be transferred to the target centre</small>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Options -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="copy_schedule_settings" name="copy_schedule_settings">
                                    <label class="form-check-label" for="copy_schedule_settings">
                                        Copy current schedule settings (date, time, batch size) to target
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Transfer Progress -->
                        <div id="transfer_progress" class="mt-4" style="display: none;">
                            <div class="progress mb-2">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small class="text-muted d-block" id="transfer_progress_text">Preparing transfer...</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="transferScheduleBtn">
                            <i class="las la-exchange-alt"></i> Transfer Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    
    <script>
        $('body').on('click','.schedule-candidates',function(){
            $('#schedule').val($(this).attr('data-id'))
            $('#test_config').val($(this).attr('data-test_config_id')).change()
        })

        $(function () {
            // Initialize Select2 - override the global initialization
            function initializeSelect2() {
                // Check if Select2 is available
                if (typeof $.fn.select2 === 'undefined') {
                    console.error('Select2 library not loaded');
                    return;
                }
                
                try {
                    $('.select2').each(function() {
                        var $this = $(this);
                        
                        // Skip if already initialized
                        if ($this.hasClass('select2-hidden-accessible')) {
                            try {
                                $this.select2('destroy');
                            } catch (destroyError) {
                                console.warn('Could not destroy select2:', destroyError);
                            }
                        }
                        
                        var $modal = $this.closest('.modal');
                        var config = {
                            width: '100%',
                            allowClear: true,
                            minimumResultsForSearch: 0 // Always show search box
                        };
                        
                        // Set placeholder
                        var placeholder = $this.data('placeholder') || $this.attr('placeholder');
                        if (placeholder) {
                            config.placeholder = placeholder;
                        }
                        
                        // If inside modal, set dropdownParent
                        if ($modal.length > 0) {
                            config.dropdownParent = $modal;
                        }
                        
                        try {
                            $this.select2(config);
                        } catch (initError) {
                            console.error('Failed to initialize select2 for element:', $this[0], initError);
                        }
                    });
                    
                    console.log('Select2 initialization completed for', $('.select2').length, 'elements');
                } catch (error) {
                    console.error('General error in Select2 initialization:', error);
                }
            }

            // Wait for the page to be fully loaded
            setTimeout(function() {
                initializeSelect2();
            }, 1000);

            // Reinitialize Select2 when modals are shown
            $('#addScheduleModal, #scheduleAllCentersModal, #batchRescheduleModal, #batchScheduleCandidatesModal').on('shown.bs.modal', function () {
                initializeSelect2();
            });

            // Individual Schedule Modal functionality
            $('#centre').on('change', function () {
                const centreId = $(this).val();
                if (centreId) {
                    $.get('{{ route('admin.misc.venues',[':id']) }}'.replace(':id', centreId), function (data) {
                        let options = `<option value="">Select Venue</option>`;
                        $.each(data, function (i, v) {
                            options += `<option value='${v.id}'>${v.name}</option>`;
                        });
                        $('#venue').html(options);
                        // Reinitialize select2 for venue dropdown
                        try {
                            if ($('#venue').hasClass('select2-hidden-accessible')) {
                                $('#venue').select2('destroy');
                            }
                            
                            var $modal = $('#venue').closest('.modal');
                            var config = {
                                width: '100%',
                                allowClear: true,
                                minimumResultsForSearch: 0, // Always show search box
                                placeholder: 'Select Venue'
                            };
                            if ($modal.length > 0) {
                                config.dropdownParent = $modal;
                            }
                            $('#venue').select2(config);
                        } catch (error) {
                            console.error('Error initializing venue select2:', error);
                        }
                    });
                } else {
                    $('#venue').html('<option value="">Select Venue</option>');
                    try {
                        if ($('#venue').hasClass('select2-hidden-accessible')) {
                            $('#venue').select2('destroy');
                        }
                        
                        var $modal = $('#venue').closest('.modal');
                        var config = {
                            width: '100%',
                            allowClear: true,
                            minimumResultsForSearch: 0, // Always show search box
                            placeholder: 'Select Venue'
                        };
                        if ($modal.length > 0) {
                            config.dropdownParent = $modal;
                        }
                        $('#venue').select2(config);
                    } catch (error) {
                        console.error('Error initializing empty venue select2:', error);
                    }
                }
            });

            $('#venue').on('change', function () {
                const venueId = $(this).val();
                if (venueId) {
                    $.get('{{ route('admin.misc.batches.capacity',[':id']) }}'.replace(':id', venueId),
                        function (venue) {
                            $('#no_per_schedule').val(venue.capacity);
                        }
                    );
                }
            });

            // Edit schedule functionality
            $('body').on('click','.modify', function () {
                const scheduleData = {
                    id: $(this).data('id'),
                    date: $(this).data('date'),
                    centre: $(this).data('centre'),
                    venue: $(this).data('venue'),
                    batch: $(this).data('batch'),
                    count: $(this).data('count'),
                    start: $(this).data('start'),
                    end: $(this).data('end')
                };
                
                // Change modal title and populate form
                $('#addScheduleModalTitle').text('Edit Schedule');
                $('#saveScheduleBtn').text('Update Schedule');
                $('#schedule_id').val(scheduleData.id);
                
                // Set values for select2 elements
                $('#exam-dates').val(scheduleData.date).trigger('change');
                $('#centre').val(scheduleData.centre).trigger('change');
                
                // Wait for venues to load then set venue
                setTimeout(() => {
                    $('#venue').val(scheduleData.venue).trigger('change');
                    $('#maximum_batch').val(scheduleData.batch);
                    $('#no_per_schedule').val(scheduleData.count);
                    $('#daily_start_time').val(scheduleData.start);
                    $('#daily_end_time').val(scheduleData.end);
                }, 800);
                
                // Show modal
                $('#addScheduleModal').modal('show');
            });

            // Reset modal when closed
            $('#addScheduleModal').on('hidden.bs.modal', function () {
                $('#addScheduleModalTitle').text('Add Schedule');
                $('#saveScheduleBtn').text('Save Schedule');
                $('#addScheduleForm')[0].reset();
                $('#schedule_id').val('');
                
                // Reset select2 elements
                $('#exam-dates').val(null).trigger('change');
                $('#centre').val(null).trigger('change');
                $('#venue').html('<option value="">Select Venue</option>').val(null).trigger('change');
                
                // Reinitialize select2
                initializeSelect2();
            });

            // Form submission with validation
            $('#addScheduleForm').on('submit', function(e) {
                // Basic validation
                if (!$('#exam-dates').val() || !$('#centre').val() || !$('#venue').val()) {
                    e.preventDefault();
                    Swal.fire('Error', 'Please fill in all required fields', 'error');
                    return false;
                }
            })

            // Schedule All Centers functionality
            $('#scheduleAllCentersForm').on('submit', function(e) {
                e.preventDefault();
                
                const formData = $(this).serialize();
                const $submitBtn = $('#scheduleAllBtn');
                const $progress = $('#schedule_progress');
                const $progressBar = $progress.find('.progress-bar');
                
                // Validate required fields
                if (!$('#all_test_date').val()) {
                    Swal.fire('Error', 'Please select a test date', 'error');
                    return;
                }
                
                // Show confirmation
                Swal.fire({
                    title: 'Schedule All Centers?',
                    text: 'This will create schedules for all available centers on the selected date.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Schedule All'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Disable submit button and show progress
                        $submitBtn.prop('disabled', true).text('Processing...');
                        $progress.show();
                        $progressBar.css('width', '20%');
                        
                        $.ajax({
                            url: '{{ route('admin.test.config.schedules.schedule-all', $config_id) }}',
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                $progressBar.css('width', '100%');
                                
                                setTimeout(() => {
                                    if (response.success) {
                                        Swal.fire({
                                            title: 'Success!',
                                            text: response.message,
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire('Error', response.message, 'error');
                                    }
                                    
                                    // Reset form
                                    $submitBtn.prop('disabled', false).text('Schedule All Centers');
                                    $progress.hide();
                                    $progressBar.css('width', '0%');
                                    $('#scheduleAllCentersModal').modal('hide');
                                }, 500);
                            },
                            error: function(xhr, status, error) {
                                $progressBar.css('width', '0%');
                                $progress.hide();
                                $submitBtn.prop('disabled', false).text('Schedule All Centers');
                                
                                let message = 'An error occurred while scheduling centers.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }
                                
                                Swal.fire('Error', message, 'error');
                            }
                        });
                    }
                });
            });

            // Batch Reschedule functionality
            var selectedSchedules = [];

            // Select All checkbox functionality
            $('#selectAll').on('change', function() {
                var selectAllCheckbox = this;
                var isChecked = selectAllCheckbox.checked;
                
                // Clear indeterminate state when clicked
                selectAllCheckbox.indeterminate = false;
                
                // Set all checkboxes to the same state
                $('.schedule-checkbox').prop('checked', isChecked);
                updateSelectedSchedules();
            });

            // Individual checkbox functionality
            $(document).on('change', '.schedule-checkbox', function() {
                updateSelectedSchedules();
                updateSelectAllState();
            });

            // Update select all checkbox state (checked, unchecked, or indeterminate)
            function updateSelectAllState() {
                var totalCheckboxes = $('.schedule-checkbox').length;
                var checkedCheckboxes = $('.schedule-checkbox:checked').length;
                var selectAllCheckbox = $('#selectAll')[0];

                if (checkedCheckboxes === 0) {
                    // None selected
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                } else if (checkedCheckboxes === totalCheckboxes) {
                    // All selected
                    selectAllCheckbox.checked = true;
                    selectAllCheckbox.indeterminate = false;
                } else {
                    // Some selected (indeterminate state)
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = true;
                }
            }

            // Update selected schedules array and UI
            function updateSelectedSchedules() {
                selectedSchedules = [];
                var schedulesList = [];

                $('.schedule-checkbox:checked').each(function() {
                    var scheduleId = $(this).val();
                    var date = $(this).data('date');
                    var centre = $(this).data('centre');
                    
                    selectedSchedules.push(scheduleId);
                    schedulesList.push(`${centre} - ${date}`);
                });

                // Update UI
                $('#selectedCount').text(selectedSchedules.length);
                
                if (selectedSchedules.length > 0) {
                    $('#selectedSchedulesInfo').show();
                    $('#selectedSchedulesList').html(schedulesList.join('<br>'));
                    $('#batchRescheduleBtn').prop('disabled', false);
                } else {
                    $('#selectedSchedulesInfo').hide();
                    $('#batchRescheduleBtn').prop('disabled', true);
                }
            }

            // Reset modal when closed
            $('#batchRescheduleModal').on('hidden.bs.modal', function () {
                $('#batchRescheduleForm')[0].reset();
                $('#selectedSchedulesInfo').hide();
                $('#reschedule_progress').hide();
                $('.progress-bar').css('width', '0%');
                $('#batchRescheduleBtn').prop('disabled', selectedSchedules.length === 0);
                initializeSelect2();
            });

            // Batch reschedule form submission
            $('#batchRescheduleForm').on('submit', function(e) {
                e.preventDefault();
                
                if (selectedSchedules.length === 0) {
                    Swal.fire('Error', 'Please select at least one schedule to reschedule', 'error');
                    return;
                }

                if (!$('#batch_new_date').val()) {
                    Swal.fire('Error', 'Please select a new date for rescheduling', 'error');
                    return;
                }
                
                const formData = $(this).serialize() + '&schedule_ids=' + selectedSchedules.join(',');
                const $submitBtn = $('#batchRescheduleBtn');
                const $progress = $('#reschedule_progress');
                const $progressBar = $progress.find('.progress-bar');
                
                // Show confirmation
                Swal.fire({
                    title: 'Reschedule Schedules?',
                    text: `This will reschedule ${selectedSchedules.length} selected schedule(s) to the new date/time settings.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Reschedule'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Disable submit button and show progress
                        $submitBtn.prop('disabled', true).html('<i class="las la-spinner la-spin"></i> Processing...');
                        $progress.show();
                        $progressBar.css('width', '20%');
                        
                        $.ajax({
                            url: '{{ route('admin.test.config.schedules.batch-reschedule', $config_id) }}',
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                $progressBar.css('width', '100%');
                                
                                setTimeout(() => {
                                    if (response.success) {
                                        Swal.fire({
                                            title: 'Success!',
                                            text: response.message,
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire('Error', response.message, 'error');
                                    }
                                    
                                    // Reset form
                                    $submitBtn.prop('disabled', false).html('<i class="las la-calendar-alt"></i> Reschedule Selected');
                                    $progress.hide();
                                    $progressBar.css('width', '0%');
                                    $('#batchRescheduleModal').modal('hide');
                                }, 500);
                            },
                            error: function(xhr, status, error) {
                                $progressBar.css('width', '0%');
                                $progress.hide();
                                $submitBtn.prop('disabled', false).html('<i class="las la-calendar-alt"></i> Reschedule Selected');
                                
                                let message = 'An error occurred while rescheduling schedules.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }
                                
                                Swal.fire('Error', message, 'error');
                            }
                        });
                    }
                });
            });

            // Batch Schedule Candidates functionality
            $('#batchScheduleCandidatesForm').on('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const $submitBtn = $('#batchScheduleCandidatesBtn');
                const $progress = $('#batch_schedule_progress');
                const $progressBar = $progress.find('.progress-bar');
                const $progressText = $('#progress_text');
                const $progressDetails = $('#progress_details');
                
                // Validate file
                const fileInput = $('#batch_schedule_file')[0];
                if (!fileInput.files || !fileInput.files[0]) {
                    Swal.fire('Error', 'Please select an Excel file to upload', 'error');
                    return;
                }
                
                // Validate file type
                const fileName = fileInput.files[0].name;
                const fileExtension = fileName.split('.').pop().toLowerCase();
                if (!['xls', 'xlsx','csv'].includes(fileExtension)) {
                    Swal.fire('Error', 'Please select a valid Excel file (.xls or .xlsx)', 'error');
                    return;
                }
                
                // Show confirmation
                Swal.fire({
                    title: 'Process Batch Scheduling?',
                    text: 'This will process the Excel file and schedule candidates according to the data provided.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#17a2b8',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Process File'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Disable submit button and show progress
                        $submitBtn.prop('disabled', true).html('<i class="las la-spinner la-spin"></i> Processing...');
                        $progress.show();
                        $progressBar.css('width', '10%');
                        $progressText.text('Uploading file...');
                        
                        $.ajax({
                            url: '{{ route('admin.test.config.batch-schedule-candidates', $config_id) }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            xhr: function() {
                                var xhr = new XMLHttpRequest();
                                xhr.upload.addEventListener('progress', function(e) {
                                    if (e.lengthComputable) {
                                        var percentComplete = (e.loaded / e.total) * 50; // Upload is 50% of total progress
                                        $progressBar.css('width', percentComplete + '%');
                                    }
                                });
                                return xhr;
                            },
                            success: function(response) {
                                $progressBar.css('width', '100%');
                                $progressText.text('Processing complete!');
                                
                                console.log(response);
                                if (response.success) {
                                    // Show detailed results if available
                                    if (response.details) {
                                        $progressDetails.show();
                                        $('#processed_count').text(response.details.processed || 0);
                                        $('#error_count').text(response.details.errors || 0);
                                        $('#total_count').text(response.details.total || 0);
                                    }
                                    
                                    setTimeout(() => {
                                        let message = response.message;
                                        if (response.details && response.details.processed > 0) {
                                            message += `\n\nProcessed: ${response.details.processed} candidates`;
                                            if (response.details.errors > 0) {
                                                message += `\nErrors: ${response.details.errors} candidates could not be processed`;
                                            }
                                        }
                                        
                                        Swal.fire({
                                            title: 'Success!',
                                            text: message,
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            location.reload();
                                        });
                                    }, 1000);
                                } else {
                                    Swal.fire('Error', response.message || 'An error occurred while processing the file', 'error');
                                }
                                
                                // Reset form
                                $submitBtn.prop('disabled', false).html('<i class="las la-upload"></i> Process Upload');
                                setTimeout(() => {
                                    $progress.hide();
                                    $progressBar.css('width', '0%');
                                    $progressDetails.hide();
                                    if (response.success) {
                                        $('#batchScheduleCandidatesModal').modal('hide');
                                    }
                                }, response.success ? 1500 : 500);
                            },
                            error: function(xhr, status, error) {
                                $progressBar.css('width', '0%');
                                $progress.hide();
                                $progressDetails.hide();
                                $submitBtn.prop('disabled', false).html('<i class="las la-upload"></i> Process Upload');
                                
                                let message = 'An error occurred while processing the file.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                } else if (xhr.status === 413) {
                                    message = 'File is too large. Please use a smaller file.';
                                } else if (xhr.status === 422) {
                                    message = 'Invalid file format or missing required data.';
                                }
                                
                                Swal.fire('Error', message, 'error');
                            }
                        });
                    }
                });
            });

            // Reset batch scheduling modal when closed
            $('#batchScheduleCandidatesModal').on('hidden.bs.modal', function () {
                $('#batchScheduleCandidatesForm')[0].reset();
                $('#batch_schedule_progress').hide();
                $('#progress_details').hide();
                $('.progress-bar').css('width', '0%');
                $('#batchScheduleCandidatesBtn').prop('disabled', false).html('<i class="las la-upload"></i> Process Upload');
                initializeSelect2();
            });

            // Transfer Schedule functionality
            $('body').on('click','.transfer-schedule-btn', function() {
                const scheduleId = $(this).data('schedule-id');
                const scheduleCentre = $(this).data('schedule-centre');
                const scheduleVenue = $(this).data('schedule-venue');
                const scheduleDate = $(this).data('schedule-date');
                
                // Populate modal with current schedule info
                $('#transfer_schedule_id').val(scheduleId);
                $('#current_schedule_centre').text(scheduleCentre || 'N/A');
                $('#current_schedule_venue').text(scheduleVenue || 'N/A');
                $('#current_schedule_date').text(scheduleDate || 'N/A');
                
                // Reset form
                $('#transferScheduleForm')[0].reset();
                $('#transfer_schedule_id').val(scheduleId); // Reset form clears this, so set it again
                $('#transfer_progress').hide();
                $('.progress-bar').css('width', '0%');
                
                // Reinitialize Select2 for transfer modal
                setTimeout(() => {
                    initializeSelect2();
                }, 100);
            });

            // Transfer Schedule Modal - show when opened
            $('#transferScheduleModal').on('shown.bs.modal', function () {
                initializeSelect2();
            });

            // Target centre change handler for transfer
            $('#target_centre').on('change', function () {
                const centreId = $(this).val();
                if (centreId) {
                    // Load venues for selected centre
                    $.get('{{ route('admin.misc.venues',[':id']) }}'.replace(':id', centreId), function (data) {
                        let options = `<option value="">Select Target Venue</option>`;
                        $.each(data, function (i, v) {
                            options += `<option value='${v.id}'>${v.name}</option>`;
                        });
                        $('#target_venue').html(options);
                        
                        // Reinitialize select2 for target venue dropdown
                        try {
                            if ($('#target_venue').hasClass('select2-hidden-accessible')) {
                                $('#target_venue').select2('destroy');
                            }
                            
                            var $modal = $('#target_venue').closest('.modal');
                            var config = {
                                width: '100%',
                                allowClear: true,
                                minimumResultsForSearch: 0,
                                placeholder: 'Select Target Venue'
                            };
                            if ($modal.length > 0) {
                                config.dropdownParent = $modal;
                            }
                            $('#target_venue').select2(config);
                        } catch (error) {
                            console.error('Error initializing target venue select2:', error);
                        }
                    }).fail(function() {
                        Swal.fire('Error', 'Failed to load venues for selected centre', 'error');
                    });
                } else {
                    // Reset venue dropdown when no centre is selected
                    $('#target_venue').html('<option value="">Select Target Venue</option>');
                }
            });

            // Transfer mode change handler
            $('#transfer_mode').on('change', function() {
                const mode = $(this).val();
                // Set venue as required only when specific_venue mode is selected
                if (mode === 'specific_venue') {
                    $('#target_venue').prop('required', true);
                } else {
                    $('#target_venue').prop('required', false);
                }
                // Note: venue section visibility is now controlled by target_centre selection
            });

            // Transfer schedule form submission
            $('#transferScheduleForm').on('submit', function(e) {
                e.preventDefault();
                
                // Validate required fields
                if (!$('#target_centre').val()) {
                    Swal.fire('Error', 'Please select a target centre', 'error');
                    return;
                }
                
                if (!$('#transfer_mode').val()) {
                    Swal.fire('Error', 'Please select a transfer mode', 'error');
                    return;
                }
                
                if ($('#transfer_mode').val() === 'specific_venue' && !$('#target_venue').val()) {
                    Swal.fire('Error', 'Please select a target venue', 'error');
                    return;
                }
                
                const formData = $(this).serialize();
                
                // Debug: Log form data
                console.log('Form data being sent:', formData);
                console.log('Target centre ID:', $('#target_centre').val());
                console.log('Transfer mode:', $('#transfer_mode').val());
                console.log('Target venue ID:', $('#target_venue').val());
                console.log('Target venue options:', $('#target_venue option'));
                
                // Debug: Check if venue belongs to centre
                if ($('#transfer_mode').val() === 'specific_venue') {
                    console.log('Specific venue mode - checking venue availability');
                    const venueOptions = $('#target_venue option:not([value=""])');
                    console.log('Available venue options:', venueOptions.length);
                    venueOptions.each(function() {
                        console.log('Venue option:', $(this).val(), $(this).text());
                    });
                }
                const $submitBtn = $('#transferScheduleBtn');
                const $progress = $('#transfer_progress');
                const $progressBar = $progress.find('.progress-bar');
                const $progressText = $('#transfer_progress_text');
                
                // Show confirmation
                const targetCentreName = $('#target_centre option:selected').text();
                const currentCentreName = $('#current_schedule_centre').text();
                
                Swal.fire({
                    title: 'Transfer Schedule?',
                    html: `This will transfer all candidates from:<br><strong>${currentCentreName}</strong><br>to:<br><strong>${targetCentreName}</strong>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Transfer'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Disable submit button and show progress
                        $submitBtn.prop('disabled', true).html('<i class="las la-spinner la-spin"></i> Processing...');
                        $progress.show();
                        $progressBar.css('width', '20%');
                        $progressText.text('Initiating transfer...');
                        
                        $.ajax({
                            url: '{{ route('admin.test.config.transfer-schedule', $config_id) }}',
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                $progressBar.css('width', '80%');
                                $progressText.text('Finalizing transfer...');
                                
                                setTimeout(() => {
                                    $progressBar.css('width', '100%');
                                    $progressText.text('Transfer completed!');
                                    
                                    if (response.success) {
                                        setTimeout(() => {
                                            Swal.fire({
                                                title: 'Success!',
                                                text: response.message,
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            }).then(() => {
                                                location.reload();
                                            });
                                        }, 500);
                                    } else {
                                        Swal.fire('Error', response.message, 'error');
                                    }
                                    
                                    // Reset form
                                    $submitBtn.prop('disabled', false).html('<i class="las la-exchange-alt"></i> Transfer Schedule');
                                    setTimeout(() => {
                                        $progress.hide();
                                        $progressBar.css('width', '0%');
                                        if (response.success) {
                                            $('#transferScheduleModal').modal('hide');
                                        }
                                    }, response.success ? 1000 : 500);
                                }, 1000);
                            },
                            error: function(xhr, status, error) {
                                $progressBar.css('width', '0%');
                                $progress.hide();
                                $submitBtn.prop('disabled', false).html('<i class="las la-exchange-alt"></i> Transfer Schedule');
                                
                                let message = 'An error occurred while transferring the schedule.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                } else if (xhr.status === 404) {
                                    message = 'Schedule not found or may have been deleted.';
                                } else if (xhr.status === 422) {
                                    message = 'Invalid transfer request. Please check your selections.';
                                }
                                
                                Swal.fire('Error', message, 'error');
                            }
                        });
                    }
                });
            });

            // Reset transfer modal when closed
            $('#transferScheduleModal').on('hidden.bs.modal', function () {
                $('#transferScheduleForm')[0].reset();
                $('#transfer_progress').hide();
                $('.progress-bar').css('width', '0%');
                $('#transferScheduleBtn').prop('disabled', false).html('<i class="las la-exchange-alt"></i> Transfer Schedule');
                $('#target_venue').html('<option value="">Select Target Venue</option>');
                initializeSelect2();
            });

            // Transfer Candidates functionality
            var selectedCandidates = [];
            var allCandidates = [];

            // Transfer Candidates Modal - when button is clicked
            $('body').on('click', '.transfer-candidates-btn', function() {
                const scheduleId = $(this).data('schedule-id');
                const scheduleCentre = $(this).data('schedule-centre');
                const scheduleVenue = $(this).data('schedule-venue');
                const scheduleDate = $(this).data('schedule-date');
                
                // Populate modal with current schedule info
                $('#transfer_candidates_schedule_id').val(scheduleId);
                $('#source_schedule_centre').text(scheduleCentre || 'N/A');
                $('#source_schedule_venue').text(scheduleVenue || 'N/A');
                $('#source_schedule_date').text(scheduleDate || 'N/A');
                
                // Reset UI
                resetTransferCandidatesModal();
                
                // Load candidates for this schedule
                loadScheduleCandidates(scheduleId);
                
                // Reinitialize Select2
                setTimeout(() => {
                    initializeSelect2();
                }, 100);
            });

            // Transfer Candidates Modal - shown event
            $('#transferCandidatesModal').on('shown.bs.modal', function () {
                initializeSelect2();
            });

            // Reset transfer candidates modal
            function resetTransferCandidatesModal() {
                selectedCandidates = [];
                allCandidates = [];
                
                // Reset form fields
                $('#candidate_target_centre').val(null).trigger('change');
                $('#candidate_transfer_mode').val('').trigger('change');
                $('#target_schedules_section').hide();
                $('#selected_target_schedule').val('');
                $('#candidate_search').val('');
                $('#candidate_filter').val('all');
                
                // Reset candidates UI
                $('#candidates_loading').show();
                $('#candidates_table_container').hide();
                $('#no_candidates_found').hide();
                $('#candidate_transfer_progress').hide();
                $('.progress-bar').css('width', '0%');
                
                // Reset selection counts
                updateSelectedCandidatesCount();
                $('#transferCandidatesBtn').prop('disabled', true);
            }

            // Load candidates for selected schedule
            function loadScheduleCandidates(scheduleId) {
                $('#candidates_loading').show();
                $('#candidates_table_container').hide();
                $('#no_candidates_found').hide();
                
                // Use the actual API endpoint
                $.ajax({
                    url: `{{ url('/admin/test/config/schedules') }}/${scheduleId}/candidates`,
                    type: 'GET',
                    success: function(response) {
                        if (response.success && response.candidates && response.candidates.length > 0) {
                            // Sort candidates by indexing number in ascending order
                            allCandidates = response.candidates.sort(function(a, b) {
                                // Handle cases where indexing might be null or undefined
                                const indexA = a.indexing || '';
                                const indexB = b.indexing || '';
                                
                                // Try to compare as numbers if they are numeric, otherwise compare as strings
                                const numA = parseInt(indexA.replace(/[^0-9]/g, ''));
                                const numB = parseInt(indexB.replace(/[^0-9]/g, ''));
                                
                                if (!isNaN(numA) && !isNaN(numB)) {
                                    return numA - numB;
                                }
                                
                                // Fallback to string comparison
                                return indexA.localeCompare(indexB);
                            });
                            
                            displayCandidates(allCandidates);
                            $('#candidates_loading').hide();
                            $('#candidates_table_container').show();
                        } else {
                            $('#candidates_loading').hide();
                            $('#no_candidates_found').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#candidates_loading').hide();
                        $('#no_candidates_found').show();
                        console.error('Error loading candidates:', xhr.responseText);
                    }
                });
            }

            // Generate sample candidates for demo
            function generateSampleCandidates() {
                return [
                    { id: 1, indexing: 'IDX001', name: 'John Doe', exam_number: 'EX2024001', status: 'scheduled', papers: ['Math', 'English'] },
                    { id: 2, indexing: 'IDX002', name: 'Jane Smith', exam_number: 'EX2024002', status: 'pulled', papers: ['Science', 'Math'] },
                    { id: 3, indexing: 'IDX003', name: 'Bob Johnson', exam_number: 'EX2024003', status: 'scheduled', papers: ['English', 'History'] },
                    { id: 4, indexing: 'IDX004', name: 'Alice Brown', exam_number: 'EX2024004', status: 'pushed', papers: ['Math', 'Science'] },
                    { id: 5, indexing: 'IDX005', name: 'Charlie Wilson', exam_number: 'EX2024005', status: 'scheduled', papers: ['History', 'English'] }
                ];
            }

            // Display candidates in table
            function displayCandidates(candidates) {
                let tableBody = $('#candidates_table_body');
                tableBody.empty();
                
                candidates.forEach(function(candidate) {
                    let statusBadge = '';
                    switch(candidate.status) {
                        case 'scheduled':
                            statusBadge = '<span class="badge bg-success">Scheduled</span>';
                            break;
                        case 'pulled':
                            statusBadge = '<span class="badge bg-warning">Pulled</span>';
                            break;
                        case 'pushed':
                            statusBadge = '<span class="badge bg-info">Pushed</span>';
                            break;
                        default:
                            statusBadge = '<span class="badge bg-secondary">Unknown</span>';
                    }
                    
                    let papersText = Array.isArray(candidate.papers) ? candidate.papers.join(', ') : candidate.papers || 'N/A';
                    
                    let row = `
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input candidate-checkbox" value="${candidate.id}" data-status="${candidate.status}">
                            </td>
                            <td>${candidate.indexing || 'N/A'}</td>
                            <td>${candidate.name || 'N/A'}</td>
                            <td>${candidate.exam_number || 'N/A'}</td>
                            <td>${statusBadge}</td>
                            <td><small>${papersText}</small></td>
                        </tr>
                    `;
                    
                    tableBody.append(row);
                });
            }

            // Candidate search functionality
            $('#candidate_search').on('input', function() {
                filterAndDisplayCandidates();
            });

            // Candidate filter functionality
            $('#candidate_filter').on('change', function() {
                filterAndDisplayCandidates();
            });

            // Filter and display candidates based on search and filter
            function filterAndDisplayCandidates() {
                let searchTerm = $('#candidate_search').val().toLowerCase();
                let statusFilter = $('#candidate_filter').val();
                
                let filteredCandidates = allCandidates.filter(function(candidate) {
                    let matchesSearch = !searchTerm || 
                        (candidate.name && candidate.name.toLowerCase().includes(searchTerm)) ||
                        (candidate.indexing && candidate.indexing.toLowerCase().includes(searchTerm)) ||
                        (candidate.exam_number && candidate.exam_number.toLowerCase().includes(searchTerm));
                    
                    let matchesStatus = statusFilter === 'all' || candidate.status === statusFilter;
                    
                    return matchesSearch && matchesStatus;
                });
                
                displayCandidates(filteredCandidates);
                updateSelectedCandidatesCount();
            }

            // Bulk selection buttons
            $('#select_all_candidates').on('click', function() {
                $('.candidate-checkbox:visible').prop('checked', true);
                updateSelectedCandidatesCount();
            });

            $('#deselect_all_candidates').on('click', function() {
                $('.candidate-checkbox').prop('checked', false);
                updateSelectedCandidatesCount();
            });

            $('#select_scheduled_only').on('click', function() {
                $('.candidate-checkbox').prop('checked', false);
                $('.candidate-checkbox[data-status="scheduled"]:visible').prop('checked', true);
                updateSelectedCandidatesCount();
            });

            // Select all checkbox in table header
            $(document).on('change', '#select_all_table_candidates', function() {
                let isChecked = $(this).is(':checked');
                $('.candidate-checkbox:visible').prop('checked', isChecked);
                updateSelectedCandidatesCount();
            });

            // Individual candidate checkbox change
            $(document).on('change', '.candidate-checkbox', function() {
                updateSelectedCandidatesCount();
                updateSelectAllTableState();
            });

            // Update select all table checkbox state
            function updateSelectAllTableState() {
                let totalVisible = $('.candidate-checkbox:visible').length;
                let checkedVisible = $('.candidate-checkbox:visible:checked').length;
                let selectAllCheckbox = $('#select_all_table_candidates')[0];
                
                if (checkedVisible === 0) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                } else if (checkedVisible === totalVisible) {
                    selectAllCheckbox.checked = true;
                    selectAllCheckbox.indeterminate = false;
                } else {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = true;
                }
            }

            // Update selected candidates count
            function updateSelectedCandidatesCount() {
                selectedCandidates = [];
                $('.candidate-checkbox:checked').each(function() {
                    selectedCandidates.push($(this).val());
                });
                
                $('#selected_candidates_count').html(`<strong>${selectedCandidates.length}</strong> candidates selected`);
                $('#transferCandidatesBtn').prop('disabled', selectedCandidates.length === 0);
            }

            // Target centre change handler for candidate transfer
            $('#candidate_target_centre').on('change', function() {
                const centreId = $(this).val();
                
                if (centreId) {
                    // Load venues for selected centre
                    $.get('{{ route('admin.misc.venues',[':id']) }}'.replace(':id', centreId), function (data) {
                        let options = `<option value="">Select Target Venue</option>`;
                        $.each(data, function (i, v) {
                            options += `<option value='${v.id}'>${v.name}</option>`;
                        });
                        $('#candidate_target_venue').html(options);
                        
                        // Reinitialize select2 for candidate target venue dropdown
                        try {
                            if ($('#candidate_target_venue').hasClass('select2-hidden-accessible')) {
                                $('#candidate_target_venue').select2('destroy');
                            }
                            
                            var $modal = $('#candidate_target_venue').closest('.modal');
                            var config = {
                                width: '100%',
                                allowClear: true,
                                minimumResultsForSearch: 0,
                                placeholder: 'Select Target Venue'
                            };
                            if ($modal.length > 0) {
                                config.dropdownParent = $modal;
                            }
                            $('#candidate_target_venue').select2(config);
                        } catch (error) {
                            console.error('Error initializing candidate target venue select2:', error);
                        }
                    }).fail(function() {
                        Swal.fire('Error', 'Failed to load venues for selected centre', 'error');
                    });
                    
                    // Also check if we need to load schedules
                    if ($('#candidate_transfer_mode').val() === 'specific_schedule') {
                        loadTargetSchedules(centreId, $('#candidate_target_venue').val());
                    }
                } else {
                    // Reset venue dropdown when no centre is selected
                    $('#candidate_target_venue').html('<option value="">Select Target Venue</option>');
                    $('#target_schedules_section').hide();
                    $('#selected_target_schedule').val('');
                }
            });
            
            // Target venue change handler for candidate transfer
            $('#candidate_target_venue').on('change', function() {
                const centreId = $('#candidate_target_centre').val();
                const venueId = $(this).val();
                
                if (centreId && $('#candidate_transfer_mode').val() === 'specific_schedule') {
                    loadTargetSchedules(centreId, venueId);
                }
            });

            // Transfer mode change handler for candidates
            $('#candidate_transfer_mode').on('change', function() {
                const mode = $(this).val();
                const centreId = $('#candidate_target_centre').val();
                
                if (mode === 'specific_schedule' && centreId) {
                    $('#target_schedules_section').show();
                    loadTargetSchedules(centreId);
                } else {
                    $('#target_schedules_section').hide();
                    $('#selected_target_schedule').val('');
                }
            });

            // Load target schedules for selected centre and optionally filter by venue
            function loadTargetSchedules(centreId, venueId = null) {
                $('#target_schedules_list').html('<p class="text-muted mb-0">Loading available schedules...</p>');
                
                // Build URL with test config ID and optional venue parameter
                let url = `{{ url('/admin/misc/centre') }}/${centreId}/schedules?test_config_id={{ $config_id }}`;
                if (venueId) {
                    url += `&venue_id=${venueId}`;
                }
                
                // Call the actual API endpoint
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.success && response.schedules && response.schedules.length > 0) {
                            displayTargetSchedules(response.schedules);
                        } else {
                            let message = venueId ? 
                                'No available schedules found for this venue' : 
                                'No available schedules found for this centre';
                            $('#target_schedules_list').html(`<p class="text-muted mb-0">${message}</p>`);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading target schedules:', xhr.responseText);
                        let message = venueId ? 
                            'Error loading schedules for this venue' : 
                            'Error loading schedules for this centre';
                        $('#target_schedules_list').html(`<p class="text-muted mb-0">${message}</p>`);
                    }
                });
            }

            // Display target schedules
            function displayTargetSchedules(schedules) {
                let html = '';
                schedules.forEach(function(schedule) {
                    let availableSlots = schedule.capacity - schedule.current_count;
                    let statusClass = availableSlots > 0 ? 'text-success' : 'text-warning';
                    
                    html += `
                        <div class="form-check mb-2">
                            <input class="form-check-input target-schedule-radio" type="radio" name="target_schedule" value="${schedule.id}" id="schedule_${schedule.id}">
                            <label class="form-check-label" for="schedule_${schedule.id}">
                                <strong>${schedule.venue}</strong> - ${schedule.date}<br>
                                <small class="text-muted">
                                    ${schedule.start_time} - ${schedule.end_time} | 
                                    <span class="${statusClass}">${availableSlots} slots available (${schedule.current_count}/${schedule.capacity})</span>
                                </small>
                            </label>
                        </div>
                    `;
                });
                
                $('#target_schedules_list').html(html);
            }

            // Target schedule selection
            $(document).on('change', '.target-schedule-radio', function() {
                $('#selected_target_schedule').val($(this).val());
            });

            // Transfer candidates button click
            $('#transferCandidatesBtn').on('click', function() {
                if (selectedCandidates.length === 0) {
                    Swal.fire('Error', 'Please select at least one candidate to transfer', 'error');
                    return;
                }
                
                if (!$('#candidate_target_centre').val()) {
                    Swal.fire('Error', 'Please select a target centre', 'error');
                    return;
                }
                
                if (!$('#candidate_transfer_mode').val()) {
                    Swal.fire('Error', 'Please select a transfer mode', 'error');
                    return;
                }
                
                if ($('#candidate_transfer_mode').val() === 'specific_schedule' && !$('#selected_target_schedule').val()) {
                    Swal.fire('Error', 'Please select a target schedule', 'error');
                    return;
                }
                
                // Show confirmation
                const targetCentreName = $('#candidate_target_centre option:selected').text();
                const sourceCentreName = $('#source_schedule_centre').text();
                
                Swal.fire({
                    title: 'Transfer Candidates?',
                    html: `This will transfer <strong>${selectedCandidates.length} candidates</strong> from:<br><strong>${sourceCentreName}</strong><br>to:<br><strong>${targetCentreName}</strong>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Transfer Candidates'
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log("starting candidate transfer...");
                        performCandidateTransfer();
                    }
                });
            });

            // Perform candidate transfer
            function performCandidateTransfer() {
                const $submitBtn = $('#transferCandidatesBtn');
                const $progress = $('#candidate_transfer_progress');
                const $progressBar = $progress.find('.progress-bar');
                const $progressText = $('#candidate_transfer_progress_text');
                
                // Disable button and show progress
                $submitBtn.prop('disabled', true).html('<i class="las la-spinner la-spin"></i> Processing...');
                $progress.show();
                $progressBar.css('width', '20%');
                $progressText.text('Initiating candidate transfer...');
                
                // Prepare form data
                const formData = {
                    source_schedule_id: $('#transfer_candidates_schedule_id').val(),
                    target_centre_id: $('#candidate_target_centre').val(),
                    transfer_mode: $('#candidate_transfer_mode').val(),
                    target_schedule_id: $('#selected_target_schedule').val(),
                    candidate_ids: selectedCandidates
                };
                
                console.log('Form data for candidate transfer:', formData);
                $.ajax({
                    url: '{{ route('admin.test.config.transfer-candidates', $config_id) }}',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $progressBar.css('width', '80%');
                        $progressText.text('Finalizing transfer...');
                        console.log('Candidate transfer response:', response);
                        setTimeout(() => {
                            $progressBar.css('width', '100%');
                            $progressText.text('Transfer completed!');
                            
                            if (response.success) {
                                setTimeout(() => {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: response.message || `Successfully transferred ${selectedCandidates.length} candidates`,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        location.reload();
                                    });
                                }, 500);
                            } else {
                                Swal.fire('Error', response.message || 'An error occurred during transfer', 'error');
                                resetTransferUI();
                            }
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        let message = 'An error occurred while transferring candidates.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        
                        Swal.fire('Error', message, 'error');
                        resetTransferUI();
                    }
                });
            }

            // Reset transfer UI after error
            function resetTransferUI() {
                const $submitBtn = $('#transferCandidatesBtn');
                const $progress = $('#candidate_transfer_progress');
                const $progressBar = $progress.find('.progress-bar');
                
                $submitBtn.prop('disabled', selectedCandidates.length === 0).html('<i class="las la-user-friends"></i> Transfer Selected Candidates');
                $progress.hide();
                $progressBar.css('width', '0%');
            }

            // Reset transfer candidates modal when closed
            $('#transferCandidatesModal').on('hidden.bs.modal', function () {
                resetTransferCandidatesModal();
                initializeSelect2();
            });
        })
    </script>
@endsection
