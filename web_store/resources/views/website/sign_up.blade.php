<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>{{$title}}</title>
    <!-- Favicon-->
    <link rel="icon" href="{{asset('website')}}/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="{{asset('website')}}/plugins/materialicsone.css" rel="stylesheet" type="text/css">
    <link href="{{asset('website')}}/plugins/materialicons2.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('website')}}/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('website')}}/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('website')}}/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('website')}}/css/style.css" rel="stylesheet">
</head>

<body class="signup-page">
    <div class="signup-box">
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
            <div class="body">
                <form action="{{route('register')}}" id="sign_up" method="POST">
                    {{ csrf_field() }}
                    <div class="msg">{{ $title }}</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="name" placeholder="{{$name}}" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="email" placeholder="{{$email}}" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" minlength="6" placeholder="{{$password}}" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password_confirmation" minlength="6" placeholder="{{$password_confirmation}}" required>
                        </div>
                    </div>
                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">SIGN UP</button>

                    <div class="m-t-25 m-b--5 align-center">
                        <a href="{{ url("login") }}">{{ __("auth.text_have_account") }}</a>
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
    <script src="{{asset('website')}}/js/pages/examples/sign-up.js"></script>
</body>

</html>