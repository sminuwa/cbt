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
                        <input type="hidden" name="test_config_id" value="{{$config_id}}">
                        <div id="compositor-div">
                        </div>
                    </form>

                    <div style="display: none" class="mt-1">
                        <p class="p-3">Available Compositor(s)</p>

                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Staff #</th>
                                <th>Full Name</th>
                                <th>Department</th>
                                <th>Subject(s)</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="tab-pane" id="invigilators">
                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="test_config_id" value="">
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
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$user->number}}</td>
                                <td>{{$user->name}}</td>
                                <td>
                                    @foreach($user->subjects as $subject)
                                        <p> {{$subject->subject_code}} - {{$subject->name}} </p>
                                    @endforeach
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-danger text-light"
                                       href="{{route('admin.test.config.manage.users.remove.compositor',[$config_id,$user->id])}}">Remove</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="invigilator-div" style="display: none"></div>
                <div id="previewer-div" style="display: none"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            let header = $('#header')
            $('#search-compositor').on('click', function () {
                let user_number = $('#staff_number').val()
                if (user_number === '') {
                    alert('Provide User Number to continue')
                    return
                }

                $.post('{{route('admin.test.config.manage.users.search.compositor')}}', {
                    '_token': '{{csrf_token()}}',
                    'user_number': user_number,
                    'config_id': {{$config_id}}
                }, function (response) {
                    $('#compositor-div').html(response)
                })
            })
            $('.compositors').on('click', function () {
                header.html('Available Test Compositor(s)')
            })

            $('.invigilators').on('click', function () {
                header.html('Available Test Invigilator(s)')
            })

            $('.previewer').on('click', function () {
                header.html('Available Test Previewer')
            })
        })
    </script>
@endsection
