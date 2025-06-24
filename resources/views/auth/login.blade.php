
<!DOCTYPE html>
<html lang="es_cl">
<head>
   <title>Iniciar Sesión | NEA</title>
   <meta charset="utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta content="NEA Notificación de elementos ADV" name="description"/>
   <meta content="Themesbrand" name="author"/>
   <!-- App favicon -->
   <link rel="shortcut icon" href="build/assets/images/favicon.ico">

    @vite([
        
            'resources/assets/css/preloader.min.css',
            'resources/assets/css/bootstrap.min.css',
            'resources/assets/css/icons.min.css',
            'resources/assets/css/app.min.css',
            'resources/assets/css/estilos.css'
   ])

</head>

 <body>
<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-xxl-3 col-lg-4 col-md-5">
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4 mb-md-5 text-center">
                                <a class="d-block auth-logo">
                                    <img src="build/assets/images/logo-sm.svg" alt="" height="28"> <span class="logo-txt">SIVEA</span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                    <h5 class="mb-0">¡Bienvenidos!</h5>
                                    <p class="text-muted mt-2">Iniciar sesión para continuar.</p>
                                </div>
                                <form  method="POST" action="{{ route('login')}}" class="custom-form mt-4 pt-2">
                                 {{ csrf_field() }}
                                    <div class="mb-3">
                                        <label class="form-label">RUN</label>
                                        <input type="text" class="form-control" value="{{old('rut')}}" id="rut" name="rut" placeholder="Ingrese RUN">
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Password</label>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="">
                                                    {{-- <a href="auth-recoverpw.php" class="text-muted">¿recuperar password?</a> --}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" name="password" id="password"  value="{{old('password')}}" placeholder="Ingrese password" aria-label="Password" aria-describedby="password-addon">
                                            <button class="btn btn-light ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>
                                    {{-- <div class="row mb-4">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember-check">
                                                <label class="form-check-label" for="remember-check">
                                                    Remember me
                                                </label>
                                            </div>
                                        </div>

                                    </div> --}}
                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Ingresar</button>
                                    </div>
                                </form>
     
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">© <script>
                                        document.write(new Date().getFullYear())
                                    </script> HSJD <i class="mdi mdi-heart text-danger"></i> por  (NFSH)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end auth full page content -->
            </div>
            <!-- end col -->
            <div class="col-xxl-9 col-lg-8 col-md-7">
                <div class="auth-bg pt-md-5 p-4 d-flex">
                    <div class="gradient_login bg-primary"></div>
                    <ul class="bg-bubbles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <!-- end bubble effect -->
                  
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container fluid -->
</div>
<!-- JAVASCRIPT -->
    @vite([
        'resources/assets/libs/jquery/jquery.min.js'
    ])
</body>
</html>