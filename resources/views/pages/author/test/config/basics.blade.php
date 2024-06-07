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
    <form action="{{ route('admin.test.config.basics.store') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $config->id }}">
        <div class="row">
            <div class="col-md-8">
                <div class="card border-info">
                    <div class="card-header border-info">
                        <h4>Duration & Mode</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row mt-3">
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="duration">Test Duration:</label>
                                    <input class="form-control" type="number" name="duration" id="duration"
                                           value="{{ $config->duration }}" placeholder="Duration (min)" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="time_padding">Pending Time:</label>
                                    <input class="form-control" type="number" name="time_padding" id="time_padding"
                                           value="{{$config->time_padding}}" placeholder="Time (min)" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="endorsement">Invigilator's Endorsement:</label>
                                    <select class="form-control form-select" name="endorsement" id="endorsement"
                                            required>
                                        <option value="no" {{$config->endorsement=='no'?'selected':''}}>Not Required
                                        </option>
                                        <option value="yes"{{$config->endorsement=='yes'?'selected':''}}>Required
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="availability">Test Availability:</label>
                                    <select class="form-control form-select" name="availability" id="availability"
                                            required>
                                        <option value="0">Unavailable</option>
                                        <option value="1">Available</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="starting_mode">Starting Mode:</label>
                                    <select class="form-control form-select" name="starting_mode" id="starting_mode"
                                            required>
                                        <option value="on login" {{$config->starting_mode=='on login'?'selected':''}}>On
                                            Login
                                        </option>
                                        <option
                                            value="on starttime"{{$config->starting_mode=='on starttime'?'selected':''}}>
                                            On Start Time
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="pass_key">Registration Key:</label>
                                    <input class="form-control" type="text" name="pass_key" id="pass_key"
                                           placeholder="Computer Key" value="{{$config->pass_key?:'cbt'}}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-info">
                    <div class="card-header border-info">
                        <h4>Test Pattern</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row mt-3">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="display_mode">Question Display:</label>
                                    <select class="form-control form-select" name="display_mode" id="display_mode"
                                            required>
                                        <option value="All" {{$config->display_mode=='All'?'selected':''}}>All at once
                                        </option>
                                        <option
                                            value="single question" {{ $config->display_mode=='single question'?'selected':'' }}>
                                            Step by step
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="question_administration">Question Administration:</label>
                                    <select class="form-control form-select" name="question_administration"
                                            id="question_administration" required>
                                        <option
                                            value="linear"{{$config->question_administration=='linear'?'selected':''}}>
                                            Uniform
                                        </option>
                                        <option
                                            value="random" {{$config->question_administration=='random'?'Selected':''}}>
                                            Random
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="option_administration">Starting Mode:</label>
                                    <select class="form-control form-select" name="option_administration"
                                            id="option_administration" required>
                                        <option
                                            value="linear" {{$config->option_administration=='linear'?'selected':''}}>
                                            Uniform
                                        </option>
                                        <option
                                            value="random" {{$config->option_administration=='random'?'selected':''}}>
                                            Random
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card border-info">
                    <div class="card-header border-info">
                        <h4>Calculator Option</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row mt-3">
                            <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="allow_calc">Allow Use of In-Built Calculator:</label>
                                    <select class="form-control form-select" name="allow_calc" id="allow_calc" required>
                                        <option value="1"{{$config->allow_calc=='1'?'selected':''}}>Allow</option>
                                        <option value="0" {{$config->allow_calc=='0'?'selected':''}}>Disable
                                            Calculator
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3 d-flex justify-content-between">
            <a class="btn btn-warning text-light" href="{{ route('admin.test.config.index') }}"><i class="fa fa-arrow-left me-1"></i>Back</a>
            <input class="btn btn-info text-light" type="submit" value="Save Config">
        </div>
    </form>
@endsection
