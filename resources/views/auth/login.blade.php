<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Acceso al Portal de Aplicaciones Hospitalarias del Hospital San Juan de Dios">
    <title>Iniciar sesión | Hospital San Juan de Dios</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/small/favicon.ico') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/hospital-login.css') }}?v={{ filemtime(public_path('assets/css/hospital-login.css')) }}" rel="stylesheet">
</head>
<body class="hospital-login">
    <header class="login-header">
        <a href="{{ url('/') }}" class="login-brand">
            <img src="{{ asset('assets/images/small/logo.jpg') }}" alt="" width="30" height="30">
            <span><strong>Hospital San Juan de Dios</strong><small>El Primero de Chile</small></span>
        </a>
        <a href="{{ url('/') }}" class="portal-back"><i class="mdi mdi-arrow-left" aria-hidden="true"></i> Volver al portal</a>
    </header>
    <main class="login-main">
        <div class="login-shell">
            <section class="login-intro" aria-labelledby="portal-title">
                <span class="intro-label">PORTAL DE APLICACIONES HOSPITALARIAS</span>
                <h1 id="portal-title">Tecnología al servicio<br>del cuidado.</h1>
                <p>Accede a tus sistemas clínicos y herramientas de trabajo en un solo lugar.</p>
                <div class="intro-symbol" aria-hidden="true"><i class="mdi mdi-hospital-building"></i><span class="symbol-orbit orbit-one"></span><span class="symbol-orbit orbit-two"></span></div>
                <div class="intro-footer"><i class="mdi mdi-account-group-outline" aria-hidden="true"></i><span>Un portal para quienes cuidan de las personas.</span></div>
            </section>
            <section class="login-form-panel" aria-labelledby="login-title">
                <span class="login-icon" aria-hidden="true"><i class="mdi mdi-account-outline"></i></span>
                <h2 id="login-title">Bienvenido a tu portal</h2>
                <p class="login-subtitle">Ingresa con tu cuenta institucional para continuar.</p>
                @if ($errors->any())
                    <div class="login-error" role="alert"><i class="mdi mdi-alert-circle-outline" aria-hidden="true"></i><span>{{ $errors->first() }}</span></div>
                @endif
                <form method="POST" action="{{ route('iniciarSesion') }}" id="clinical-login-form">
                    @csrf
                    <input type="hidden" name="location_status" value="unavailable">
                    <input type="hidden" name="latitude">
                    <input type="hidden" name="longitude">
                    <input type="hidden" name="accuracy_meters">
                    <div class="login-field">
                        <label for="rut">RUN</label>
                        <div class="login-input"><i class="mdi mdi-card-account-details-outline" aria-hidden="true"></i><input type="text" value="{{ old('rut') }}" id="rut" name="rut" placeholder="Ej. 12345678-9" autocomplete="username" autocapitalize="characters" spellcheck="false" required oninput="formatearRutSoloGuion(this)" @if($errors->has('rut')) aria-invalid="true" @endif></div>
                    </div>
                    <div class="login-field">
                        <div class="login-label-row"><label for="password">Contraseña</label><a href="{{ route('recuperarContrasena') }}">¿Olvidaste tu contraseña?</a></div>
                        <div class="login-input"><i class="mdi mdi-lock-outline" aria-hidden="true"></i><input type="password" name="password" id="password" placeholder="Ingresa tu contraseña" autocomplete="current-password" required><button type="button" id="password-addon" aria-label="Mostrar contraseña" aria-controls="password" aria-pressed="false"><i class="mdi mdi-eye-outline" aria-hidden="true"></i></button></div>
                    </div>
                    <button class="login-submit" type="submit">Iniciar sesión <i class="mdi mdi-arrow-right" aria-hidden="true"></i></button>
                    <div class="login-account-note"><i class="mdi mdi-shield-account-outline" aria-hidden="true"></i><p>Tu cuenta es <strong>personal e intransferible</strong>. Protege tus credenciales y la información de los pacientes.</p></div>
                    <p class="login-audit-note">Se registra la IP del equipo al ingresar. Si autorizas al navegador, también se registra tu ubicación para la auditoría del acceso.</p>
                    <p id="login-location-status" class="login-location-status" role="status" aria-live="polite"></p>
                </form>
            </section>
        </div>
    </main>
    <footer class="login-footer">© {{ date('Y') }} Hospital San Juan de Dios <span>Unidad de Transformación Digital</span></footer>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/login.js') }}?v={{ filemtime(public_path('assets/js/login.js')) }}"></script>
    <script src="{{ asset('assets/js/login-location.js') }}?v={{ filemtime(public_path('assets/js/login-location.js')) }}"></script>
</body>
</html>
