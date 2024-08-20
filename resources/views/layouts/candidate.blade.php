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
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('commons/css/calculator.css') }}">
    @stack('style')
    <style>
        /*.radio-toolbar input[type="radio"] {
            display: none;
        }*/
        .border-white{
            border-color: #fff !important;
        }
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
            padding: 2px 5px;
            width:45px;
            max-width:50px;
        }

        .btn-group {
            flex-wrap: wrap;
        }
        .btn-group > :not(.btn-check:first-child) + .btn, .btn-group > .btn-group:not(:first-child) {
            margin-left: 0;
        }


        .custom-check-icon::after{
            content:'\2713';
            width:20px;
            height:20px;
        }

        .ribbon {
            padding: 0 20px;
            height: auto;
            line-height: 30px;
            clear: left;
            position: absolute;
            top: 12px;
            color: #fff;
            z-index: 2;
            border-radius: 10px;


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
$time_difference = session('time_difference');
$remaining_seconds = session('remaining_seconds');
$time_control = session('time_control');
$time_elapsed = $time_control->elapsed;
?>
<!-- loader starts-->
<div class="loader-wrapper">
    <div class="loader">
        <div class="loader4"></div>
    </div>
</div>
<!-- loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper horizontal-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
{{--    @include('commons.candidate.header')--}}
    <div class="page-header">
        <div class="header-wrapper row m-0">
            <div class="header-logo-wrapper col-auto p-0">
                <div class="logo-wrapper">
                    <a href="#">
                        <img class="img-fluid for-light" src="{!! logo() !!}" alt="logo-light">
                        <img class="img-fluid for-dark" src="{!! logo() !!}" alt="logo-dark">
                    </a>
                </div>
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
                    <li class="profile-nav">
                        <div class="media profile-media">
                            <img class="b-r-10" src="{{ $candidate->passport() }}" width="35"  alt="">
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Page Header Ends                              -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->

        <!-- Page Sidebar Ends-->
        <div class="page-body">
{{--            @yield('content')--}}
{{--            @json($scheduled_candidate)--}}
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 col-xl-4">
                        <div class="card social-profile">
                            <div class="card-body">
                                <div class="border-l-primary border-r-primary border-3" style="border-radius: 8px;">
                                    <div class="social-img-wrap">
                                        <div class="social-img"><img class="img-fluid" src="{{ $candidate->passport() }}" alt="profile"></div>
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
                                            @foreach($question_array as $q)
                                                <a href="javascript:;"
                                                   class="q{{ $q['question_bank_id'] }} btn btn-{{ $q['question_bank_id'] != $q['has_score'] ? 'outline-':'' }}primary
                                                   {{ $q['question_bank_id'] == $q['has_score'] ? 'custom-check-icon':'' }}
                                                    btn-sm btn-question"
                                                   question_id="{{ $q['question_bank_id'] }}"
                                                   step="{{ $loop->index }}"
                                                >
                                                    {!!  $q['question_bank_id'] == $q['has_score'] ? $loop->iteration:$loop->iteration  !!}
                                                </a>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <div class="text-center">
                                            <button id="submitBtn" onclick="return confirm('Are you sure you want to submit this exam?')" class="submitBtn btn btn-primary btn-sm hidden">
                                                Submit Exam
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 col-xl-8">
                        <div class="card">
                            <div class="card-header border-r-primary border-3 ribbon-wrapper-right">
                                <div class="ribbon ribbon-primary ribbon-clip-right ribbon-right">
                                    @foreach($candidate_subjects as $s)
                                        <form action="" method="post" class="d-inline">
                                            <input type="hidden" name='subject_id' value="{{ $s->subject_id }}">
                                            <input type="hidden" name='scheduled_candidate_id' value="{{ $scheduled_candidate->id }}">
                                            <input type="hidden" name='test_config_id' value="{{ $test->id }}">
                                            <button
                                                type="submit"
                                                name="change-paper"
                                                class="b-r-0 text-white btn btn-{{ $subject->id == $s->subject_id ? 'warning':'light' }}">
                                                {{ $s->name }}
                                            </button>
                                        </form>
                                        @if(!$loop->last) | @endif
                                    @endforeach
                                </div>
                                <h4 class="card-title ">
                                    {{--{{ $test->test_code->name }}--}}
                                    {{ $test->test_code->name }} {{ $test->session }}
                                    {{--<div class="float-end">

                                    </div>--}}
                                </h4>
                            </div>
                            <div class="card-body">
{{--                                @json($question_papers)--}}
                                <form id="wizardForm">
                                    @foreach($question_array as $question_paper)
                                        @php $step = $loop->index; @endphp
                                        <div step="{{ $step }}" id="{{ $question_paper['question_bank_id'] }}" class="wizard-step @if(!$loop->first) hidden @endif">
                                            <div class="text-center m-4">
                                                <h5>{{ $question_paper['section_title'] }}</h5>
                                                <h5>Instruction: {{ strip_tags($question_paper['section_instruction'],'<img>') }}</h5>
                                            </div>
                                            <div class="card-wrapper border rounded-3 fill-radios h-100 radio-toolbar checkbox-checked fadeIn  animated z-0">
                                                <h6 class="sub-title">Q {{ $loop->iteration }}. {{ strip_tags($question_paper['question_name'],'<img>') }}</h6>
                                                @foreach($question_paper['answer_options'] as $answer_option)
                                                    <div id="{{ $question_paper['question_bank_id'] }}{{ $answer_option['answer_option_id'] }}" class="form-check radio radio-primary" style="width:100%">
                                                        <input
                                                            @if($answer_option['answer_option_id'] == $answer_option['selected_answer_option']) checked @endif
                                                            class="form-check-input answer_option {{ chr(64+ $loop->iteration) }}_KEY"
                                                            id="{{ $answer_option['answer_option_id'] }}"
                                                            type="radio"
                                                            name="q{{ $question_paper['question_bank_id'] }}"
                                                            name="q{{ $question_paper['question_bank_id'] }}"
                                                            question_step="{{ $step }}"
                                                            scheduled_candidate_id="{{ $scheduled_candidate->id }}"
                                                            test_config_id="{{ $question_paper['test_config_id'] }}"
                                                            test_section_id="{{ $answer_option['test_section_id'] }}"
                                                            mark_per_question="{{ $question_paper['mark_per_question'] }}"
                                                            question_bank_id="{{ $question_paper['question_bank_id'] }}"
                                                            answer_option_id="{{ $answer_option['answer_option_id'] }}"
                                                            scoring_mode="normal"
                                                            value="">
                                                        <label class="form-check-label" for="{{$answer_option['answer_option_id']}}">{{ chr(64+ $loop->iteration) }}. {{ strip_tags($answer_option['answer_name'],'<img>') }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </form>

                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-4 text-left">
                                        <button type="button" id="prevBtn" class="btn btn-square btn-outline-primary">Previous</button>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h3 class="d-inline"><span class="badge badge-primary" id="attempt-tracker">{{ count($question_answered) }} / {{ count($question_array) }}</span></h3>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="float-end">
                                            <button type="button" id="nextBtn" class="btn btn-square btn-outline-primary">Next</button>
                                            {{--                                    <button type="submit" id="submitBtn" class="submitBtn btn btn-square btn-primary hidden">Submit</button>--}}
                                        </div>
                                    </div>
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
<script src="{{ asset('candidate/assets/js/sweet-alert/sweetalert2.all.min.js') }}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('candidate/assets/js/script.js') }}"></script>
<script src="{{ asset('commons/js/calculator.js') }}"></script>
{{--<script src="{{ asset('candidate/assets/js/theme-customizer/customizer.js') }}"></script>--}}
{{--<script src="{{ asset('commons/js/timer.js') }}"></script>--}}

@stack('script')
<script>
       
    document.addEventListener('DOMContentLoaded', () => {
        const steps = document.querySelectorAll('.wizard-step');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');
        let currentStep = 0;
        var time_elapsed = {{ $time_elapsed }};
        var remaining_seconds = {{ $remaining_seconds }};
        var every_one_minutes = 0;
        var time_difference = {{ $time_difference }};
        let attempt_tracker = $('#attempt-tracker');
        function showStep(step, answered = false) {
            steps.forEach((el, index) => {
                el.classList.toggle('hidden', index !== step);
                // console.log(step)
            });
            prevBtn.classList.toggle('hidden', step === 0);
            nextBtn.classList.toggle('hidden', step === steps.length - 1);
            // submitBtn.classList.toggle('hidden', step !== steps.length - 1);
            let qid = steps[step].id;
            let qstep = steps[step].step;
            let qlist = $('.q'+qid);
            // console.log(qstep)

            // qlist.nextAll().addClass('btn-outline-primary')
            $(".btn-question").each(function() {
                let el = $(this);
                if(el.hasClass( "custom-check-icon" )) {
                    el.removeClass('btn-outline-primary');
                    el.addClass('btn-primary text-white border-white');
                }else{
                    el.removeClass('btn-warning btn-primary text-white border-white');
                    el.addClass('btn-outline-primary');
                }
            });
            if(answered === true) {
                qlist.addClass('btn-primary custom-check-icon');
            }
            qlist.removeClass('btn-primary btn-outline-primary');
            qlist.addClass('btn-warning text-white border-white');
            // check_all = querySelectorAll('.custom-check-icon');
            /*check_all.each((el, index) => {
                $(this).removeClass('btn-outline-primary');
                $(this).addClass('btn-primary');
                // console.log(step)
            });*/
            // qlist.prev()
            // console.log(qlist)
            // alert(qid);
        }
        function updateReview() {

        }
        nextBtn.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                if (currentStep === steps.length - 1) updateReview();
                showStep(currentStep);
                // console.log(currentStep)
            }
        });
        prevBtn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
                // console.log(currentStep)
            }
        });
        document.getElementById('wizardForm').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Form submitted successfully!');
        });
        //time control function
        function time_control(){
            let remaining_seconds = parseInt({{$remaining_seconds}});
            $.get('{{ route('candidate.test.time_control') }}',
                {
                    test_config_id: '{{ $test->id }}',
                    scheduled_candidate_id: '{{ $scheduled_candidate->id }}',
                    remaining_seconds,
                },
                function(){
                    console.log(remaining_seconds)
                }).done(function(data){
                console.log(data)
            }).fail(function(data){
                console.log(data)
            })
        }

        //submitting question

        $('body').on('click', '.submitBtn', function(e){
            e.preventDefault();
            submit_test();
        })
        //clicking questions
        $('body').on('click', '.btn-question', function(){
            currentStep = parseInt($(this).attr('step'));
            showStep(currentStep);
        })

        $('body').on('click', '.answer_option', function(){
            let question_step = $(this).attr('question_step');
            let scheduled_candidate_id = $(this).attr('scheduled_candidate_id');
            let test_config_id = $(this).attr('test_config_id');
            let test_section_id = $(this).attr('test_section_id');
            let mark_per_question = $(this).attr('mark_per_question');
            let question_bank_id = $(this).attr('question_bank_id');
            let answer_option_id = $(this).attr('answer_option_id');
            let scoring_mode = $(this).attr('scoring_mode');
            let time_control_id = {{ $time_control->id }};
            let test_subject_id = {{ $subject->id }};
            currentStep = parseInt(question_step)
            showStep(currentStep, true)
            $.get('{{ route('candidate.test.answering') }}',
                {
                    scheduled_candidate_id,
                    test_config_id,
                    test_section_id,
                    mark_per_question,
                    question_bank_id,
                    answer_option_id,
                    scoring_mode,
                    time_control_id,
                    remaining_seconds,
                    time_elapsed,
                    test_subject_id
                },
                function(){
                    // console.log('Saving answer')
            }).done(function(data){
                console.log(data)
                attempt_tracker.html(data.answered + ' / '+ data.total)
            }).fail(function(data){
                // console.log(data)
            })
        })

        showStep(currentStep);

        function submit_test(){
            $.get('{{ route('candidate.test.submit_test') }}',
                {
                    time_control_id: {{ $time_control->id }},
                    remaining_seconds,
                    time_elapsed
                },
                function(){
                    // console.log('Saving answer')
                }).done(function(data){
                    if(data.status){
                        window.location.href = data.url;
                        // location = data.url;
                    }
                    console.log(data)
                }).fail(function(data){
                    // console.log(data)
                })
        }

        let remaining_interval = setInterval(function(){
            //update time control after every one minutes even if no activity
            if(every_one_minutes >= 10){
                ++time_difference; // time difference in minutes
                let test_subject_id = {{ $subject->id }};
                $.get('{{ route('candidate.test.time_control') }}',
                    {
                        time_control_id: {{ $time_control->id }},
                        scheduled_candidate_id: {{ $scheduled_candidate->id }},
                        test_config_id: {{ session('test')->id }},
                        remaining_seconds,
                        time_elapsed,
                        test_subject_id
                    },
                    function(){
                        // console.log('Saving answer')
                    }).done(function(data){
                    console.log(data)
                }).fail(function(data){
                    // console.log(data)
                })
                console.log('time difference: '+time_difference+' actual: '+{{ $time_difference }})
                every_one_minutes = 0;
            }
            {{--if(parseInt(time_difference) >= (parseInt({{$test->duration}}) + parseInt({{$test->time_padding}})))--}}
            ++every_one_minutes;
            ++time_elapsed;
            --remaining_seconds;
            if((time_elapsed / 60) > 30){
                $('#submitBtn').removeClass('hidden')
            }
            if(remaining_seconds < 5 * 60){
                blink("#clock")
            }
            if(remaining_seconds < -{{( $test->time_padding ?? 0) * 60 }}){
                clearInterval(remaining_interval);
            }
        }, 1000)


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
                // console.log(-{{( $test->time_padding ?? 0) * 60 }} + ' - '+timer)
                if (--timer < -{{( $test->time_padding ?? 0) * 60 }}) {
                    clearInterval(interval);
                    alert('Time is up!')
                    submit_test()
                }


            }, 1000);
        }
        let stopBlinking = false;

        window.onload = function () {
            // const twoHours = 60 * 60 * 2; // 2 hours in seconds
            const twoHours = {{ $remaining_seconds }}; // 2 hours in seconds
            const display = document.querySelector('#clock');
            startTimer(twoHours, display);


        };

        function blink(selector) {
            if(stopBlinking)
                return false;
            $(selector).fadeOut('slow', function() {
                $(this).fadeIn('slow', function() {
                    blink(this);
                });
            });
        }


        $("body").keydown(function(e) {
            if(e.keyCode === 37) { // left
                $("#prevBtn").trigger("click");
            }
            else if(e.keyCode === 39) { // right
                $("#nextBtn").trigger("click");
            }
            // if(e.keyCode === 65) { // A
            //     $(".A_KEY").trigger("click");
            // }

            // if(e.keyCode === 66) { // B
            //     $(".B_KEY").trigger("click");
            // }

            // if(e.keyCode === 67) { // C
            //     $(".C_KEY").trigger("click");
            // }

            // if(e.keyCode === 68) { // D
            //     $(".D_KEY").trigger("click");
            // }

            // if(e.keyCode === 69) { // E
            //     $(".E_KEY").trigger("click");
            // }

            // if(e.keyCode === 70) { // F
            //     $(".F_KEY").trigger("click");
            // }
        });

    });

</script>



<script>


    /*blink("#clock");

    setInterval(function(){
        stopBlinking = !stopBlinking;
        blink("#clock");
    }, 50000);*/
</script>
</body>
</html>
