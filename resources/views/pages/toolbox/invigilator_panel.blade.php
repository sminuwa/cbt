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
                                                    <td><b>Username</b></td>
                                                    <td>
                                                        <input type="text" name="username" value="" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <button id="btn-nxt-step1" class="btn btn-primary">Load Candidate's Profile</button>
                                                    </td>
                                                </tr>
                                            </table>

                                <div id="second-step" style='display:none;'></div>
                            </form>
                        </div>
                </div>

                        <div class="tab-pane" id="time_control">
                            <form id="frm2" class="style-frm" method="post" action="{{ route('toolbox.invigilator.increase-time.view') }}">
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
                                                <td><b> Exam Type</b></td>
                                                <td>
                                                    <select name="testid_inc" id="testid_inc" class="form-control">
                                                        <option value="">Select Category</option>
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
                                            <tr>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </div>
                                </fieldset>
                            </form>
                            <div id="cand_data2" style="display:none"></div>
                        </div>
                        </div>

                        <div class="tab-pane" id="reset_password">

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
                </script>
@endsection
