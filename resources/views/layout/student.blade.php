<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Murid</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @foreach(getGlobalAssets('css') as $path)
        <link rel="stylesheet" href="{{ asset($path) }}">
    @endforeach
    @foreach(getVendors('css') as $path)
        <link rel="stylesheet" href="{{ asset($path) }}">
    @endforeach
    @foreach(getCustomCss() as $path)
        <link rel="stylesheet" href="{{ asset($path) }}">
    @endforeach
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}?v={{ filemtime(public_path('assets/css/custom.css')) }}">
    @stack('styles')
</head>
<body class="bg-light">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="aside bg-white aside-hoverable min-vh-100 d-none d-md-block shadow-sm" style="width:220px;">
                <div class="aside-logo d-flex align-items-center justify-content-center py-4">
                    <img src="{{ asset('assets/media/logos/logo.png') }}" alt="Logo" style="height:40px;">
                </div>
                <div class="aside-menu flex-column-fluid">
                    <ul class="menu-nav nav flex-column px-2">
                        <li class="menu-item mb-1">
                            <a class="menu-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
                                <span class="menu-icon"><i class="bi bi-house"></i></span>
                                <span class="menu-title">Overview</span>
                            </a>
                        </li>
                        <li class="menu-item mb-1">
                            <a class="menu-link {{ request()->routeIs('profile.show') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                                <span class="menu-icon"><i class="bi bi-person"></i></span>
                                <span class="menu-title">My Profile</span>
                            </a>
                        </li>
                        <li class="menu-item mt-4">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="bi bi-box-arrow-right"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Sidebar -->

            <!-- Hamburger for mobile -->
            <button class="btn btn-icon btn-light d-md-none position-fixed m-2" style="z-index:1051;top:0;left:0;" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                <i class="bi bi-list fs-2"></i>
            </button>
            <div class="offcanvas offcanvas-start d-md-none bg-white" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
                <div class="offcanvas-header">
                    <img src="{{ asset('assets/media/logos/logo.png') }}" alt="Logo" style="height:32px;">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
                                <i class="bi bi-house me-2"></i> Overview
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->routeIs('profile.show') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                                <i class="bi bi-person me-2"></i> My Profile
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="bi bi-box-arrow-right"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End Hamburger for mobile -->

            <!-- Main Wrapper -->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!-- Content -->
                <main class="content d-flex flex-column flex-column-fluid p-4" id="kt_content">
                    @yield('content')
                </main>
                <!-- End Content -->
            </div>
            <!-- End Main Wrapper -->
        </div>
    </div>
    <!-- JS dari master.blade -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @foreach(getGlobalAssets('js') as $path)
        <script src="{{ asset($path) }}"></script>
    @endforeach
    @foreach(getVendors('js') as $path)
        <script src="{{ asset($path) }}"></script>
    @endforeach
    @foreach(getCustomJs() as $path)
        <script src="{{ asset($path) }}"></script>
    @endforeach
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/js/courses-index.js') }}?v={{ filemtime(public_path('assets/js/courses-index.js')) }}"></script>
    <script src="{{ asset('assets/js/courses.js') }}?v={{ filemtime(public_path('assets/js/courses.js')) }}"></script>
    @stack('scripts')
</body>
</html>