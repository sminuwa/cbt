@extends('layouts.app')

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
                    <h4 class="mb-5 mt-5">
                    </h4>
                    <div class="card border-info">
                        <div class="card-header">
                            <h4 class="card-title">Questions Authoring Successful!</h4>
                        </div>
                        <div class="card-body pt-2 pb-2  mt-1 mb-1">
                            <div class="row">
                                <div class="row pb-3 pt-2">
                                    <p>The process of questions authoring is now completed successfully. Click the
                                        bottom below to go back<br>

                                        <a href="{{route('questions.authoring')}}"
                                           class="btn btn-sm btn-info mt-5 text-light">Go Back</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
