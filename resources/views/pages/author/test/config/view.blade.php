@php use App\Models\TestCode;use App\Models\TestConfig;use App\Models\TestType; @endphp
@extends('layouts.app')

@section('content')
    <div class="row mt-3">

        <div class="col-6 col-lg-6 col-xl-6 col-md-12">
            <div class="card border-info">
                <div class="card-header border-info">
                    {{ $config->session }} / {{ $config->test_type->name}}
                    / {{ $config->semester==1?'First':'Second' }}
                </div>
                <div class="card-body">
                    <ol style="list-style-type: circle;">
                        <li>
                            <a href="{{ route('admin.test.config.basics',[$config->id]) }}" class="mb-2">
                                Basic Configurations
                            </a>
                        </li>
                        <li><a href="" class="mb-2">Test Versions</a></li>
                        <li>
                            <a href="{{ route('admin.test.config.dates',[$config->id]) }}" class="mb-2">Test Dates</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.test.config.schedules',[$config->id]) }}" class="mb-2">
                                Test Schedules
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.test.config.mappings',[$config->id]) }}" class="mb-2">
                                Test Mapping
                            </a>
                        </li>
                        <li><a href="" class="mb-2">Manual Candidate Scheduling</a></li>
                        <li>
                            <a href="{{ route('admin.test.config.subjects',[$config->id]) }}" class="mb-2">
                                Test Subjects
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.test.config.composition',[$config->id]) }}" class="mb-2">
                                Test Composition
                            </a>
                        </li>
                        <li><a href="" class="mb-2">Preview Test Questions</a></li>
                        <li><a href="" class="mb-2">Manage Users</a></li>
                        <li><a href="" class="mb-2">Delete</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <div class="modal fade custom-modal" id="add_new_config">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Test Config</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{ route('admin.test.config.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="hours-info">
                            <div class="row hours-cont">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                @php
                                                    $now = date('Y');
                                                    $years = range($now - 2, $now + 2);
                                                @endphp
                                                <label for="session" class="mb-2">Year</label>
                                                <select class="form-select form-control" id="session" name="session"
                                                        required>
                                                    @foreach($years as $year)
                                                        <option
                                                            value="{{ $year }}" {{$year==$now?'selected':''}} >{{ $year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label class="mb-2" for="semester">Semester</label>
                                                <select class="form-select form-control" id="semester" required
                                                        name="semester">
                                                    <option value="1" selected>First</option>
                                                    <option value="2">Second</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row hours-cont">
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="test_code_id" class="mb-2">Test Code</label>
                                                <select class="form-select form-control" id="test_code_id" required
                                                        name="test_code_id">
                                                    <option value="">Select Test Code</option>
                                                    @foreach(TestCode::orderBy('name')->get() as $code)
                                                        <option value="{{ $code->id }}">{{ $code->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="test_type_id" class="mb-2">Test Type</label>
                                                <select class="form-select form-control" id="test_type_id" required
                                                        name="test_type_id">
                                                    <option value="">Select Test Type</option>
                                                    @foreach(TestType::orderBy('name')->get() as $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer submit-section text-end">
                        <button type="submit" class="btn btn-sm btn-info submit-btn text-light">Create Test</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
