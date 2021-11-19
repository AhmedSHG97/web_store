<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>{{$title}}</title>
    <!-- Favicon-->
    <link rel="icon" href="{{asset('website')}}/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('website')}}/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('website')}}/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('website')}}/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('website')}}/css/style.css" rel="stylesheet">
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);"><b>{{$app_name}}</b></a>
        </div>
        <div class="card">
            @if($errors->any())
                <div class="alert bg-red alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ $errors->first() }}
                </div>
            @endif
            @if(session()->has('success'))
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ session('success') }}
                </div>
            @endif
            <div class="body">
                <form action="{{route("signIn")}}" id="sign_in" method="POST">
                    {{ csrf_field() }}
                    <div class="msg">{{$start_exploring}}</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" placeholder="{{$email}}" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="{{$password}}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="remember_me" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">{{ __("auth.remember_me") }}</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit">{{ __("auth.button_sign_in") }}</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            <a href="{{route('signUp')}}">{{ __("auth.text_register_now") }}</a>
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="{{ route("forgot") }}">{{ __("auth.forgot_password") }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{{asset('website')}}/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{asset('website')}}/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('website')}}/plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="{{asset('website')}}/plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="{{asset('website')}}/js/admin.js"></script>
    <script src="{{asset('website')}}/js/pages/examples/sign-in.js"></script>
</body>

</html>