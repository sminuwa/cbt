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
                <div class="card">
                    <div class="card-header">
                        <h4>Duration & Mode</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="duration">Test Duration:</label>
                                    <input class="form-control" type="number" name="duration" id="duration"
                                           value="{{ $config->duration }}" placeholder="Duration (min)" required>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="time_padding">Padding Time:</label>
                                    <input class="form-control" type="number" name="time_padding" id="time_padding"
                                           value="{{$config->time_padding}}" placeholder="Time (min)" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
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
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="availability">Test Availability:</label>
                                    <select class="form-control form-select" name="availability" id="availability"
                                            required>
                                        <option {{$config->status==0?'selected':''}} value="0">Unavailable
                                        </option>
                                        <option {{$config->status==1?'selected':''}} value="1">Available
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
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
                            <div class="col-md-6 mt-3">
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
                <div class="card">
                    <div class="card-header">
                        <h4>Test Pattern</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label" for="display_mode">Question Display:</label>
                                    <select class="form-control form-select" name="display_mode" id="display_mode" required>
                                        <option value="single question" {{ $config->display_mode=='single question'?'selected':'' }}>Step by step</option>
                                        <option value="All" {{$config->display_mode=='All'?'selected':''}}>All at once</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label" for="question_administration">Question Administration:</label>
                                    <select class="form-control form-select" name="question_administration" id="question_administration" required>
                                        <option value="linear"{{$config->question_administration=='linear'?'selected':''}}>Linear</option>
                                        <option value="random" {{$config->question_administration=='random'?'Selected':''}}>Random</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label" for="option_administration">Option Administration:</label>
                                    <select class="form-control form-select" name="option_administration" id="option_administration" required>
                                        <option value="linear" {{$config->option_administration=='linear'?'selected':''}}>Linear</option>
                                        <option value="random" {{$config->option_administration=='random'?'selected':''}}>Random</option>
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
                <div class="card">
                    <div class="card-header">
                        <h4>Other Options</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
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
        <div class="mt-3 text-right">
            <input class="btn btn-primary text-light" type="submit" value="Save Config">
        </div>
    </form>
@endsection
