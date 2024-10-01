<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="CHPRBN">
    <link rel="icon" href="https://admin.pixelstrap.net/riho/assets/images/favicon/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="https://admin.pixelstrap.net/riho/assets/images/favicon/favicon.png" type="image/x-icon">
    <title>CBT Exam Instructions</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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
    <style type="text/css">
        body{
            font-family: 'Montserrat', sans-serif;
            background-color: #f6f7fb;
            display: block;
            width: 750px;
            padding: 0 12px;
        }
        a{
            text-decoration: none;
        }
        span {
            font-size: 14px;
        }
        p {
            font-size: 13px;
            line-height: 1.7;
            letter-spacing: 0.7px;
            margin-top: 0;
        }
        .text-center{
            text-align: center
        }
        @media only screen and (max-width: 767px){
            body{
                width: auto;
                margin: 20px auto;
            }
            .logo-sec{
                width: 500px !important;
            }
        }
        @media only screen and (max-width: 575px){
            .logo-sec{
                width: 400px !important;
            }
        }
        @media only screen and (max-width: 480px){
            .logo-sec{
                width: 300px !important;
            }
        }
        @media only screen and (max-width: 360px){
            .logo-sec{
                width: 250px !important;
            }
        }
    </style>
</head>
<body style="margin: 30px auto;">
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
<table style="width: 100%">
    <tbody>
    <tr>
        <td>
            <table style="background-color: #f6f7fb; width: 100%">
                <tbody>
                <tr>
                    <td>
                        <table style="margin: 0 auto; margin-bottom: 30px">
                            <tbody>
                            <tr class="logo-sec" style="display: flex; align-items: center; justify-content: space-between; width: 650px;">
                                <td><img class="img-fluid" src="{!! logo() !!}" alt="" width="50"></td>
                                <td style="text-align: right; color:#999"><span>Submission</span></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="card social-profile" style="border-radius:25px">
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
                                        <hr>
                                        <h2 style="text-align: center">
                                            You have successfully submitted your test.
                                            <br>
                                            <small>Good luck!</small>
                                        </h2>
                                        <br>
                                        <div class="text-center">
                                            <a href="{{ route('candidate.auth.page') }}" style="padding: 10px; background-color: #006666; color: #fff; display: inline-block; border-radius:30px; margin-bottom:18px; font-weight:600; padding:0.6rem 1.75rem;">
                                                Okay
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
<?php
    use Illuminate\Support\Facades\Auth;
        Auth::guard('web')->logout();
        request()->session()->invalidate();

?>
