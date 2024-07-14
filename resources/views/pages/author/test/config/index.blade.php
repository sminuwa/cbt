@php use App\Models\TestCode;use App\Models\TestConfig;use App\Models\TestType; @endphp
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
    <div class="card border-info">
        <div class="card-header">
            <div class="row">
                <div>
                    <h4 class="card-title d-flex justify-content-between">
                        <span>Test Configurations</span>
                        <a data-bs-toggle="modal" href="#add_new_config"
                           class="edit-link btn btn-info text-light"><i class="fa fa-add me-1"></i>Add New</a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body pt-0" style="padding: 1px !important;"></div>
    </div>
    <div class="row mt-3">
        @php
            $configs = TestConfig::with('test_type')->select(['id','session','semester','test_type_id'])->orderBy('session','desc')->get();
        @endphp
        @foreach($configs as $config)
            <div class="col-4 col-lg-4 col-xl-4 col-md-6">
                <div class="card border-info">
                    <div class="card-header border-info view">
                        <a href="{{route('admin.test.config.basics',[$config->id])}}">
                            {{ $config->session }} / {{ $config->test_type->name}}
                            / {{ $config->semester==1?'First':'Second' }}
                        </a>
                    </div>
                    <div class="card-body">
                        <ol style="list-style-type: circle;">
                            <li><a href="" class="mb-2">Make Unavailable</a></li>
                            <li><a href="{{ route('admin.test.config.basics',[$config->id]) }}" class="mb-2">Configurations</a>
                            </li>
                            <li>Upload Candidates</li>
                            <li><a href="" class="mb-2">Add/Remove Venue</a></li>
                            <li><a href="" class="mb-2">Manage Users</a></li>
                            <li><a href="" class="mb-2">Delete</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        @endforeach
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
                                                <label class="mb-2" for="semester">Period</label>
                                                <select class="form-select form-control" id="semester" required
                                                        name="semester">
                                                    <option value="1" selected>April</option>
                                                    <option value="2">September</option>
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
                                                <label for="test_code_id" class="mb-2">Cadre/Programme</label>
                                                <select class="form-select form-control" id="test_code_id" required
                                                        name="test_code_id">
                                                    <option value="">Select</option>
                                                    @foreach(TestCode::orderBy('name')->get() as $code)
                                                        <option value="{{ $code->id }}">{{ $code->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="test_type_id" class="mb-2">Type</label>
                                                <select class="form-select form-control" id="test_type_id" required
                                                        name="test_type_id">
                                                    <option value="">Select Type</option>
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
