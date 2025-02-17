<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | BJB Document Tracker</title>

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{{ asset('favicons/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicons/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="Docutrack" />
    <link rel="manifest" href="{{ asset('favicons/site.webmanifest') }}" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/FontAwesome/6.2.1/css/all.min.css') }}">
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('assets/adminLTE/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/adminLTE/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/adminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/adminLTE/dist/css/adminlte.min.css') }}">
    <!-- Our style -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @stack('css')
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark bg-bjb border-bottom-0">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <h4 style="color: #000"><strong>bjb</strong> Document Tracker</h4>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar main-sidebar-custom sidebar-dark-warning">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link border-0 bg-white">
                <img src="{{ asset('assets/logo/main.png') }}" alt="bjb">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                    <div class="image">
                        <img src="{{ asset('assets/img/profile/' . Auth::user()->avatar) }}" class="img-circle"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ route('profile.edit') }}"
                            class="d-block text-warning"><strong>{{ Auth::user()->name }}</strong> <br>
                            <small>{{ auth()->user()->role->name }}</small></a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview"
                        role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-house"></i>
                                <p>
                                    Home
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-chart-simple"></i>
                                <p>
                                    Report
                                </p>
                            </a>
                        </li>

                        <li class="nav-header mt-3 text-white">DOCUMENT</li>

                        <li class="nav-item">
                            <a href="{{ route('document.index') }}" class="nav-link">
                                <i class="nav-icon fa-regular fa-folder-open"></i>
                                <p>
                                    Document List
                                </p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('agunan.index') }}" class="nav-link">
                                <i class="nav-icon fa-regular fa-file"></i>
                                <p>
                                    Agunan List
                                </p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ route('scan.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-magnifying-glass"></i>
                                <p>
                                    Scan Room
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-clock-rotate-left"></i>
                                <p>
                                    Changes History
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-clipboard-check"></i>
                                <p>
                                    Document Detail
                                </p>
                            </a>
                        </li>

                        <li class="nav-header mt-3 text-white">DATA</li>
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-user"></i>
                                <p>
                                    User List
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tag.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-tags"></i>
                                <p>
                                    Tag RFID
                                </p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-location-dot"></i>
                                <p>
                                    Location
                                </p>
                            </a>
                        </li> --}}

                        <li class="nav-item mt-3">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="nav-link logout">
                                <i class="nav-icon fa-solid fa-power-off"></i>
                                <p>
                                    Log Out
                                </p>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer text-sm">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Your Solution Partner
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2024 <a href="https://partnership.co.id" target="_blank"
                    class="link-black">Partnership</a></strong>
            All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('assets/adminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Sweetalert2 -->
    <script src="{{ asset('assets/adminLTE/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/adminLTE/plugins/select2/js/select2.full.min.js') }}"></script>

    @stack('scripts')

    <!-- AdminLTE App -->
    <script src="{{ asset('assets/adminLTE/dist/js/adminlte.min.js') }}"></script>

    <!-- Active Class -->
    <script>
        /*** add active class and stay opened when selected ***/
        var url = window.location;

        // for sidebar menu entirely but not cover treeview
        $('ul.nav-sidebar a').filter(function() {
            if (this.href) {
                return this.href == url || url.href.indexOf(this.href) == 0;
            }
        }).addClass('active');

        // for the treeview
        $('ul.nav-treeview a').filter(function() {
            if (this.href) {
                return this.href == url || url.href.indexOf(this.href) == 0;
            }
        }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
    </script>

    <!-- Sweetalert2 -->
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast'
            },
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        })

        @if (session('pesan'))
            @switch(session('level-alert'))
                @case('alert-success')
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('pesan') }}'
                })
                @break

                @case('alert-danger')
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('pesan') }}'
                })
                @break

                @case('alert-warning')
                Toast.fire({
                    icon: 'warning',
                    title: '{{ Session::get('pesan') }}'
                })
                @break

                @case('alert-question')
                Toast.fire({
                    icon: 'question',
                    title: '{{ Session::get('pesan') }}'
                })
                @break

                @default
                Toast.fire({
                    icon: 'info',
                    title: '{{ Session::get('pesan') }}'
                })
            @endswitch
        @endif
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                Toast.fire({
                    icon: 'error',
                    title: '{{ $error }}'
                })
            @endforeach
        @endif
    </script>
</body>

</html>
