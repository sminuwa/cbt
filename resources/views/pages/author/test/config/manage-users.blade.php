@php use App\Models\Scheduling; use Carbon\Carbon; @endphp
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
                        <span>Manage Users</span>
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
                    <a class="nav-link active compositors" href="#compositors" data-bs-toggle="tab">Compositors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link invigilators" href="#invigilators" data-bs-toggle="tab">Invigilators</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link previewer" href="#previewer" data-bs-toggle="tab">Previewer</a>
                </li>
            </ul>
        </div>
        <div class="card-body p-0">
            <div class="tab-content">
                <div class="tab-pane show active" id="compositors">
                    <div class="row p-3">
                        <div class="col-4 col-md-8 col-xl-4 col-lg-4">
                            <div class="form-group">
                                <label for="staff_number">User Number:</label>
                                <input class="form-control" type="text" name="staff_number"
                                       id="staff_number" placeholder="User Number" required>
                            </div>
                        </div>
                        <div class="col-2 col-md-4 col-xl-2 col-lg-2">
                            <label></label>
                            <input style="width:100%;" id="search-compositor" class="btn btn-info mt-1 text-light"
                                   type="submit" value="Generate">
                        </div>
                    </div>

                    <form method="post" action="{{route('admin.test.config.manage.users.add.compositor')}}"
                          class="ps-3 pe-3">
                        @csrf
                        <input type="hidden" name="test_config_id" value="{{$config->id}}">
                        <div id="compositor-div">
                        </div>
                    </form>
                </div>

                <div class="tab-pane" id="invigilators">
                    <form action="{{route('admin.test.config.manage.users.add.invigilator')}}" method="post"
                          class="p-3">
                        @csrf
                        <input type="hidden" name="test_config_id" value="{{$config->id}}">
                        <div class="row">
                            <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                                @php
                                    $schedules = Scheduling::with('venue')->where(['test_config_id' => $config->id])->get();
                                @endphp
                                <div class="form-group">
                                    <label for="scheduling">Test Schedule:</label>
                                    <select class="form-control form-select" name="scheduling_id" id="scheduling">
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
                            <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="staff">User Number:</label>
                                    <input class="form-control" type="text" name="staff" id="staff"
                                           placeholder="User Number" required>
                                </div>
                            </div>
                            <div class="col-4 col-md-12 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="pass_key">Pass Key:</label>
                                    <input class="form-control" type="text" name="pass_key" id="pass_key"
                                           placeholder="Pass Key" value="abc" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3 col-md-12 col-lg-3 col-xl-3">
                                <input style="width: 100%" class="btn btn-info text-light" type="submit"
                                       value="Generate">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane" id="previewer">
                    <div class="row p-3">
                        <div class="col-4 col-md-8 col-xl-4 col-lg-4">
                            <div class="form-group">
                                <label for="staff_number">User Number:</label>
                                <input class="form-control" type="text" name="staff_number"
                                       id="staff_num" placeholder="User Number" required>
                            </div>
                        </div>
                        <div class="col-2 col-md-4 col-xl-2 col-lg-2">
                            <label></label>
                            <input style="width:100%;" id="search-previewer" class="btn btn-info mt-1 text-light"
                                   type="submit" value="Generate">
                        </div>
                    </div>

                    <form method="post" action="{{route('admin.test.config.manage.users.add.previewer')}}"
                          class="ps-3 pe-3">
                        @csrf
                        <input type="hidden" name="test_config_id" value="{{$config->id}}">
                        <div id="previewer-div">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="schedules-div">
        <div class="card border-info">
            <div class="card-header border-info">
                <div class="row">
                    <div>
                        <h4 id="header" class="card-title d-flex justify-content-between">
                            Available Test Compositor(s)
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div id="compositors-div">
                    <table class="table table-bordered table-striped mt-2">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>User #</th>
                            <th>Full Name</th>
                            <th>Subject(s)</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            @if(count($user->compositor_subjects))
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$user->number}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>
                                        @foreach($user->compositor_subjects as $subject)
                                            <p> {{$subject->subject_code}} - {{$subject->name}} </p>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-danger text-light"
                                           href="{{route('admin.test.config.manage.users.remove.compositor',[$config->id,$user->id])}}">Remove</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="invigilators-div" style="display: none">
                    <table class="table table-bordered table-striped mt-2">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>User #</th>
                            <th>Full Name</th>
                            <th>Schedule(s)</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            @if(count($user->test_invigilators))
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$user->number}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>
                                        @foreach($user->test_invigilators as $invigilator)
                                            @php $schedule = $invigilator->scheduling; @endphp
                                            <p>
                                                {{  Carbon::parse($schedule->date)->format('D jS M, Y') }} -
                                                {{ $schedule->venue->name }} -
                                                {{ $schedule->no_per_schedule }} -
                                                {{  Carbon::parse($schedule->daily_start_time)->format('h:m a') }} -
                                                {{  Carbon::parse($schedule->daily_end_time)->format('h:m a') }}
                                            </p>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-danger text-light"
                                           href="{{route('admin.test.config.manage.users.remove.invigilator',[$config->id,$user->id])}}">Remove</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="previewers-div" style="display: none">
                    <table class="table table-bordered table-striped mt-2">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>User #</th>
                            <th>Full Name</th>
                            <th>Subject(s)</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            @if(count($user->previewer_subjects))
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$user->number}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>
                                        @foreach($user->previewer_subjects as $subject)
                                            <p> {{$subject->subject_code}} - {{$subject->name}} </p>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-danger text-light"
                                           href="{{route('admin.test.config.manage.users.remove.previewer',[$config->id,$user->id])}}">Remove</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            let header = $('#header')
            let compositors = $('#compositors-div')
            let invigilators = $('#invigilators-div')
            let previewers = $('#previewers-div')

            function search(user_number, callback) {
                $.post('{{route('admin.test.config.manage.users.search.compositor')}}', {
                    '_token': '{{csrf_token()}}',
                    'user_number': user_number,
                    'config_id': {{$config->id}}
                }, function (response) {
                    callback(response)
                })
            }

            $('#search-compositor').on('click', function () {
                let user_number = $('#staff_number').val()
                if (user_number === '') {
                    alert('Provide User Number to continue')
                    return
                }

                search(user_number, function (response) {
                    $('#compositor-div').html(response)
                })
            })

            $('#search-previewer').on('click', function () {
                let user_number = $('#staff_num').val()
                if (user_number === '') {
                    alert('Provide User Number to continue')
                    return
                }

                search(user_number, function (response) {
                    $('#previewer-div').html(response)
                })
            })


            $('.compositors').on('click', function () {
                header.html('Available Test Compositor(s)')
                $('#previewer-div').html('')
                compositors.show()
                invigilators.hide()
                previewers.hide()
            })

            $('.invigilators').on('click', function () {
                header.html('Available Test Invigilator(s)')
                invigilators.show()
                compositors.hide()
                previewers.hide()
            })

            $('.previewer').on('click', function () {
                header.html('Available Test Previewer(s)')
                $('#compositor-div').html('')
                previewers.show()
                compositors.hide()
                invigilators.hide()
            })
        })
    </script>
@endsection
