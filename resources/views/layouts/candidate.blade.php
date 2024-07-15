<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="CHPRBN">
    <link rel="icon" href="{{ asset('candidate/assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('candidate/assets/images/favicon.png') }}" type="image/x-icon">
    <title>CBT Exam</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/echart.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/date-picker.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('candidate/assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/line-awesome/css/line-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('commons/css/calculator.css') }}">
    @stack('style')
    <style>
        /*.radio-toolbar input[type="radio"] {
            display: none;
        }*/
        .radio-toolbar input[type="radio"]:checked+label {
            background-color: #006666;
            color:#ffffff;
            padding-right: 20px;
            border-radius: 8px;
        }
        .radio-toolbar input[type="radio"]:checked+label::after {
            content:'';
            width: 30px;
            background-color: #006666;
        }

        .clock {
            font-size: 2rem;
            font-family: Arial, sans-serif;
            font-weight: bolder;
            color: #006666; /* Initial color set to green */
        }

        .btn-question{
            padding: 3px 10px;
            width:45px;
        }

        .btn-group {
            flex-wrap: wrap;
        }
        .btn-group > :not(.btn-check:first-child) + .btn, .btn-group > .btn-group:not(:first-child) {
            margin-left: 0;
        }





        .wizard-step h2 {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 16px;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body class="box-layout">
<?php
$candidate = session('candidate');
$scheduled_candidate = session('scheduled_candidate');
$candidate_subjects = session('candidate_subjects');
$test = session('test');
$remaining_seconds = session('remaining_seconds');
?>
<!-- loader starts-->
<div class="loader-wrapper">
    <div class="loader">
        <div class="loader4"></div>
    </div>
</div>
<!-- loader ends-->
<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper horizontal-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
{{--    @include('commons.candidate.header')--}}
    <div class="page-header">
        <div class="header-wrapper row m-0">
            <form class="form-inline search-full col" action="index.html#" method="get">
                <div class="form-group w-100">
                    <div class="Typeahead Typeahead--twitterUsers">
                        <div class="u-posRelative">
                            <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Riho .." name="q" title="" autofocus>
                            <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading... </span></div><i class="close-search" data-feather="x"></i>
                        </div>
                        <div class="Typeahead-menu"> </div>
                    </div>
                </div>
            </form>
            <div class="header-logo-wrapper col-auto p-0">
                <div class="logo-wrapper"> <a href="#"><img class="img-fluid for-light" src="{!! logo() !!}" alt="logo-light"><img class="img-fluid for-dark" src="{!! logo() !!}" alt="logo-dark"></a></div>
                <div class="toggle-sidebar"> <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i></div>
            </div>
            <div class="left-header col-xxl-5 col-xl-6 col-lg-5 col-md-4 col-sm-3 p-0">
                <div> <a class="toggle-sidebar" href="#"> <i class="iconly-Category icli"> </i></a>
                    <div class="d-flex align-items-center gap-2 ">
                        <h4 class="f-w-600">{{ $scheduled_candidate->exam_type->name ?? 'CBT Examination' }}</h4>
                    </div>
                </div>
                <div class="welcome-content d-xl-block d-none">
                    <span class="text-truncate col-12">
                        {{ $test->test_code->name }} - {{ $test->test_type->name }} - {{ $test->session }}
                    </span>
                </div>
            </div>
            <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
                <ul class="nav-menus">

                    <div class="clock" id="clock">00:00:00</div> Time left
                    {{--                <li>--}}
                    {{--                    <div class="mode"><i class="moon" data-feather="moon"> </i></div>--}}
                    {{--                </li>--}}

                    <li class="profile-nav onhover-dropdown">
                        <div class="media profile-media">
                            <img class="b-r-10" src="{{ asset('candidate/assets/images/avtar/16.jpg') }}" width="35"  alt="">
                            <div class="media-body d-xxl-block d-none box-col-none">
                                <div class="d-flex align-items-center gap-2"> <span>Alex Mora </span><i class="middle fa fa-angle-down"> </i></div>
                                <p class="mb-0 font-roboto">Admin</p>
                            </div>
                        </div>
                        <ul class="profile-dropdown onhover-show-div">
                            <li><a href="user-profile.html"><i data-feather="user"></i><span>My Profile</span></a></li>
                            <li><a href="letter-box.html"><i data-feather="mail"></i><span>Inbox</span></a></li>
                            <li> <a href="edit-profile.html"> <i data-feather="settings"></i><span>Settings</span></a></li>
                            <li><a class="btn btn-pill btn-outline-primary btn-sm" href="login.html">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <script class="result-template" type="text/x-handlebars-template">
                <div class="ProfileCard u-cf">
                    <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
                    <div class="ProfileCard-details">
                        <div class="ProfileCard-realName"></div>
                    </div>
                </div>
            </script>
            <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
        </div>
    </div>

    <!-- Page Header Ends                              -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->

        <!-- Page Sidebar Ends-->
        <div class="page-body">
{{--            @yield('content')--}}
{{--            @json($all_test_questions)--}}
{{--            @json($scheduled_candidate)--}}
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 col-xl-4 ">
                        <div class="card social-profile">
                            <div class="card-body">
                                <div class="border-l-primary border-r-primary border-3" style="border-radius: 8px;">
                                    <div class="social-img-wrap">
                                        <div class="social-img"><img class="img-fluid" src="{{ asset('candidate/assets/images/avtar/16.jpg') }}" alt="profile"></div>
                                    </div>
                                    <div class="social-details">
                                        <h5 class="mb-1">
                                            <a href="#" class="text-uppercase">{{ $candidate->fullname() }}</a>
                                        </h5>
                                        <span class="f-light">Exam No: {{ $candidate->indexing ?? null }}</span>
                                    </div>
                                </div>
                                <div class="mt-2" style="text-align:left;">
                                    <h5>Exam: {{ $test->test_code->name }} {{ $test->session }}</h5>
                                    <h5>Duration: {{$test->duration ?? 0}} mins</h5>


                                    <div class="border-t-primary border-3 my-2" style="border-radius:5px">
                                        <span>Questions navigation</span>
                                        <br>
                                    <div class="btn-group btn-group-square">
                                        {{--@for($i = 1; $i<=50; $i++)
                                            <a class="btn border-none btn-{{ $i > 10 ? 'outline-':'' }}primary btn-sm btn-question {{ $i <30 ? 'disabled':'' }}"  href="javascript:;">
                                                {!!  $i < 10 ? $i:$i  !!}
                                            </a>
                                        @endfor--}}
                                        @foreach($all_test_questions as $q)
                                            <a href="javascript:;" class="q{{ $q->question_bank_id }} btn btn-{{ $q->question_bank_id != $q->has_score ? 'outline-':'' }}primary btn-sm btn-question " >
                                                {!!  $q->question_bank_id == $q->has_score ? $loop->iteration:$loop->iteration  !!}
                                            </a>
                                        @endforeach
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 col-xl-8">
                        <div class="card">
                            <div class="card-header border-l-warning border-3">
                                <h4 class="card-title">
                                    {{--{{ $test->test_code->name }}--}}

                                    @foreach($candidate_subjects as $subject)

                                        <a href="" class="text-primary">{{ $subject->name }}</a>
                                         @if(!$loop->last) | @endif

                                    @endforeach

                                </h4>
                            </div>
                            <div class="card-body">
{{--                                @json($question_papers)--}}
                                <form id="wizardForm">


                                    @foreach($question_array as $question_paper)
                                        <div id="{{ $question_paper['question_bank_id'] }}" class="wizard-step @if(!$loop->first) hidden @endif">
                                            <div class="text-center m-4">
                                                <h5>{{ $question_paper['section_title'] }}</h5>
                                                <h5>Instruction: {{ strip_tags($question_paper['section_instruction']) }}</h5>
                                            </div>
                                            <div class="card-wrapper border rounded-3 fill-radios h-100 radio-toolbar checkbox-checked">
                                                <h6 class="sub-title">{{ $question_paper['question_name'] }}</h6>
                                                @foreach($question_paper['answer_options'] as $answer_option)
                                                    <div id="{{ $question_paper['question_bank_id'] }}{{ $answer_option['answer_option_id'] }}" class="form-check radio radio-primary" style="width:100%">
                                                        <input @if($answer_option['answer_option_id'] == $answer_option['selected_answer_option']) checked @endif class="form-check-input" id="{{$answer_option['answer_option_id']}}" type="radio" name="radio3"  value="option1">
                                                        <label class="form-check-label" for="{{$answer_option['answer_option_id']}}">{{ chr(64+ $loop->iteration) }}. {{ $answer_option['answer_name'] }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </form>

                            </div>
                            <div class="card-footer">
                                <button type="button" id="prevBtn" class="btn btn-square btn-outline-primary">Previous</button>
                                <div class="float-end">
                                    <button type="button" id="nextBtn" class="btn btn-square btn-outline-primary">Next</button>
                                    <button type="submit" id="submitBtn" class="btn btn-square btn-primary hidden">Submit</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($test->allow_calc)
            <div class="calculator border-l-primary border-r-primary border-2 ">
                <div class="calculator-header">
                    <span class="calculator-title">Calculator</span>
                    <button id="toggle-calculator" class="toggle-button">-</button>
                </div>
                <div id="calculator-body">
                    <input id="calculator-display" type="text" class="calculator-display" readonly />
                    <div class="calculator-grid">
                        <button onclick="appendNumber('7')" class="calculator-button">7</button>
                        <button onclick="appendNumber('8')" class="calculator-button">8</button>
                        <button onclick="appendNumber('9')" class="calculator-button">9</button>
                        <button class="calculator-button operator-button" onclick="appendOperator('/')">/</button>
                        <button onclick="appendNumber('4')" class="calculator-button">4</button>
                        <button onclick="appendNumber('5')" class="calculator-button">5</button>
                        <button onclick="appendNumber('6')" class="calculator-button">6</button>
                        <button class="calculator-button operator-button" onclick="appendOperator('*')">*</button>
                        <button onclick="appendNumber('1')" class="calculator-button">1</button>
                        <button onclick="appendNumber('2')" class="calculator-button">2</button>
                        <button onclick="appendNumber('3')" class="calculator-button">3</button>
                        <button class="calculator-button operator-button" onclick="appendOperator('-')">-</button>
                        <button onclick="appendNumber('0')" class="calculator-button">0</button>
                        <button onclick="appendNumber('.')" class="calculator-button">.</button>
                        <button class="calculator-button operator-button" onclick="clearDisplay()">C</button>
                        <button class="calculator-button operator-button" onclick="appendOperator('+')">+</button>
                        <button class="calculator-button equal-button" onclick="calculateResult()">=</button>
                    </div>
                    <button id="toggle-scientific" class="scientific-button">Scientific</button>
                    <div id="scientific-operations" class="scientific-operations hidden">
                        <button onclick="appendFunction('sin')" class="calculator-button">sin</button>
                        <button onclick="appendFunction('cos')" class="calculator-button">cos</button>
                        <button onclick="appendFunction('tan')" class="calculator-button">tan</button>
                        <button onclick="appendFunction('log')" class="calculator-button">log</button>
                        <button onclick="appendFunction('sqrt')" class="calculator-button">√</button>
                        <button onclick="appendFunction('pow')" class="calculator-button">x^y</button>
                        <button onclick="appendFunction('pi')" class="calculator-button">π</button>
                        <button onclick="appendFunction('e')" class="calculator-button">e</button>
                    </div>
                </div>
            </div>
            @endif
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 footer-copyright text-center">
                        <p class="mb-0">Copyright {{ date('Y') }} </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<!-- latest jquery-->
<script src="{{ asset('candidate/assets/js/jquery.min.js') }}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('candidate/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<!-- feather icon js-->
<script src="{{ asset('candidate/assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
<!-- scrollbar js-->
<script src="{{ asset('candidate/assets/js/scrollbar/simplebar.js') }}"></script>
<script src="{{ asset('candidate/assets/js/scrollbar/custom.js') }}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('candidate/assets/js/config.js') }}"></script>
<!-- Plugins JS start-->
<script src="{{ asset('candidate/assets/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('candidate/assets/js/sidebar-pin.js') }}"></script>
<script src="{{ asset('candidate/assets/js/slick/slick.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/slick/slick.js') }}"></script>
<script src="{{ asset('candidate/assets/js/header-slick.js') }}"></script>
<!-- calendar js-->
<script src="{{ asset('candidate/assets/js/datepicker/date-picker/datepicker.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
<script src="{{ asset('candidate/assets/js/dashboard/dashboard_3.js') }}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('candidate/assets/js/script.js') }}"></script>
<script src="{{ asset('commons/js/calculator.js') }}"></script>
{{--<script src="{{ asset('commons/js/timer.js') }}"></script>--}}
{{--<script src="assets/js/theme-customizer/customizer.js"></script>--}}

@stack('script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const steps = document.querySelectorAll('.wizard-step');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');
        let currentStep = 0;
        function showStep(step) {
            steps.forEach((el, index) => {
                el.classList.toggle('hidden', index !== step);
            });
            prevBtn.classList.toggle('hidden', step === 0);
            nextBtn.classList.toggle('hidden', step === steps.length - 1);
            submitBtn.classList.toggle('hidden', step !== steps.length - 1);
            let qid = steps[step].id;
            let qlist = $('.q'+qid);
            qlist.removeClass('btn-outline-primary');
            qlist.addClass('btn-primary');
            qlist.prevAll().addClass('btn-primary')
            qlist.nextAll().removeClass('btn-primary')
            qlist.nextAll().addClass('btn-outline-primary')
            // qlist.prev()
            console.log(qlist)
            // alert(qid);
        }
        function updateReview() {

        }
        nextBtn.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                if (currentStep === steps.length - 1) updateReview();
                showStep(currentStep);
            }
        });
        prevBtn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
        document.getElementById('wizardForm').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Form submitted successfully!');
        });
        showStep(currentStep);
    });
</script>
<script>
    function startTimer(duration, display) {
        let timer = duration, hours, minutes, seconds;
        const interval = setInterval(() => {
            hours = parseInt(timer / 3600, 10);
            minutes = parseInt((timer % 3600) / 60, 10);
            seconds = parseInt(timer % 60, 10);

            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = hours + ":" + minutes + ":" + seconds;

            // Change color to red when 15 minutes (900 seconds) are left
            if (timer <= 600) {
                display.style.color = 'red';
            }

            if (--timer < -{{($test->time_padding ?? 0) * 60}}) {
                clearInterval(interval);
                alert("Time is up!");
            }
        }, 1000);
    }

    window.onload = function () {
        // const twoHours = 60 * 60 * 2; // 2 hours in seconds
        const twoHours = {{ $remaining_seconds }}; // 2 hours in seconds
        const display = document.querySelector('#clock');
        startTimer(twoHours, display);
    };
</script>
</body>
</html>
