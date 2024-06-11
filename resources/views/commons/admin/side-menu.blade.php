<!-- Profile Sidebar -->
<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
    <div class="profile-sidebar">
        <div class="widget-profile pro-widget-content">
            <div class="profile-info-widget">
                <a href="#" class="booking-doc-img">
                    <img src="/assets/img/patients/patient.jpg" alt="User Image">
                </a>
                <div class="profile-det-info">
                    <h3>Sylux Endyusa Dimitri</h3>
                    <div class="patient-details">
                        <h5><i class="fas fa-birthday-cake"></i> 24 Jul 1983, 38 years</h5>
                        <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Moscow, Russia</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-widget">
            <nav class="dashboard-menu">
                <ul>
                    <li class="active">
                        <a href="{{ route('admin.dashboard.index') }}">
                            <i class="fas fa-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.test.config.index')}}">
                            <i class="fas fa-cogs"></i>
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
                        <a href="">
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
