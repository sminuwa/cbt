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
                    <h4 class="mb-5 mt-5">Review Question(s)</h4>
                    <form method="post" action="{{ route('questions.authoring.store') }}">
                        <input type="hidden" name="subject_id" value="{{$subjectId}}">
                        <input type="hidden" name="topic_id" value="{{$topicId}}">
                        @csrf
                        @foreach($questions as $question)
                            <div class="card border-info">
                                <div class="card-header">
                                    <h4 class="card-title">({{$loop->iteration}}) {{ $question->title }}</h4>
                                </div>
                                <div class="card-body pt-2 pb-2  mt-1 mb-1">
                                    <div class="row">
                                        <div class="row pb-3 pt-2">
                                            <ol class="list-group list-group-flush ordered-list">
                                                @foreach($question->options as $option)
                                                    <li class="list-group-item {{$option->correctness=='1'?'list-group-item-success':''}}">{{ $option->question_option }}</li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <input class="btn btn-sm btn-info mt-3 text-light" type="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
