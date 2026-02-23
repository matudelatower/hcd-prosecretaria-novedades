<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Sistema de Control HCD')</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Favicon -->
    {{-- <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}"> --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <style>
        .main-sidebar {
            background: linear-gradient(180deg, #304156 10%, #263445 100%);
        }
        .brand-link {
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .nav-sidebar > .nav-item > .nav-link {
            margin: 2px 0;
            border-radius: 0.25rem;
        }
        .nav-sidebar > .nav-item > .nav-link.active {
            background: rgba(255,255,255,.1);
            color: #fff;
        }
        .nav-sidebar > .nav-item > .nav-link:hover {
            background: rgba(255,255,255,.05);
        }
        .content-wrapper {
            background: #f4f6f9;
        }
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        }
        .small-box {
            border-radius: 0.5rem;
        }
        .small-box h3 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            background: #f8f9fa;
        }
        .btn-group .btn {
            margin: 0 1px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('dashboard') }}" class="nav-link font-weight-bold">
                    <i class="fas fa-home mr-1"></i>Inicio
                </a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name ?? 'Usuario' }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i>Cerrar sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <i class="fas fa-landmark brand-image img-circle elevation-3 ml-1" style="opacity: .8"></i>
            <span class="brand-text font-weight-light">HCD Control</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <i class="fas fa-user-circle img-circle elevation-2" style="font-size: 2.5rem; color: #fff;"></i>
                </div>
                <div class="info">
                    <a href="#" class="d-block text-white">{{ Auth::user()->name ?? 'Administrador' }}</a>
                    <small class="text-muted">Usuario activo</small>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    
                    @if(Auth::check() && Auth::user()->isAdmin())
                        <li class="nav-header">GESTIÓN ADMINISTRATIVA</li>
                        <li class="nav-item">
                            <a href="{{ route('areas.index') }}" class="nav-link {{ request()->routeIs('areas.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Áreas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('responsables.index') }}" class="nav-link {{ request()->routeIs('responsables.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Responsables</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('designaciones.index') }}" class="nav-link {{ request()->routeIs('designaciones.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Designaciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                    @endif
                    
                    <li class="nav-header">NOVEDADES</li>
                    <li class="nav-item">
                        <a href="{{ route('novedades.index') }}" class="nav-link {{ request()->routeIs('novedades.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-exclamation-triangle"></i>
                            <p>Novedades</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark font-weight-bold">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-muted">Inicio</a></li>
                            <li class="breadcrumb-item active">@yield('breadcrumb', 'Dashboard')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        <h5 class="alert-heading">
                            <i class="fas fa-check-circle mr-2"></i>¡Éxito!
                        </h5>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        <h5 class="alert-heading">
                            <i class="fas fa-exclamation-circle mr-2"></i>Error
                        </h5>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- Footer -->
    <footer class="main-footer border-top">
        <div class="float-right d-none d-sm-inline">
            <small>Version 1.0.0</small>
        </div>
        <strong>Copyright &copy; {{ date('Y') }} <a href="#" class="text-dark">HCD</a>.</strong>
        Todos los derechos reservados.
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
