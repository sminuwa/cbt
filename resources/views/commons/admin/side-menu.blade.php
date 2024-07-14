@php use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\Request;use Illuminate\Support\Facades\Session; @endphp
    <!-- Profile Sidebar -->
<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
    <div class="profile-sidebar">
        <div class="widget-profile pro-widget-content">
            <div class="profile-info-widget">
                <a href="#" class="booking-doc-img">
                    <img src="/assets/img/patients/patient.jpg" alt="User Image">
                </a>
                @php
                   $user= Auth::user();
                @endphp
                <div class="profile-det-info">
                    <h3>{{$user->display_name}}</h3>
                    <div class="patient-details">
                        <h5><i class="fas fa-user"></i> {{$user->personnel_no}}</h5>
                        <h5 class="mb-0"><i class="fas fa-envelope"></i> {{$user->email}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-widget">
            <nav class="dashboard-menu">
                <ul>
                    <li class="{{Request::is('*dashboard')?'active':''}}">
                        <a href="{{ route('admin.dashboard.index') }}">
                            <i class="fas fa-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @if(Request::is('*dashboard*'))
                        <li>
                            <a href="{{route('admin.test.config.index')}}">
                                <i class="fas fa-cog"></i>
                                <span>Test Configuration</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.questions.authoring')}}">
                                <i class="fas fa-question"></i>
                                <span>Question Authoring</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('toolbox.candidate-types.index')}}">
                                <i class="fas fa-toolbox"></i>
                                <span>Admin Toolbox</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fas fa-bar-chart"></i>
                                <span>Reports</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fas fa-users"></i>
                                <span>Manage Users</span>
                            </a>
                        </li>
                    @endif
{{--                    Test Configuration--}}
                    @if(Request::is('*test/config*') && !Request::is('*test/config'))
                        @php $config = Session::get('config'); @endphp
                        <li class="{{Request::is('*basics')?'active':''}}">
                            <a href="{{route('admin.test.config.basics',[$config])}}">
                                <i class="fas fa-cogs"></i>
                                <span>Basic Configurations</span>
                            </a>
                        </li>
                        <li class="{{Request::is('*dates')?'active':''}}">
                            <a href="{{ route('admin.test.config.dates',[$config]) }}">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Test Dates</span>
                            </a>
                        </li>
                        <li class="{{Request::is('*schedules')?'active':''}}">
                            <a href="{{ route('admin.test.config.schedules',[$config]) }}">
                                <i class="fas fa-calendar-check"></i>
                                <span>Test Schedules</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fas fa-upload"></i>
                                <span>Upload Candidate List</span>
                            </a>
                        </li>
                        <li class="{{Request::is('*subjects*')?'active':''}}">
                            <a href="{{ route('admin.test.config.subjects',[$config]) }}">
                                <i class="fas fa-list"></i>
                                <span>Test Subjects</span>
                            </a>
                        </li>
                        <li class="{{Request::is('*composition*')?'active':''}}">
                            <a href="{{ route('admin.test.config.composition',[$config]) }}">
                                <i class="fas fa-edit"></i>
                                <span>Test Composition</span>
                            </a>
                        </li>
                        <li class="{{Request::is('*preview*')?'active':''}}">
                            <a href="{{ route('admin.test.config.composition.preview',[$config]) }}">
                                <i class="fas fa-display"></i>
                                <span>Preview Test Questions</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fas fa-users"></i>
                                <span>Manage Users</span>
                            </a>
                        </li>
                    @endif

{{--                    admin tool box menus--}}
                    @if(Request::is('*toolbox/*') && !Request::is('*toolbox/'))
                        <li class="{{Request::is('*manage_centers')?'active':''}}">
                            <a href="{{route('toolbox.center_venue.home')}}">
                                <span>Manage Centers/Venues</span>
                            </a>
                        </li>
                        <li class="{{Request::is('*subjects')?'active':''}}">
                            <a href="#">
                                <span>Manage Subject</span>
                            </a>
                        </li>
                        <li class="{{Request::is('*candidate_type')?'active':''}}">
                            <a href="{{ route('toolbox.candidate-types.index') }}">
                                <span>Manage Candidate Type</span>
                            </a>
                        </li>
                        <li class="{{Request::is('*candidates')?'active':''}}">
                            <a href="#">
                                <span>Manage Candidates</span>
                            </a>
                        </li>
                        <li class="{{Request::is('*candidate_upload')?'active':''}}">
                            <a href="#">
                                <i class="fas fa-upload"></i>
                                <span>Upload Candidate</span>
                            </a>
                        </li>
                        <li class="{{Request::is('*invigilator_toolkit*')?'active':''}}">
                            <a href="#">
                                <span>Invigilator Toolkit</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('auth.admin.logout') }}">
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
