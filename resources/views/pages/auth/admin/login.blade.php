@extends('layouts.app')

@section('content')

    <div class="login-content-info" style="margin-top: -128px;">
        <div class="container">

            <!-- Login Email -->
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="account-content">
                        <div class="account-info">
                            <div class="login-back">
{{--                                <a href="index.html"><i class="fas fa-arrow-left-long"></i> Back</a>--}}
                            </div>
                            @if($errors->has('email'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Oops!</strong>
                                    {{$errors->first('email')}}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{route('auth.admin.login.proc')}}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="mb-2">Username</label>
                                    <input type="text" class="form-control" name="username" placeholder="username">
                                </div>
                                <div class="mb-3">
                                    <div class="form-group-flex">
                                        <label class="mb-2">Password</label>
                                        <a href="forgot-password.html" class="forgot-link">Forgot password?</a>
                                    </div>
                                    <div class="pass-group">
                                        <input type="password" class="form-control pass-input" name="password" placeholder="*************">
                                        <span class="feather-eye-off toggle-password"></span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button class="btn w-100" type="submit">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Login Email -->

        </div>
    </div>
@endsection
