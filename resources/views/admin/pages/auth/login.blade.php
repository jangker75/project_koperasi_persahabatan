<!doctype html>
<html lang="en" dir="ltr">

<head>
    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="{{ env('APP_NAME') }}">
    <meta name="keywords"
        content="Aplikasi Koperasi Karya Husada, RS Persahabatan.">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo/logo.png') }}" />

    <!-- TITLE -->
    <title>{{ env('APP_NAME') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    @include('admin.components.style-header')
</head>

<body class="app sidebar-mini ltr">

    <!-- BACKGROUND-IMAGE -->
    <div class="login-img">

        <!-- GLOABAL LOADER -->
        <div id="global-loader">
            <img src="{{ asset('assets/images/loader.svg') }}" class="loader-img" alt="Loader">
        </div>
        <!-- /GLOABAL LOADER -->

        <!-- PAGE -->
        <div class="page">
            <div class="">
                <!-- CONTAINER OPEN -->
                <div class="col col-login mx-auto mt-7">
                    <div class="text-center">
                        <img src="{{ asset('assets/images/logo/logo2.png') }}" height="150px" class="header-brand-img"
                            alt="">
                    </div>
                </div>
                <div class="col col-login mx-auto mt-7">
                    <div class="text-center">
                        <span class="login-application-name">{{ env("APP_NAME") }}</span>
                    </div>
                </div>

                <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <span class="login100-form-title pb-5">
                            Login
                        </span>
                        @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                                    <strong>Login Failed!</strong> 
                                        {{ __('general.login_error') }}
                                </div>
                        @endif
                        <div class="panel panel-primary">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs">
                                        <li class="mx-0"><a href="#tab5" class="active" data-bs-toggle="tab">Login
                                                With NIK and Password</a></li>
                                    </ul>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body tabs-menu-body p-0 pt-5">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab5">
                                            <div class="wrap-input100 validate-input input-group">
                                                <div
                                                    class="input-group-text bg-white text-muted">
                                                    <i class="mdi mdi-account"></i>
                                                </div>
                                                <input class="input100 border-start-0 form-control ms-0" type="text"
                                                    name="email" placeholder="Nomor Induk Koperasi">
                                            </div>
                                            <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                                                <div
                                                    class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                </div>
                                                <input class="input100 border-start-0 form-control ms-0" type="password"
                                                    name="password" placeholder="Password">
                                            </div>
                                            <div class="container-login100-form-btn">
                                                <button type="submit" class="login100-form-btn btn-primary">
                                                    Login
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!-- End PAGE -->

    </div>
    <!-- BACKGROUND-IMAGE CLOSED -->
    @include('admin.components.script-footer')

</body>

</html>
