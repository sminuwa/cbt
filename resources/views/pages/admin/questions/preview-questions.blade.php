@extends('layouts.app')
@section('css')
    <style>
        .list-group.ordered-list {
            counter-reset: list-counter;
        }

        .list-group.ordered-list .list-group-item {
            position: relative;
            padding-left: 25px;
        }

        .list-group.ordered-list .list-group-item::before {
            content: counter(list-counter, upper-alpha) ".  ";
            counter-increment: list-counter;
            position: absolute;
            left: 0em;
            top: 0.5em;
        }
    </style>
@endsection
@section('content')

    <div class="row">
        <x-head.tinymce-config/>
        <!-- Profile Sidebar -->
        <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
            <div class="profile-sidebar">
                <div class="widget-profile pro-widget-content">
                    <div class="profile-info-widget">
                        <a href="#" class="booking-doc-img">
                            <img src="{{asset("assets/img/patients/patient.jpg")}}" alt="User Image">
                        </a>
                        <div class="profile-det-info">
                            <h3>Richard Wilson</h3>
                            <div class="patient-details">
                                <h5><i class="fas fa-birthday-cake"></i> 24 Jul 1983, 38 years</h5>
                                <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Newyork, USA</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dashboard-widget">
                    <nav class="dashboard-menu">
                        <ul>
                            <li class="active">
                                <a href="patient-dashboard.html">
                                    <i class="fas fa-columns"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="profile-settings.html">
                                    <i class="fas fa-user-cog"></i>
                                    <span>Profile Settings</span>
                                </a>
                            </li>
                            <li>
                                <a href="change-password.html">
                                    <i class="fas fa-lock"></i>
                                    <span>Change Password</span>
                                </a>
                            </li>
                            <li>
                                <a href="login.html">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
        <!-- / Profile Sidebar -->

        <div class="col-md-7 col-lg-8 col-xl-9">

            <div class="row patient-graph-col">
                <div class="col-12">
                    <h4 class="mb-5 mt-5">Question(s) Preview</h4>
                    <form id="preview-form" method="post">
                        @csrf
                        <div class="row pb-3 pt-2">
                            <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="subject_id">Subject:</label>
                                    <select class="form-control form-select" name="subject_id"
                                            id="subject_id" required>
                                        <option value="">Select Subject</option>
                                        @foreach(\App\Models\Subject::all() as $subject)
                                            <option value="{{$subject->id}}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="topic_id">Topic:</label>
                                    <select class="form-control form-select" name="topic_id" id="topic_id"
                                            required>
                                        <option value="">Select Topic</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                <input type="submit" class="btn btn-info text-light mt-4" value="Load Preview"/>
                            </div>
                        </div>
                    </form>
                    <div id="questions-div"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
            $('#subject_id').on('change', function () {
                let id = $(this).val();
                $.get('{{ route('questions.topics',[':id']) }}'.replace(':id', id), function (data) {
                    $('#topic_id').html(data)
                })
            })

            $('#preview-form').on('submit', function (e) {
                e.preventDefault()
                $.post('{{ route('questions.authoring.load.preview') }}', $(this).serialize(), function (response) {
                    $('#questions-div').html(response)
                })
            })
        })
    </script>
@endsection
