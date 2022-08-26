<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="{{ env('APP_NAME') }}">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo/logo.png') }}" />

    <!-- TITLE -->
    <title>{{ env('APP_NAME') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    @include('admin.components.style-header-nasabah')
    {{ isset($styleVendor) ? $styleVendor : '' }}

    <style>
        body {
            background-color: #ddd;
        }

        .navbar-nasabah {
            background-color: #343584;
            color: #f0f0f0;
        }

    </style>
    {{ isset($style) ? $style : '' }}
</head>

<body>
    @include('admin.shared.toast-component')

    <!-- PAGE -->
    <div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 offset-md-4 p-0">
                    @include('nasabah.layout.navbar')
                </div>
                <div class="col-12 col-md-4 offset-md-4 bg-light">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('footer')

    {{-- SCRIPT --}}
    @include('admin.components.script-footer')
    @include('admin.shared.toast-script')
    @include('admin.shared.script_delete_index')

    @yield('scriptVendor')
    @yield('script')
    {{-- SCRIPT --}}
</body>

</html>
