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
                        <img src="assets/images/small/logo.jpg" alt="" height="24"> <span class="logo-txt">Portal Aplicativos</span>
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

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            {{-- <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Buscar">
                    <button class="btn btn-primary" type="button"><i class="bx bx-search-alt align-middle"></i></button>
                </div>
            </form> --}}
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="search" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search" aria-label="Search Result">

                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium span-ip">
                        @if (Auth::user())
                            {{ Auth::user()->nombre }}
                             <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        @else
                           Tú IP es: {{ $ip }}
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
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="inicio" id="topnav-dashboard" role="button">
                            <i data-feather="home"></i><span data-key="t-dashboards">Dashboard</span>
                        </a>
                    </li>
                    
                    @if (Auth::user())
                        @if (COUNT(Auth::user()->jefatura)>0)
                          <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                    <i data-feather="grid"></i><span data-key="t-apps">Cuenta San Juan de Dios</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                    <a href="#" class="dropdown-item" data-key="t-calendar"  data-bs-toggle="modal" data-bs-target="#modalCrearCuenta">Solicitar Cuenta</a>
                                </div>
                            </li>
                        @endif
                    @else
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                            <i data-feather="grid"></i><span data-key="t-apps">Cuenta San Juan de Dios</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                            <a href="#" class="dropdown-item" data-key="t-calendar"  data-bs-toggle="modal" data-bs-target="#modalCrearCuenta">Solicitar Cuenta</a>
                        </div>
                    </li>
                    @endif
                    <li class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" role="button" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg><span data-key="t-horizontal">Soporte</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>