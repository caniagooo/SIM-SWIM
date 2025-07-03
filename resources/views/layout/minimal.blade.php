<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! printHtmlAttributes('html') !!}>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <link rel="canonical" href="{{ url()->current() }}"/>

    {!! includeFavicon() !!}
    {!! includeFonts() !!}

    {{-- Global Styles --}}
    @foreach(getGlobalAssets('css') as $path)
        <link rel="stylesheet" href="{{ asset($path) }}">
    @endforeach

    {{-- Vendor Styles --}}
    @foreach(getVendors('css') as $path)
        <link rel="stylesheet" href="{{ asset($path) }}">
    @endforeach

    {{-- Custom Styles --}}
    @foreach(getCustomCss() as $path)
        <link rel="stylesheet" href="{{ asset($path) }}">
    @endforeach

    {{-- Ekstra Plugin Styles --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    @livewireStyles
</head>
<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

    <div class="d-flex flex-row flex-root">
        <!--begin::Sidebar-->
        <button class="hamburger d-lg-none position-fixed top-0 start-0 m-2" id="sidebarToggle" aria-label="Toggle sidebar">
            <span style="display:inline-block;width:2em;height:2em;">
                <svg viewBox="0 0 32 32" width="32" height="32">
                    <rect y="6" width="32" height="4" rx="2"/>
                    <rect y="14" width="32" height="4" rx="2"/>
                    <rect y="22" width="32" height="4" rx="2"/>
                </svg>
            </span>
        </button>
        <div class="sidebar-overlay"></div>
        <div class="app-sidebar">
            @include('layout.partials.sidebar-layout._sidebar')
        </div>
        <!--end::Sidebar-->

        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!-- Logo mobile -->
            <div class="d-lg-none position-fixed top-0 start-50 translate-middle-x mt-2 logo-mobile bg-white rounded shadow-sm px-2 py-1">
                @include('layout.partials.sidebar-layout.sidebar._logo')
            </div>

            

            <div class="d-flex flex-column flex-column-fluid">
                @includeIf('layout.partials.sidebar-layout._toolbar')

                <main id="kt_app_content" class="app-content flex-column-fluid">
                    <div id="kt_app_content_container" class="app-container container-fluid">
                        @yield('content')
                    </div>
                </main>
            </div>

            @includeIf('layout.partials.sidebar-layout._footer')
        </div>
        <!--end::Main-->
    </div>

    @includeIf('partials._drawers')
    @includeIf('partials._modals')
    @includeIf('partials._scrolltop')

    {{-- Scripts --}}
    @foreach(getGlobalAssets('js') as $path)
        <script src="{{ asset($path) }}"></script>
    @endforeach

    @foreach(getVendors('js') as $path)
        <script src="{{ asset($path) }}"></script>
    @endforeach

    @foreach(getCustomJs() as $path)
        <script src="{{ asset($path) }}"></script>
    @endforeach

    {{-- Ekstra Plugin --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/courses.js') }}"></script>

    @livewireScripts

    <script>
        // Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function () {
            var sidebarToggle = document.getElementById('sidebarToggle');
            var body = document.body;
            var overlay = document.querySelector('.sidebar-overlay');
            if (sidebarToggle && overlay) {
                sidebarToggle.addEventListener('click', function (e) {
                    e.stopPropagation();
                    body.classList.toggle('sidebar-open');
                });
                overlay.addEventListener('click', function () {
                    body.classList.remove('sidebar-open');
                });
            }
        });

        // Livewire Events
        document.addEventListener('livewire:init', () => {
            Livewire.on('success', (message) => toastr.success(message));
            Livewire.on('error', (message) => toastr.error(message));
            Livewire.on('swal', (message, icon = 'success', confirmButtonText = 'Ok, got it!') => {
                Swal.fire({
                    text: message,
                    icon: icon,
                    buttonsStyling: false,
                    confirmButtonText: confirmButtonText,
                    customClass: { confirmButton: 'btn btn-primary' }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
