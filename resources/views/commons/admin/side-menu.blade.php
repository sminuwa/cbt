<!-- Profile Sidebar -->
<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
    <div class="profile-sidebar">
        <div class="widget-profile pro-widget-content">
            <div class="profile-info-widget">
                <a href="#" class="booking-doc-img">
                    <img src="/assets/img/patients/patient.jpg" alt="User Image">
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
                        <a href="{{route('admin.test.config.index')}}">
                            <i class="fas fa-clipboard"></i>
                            <span>Test</span>
                        </a>
                    </li>
                    <li>
                        <a href="dependent.html">
                            <i class="fas fa-users"></i>
                            <span>Dependent</span>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <i class="fas fa-comments"></i>
                            <span>Message</span>
                            <small class="unread-msg">23</small>
                        </a>
                    </li>
                    <li>
                        <a href="patient-accounts.html">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Accounts</span>
                        </a>
                    </li>
                    <li>
                        <a href="orders-list.html">
                            <i class="fas fa-list-alt"></i>
                            <span>Orders</span>
                            <small class="unread-msg">7</small>
                        </a>
                    </li>
                    <li>
                        <a href="medical-records.html">
                            <i class="fas fa-clipboard"></i>
                            <span>Add Medical Records</span>
                        </a>
                    </li>
                    <li>
                        <a href="medical-details.html">
                            <i class="fas fa-file-medical-alt"></i>
                            <span>Medical Details</span>
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
