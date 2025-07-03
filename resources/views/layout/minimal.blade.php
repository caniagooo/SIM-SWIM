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

    <!-- Global Stylesheets -->
    @foreach(getGlobalAssets('css') as $path)
        <link rel="stylesheet" href="{{ asset($path) }}">
    @endforeach

    <!-- Vendor Stylesheets -->
    @foreach(getVendors('css') as $path)
        <link rel="stylesheet" href="{{ asset($path) }}">
    @endforeach

    <!-- Custom Stylesheets -->
    @foreach(getCustomCss() as $path)
        <link rel="stylesheet" href="{{ asset($path) }}">
    @endforeach

    @livewireStyles
    @stack('styles')
</head>
<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>
    
    <div class="d-flex flex-row flex-root">
        <!--begin::Sidebar-->
        @include('layout.partials.sidebar-layout._sidebar')
        <!--end::Sidebar-->
    
        <!--begin::Main-->
        <div class="page d-flex flex-column flex-row-fluid">
            <main class="d-flex flex-column flex-grow-1">
                @yield('content')
            </main>
        </div>
        <!--end::Main-->
    </div>
    
    
    <!-- Global JS Bundle -->
    @foreach(getGlobalAssets('js') as $path)
        <script src="{{ asset($path) }}"></script>
    @endforeach

    <!-- Vendor JS -->
    @foreach(getVendors('js') as $path)
        <script src="{{ asset($path) }}"></script>
    @endforeach

    <!-- Custom JS -->
    @foreach(getCustomJs() as $path)
        <script src="{{ asset($path) }}"></script>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Datatables -->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/js/courses.js') }}"></script>

    @livewireScripts


    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('success', (message) => { toastr.success(message); });
            Livewire.on('error', (message) => { toastr.error(message); });
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