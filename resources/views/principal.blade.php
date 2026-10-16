<!DOCTYPE html>
<html lang="es_cl">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="csp-nonce" nonce="{{ request()->attributes->get('csp_nonce') }}">
    <title>Portal de Aplicativos</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Portal San Juan de Dios" name="description"/>
    <meta content="Nelson Fredy Serrano Herrera" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/small/favicon.ico') }}">
    <!-- plugin css -->
    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css') }}" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/estilos.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/hospital-portal.css') }}?v={{ substr(hash_file('sha256', public_path('assets/css/hospital-portal.css')), 0, 12) }}" rel="stylesheet" type="text/css" />
</head>

<body class="hospital-portal" data-topbar="light" data-layout="horizontal">
    <!-- Begin page -->
    <div id="layout-wrapper">
        <div id="portal-layout">
            @include('layouts.horizontal-menu') 
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content" >
                <div class="page-content">
                    <div class="container-fluid">
                        @yield('contenido')

                    </div> 
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                @include('layouts.footer')           
            </div>
            <!-- end main content-->
            @if (Auth::check() && Auth::user()->id_perfil == 1)
                <div id="portal-admin-modals"></div>
            @endif
        </div>
    </div>
    <!-- END layout-wrapper -->
    <!-- Right Sidebar -->
    @include('layouts.sidebar') 
    <!-- /Right-bar -->
    <!-- JAVASCRIPT -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <!-- pace js -->
    <script src="{{ asset('assets/libs/pace-js/pace.min.js') }}"></script>
    <!-- apexcharts -->
    <!-- Plugins js-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/portal-events.js') }}"></script>
    @vite('resources/js/app.js')
</body>

</html>
