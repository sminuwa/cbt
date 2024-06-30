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
    <link rel="stylesheet" type="text/css" href="{{ asset('commons/css/calculator.css') }}">
    @stack('style')
</head>
<body class="box-layout">
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
    @include('commons.candidate.header')
    <!-- Page Header Ends                              -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->

        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-6">
                            <h4>Default</h4>
                        </div>
                        <div class="col-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">
                                        <svg class="stroke-icon">
                                            <use href="assets/svg/icon-sprite.svg#stroke-home"></use>
                                        </svg></a></li>
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item active">Default</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            @yield('content')
            <div class="calculator">
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
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 footer-copyright text-center">
                        <p class="mb-0">Copyright 2024 </p>
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
<script src="{{ asset('candidate/assets/js/chart/apex-chart/apex-chart.js') }}"></script>
<script src="{{ asset('candidate/assets/js/chart/apex-chart/stock-prices.js') }}"></script>
<script src="{{ asset('candidate/assets/js/chart/apex-chart/moment.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/chart/echart/esl.js') }}"></script>
<script src="{{ asset('candidate/assets/js/chart/echart/config.js') }}"></script>
<script src="{{ asset('candidate/assets/js/chart/echart/pie-chart/facePrint.js') }}"></script>
<script src="{{ asset('candidate/assets/js/chart/echart/pie-chart/testHelper.js') }}"></script>
<script src="{{ asset('candidate/assets/js/chart/echart/pie-chart/custom-transition-texture.js') }}"></script>
<script src="{{ asset('candidate/assets/js/chart/echart/data/symbols.js') }}"></script>
<!-- calendar js-->
<script src="{{ asset('candidate/assets/js/datepicker/date-picker/datepicker.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
<script src="{{ asset('candidate/assets/js/dashboard/dashboard_3.js') }}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('candidate/assets/js/script.js') }}"></script>
<script src="{{ asset('commons/js/calculator.js') }}"></script>
<script src="{{ asset('commons/js/timer.js') }}"></script>
{{--<script src="assets/js/theme-customizer/customizer.js"></script>--}}

@stack('script')
</body>
</html>
