@php
    use Carbon\Carbon; @endphp
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
                        <span>Upload Candidate List</span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body pt-0" style="padding: 1px !important;"></div>
    </div>
    <div class="card border-info">
        <div class="card-header border-info">
            <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
                <li class="nav-item">
                    <a class="nav-link active" href="#bulk-upload" data-bs-toggle="tab">Bulk Upload</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#single-candidate" data-bs-toggle="tab">Single Candidate</a>
                </li>
            </ul>
        </div>
        <div class="card-body p-3">
            <div class="tab-content">
                <div class="tab-pane" id="single-candidate">
                    <form method="post" action="{{route('admin.test.config.upload.single')}}">
                        @csrf
                        <input type="hidden" name="test_config_id" value="{{$config_id}}">
                        <div class="row">
                            <div class="col-4 col-md-12 col-xl-4 col-lg-4">
                                <div class="form-group">
                                    <label for="candidate_number">Candidate Number:</label>
                                    <input class="form-control" type="text" name="candidate_number"
                                           id="candidate_number" placeholder="Candidate Number" required>
                                </div>
                            </div>
                            <div class="col-8 col-md-12 col-xl-8 col-lg-8">
                                <div class="form-group">
                                    <label for="schedule">Test Schedule:</label>
                                    <select class="form-control form-select" name="schedule_id" id="schedule" required>
                                        @foreach($schedules as $schedule)
                                            <option value="{{$schedule->id}}">
                                                {{  Carbon::parse($schedule->date)->format('D jS M, Y') }} -
                                                {{ $schedule->venue->name }} -
                                                {{ $schedule->no_per_schedule }} -
                                                {{  Carbon::parse($schedule->daily_start_time)->format('h:m a') }} -
                                                {{  Carbon::parse($schedule->daily_end_time)->format('h:m a') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 col-md-12 col-xl-3 col-lg-3">
                                <input style="width:100%;" class="btn btn-info mt-1 text-light" type="submit"
                                       value="Register Candidate">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane show active" id="bulk-upload">
                    <form action="{{route('admin.test.config.upload.list')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="test_config_id" value="{{$config_id}}">
                        <div class="row">
                            <div class="col-12 col-md-12 col-xl-12 col-lg-12">
                                <div class="form-group">
                                    <label for="schedule">Test Schedule:</label>
                                    <select class="form-control form-select" name="schedule_id" id="schedule" required>
                                        @foreach($schedules as $schedule)
                                            <option value="{{$schedule->id}}">
                                                {{  Carbon::parse($schedule->date)->format('D jS M, Y') }} -
                                                {{ $schedule->venue->name }} -
                                                {{ $schedule->no_per_schedule }} -
                                                {{  Carbon::parse($schedule->daily_start_time)->format('h:m a') }} -
                                                {{  Carbon::parse($schedule->daily_end_time)->format('h:m a') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="file"></label>
                                    <input class="form-control" type="file" name="file" id="file" required>
                                </div>
                            </div>
                            <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="sheet">Sheet Number:</label>
                                    <input class="form-control" type="number" name="sheet" id="sheet"
                                           placeholder="Sheet Number (e.g 1)" required>
                                </div>
                            </div>
                            <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="column">Column:</label>
                                    <select class="form-control form-select" name="column" id="column">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3 col-md-12 col-lg-3 col-xl-3">
                                <input style="width: 100%" class="btn btn-info text-light" type="submit" value="Upload">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="appointment-tab border-info">


    </div>
@endsection

@section('script')
    <script>
        $(function () {
        })
    </script>
@endsection
