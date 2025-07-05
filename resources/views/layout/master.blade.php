<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! printHtmlAttributes('html') !!}>
<!--begin::Head-->
<head>
    <base href=""/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content=""/>
    <link rel="canonical" href="{{ url()->current() }}"/>

    {!! includeFavicon() !!}
    {!! includeFonts() !!}

    <!--begin::Global Stylesheets Bundle (used by all pages)-->
    @foreach(getGlobalAssets('css') as $path)
        <link rel="stylesheet" href="{{ asset($path) }}">
    @endforeach
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Vendor Stylesheets (used by this page)-->
    @foreach(getVendors('css') as $path)
        <link rel="stylesheet" href="{{ asset($path) }}">
    @endforeach
    <!--end::Vendor Stylesheets-->

    <!--begin::Custom Stylesheets (optional)-->
    @foreach(getCustomCss() as $path)
        <link rel="stylesheet" href="{{ asset($path) }}">
    @endforeach
    <!--end::Custom Stylesheets-->

    <!-- Ekstra plugin CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}?v={{ filemtime(public_path('assets/css/custom.css')) }}">

</head>
<!--end::Head-->

<!--begin::Body-->
<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

    @include('partials/theme-mode/_init')

    @yield('content')

    <!--begin::Javascript-->
    <!-- jQuery (wajib sebelum plugin lain) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!--begin::Global Javascript Bundle (mandatory for all pages)-->
    @foreach(getGlobalAssets('js') as $path)
        <script src="{{ asset($path) }}"></script>
    @endforeach
    <!--end::Global Javascript Bundle-->

    <!--begin::Vendors Javascript (used by this page)-->
    @foreach(getVendors('js') as $path)
        <script src="{{ asset($path) }}"></script>
    @endforeach
    <!--end::Vendors Javascript-->

    <!--begin::Custom Javascript (optional)-->
    @foreach(getCustomJs() as $path)
        <script src="{{ asset($path) }}"></script>
    @endforeach
    <!--end::Custom Javascript-->

    <!-- Ekstra Plugin JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/courses-index.js') }}?v={{ filemtime(public_path('assets/js/courses-index.js')) }}"></script>
    <script src="{{ asset('assets/js/courses.js') }}?v={{ filemtime(public_path('assets/js/courses.js')) }}"></script>

    @stack('scripts')
    <!--end::Javascript-->

    

 
</body>
<!--end::Body-->
</html>
