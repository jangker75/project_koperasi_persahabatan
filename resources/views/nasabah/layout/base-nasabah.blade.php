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
    <div class="page">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 offset-md-4 border border-dark p-0">
                    <!-- Navbar -->
                    <nav class="navbar navbar-nasabah border border-dark p-2">
                        <div class="w-100 d-flex justify-content-between align-items-center">
                            <div class="logo">
                                <a href="" class="d-flex align-items-center">
                                    <img src="{{ asset('assets/images/logo/logo3.png') }}" alt="" height="48">
                                </a>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <div class="dropdown">
                                    <a class="btn text-light" role="button" id="dropdownCart" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fe fe-shopping-cart"></i>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownCart">
                                        <li><span class="dropdown-item">List Shopping Cart</span></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <div class="dropdown-item">
                                                <div class="d-flex align-items-center">
                                                    <div class="p-4 bg-secondary rounded"></div>
                                                    <div class="text ms-3">
                                                        <span>Product 1</span><br>
                                                        <small class="text-danger">Rp 9000</small>
                                                    </div>
                                                    <div class="text ms-3">
                                                        <small>qty : <strong>4</strong></small>
                                                    </div>
                                                    <div class="text ms-3">
                                                        <i class="fe fe-x"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <button class="btn text-light" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasAccount" aria-controls="offcanvasAccount"><i class="fe fe-user"></i></button>

                                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAccount"
                                    aria-labelledby="offcanvasAccountLabel">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasAccountLabel" class="text-dark">Koperasi Karya Husada</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        ...
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="p-2 w-100 mt-2">
                            <div class="input-group w-100">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fe fe-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Cari.." aria-label="Username"
                                    aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </nav>
                    <!-- Navbar -->
                </div>
                <div class="col-12 col-md-4 offset-md-4 bg-light">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- SCRIPT --}}
    @include('admin.components.script-footer')
    @include('admin.shared.toast-script')
    @include('admin.shared.script_delete_index')
    {{ isset($scriptVendor) ? $scriptVendor : '' }}
    {{ isset($script) ? $script : '' }}
    {{-- SCRIPT --}}
</body>

</html>
