<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar contraseña | Hospital San Juan de Dios</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/small/favicon.ico') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/hospital-login.css') }}?v={{ filemtime(public_path('assets/css/hospital-login.css')) }}" rel="stylesheet">
</head>
<body class="hospital-login">
    <header class="login-header">
        <a href="{{ '/' }}" class="login-brand">
            <img src="{{ asset('assets/images/small/logo.jpg') }}" alt="" width="30" height="30">
            <span><strong>Hospital San Juan de Dios</strong><small>El Primero de Chile</small></span>
        </a>
        <a href="{{ '/' }}" class="portal-back"><i class="mdi mdi-arrow-left" aria-hidden="true"></i> Volver al portal</a>
    </header>
    <main class="login-main" id="app"><router-view></router-view></main>
    <footer class="login-footer">© {{ date('Y') }} Hospital San Juan de Dios <span>Unidad de Transformación Digital</span></footer>
    @vite('resources/js/app.js')
</body>
</html>
