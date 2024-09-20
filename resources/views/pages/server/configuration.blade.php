@php
    use App\Models\TestCode;
    use App\Models\TestConfig;
    use App\Models\TestType;
@endphp
@extends('layouts.app')

@section('content')
    @if (session()->has('success'))
        @if (!session('success'))
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
    
    <div class="row">
        <div class="col-sm-12 col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Test Configurations</h4>
                    <div class="card-header-right">
                        <a data-bs-toggle="modal" href="#add_new_config" class="btn btn-primary btn-xs px-3">
                            <i class="las la-plus text-white"></i>Add
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.configuration') }}" method="post">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title d-flex justify-content-between">
                                            Duration & Mode
                                        </h4>
                                    
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label for="duration">Test Duration:</label>
                                                    <input class="form-control" type="number" name="duration" id="duration"
                                                           value="" placeholder="Duration (min)" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label for="time_padding">Padding Time:</label>
                                                    <input class="form-control" type="number" name="time_padding" id="time_padding"
                                                           value="" placeholder="Time (min)" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label for="endorsement">Select network card:</label>
                                                    <select class="form-control form-select" name="endorsement" id="endorsement"
                                                            required>
                                                        @foreach($network_interfaces as $network_interface) 
                                                            <option>{{  $network_interface }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label for="endorsement">Select file to configure:</label>
                                                    <select class="form-control form-select" name="endorsement" id="endorsement"
                                                            required>
                                                        @foreach($configuration_files as $file_name) 
                                                            <option>{{  $file_name }}</option>
                                                        @endforeach
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
                </div>
            </div>
        </div>


    </div>
    
@endsection

@section('script')
    
@endsection
