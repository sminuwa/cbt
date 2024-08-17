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
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/prism.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/intltelinput.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/tagify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/date-picker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/line-awesome/css/line-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/datatable-extension.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('candidate/assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('commons/css/app.css') }}">

    @yield('css')

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

<!-- Main Wrapper -->
    <div class="page-wrapper compact-wrapper box-layout" id="pageWrapper">

        <!-- Header -->
        @include('commons.header')
        <!-- /Header -->

        <!-- Breadcrumb -->
        <!-- /Breadcrumb -->

        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            @include('commons.admin.side-menu')
                
            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                            <h4>Welcome!</h4>
                            </div>
                            <div class="col-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">                                       
                                        <i class="las la-home la-md-2x"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item">Page Layout</li>
                                <li class="breadcrumb-item active">Box Layout</li>
                            </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            
            <!-- Footer -->
             @include('commons.footer')
            <!-- /Footer -->
        </div>
        <!-- /Page Content -->

        
    </div>
</div>
<!-- /Main Wrapper -->

<!-- /Graph Two-->
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
<script src="{{ asset('candidate/assets/js/sidebar-menu-admin.js') }}"></script>
<script src="{{ asset('candidate/assets/js/sidebar-pin.js') }}"></script>
<script src="{{ asset('candidate/assets/js/slick/slick.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/slick/slick.js') }}"></script>
<script src="{{ asset('candidate/assets/js/header-slick.js') }}"></script>
<script src="{{ asset('candidate/assets/js/prism/prism.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/clipboard/clipboard.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/custom-card/custom-card.js') }}"></script>

<script src="{{ asset('candidate/assets/js/select2/tagify.js') }}"></script>
<script src="{{ asset('candidate/assets/js/select2/tagify.polyfills.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/select2/intltelinput.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/select2/telephone-input.js') }}"></script>
<script src="{{ asset('candidate/assets/js/select2/custom-inputsearch.js') }}"></script>
<script src="{{ asset('candidate/assets/js/select2/select3-custom.js') }}"></script>
<!-- calendar js-->
<script src="{{ asset('candidate/assets/js/datepicker/date-picker/datepicker.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
{{-- <script src="{{ asset('candidate/assets/js/dashboard/dashboard_3.js') }}"></script> --}}
<script src="{{ asset('candidate/assets/js/sweet-alert/sweetalert2.all.min.js') }}"></script>

<script src="{{ asset('candidate/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/jszip.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/pdfmake.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/vfs_fonts.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/dataTables.autoFill.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/dataTables.select.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/buttons.html5.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/dataTables.colReorder.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/dataTables.scroller.min.js') }}"></script>
<script src="{{ asset('candidate/assets/js/datatable/datatable-extension/custom.js') }}"></script>
<script src="{{ asset('candidate/assets/js/tooltip-init.js') }}"></script>
<!-- Plugins JS Ends-->

<!-- calendar js-->
<script src="{{ asset('candidate/assets/js/height-equal.js') }}"></script>
<!-- Theme js-->
<script src="{{ asset('candidate/assets/js/script.js') }}"></script>
{{-- <script src="{{ asset('candidate/assets/js/theme-customizer/customizer.js') }}"></script> --}}

@yield('script')
</body>
</html>
