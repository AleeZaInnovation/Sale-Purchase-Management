<!DOCTYPE html>
<html lang="en">
<head>
    <title>AleeZa Innovation</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="{{asset('public/frontend/assets/assets/img/favicon.png')}}"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/ppp/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/ppp/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/ppp/fonts/iconic/css/material-design-iconic-font.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/ppp/vendor/animate/animate.css')}}">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/ppp/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/ppp/vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/ppp/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/ppp/vendor/daterangepicker/daterangepicker.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/ppp/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/ppp/css/main.css')}}">
<!--===============================================================================================-->
</head>
<body>
    
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-t-85 p-b-20">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <span class="login100-form-title p-b-70">
                        Welcome
                    </span>
                    <span class="login100-form-avatar">
                        <img src="{{asset('public/frontend/ppp/images/avatar-01.png')}}" alt="AVATAR">
                    </span>

                    <div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "Enter username">
                        <label for="email" class="col-md-8 ">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                    </div>

                    <div class="wrap-input100 validate-input m-b-50" data-validate="Enter password">
                        <label for="password" class="col-md-8">{{ __('Password') }}</label>                        
                        <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            {{ __('Login') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    

    <div id="dropDownSelect1"></div>
    
<!--===============================================================================================-->
    <script src="{{asset('public/frontend/ppp/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('public/frontend/ppp/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('public/frontend/ppp/vendor/bootstrap/js/popper.js')}}"></script>
    <script src="{{asset('public/frontend/ppp/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('public/frontend/ppp/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('public/frontend/ppp/vendor/daterangepicker/moment.min.js')}}"></script>
    <script src="{{asset('public/frontend/ppp/vendor/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('public/frontend/ppp/vendor/countdowntime/countdowntime.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('public/frontend/ppp/js/main.js')}}"></script>

</body>
</html>