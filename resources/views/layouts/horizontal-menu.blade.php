<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.php" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/small/logo.jpg" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/small/logo.jpg" alt="" height="24"> <span class="logo-txt">Portal Aplicativos</span>
                    </span>
                </a>

                <a href="index.php" class="logo logo-light">
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
                    
                    <span class="d-none d-xl-inline-block ms-1 fw-medium span-ip">Tú IP es: {{ $ip }}</span>
                     
                    {{-- <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i> --}}
                </button>
                {{-- <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="apps-contacts-profile.php"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Profile</a>
                   <a class="dropdown-item" href="auth-lock-screen.php"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i> Lock_screen</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                </div> --}}
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


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                            <i data-feather="grid"></i><span data-key="t-apps">Cuenta San Juan de Dios</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-pages">

                            <a href="apps-calendar.php" class="dropdown-item" data-key="t-calendar">Calendar</a>
                            <a href="apps-chat.php" class="dropdown-item" data-key="t-chat">Chat</a>

                            {{-- <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email" role="button">
                                    <span data-key="t-email">Email</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a href="apps-email-inbox.php" class="dropdown-item" data-key="t-inbox">Inbox</a>
                                    <a href="apps-email-read.php" class="dropdown-item" data-key="t-read-email">Read_Email</a>
                                </div>
                            </div> --}}

                            {{-- <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-invoice" role="button">
                                    <span data-key="t-invoices">Invoices</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-invoice">
                                    <a href="apps-invoices-list.php" class="dropdown-item" data-key="t-invoice-list">Invoice_List</a>
                                    <a href="apps-invoices-detail.php" class="dropdown-item" data-key="t-invoice-detail">Invoice_Detail</a>
                                </div>
                            </div> --}}
                            
                            {{-- <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-contact" role="button">
                                    <span data-key="t-contacts">Contacts</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-contact">
                                    <a href="apps-contacts-grid.php" class="dropdown-item" data-key="t-user-grid">User_Grid</a>
                                    <a href="apps-contacts-list.php" class="dropdown-item" data-key="t-user-list">User_List</a>
                                    <a href="apps-contacts-profile.php" class="dropdown-item" data-key="t-profile">Profile</a>
                                </div>
                            </div> --}}
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>