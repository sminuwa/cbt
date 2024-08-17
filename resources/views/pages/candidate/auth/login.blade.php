@php use App\Models\TestConfig; @endphp
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
    <title>CBT EXAMS</title>
    <!-- Google font-->
    {{--<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">--}}
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
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('candidate/assets/css/color-1.css" media="screen') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/vendors/sweetalert2.min.css') }}">

    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('candidate/assets/css/responsive.css') }}">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-7">
            <img class="bg-img-cover bg-center" src="{{ asset('candidate/assets/images/login/2.jpg') }}" alt="looginpage">
        </div>
      <div class="col-xl-5 p-0">
        <div class="login-card login-dark">
          <div>
            <div>
                <a class="logo text-center" href="#">
                    <img class="img-fluid for-dark" src="{!! logo(100,100) !!}" alt="logo-image">
                    <img class="img-fluid for-light" src="{!! logo(100,100) !!}" alt="logo-image">
                </a>
            </div>
            <div class="login-main">
                <form class="theme-form" action="{{ route('candidate.auth.login') }}" method="POST">
                    <h4>Sign in </h4>
                    <p>Enter your Exam No & password to login</p>
                    @include('components.alert')
                    <div class="form-group">
                        <label class="col-form-label">Exam Type</label>
                        <select name="test_id" class="form-control" type="text" required>
                            <option value="">-- Select Exam -- </option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->code }} - {{ $exam->type }} - {{ $exam->session }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Exam No.</label>
                        <input class="form-control" type="text" name="username" required="" placeholder="Exam No.">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Password </label>
                        <div class="form-input position-relative">
                            <input class="form-control" type="password" name="password" required="" placeholder="*********">
                            <div class="show-hide"> <span class="show"></span></div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="text-end mt-4">
                            <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                        </div>
                    </div>

                </form>
            </div>
          </div>
        </div>
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
    <!-- Sidebar jquery-->
    <script src="{{ asset('candidate/assets/js/config.js') }}"></script>
    <script src="{{ asset('candidate/assets/js/sweet-alert/sweetalert2.all.min.js') }}"></script>
    <!-- Plugins JS start-->
    <!-- calendar js-->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ asset('candidate/assets/js/script.js') }}"></script>

    <script>
         $(document).ready(function(){
            @if(session()->has('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'Okay'
            })
            @endif
         })
    </script>
  </div>
</body>
</html>
