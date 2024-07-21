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
                        <span>Manage Exam Candidate</span>
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
                    <a class="nav-link active restore" href="#restore" data-bs-toggle="tab">Restore Candidate</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link time_control" href="#time_control" data-bs-toggle="tab">Manage Candidate Time</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link reset_password" href="#reset_password" data-bs-toggle="tab">Reset Candidate
                        Password</a>
                </li>
            </ul>
        </div>
        <div class="card-body p-0">
            <div class="tab-content">
                <div class="tab-pane show active" id="restore">
                    <div class="row p-3">
                            <h3>Restore Logged Out Candidate</h3><br>
                            <form id="frm1" class="style-frm" method="POST" action="">
                                @csrf
                                            <table>
                                                <tr>
                                                    <td><b>Candidate Exam</b></td>
                                                    <td>
                                                        <select name="examtype" id="examtype" class="form-control">
                                                            <option value="">--Select Exam Type--</option>
                                                            @foreach($testConfigs as $testConfig)
                                                                <option value="{{ $testConfig->id }}">{{ $testConfig->code ?? "" }}-{{$testConfig->type ??""}}-{{$testConfig->session ??""}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Indexing Number</b></td>
                                                    <td>
                                                        <input type="text" name="username" id="username" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <button id="btn-nxt-step1" class="btn btn-primary">Load Candidate's Profile</button>
                                                    </td>
                                                </tr>
                                            </table>

                                <div id="second-step" style='display:none;'>

                                </div>
                            </form>
                        </div>
                </div>

                        <div class="tab-pane" id="time_control">
                            <form id="frm2" method="post" action="{{ route('toolbox.invigilator.increase-time.view') }}">
                                @csrf
                                <fieldset><legend>Enter Candidate's Details</legend>
                                    <div id="cand_data">
                                        <table>
                                            <tr>
                                                <td><b> Candidate Type</b></td>
                                                <td>
                                                    <select name="candidatetype_inc" id="candidatetype_inc" class="form-control">
                                                        <option value="">--Select Candidate Type --</option>
                                                        @foreach($candidateTypes as $type)
                                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Exam</td>
                                                <td>
                                                    <select name="testid_inc" id="testid_inc" class="form-control">
                                                        <option value="">--Select Exam--</option>
                                                        @foreach($examTypes as $exam)
                                                            <option value="{{ $exam->testid }}">{{ strtoupper($exam->testname) }}-{{ $exam->testtypename }}-{{ $exam->session }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b> Username</b></td>
                                                <td> <input type="text" name="username_inc" value="" class="form-control"/></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <button type="submit" name="inc_time" id="inc_time" class="btn btn-primary">View Candidate's Time Usage</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </fieldset>
                            </form>
                            <div id="cand_data2" style="display:none"></div>
                        </div>

                        <div class="tab-pane" id="reset_password">
                            <form action="{{route('toolbox.invigilator.reset.password')}}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="hours-info">
                                        <div class="row hours-cont">
                                            <div class="col-12 col-md-12">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-6">
                                                            <label for="index_number" class="mb-6">Indexing Number</label>
                                                            <input type="text" id="index_number" name="index_number" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-6">
                                                            <label for="npassword" class="mb-6">Enter New Password</label>
                                                            <input type="text" id="npassword" name="npassword" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-6">
                                                            <label for="rnpassword" class="mb-6">Confirm New Password</label>
                                                            <input type="text" id="rnpassword" name="rnpassword" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary submit-btn text-light">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @endsection

@section('script')
    <script>
        $(function () {
            let header = $('#header')
            let restore = $('#restore-div')
            let time_control = $('#time_control-div')
            let reset_password = $('#reset_password-div')
        })

        //restore candidate details
        $(document).ready(function () {
            $('#btn-nxt-step1').click(function (e) {
                e.preventDefault();

                var examtype = $('#examtype').val();
                var username = $('#username').val();
                var _token = $('input[name="_token"]').val();
                //console.log(username, examtype)

                $.ajax({
                    url: "{{ route('toolbox.invigilator.candidate.loadProfile') }}",
                    method: "POST",
                    data: {
                        _token: _token,
                        examtype: examtype,
                        username: username
                    },
                    success: function (response) {
                        $('#second-step').html(`
                    <form class="style-frm">
                        <fieldset>
                            <legend>Candidate's Profile</legend>
                            <div>
                                <table style="width:100%">
                                    <tr>
                                        <td><b>Full Name:</b></td>
                                        <td>${response.candName}</td>
                                        <td rowspan="3" colspan="2">
                                            <div>
                                                <img src="{{ asset('candidate_pics') }}/${response.indexing}.jpg" onerror="this.onerror=null;this.src='{{ asset('assets/img/photo.png') }}';" style="width:150px; height:150px;" alt="image">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Reg No:</b></td>
                                        <td>${response.indexing}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Center:</b></td>
                                        <td>${response.centreName}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Venue:</b></td>
                                        <td>${response.venueName}</td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align:center">
                                            <button id="btn-bk-step2" class="btn btn-primary">Back</button>
                                            <button id="btn-nxt-step2" class="btn btn-primary">Restore Candidate</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </fieldset>
                    </form>
                `);
                        $('#second-step').show();
                    },
                    error: function (xhr) {
                        let errorMessage = "An error occurred";
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = xhr.responseJSON.errors.join(", ");
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert(errorMessage);
                    }
                });
            });
        });

        $(document).ready(function () {
            $("#testid_inc").select2();
        });

        $(document).on("submit", "#frm2", function (event) {
            event.preventDefault();
            $.ajax({
                type: 'post',
                url: '{{ route('toolbox.invigilator.increase-time.view') }}',
                data: $("#frm2").serialize()
            }).done(function (msg) {
                $("#cand_data2").empty().html(msg).slideDown();
                $("#cand_data").slideUp();
            });
        });

        $(document).on("click", "#btn-bk-step3", function (event) {
            $("#cand_data").slideDown();
            $("#cand_data2").slideUp();
        });

        $(document).on("click", "#btn-nxt-step3", function (event) {
            event.preventDefault();
            $.ajax({
                type: 'post',
                url: '{{ route('toolbox.invigilator.save-time.adjust') }}',
                data: $("#frm3").serialize()
            }).done(function (msg) {
                alert(msg == 1 ? "Time was adjusted successfully!" : "Operation was not successful!");
            });
        });
    </script>
@endsection
