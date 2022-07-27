@props(['titlePage' => ''])
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

    @include('admin.components.style-header')
    {{ isset($styleVendor) ? $styleVendor : '' }}

    {{ isset($style) ? $style : '' }}
</head>

<body class="app sidebar-mini ltr">
    @include('admin.shared.toast-component')
    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src="{{ asset('assets/images/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">

            <!-- app-Header -->
            <x-header></x-header>
            <!-- /app-Header -->

            <!--APP-SIDEBAR-->
            <x-left-sidebar></x-left-sidebar>
            <!--APP-SIDEBAR-->

            <!--app-content open-->
            <div class="main-content app-content mt-0">
                <div class="side-app">

                    <!-- CONTAINER -->
                    <div class="main-container container-fluid">

                        <!-- PAGE-HEADER -->
                        <div class="page-header">
                            <h1 class="page-title">{{ $titlePage }}</h1>
                            <div>
                                @if (Request::segment(1) !== null)
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a
                                                href="{{ url('/') }}">{{ str(Request::segment(1))->title() }}</a>
                                        </li>
                                        @if (Request::segment(2) !== null)
                                            <li class="breadcrumb-item active" aria-current="page">
                                                {{ str(Request::segment(2))->title() }}</li>
                                        @endif
                                    </ol>
                                @endif
                            </div>
                        </div>
                        <!-- PAGE-HEADER END -->
                        
                        {{ $slot }} {{-- Content --}}
                    </div>
                    <!-- CONTAINER CLOSED -->

                </div>
            </div>
            <!--app-content closed-->
        </div>

        <!-- Sidebar-right -->
        <x-right-sidebar></x-right-sidebar>
        <!--/Sidebar-right-->

        <!-- FOOTER -->
        <x-footer></x-footer>
        <!-- FOOTER END -->
    </div>

    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    {{-- SCRIPT --}}
    @include('admin.components.script-footer')
    @include('admin.shared.toast-script')
    @include('admin.shared.script_delete_index')
    <script>
      $(".format-uang").keyup(function(){
          $(this).val(formatRupiah($(this).val()))
        })
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>
    {{ isset($scriptVendor) ? $scriptVendor : '' }}
    {{ isset($script) ? $script : '' }}
    {{-- SCRIPT --}}
</body>

</html>
