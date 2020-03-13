<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<!-- Site wrapper -->
<div class="wrapper" id="el">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/') }}" class="nav-link">Inicio</a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{ asset('dist/img/user1-128x128.jpg') }}" alt="User Avatar"
                                 class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{ asset('dist/img/user8-128x128.jpg') }}" alt="User Avatar"
                                 class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{ asset('dist/img/user3-128x128.jpg') }}" alt="User Avatar"
                                 class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="brand-link">
            <img src="{{ asset('dist/img/AdminLTELogo.png') }}"
                 alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Laboratorio HHHA</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                         alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Infinity
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('user.infinityTest') }}" onclick="getclick()" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pruebas</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../../index.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard v1</p>
                                </a>
                                <a href="{{ route('admin.verification') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Revisión final</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- @if(Auth::user()->name == "Administrador") -->
                    <li class="nav-header">MANTENEDOR</li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Tablas maestras
                                <i class="fas fa-angle-left right"></i>
                                {{--                                <span class="badge badge-info right">6</span>--}}
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('section') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sección</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('state') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Estado</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('workarea') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Area de trabajo</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Usuarios</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('sample') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tipos de muestra</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('container') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Contenedores</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('collectionMethod') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Obtención</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mainAnalyte') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Prestación</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('label') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Etiqueta</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.vihkey') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Clave VIH</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('available') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Disponibilidad</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('fonasa') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>FONASA</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('method') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Método</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('timeProcess') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tiempo de procesamiento</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('timeReception') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Recepción muestra</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('analyte') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Examen</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.unit') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Unidades</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.test') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pruebas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.analyteTest') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Rel pruebas y examen</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.gender') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Genero</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.ageUnit') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Unidades edad</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.referenceRange') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Rango de referencia</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.medicalOrder') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Solicitud médica</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.indication') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Indicaciones</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.timeResponse') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tiempo de respuesta</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Tablas LIS
                                <i class="fas fa-angle-left right"></i>
                                {{--                                <span class="badge badge-info right">6</span>--}}
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('hcaLaboratory') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Infinity - HCA HHHA</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('infinityRelGroupTest') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Infinity - Grupo - Prueba</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('infinitySupergroup') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Infinity - Supergrupo</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('infinityGroup') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Infinity - Grupo</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('infinitySample') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Infinity - Tipo Muestra</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('infinityTypeTube') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Infinity - Tipo Tubo</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('infinityTest') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Infinity - Prueba</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('infinityLabdateTest') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Infinity - Labdate</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                LOINC
                                <i class="fas fa-angle-left right"></i>
                                {{--                                <span class="badge badge-info right">6</span>--}}
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('loinc') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>LOINC</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- @endif -->

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0
        </div>
        <strong>2019-2020 <a href="https://www.hhha.cl" target="_blank">Hospital Dr. Hernán Henríquez
                Aravena</a>.</strong> Subdepartamento Laboratorio Clínico
    </footer>

    {{--    <!-- Control Sidebar -->--}}
    {{--    <aside class="control-sidebar control-sidebar-dark">--}}
    {{--        <!-- Control sidebar content goes here -->--}}
    {{--    </aside>--}}
    {{--    <!-- /.control-sidebar -->--}}
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js')}}"></script>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

<script>

    const link = document.getElementsByClassName('nav-item has-treeview');

    for (let i = 0; i< link.length; i++){
        link[i].className += " menu-open"
    }



</script>

</body>
</html>
