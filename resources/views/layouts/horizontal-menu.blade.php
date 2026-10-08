<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/small/logo.jpg" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/small/logo.jpg" alt="" height="24"> <span class="hospital-brand-copy"><span class="logo-txt">Portal de Aplicaciones Hospitalarias</span><small>Hospital San Juan de Dios - El Primero de Chile</small></span>
                    </span>
                </a>

                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/small/logo.jpg" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/small/logo.jpg" alt="" height="24"> <span class="logo-txt">Portal de Aplicativos del Hospital San Juan de Dios</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content" aria-controls="topnav-menu-content" aria-expanded="false" aria-label="Abrir menú de navegación">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>
        @auth
            <div class="hospital-header-ip" aria-label="Dirección IP de tu equipo">
                <i class="mdi mdi-lan-connect" aria-hidden="true"></i>
                <span>IP de tu equipo</span>
                <strong>{{ $ip }}</strong>
            </div>
        @endauth
        <div class="d-flex">
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="ms-1 fw-medium span-ip">
                        @if (Auth::user())
                            {{ Auth::user()->nombre }}
                             <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        @else
                           <i class="mdi mdi-wifi" aria-hidden="true"></i> {{ $ip }}
                        @endif
                    </span>
                </button>
                    @if (Auth::user())
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" id="enlace_logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Cerrar sesión</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                    @endif
            </div>

        </div>
    </div>
</header>

<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu" aria-label="Navegación principal">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav hospital-navigation">
                    <li class="nav-item">
                        <a class="nav-link hospital-nav-active" href="{{ Auth::user() ? route('misSistemas') : url('/') }}" id="topnav-dashboard" aria-current="page">
                            <i class="mdi mdi-home-outline" aria-hidden="true"></i><span>Inicio</span>
                        </a>
                    </li>
                    @if (!Auth::user() || count(Auth::user()->jefatura) > 0)
                        <li class="nav-item">
                            <button type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalCrearCuenta">
                                <i class="mdi mdi-account-plus-outline" aria-hidden="true"></i><span>Solicitar Cuenta HSJD</span>
                            </button>
                        </li>
                    @endif
                    @if (Auth::user())
                        <li class="nav-item dropdown" id="menu-nuevo">
                            <button type="button" class="nav-link dropdown-toggle arrow-none" id="topnav-development" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-code-tags" aria-hidden="true"></i><span>Solicitar Nuevo Desarrollo</span><i class="mdi mdi-chevron-down hospital-nav-chevron" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="topnav-development">
                                <a href="{{ url('http://10.4.237.75/formulario/' . Auth::user()->rut) }}" class="dropdown-item" target="_blank" rel="noopener noreferrer">
                                    <i class="mdi mdi-code-tags" aria-hidden="true"></i> Desarrollo Informático
                                </a>
                                <a href="{{ url('http://10.4.237.75/formulario-enmienda-error/' . Auth::user()->rut) }}" class="dropdown-item" target="_blank" rel="noopener noreferrer">
                                    <i class="mdi mdi-tools" aria-hidden="true"></i> Enmienda de Error
                                </a>
                            </div>
                        </li>
                        @if (Auth::user()->id_perfil == 1)
                            <li class="nav-item dropdown">
                                <button type="button" class="nav-link dropdown-toggle arrow-none" id="topnav-admin" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-cog-outline" aria-hidden="true"></i><span>Mantenedores</span><i class="mdi mdi-chevron-down hospital-nav-chevron" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="topnav-admin">
                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalEditEnlaces">Enlaces</button>
                                </div>
                            </li>
                        @endif
                    @endif
                    <li class="nav-item">
                        <button type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalDesarrollo">
                            <i class="mdi mdi-monitor-dashboard" aria-hidden="true"></i><span>Unidad de Transformación Digital</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalInformatica">
                            <i class="mdi mdi-lifebuoy" aria-hidden="true"></i><span>Unidad de Informática</span>
                        </button>
                    </li>
                </ul>
                @php
                    $anexosUrl = config('services.anexos.url') ?: \App\Models\Enlace::where('estado', 1)
                        ->where('nombre', 'like', '%anexo%')->value('enlace');
                @endphp
                @if ($anexosUrl)
                    <a class="hospital-anexos ms-lg-auto" href="{{ $anexosUrl }}" target="_blank" rel="noopener noreferrer">
                        <i class="mdi mdi-phone-outline" aria-hidden="true"></i> Anexos Hospitalarios
                    </a>
                @else
                    <button type="button" class="hospital-anexos ms-lg-auto" data-bs-toggle="modal" data-bs-target="#modalAnexosHospitalarios">
                        <i class="mdi mdi-phone-outline" aria-hidden="true"></i> Anexos Hospitalarios
                    </button>
                @endif
            </div>
        </nav>
    </div>
</div>
<div class="modal fade" id="modalAnexosHospitalarios" tabindex="-1" aria-labelledby="anexosHospitalariosTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="anexosHospitalariosTitle">Anexos Hospitalarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">El directorio de anexos hospitalarios aún no tiene un enlace configurado.</div>
        </div>
    </div>
</div>
