
<!DOCTYPE html>
<html lang="es-cl">

<head>
    <title>cambiar contraseña </title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Nelson Serrano Herrera" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- swiper css -->
    <link rel="stylesheet" href="assets/libs/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="assets/css/preloader.min.css">
    <link rel="stylesheet" href="assets/css/icons.min.css">
      <link rel="stylesheet" href="assets/css/app.min.css">
    <!-- preloader css -->
</head>

<body>

<div class="preview-img">
    <div class="swiper-container preview-thumb">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="slide-bg" style="background-image: url(./assets/images/hsjd.jpg);"></div>
            </div>
        </div>
    </div>
</div>
<!-- preview bg -->

<div class="coming-content min-vh-100 py-4 px-3 py-sm-5">
    <div class="bg-overlay bg-primary"></div>
    <div class="container">
         <div id="app">
            @yield('contenido')
         </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- coming-content -->

<!-- JAVASCRIPT -->

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

 
<script src="assets/js/metismenu/metisMenu.js"></script>
<script src="assets/js/feather-icons/feather.min.js"></script>

<!-- /Right-bar -->
  
{{-- <script src="assets/js/app.js"></script> --}}
<script src="assets/js/sweetalert2.js"></script>
<!-- JAVASCRIPT -->


<!-- swiper js -->
{{-- @vite([
    'resources/assets/js/pages/bootstrap.bundle.min.js',
]) --}}

<script src="assets/js/swiper/swiper-bundle.min.js"></script>
<!-- Plugins js-->
<script src="assets/js/jquery-countdown/jquery.countdown.min.js"></script>

<!-- Countdown js -->
<script src="assets/js/coming-soon.init.js"></script>
{{-- @vite([
    'resources/assets/js/app.js',
]) --}}

@vite([
    'resources/js/app.js',
])
</body>

</html>