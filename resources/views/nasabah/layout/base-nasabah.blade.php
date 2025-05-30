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
        .navbar-nasabah {
            background-color: #343584;
            color: #f0f0f0;
        }

        .bg-content{
          background-color: #fff;
        }

    </style>
    {{ isset($style) ? $style : '' }}
    @stack('style')
</head>

<body>
    @include('admin.shared.toast-component')

    <!-- PAGE -->
    <div>
        <div class="container">
            <div class="row" style="min-height: 100vh;">
                {{-- @if (Request::segment(1) == "product" || Request::segment(1) == null)
                <div class="col-12 col-md-4 offset-md-4 p-0 mb-0">
                  @include('nasabah.layout.navbar')
                </div>
                @endif --}}
                
                <div class="col-12 col-md-4 offset-md-4 p-0 bg-content">
                    @if (Request::segment(1) == "product" || Request::segment(1) == null)
                      @include('nasabah.layout.navbar')
                    @endif
                    <div class="row px-4">
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
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
    @include('nasabah.shared.script-navbar')

    @yield('scriptVendor')
    @yield('script')
    {{ isset($scriptVendor) ? $scriptVendor : '' }}
    {{ isset($script) ? $script : '' }}
    @stack('script')
    {{-- SCRIPT --}}
</body>

</html>
