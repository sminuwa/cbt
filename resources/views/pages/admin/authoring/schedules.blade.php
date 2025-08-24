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
                        <th>Candidates (S/P/P)</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Batches</th>
                        <th>No. Per Batch</th>
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
                                <a class="btn btn-sm btn-warning modify" style="padding: 2px 8px;"
                                data-id="{{$schedule->id}}" data-date="{{$schedule->date}}"
                                data-venue="{{$schedule->venue->id}}" data-centre="{{$schedule->venue->centre->id}}"
                                data-batch="{{$schedule->maximum_batch}}" data-count="{{$schedule->no_per_schedule}}"
                                data-start="{{Carbon::parse($schedule->daily_start_time)->format('H:m')}}"
                                data-end="{{Carbon::parse($schedule->daily_end_time)->format('H:m')}}"
                                href="javascript:;">
                                    <i class="las la-edit"></i>
                                </a>
                                <a class="btn btn-sm btn-danger" style="padding: 2px 8px;" onclick="return confirm('Are you sure you want to delete this schedule? ')"
                                    href="{{route('admin.test.config.schedules.delete',[$schedule->id])}}">
                                <i class="las la-trash"></i>
                                </a>

                                <a class="btn btn-sm btn-info schedule-candidates" style="padding: 2px 15px;" 
                                data-bs-toggle="modal" href="#schedule-candidates"
                                data-id="{{$schedule->id}}"
                                data-test_config_id="{{$schedule->test_config_id}}"
                                >
                                <i class="las la-upload"></i>
                                </a>
                                
                                
                            </td>
                            
                            <td>{{ $schedule->venue->centre->name ?? null }}</td>
                            <td>
                                
                                {{ $schedule->total_schedules ?? 0 }}/{{ $schedule->pull_status->total_candidate ?? 0 }}/{{ $schedule->total_pushed ?? 0 }}
                               
                            </td>
                            <td>{{  Carbon::parse($schedule->date)->format('D jS M, Y') }}</td>
                            <td>{{ date('g:i A', strtotime($schedule->date.' '.$schedule->daily_start_time)) }}</td>
                            <td>{{ date('g:i A', strtotime($schedule->date.' '.$schedule->daily_end_time)) }}</td>
                            <td>{{ $schedule->maximum_batch }}</td>
                            <td>{{ $schedule->no_per_schedule }}</td>
                            
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
                                           accept=".xls,.xlsx" required>
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
                if (!['xls', 'xlsx'].includes(fileExtension)) {
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
                                            // location.reload();
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
        })
    </script>
@endsection
