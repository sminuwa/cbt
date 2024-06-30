<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>CHPRBN: CBT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
    <meta name="keywords"
          content="practo clone, doccure, doctor appointment, Practo clone html template, doctor booking template">
    <meta name="author" content="Practo Clone HTML Template - Doctor Booking Template">
    <meta property="og:url" content="https://doccure.dreamstechnologies.com/html/">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Doctors Appointment HTML Website Templates | Doccure">
    <meta property="og:description"
          content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
    <meta property="og:image" content="assets/img/preview-banner.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="https://doccure.dreamstechnologies.com/html/">
    <meta property="twitter:url" content="https://doccure.dreamstechnologies.com/html/">
    <meta name="twitter:title" content="Doctors Appointment HTML Website Templates | Doccure">
    <meta name="twitter:description"
          content="The responsive professional Doccure template offers many features, like scheduling appointments with  top doctors, clinics, and hospitals via voice, video call & chat.">
    <meta name="twitter:image" content="assets/img/preview-banner.jpg">

    <!-- Favicons -->
    <link href="{{asset("assets/img/favicon.png")}}" rel="icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset("assets/css/bootstrap.min.css")}}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset("assets/plugins/fontawesome/css/fontawesome.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/plugins/fontawesome/css/all.min.css")}}">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{asset("assets/css/feather.css")}}">

    <!-- Apex Css -->
    <link rel="stylesheet" href="{{asset("assets/plugins/apex/apexcharts.css")}}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset("assets/css/custom.css")}}">

    <link rel="stylesheet" href="{{asset("assets/css/jquery.ui.css")}}">

    @yield('css')

</head>
<body>

<!-- Main Wrapper -->
<div class="main-wrapper">

    <!-- Header -->
    @include('commons.header')
    <!-- /Header -->

    <!-- Breadcrumb -->
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content pt-5">
        <div class="container" style="padding-top:64px;">
            <div class="row">
                @auth('admin')
                    @include('commons.admin.side-menu')
                    <div class="col-md-7 col-lg-8 col-xl-9">
                        @yield('content')
                    </div>
                @else
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        @yield('content')
                    </div>
                @endauth

            </div>

        </div>

    </div>
    <!-- /Page Content -->

    <!-- Footer -->
    @include('commons.footer')
    <!-- /Footer -->

</div>
<!-- /Main Wrapper -->

<!-- /Graph Two-->
@include('commons.script')
</body>
</html>
