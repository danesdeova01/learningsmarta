<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ env('APP_NAME') }} | @yield('title')</title>

    <!-- General CSS Files -->
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">

    <!-- CSS Libraries -->
    @yield('style')

    <!-- Template CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/stisla@2.3.0/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/stisla@2.3.0/assets/css/components.min.css">
    <style>
        body {
            font-size: 1.05rem !important;
        }

        .navbar-secondary .navbar-nav .nav-link,
        i {
            font-size: 1.05rem !important;
        }
    </style>
    @livewireStyles
</head>


<body class="layout-3">



    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="{{ url('/', []) }}" class="navbar-brand sidebar-gone-hide">{{ env('APP_NAME') }}</a>
                <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar">
                    <i class="fas fa-bars"></i>
                </a>

                <div class="ml-auto">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="dropdown-item text-white" href="#" data-toggle="modal"
                                data-target="#logoutModal">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                        </li>
                    </ul>
                </div>

            </nav>

            <!-- Modal Logout -->
            <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog">
                    <div class="modal-content text-center">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Profil</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @php
                                $initial = strtoupper(substr(Auth::user()->name, 0, 1));
                            @endphp

                            <div class="mx-auto mb-3" style="width: 80px; height: 80px;">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 80px; height: 80px; font-size: 32px; font-weight: bold;">
                                    {{ $initial }}
                                </div>
                            </div>

                            <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                            <p class="text-muted mb-3">{{ Auth::user()->email }}</p>

                        </div>
                        <div class="modal-footer d-flex align-items-center">
                            <a type="button" class="btn btn-warning"
                                href="{{ route('siswa.change-password', ['id' => 1]) }}">Ubah Password</a>

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <nav class="navbar navbar-secondary navbar-expand-lg">
                <div class="container">
                    <ul class="navbar-nav">
                        <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                            <a href="{{ url('/', []) }}" class="nav-link">
                                <i class="fas fa-fire"></i>
                                <span>Beranda</span>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->is('matapelajaran') ? 'active' : '' }}">
                            <a href="{{ url('/matapelajaran', []) }}" class="nav-link">
                                <i class="fas fa-book"></i>
                                <span>Materi</span>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ request()->is('kuis') || request()->is('kuis/before-kelas') ? 'active' : '' }}">
                            <a href="{{ url('/kuis/before-kelas') }}" class="nav-link">
                                <i class="fas fa-book-reader"></i>
                                <span>Ujian</span>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->is('kirimtugas') ? 'active' : '' }}">
                            <a href="{{ url('/kirimtugas', []) }}" class="nav-link">
                                <i class="fas fa-edit"></i>
                                <span>Tugas</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->is('forum') ? 'active' : '' }}">
                            <a href="{{ url('/forum', []) }}" class="nav-link">
                                <i class="fas fa-comments"></i>
                                <span>Forum Diskusi</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->is('kelas') ? 'active' : '' }}">
                            <a href="{{ url('/kelas', []) }}" class="nav-link">
                                <i class="fas fa-school"></i>
                                <span>Kelas</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>@yield('title')</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ url('/', []) }}">Beranda</a></div>
                            @yield('breadcrumb')
                        </div>
                    </div>

                    <div class="section-body">
                        @yield('content')
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <p class="text-center">
                    Copyright &copy; {{ date('Y') }} By <a href="#"
                        target="_blank">{{ env('APP_NAME') }}</a>
                </p>
            </footer>
        </div>
    </div>


    <!-- General JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/stisla@2.3.0/assets/js/stisla.js"></script>

    <!-- Template JS File -->
    <script src="https://cdn.jsdelivr.net/npm/stisla@2.3.0/assets/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/stisla@2.3.0/assets/js/custom.js"></script>

    <!-- JS Libraies -->
    @include('sweetalert::alert')
   


     @livewireScripts
</body>

</html>
