
<!DOCTYPE html>
<html lang="es_cl">
<head>
   <title>Iniciar Sesión Ficha clínica</title>
   <meta charset="utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta content="NEA Notificación de elementos ADV" name="description"/>
   <meta content="Themesbrand" name="author"/>
   <!-- App favicon -->
    <link rel="shortcut icon" href="build/assets/images/favicon.ico">
    <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css') }}" type="text/css" />
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
     <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    
    <link href="{{ asset('assets/css/estilos.css') }}" id="app-style" rel="stylesheet" type="text/css" />

</head>

 <body>
<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
            
            <!-- end col -->
            <div class="col-xxl-12 col-lg-12 col-md-12">
                
                <div class="auth-bg pt-md-5 p-4 d-flex justify-content-center">
                    <div class="row">
                      <div class="col-md-8 col-xl-8">
                            <div class="card card-login">
                                <div class="card-body">
                                    <h4 class="card-title">Iniciar Sesión</h4>
                                    <div class="row">
                                        <div class="col-md-12 d-flex align-items-center justify-content-center">
                                             <div class="image-wrapper">
                                                <img src="assets/images/logo-sjd.png" class="ht-100 mb-0" alt="Logo Hospital San Juan de Dios">
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>
            
                                <div class="card-body">
                                    <div class="auth-content my-auto">
                                        <div class="text-center">
                                            <h5 class="mb-0">¡Bienvenido!</h5>
                                            <p class="text-muted mt-2">Iniciar sesión para continuar.</p>
                                        </div>
                                        <form  method="POST" action="{{ route('iniciarSesion')}}" class="custom-form mt-4 pt-2">
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
                        
                                            <div class="mb-3">
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Ingresar</button>
                                            </div>
                                        </form>
            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
</body>
</html>