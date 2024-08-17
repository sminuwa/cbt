<div class="sidebar-wrapper" data-layout="stroke-svg">
    <div class="logo-wrapper">
        <a href="#">
            <img class="img-fluid" src="{!! logo(40,40) !!}" alt="">
        </a>
        <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
        <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
    </div>
    <div class="logo-icon-wrapper">
        <a href="#">
            <img class="img-fluid" src="{!! logo(40,40) !!}"alt="">
        </a>
    </div>
    <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="#"><img class="img-fluid" src="{!! logo() !!}"
                            alt=""></a>
                    <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2"
                            aria-hidden="true"></i></div>
                </li>
                <li class="pin-title sidebar-main-title">
                    <div>
                        <h6>Pinned</h6>
                    </div>
                </li>
                <li class="sidebar-main-title">
                    <div>
                        <h6 class="lan-1">General</h6>
                    </div>
                </li>

                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"> </i>
                    <a class="sidebar-link text-white sidebar-title link-nav"
                        href="{{ route('admin.dashboard.index') }}" style="vertical-align:middle !important">
                        <i class="las la-home la-md-2x"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"> </i>
                    <a class="sidebar-link sidebar-title" href="#">
                        <i class="las la-cogs la-md-2x"></i>
                        <span>Test Configs </span>
                    </a>
                    <ul class="sidebar-submenu">
                        @php $config = session('config'); @endphp
                        <li><a href="{{ route('admin.test.config.index') }}">Test Panel</a></li>
                        {{-- <li><a href="{{ route('admin.test.config.basics', [$config]) }}">Basic Config</a></li>
                        <li><a href="{{ route('admin.test.config.dates', [$config]) }}">Test Date</a></li>
                        <li><a href="{{ route('admin.test.config.schedules', [$config]) }}">Test Schedule</a></li>
                        <li><a href="{{ route('admin.test.config.subjects', [$config]) }}">Test Papers</a></li>
                        <li><a href="{{ route('admin.test.config.composition', [$config]) }}">Test Compositions</a></li>
                        <li><a href="{{ route('admin.test.config.upload.options', [$config]) }}">Upload Candidates</a></li>
                        <li><a href="{{ route('admin.test.config.composition.preview', [$config]) }}">Preview Test Question</a></li>
                        <li><a href="{{ route('admin.test.config.manage.users', [$config]) }}">Manage Users</a></li> --}}
                    </ul>
                </li>
                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"> </i>
                    <a class="sidebar-link sidebar-title"
                        href="#">
                        <i class="las la-question-circle la-md-2x"></i>
                        <span>Question Bank </span></a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{ route('admin.questions.authoring.author') }}">Author Questions</a></li>
                        <li><a href="{{ route('admin.questions.authoring.edit.questions') }}">Modify Questions</a></li>
                        <li><a href="{{ route('admin.questions.authoring.move.questions') }}">Move Questions</a></li>
                        <li><a href="{{ route('admin.questions.authoring.preview') }}">Preview Questions</a></li>
                    </ul>
                </li>
                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"> </i>
                    <a class="sidebar-link sidebar-title"
                        href="#">
                        <i class="las la-cog la-md-2x"></i>
                        <span>Toolbox</span></a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{ route('toolbox.center_venue.home') }}">Centres</a></li>
                        <li><a href="{{ route('toolbox.subject.home') }}">Papers</a></li>
                        <li><a href="{{ route('toolbox.candidate-types.index') }}">Exam Type</a></li>
                        <li><a href="{{ route('toolbox.candidate_upload.upload.candidate') }}">Candidates</a></li>
                        <li><a href="{{ route('toolbox.candidate_image_upload.upload.images') }}">Candidate Pictures</a></li>

                    </ul>
                </li>
                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"> </i>
                    <a class="sidebar-link sidebar-title"
                        href="#">
                        <i class="las la-chart-pie la-md-2x"></i>
                        <span>Report </span></a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{ route('admin.reports.summary.reports') }}">Report Summary</a></li>
                        <li><a href="{{ route('admin.reports.summary.question') }}">Question Summary</a></li>
                        <li><a href="{{ route('admin.reports.summary.presentation') }}">Presentation Summary</a></li>
                        <li><a href="{{ route('admin.reports.active.index') }}">Active Candidates</a></li>
                    </ul>
                </li>

                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"> </i>
                    <a class="sidebar-link sidebar-title"
                        href="#">
                        <i class="las la-users la-md-2x"></i>
                        <span>Manage Exams </span></a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{ route('admin.exams.setup.index') }}">Pull Record</a></li>
                        <li><a href="{{ route('toolbox.invigilator.index') }}">Candidates</a></li>
                        <li><a href="#">Push Record</a></li>
                    </ul>
                </li>

                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"> </i>
                    <a class="sidebar-link sidebar-title"
                        href="#">
                        <i class="las la-lock la-md-2x"></i>
                        <span>Authorisation </span></a>
                    <ul class="sidebar-submenu">
                        <li><a href="#">Users</a></li>
                        <li><a href="#">Roles</a></li>
                    </ul>
                </li>

                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"> </i>
                    <a class="sidebar-link text-white sidebar-title link-nav"
                        href="{{ route('auth.admin.logout') }}">
                        <i class="las la-sign-out-alt la-md-2x"></i>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</div>
