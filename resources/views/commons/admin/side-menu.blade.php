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
                @php
                    $user = auth()->user();
                    // Test Configs Menu
                    $showTestConfigs = $user->canDo('admin.test.config.index') ||
                                    $user->canDo('admin.test.config.basics') ||
                                    $user->canDo('admin.test.config.dates') ||
                                    $user->canDo('admin.test.config.schedules') ||
                                    $user->canDo('admin.test.config.subjects') ||
                                    $user->canDo('admin.test.config.composition') ||
                                    $user->canDo('admin.test.config.upload.options') ||
                                    $user->canDo('admin.test.config.composition.preview') ||
                                    $user->canDo('admin.test.config.manage.users');

                    // Question Bank Menu
                    $showQuestionBank = $user->canDo('admin.questions.authoring.author') ||
                                        $user->canDo('admin.questions.authoring.edit.questions') ||
                                        $user->canDo('admin.questions.authoring.move.questions') ||
                                        $user->canDo('admin.questions.authoring.preview');

                    // Toolbox Menu
                    $showToolbox = $user->canDo('toolbox.center_venue.home') ||
                                $user->canDo('toolbox.subject.home') ||
                                $user->canDo('toolbox.candidate-types.index') ||
                                $user->canDo('toolbox.candidate_upload.upload.candidate') ||
                                $user->canDo('toolbox.candidate_image_upload.upload.images');

                    // Report Menu
                    $showReport = $user->canDo('admin.reports.summary.reports') ||
                                $user->canDo('admin.reports.summary.question') ||
                                $user->canDo('admin.reports.summary.presentation') ||
                                $user->canDo('admin.reports.active.index');

                    // Manage Exams Menu
                    $showManageExams = $user->canDo('admin.exams.setup.index') ||
                                    $user->canDo('toolbox.invigilator.index') ||
                                    $user->canDo('admin.exams.setup.push');

                    // Authorisation Menu
                    $showAuthorisation = $user->canDo('toolbox.authorization.users.index') ||
                                        $user->canDo('toolbox.authorization.role.index');
                @endphp
                @if($showTestConfigs)
                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"> </i>
                    <a class="sidebar-link sidebar-title" href="#">
                        <i class="las la-cogs la-md-2x"></i>
                        <span>Test Configs </span>
                    </a>
                    @php $config = session('config'); @endphp
                    <ul class="sidebar-submenu">
                        @if($user->canDo('admin.test.config.index'))
                            <li><a href="{{ route('admin.test.config.index') }}">Test Panel</a></li>
                        @endif
                        {{-- @if($user->canDo('admin.test.config.basics'))
                            <li><a href="{{ route('admin.test.config.basics', [$config]) }}">Basic Config</a></li>
                        @endif
                        @if($user->canDo('admin.test.config.dates'))
                            <li><a href="{{ route('admin.test.config.dates', [$config]) }}">Test Date</a></li>
                        @endif
                        @if($user->canDo('admin.test.config.schedules'))
                            <li><a href="{{ route('admin.test.config.schedules', [$config]) }}">Test Schedule</a></li>
                        @endif
                        @if($user->canDo('admin.test.config.subjects'))
                            <li><a href="{{ route('admin.test.config.subjects', [$config]) }}">Test Papers</a></li>
                        @endif
                        @if($user->canDo('admin.test.config.composition'))
                            <li><a href="{{ route('admin.test.config.composition', [$config]) }}">Test Compositions</a></li>
                        @endif
                        @if($user->canDo('admin.test.config.upload.options'))
                            <li><a href="{{ route('admin.test.config.upload.options', [$config]) }}">Upload Candidates</a></li>
                        @endif
                        @if($user->canDo('admin.test.config.composition.preview'))
                            <li><a href="{{ route('admin.test.config.composition.preview', [$config]) }}">Preview Test Question</a></li>
                        @endif
                        @if($user->canDo('admin.test.config.manage.users'))
                            <li><a href="{{ route('admin.test.config.manage.users', [$config]) }}">Manage Users</a></li>
                        @endif --}}
                    </ul>
                </li>
                @endif

                @if($showQuestionBank)
                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"> </i>
                    <a class="sidebar-link sidebar-title" href="#">
                        <i class="las la-question-circle la-md-2x"></i>
                        <span>Question Bank </span></a>
                    <ul class="sidebar-submenu">
                        @if($user->canDo('admin.questions.authoring.author'))
                            <li><a href="{{ route('admin.questions.authoring.author') }}">Author Questions</a></li>
                        @endif
                        @if($user->canDo('admin.questions.authoring.edit.questions'))
                            <li><a href="{{ route('admin.questions.authoring.edit.questions') }}">Modify Questions</a></li>
                        @endif
                        @if($user->canDo('admin.questions.authoring.move.questions'))
                            <li><a href="{{ route('admin.questions.authoring.move.questions') }}">Move Questions</a></li>
                        @endif
                        @if($user->canDo('admin.questions.authoring.preview'))
                            <li><a href="{{ route('admin.questions.authoring.preview') }}">Preview Questions</a></li>
                        @endif
                    </ul>
                </li>
                @endif

                @if($showToolbox)
                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"> </i>
                    <a class="sidebar-link sidebar-title" href="#">
                        <i class="las la-cog la-md-2x"></i>
                        <span>Toolbox</span></a>
                    <ul class="sidebar-submenu">
                        @if($user->canDo('toolbox.center_venue.home'))
                            <li><a href="{{ route('toolbox.center_venue.home') }}">Centres</a></li>
                        @endif
                        @if($user->canDo('toolbox.subject.home'))
                            <li><a href="{{ route('toolbox.subject.home') }}">Papers</a></li>
                        @endif
                        @if($user->canDo('toolbox.candidate-types.index'))
                            <li><a href="{{ route('toolbox.candidate-types.index') }}">Exam Type</a></li>
                        @endif
                        @if($user->canDo('toolbox.candidate_upload.upload.candidate'))
                            <li><a href="{{ route('toolbox.candidate_upload.upload.candidate') }}">Candidates</a></li>
                        @endif
                        @if($user->canDo('toolbox.candidate_image_upload.upload.images'))
                            <li><a href="{{ route('toolbox.candidate_image_upload.upload.images') }}">Candidate Pictures</a></li>
                        @endif
                    </ul>
                </li>
                @endif

                @if($showReport)
                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"> </i>
                    <a class="sidebar-link sidebar-title" href="#">
                        <i class="las la-chart-pie la-md-2x"></i>
                        <span>Report </span></a>
                    <ul class="sidebar-submenu">
                        @if($user->canDo('admin.reports.summary.reports'))
                            <li><a href="{{ route('admin.reports.summary.reports') }}">Report Summary</a></li>
                        @endif
                        @if($user->canDo('admin.reports.summary.question'))
                            <li><a href="{{ route('admin.reports.summary.question') }}">Question Summary</a></li>
                        @endif
                        @if($user->canDo('admin.reports.summary.presentation'))
                            <li><a href="{{ route('admin.reports.summary.presentation') }}">Presentation Summary</a></li>
                        @endif
                        @if($user->canDo('admin.reports.active.index'))
                            <li><a href="{{ route('admin.reports.active.index') }}">Active Candidates</a></li>
                        @endif
                    </ul>
                </li>
                @endif

                @if($showManageExams)
                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"> </i>
                    <a class="sidebar-link sidebar-title" href="#">
                        <i class="las la-users la-md-2x"></i>
                        <span>Manage Exams </span></a>
                    <ul class="sidebar-submenu">
                        @if($user->canDo('admin.exams.setup.index'))
                            <li><a href="{{ route('admin.exams.setup.index') }}">Pull Record</a></li>
                        @endif
                        @if($user->canDo('toolbox.invigilator.index'))
                            <li><a href="{{ route('toolbox.invigilator.index') }}">Candidates</a></li>
                        @endif
                        @if($user->canDo('admin.exams.setup.push'))
                            <li><a href="{{ route('admin.exams.setup.push') }}">Push Record</a></li>
                        @endif
                        <!-- Additional Manage Exams child links -->
                    </ul>
                </li>
                @endif

                @if($showAuthorisation)
                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"> </i>
                    <a class="sidebar-link sidebar-title" href="#">
                        <i class="las la-user-shield la-md-2x"></i>
                        <span>Authorisation </span></a>
                    <ul class="sidebar-submenu">
                        @if($user->canDo('toolbox.authorization.users.index'))
                            <li><a href="{{ route('toolbox.authorization.users.index') }}">Users</a></li>
                        @endif
                        @if($user->canDo('toolbox.authorization.role.index'))
                            <li><a href="{{ route('toolbox.authorization.role.index') }}">Roles</a></li>
                        @endif
                    </ul>
                </li>
                @endif


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
