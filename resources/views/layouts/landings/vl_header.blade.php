<head>
    <meta charset="utf-8" />
    <title>Horizontal Layout | Velonic - Bootstrap 5 Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully responsive admin theme which can be used to build CRM, CMS,ERP etc." name="description" />
    <meta content="Techzaa" name="author" />


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.ico') }}?v={{ time() }}">

    <!-- Daterangepicker css -->
    <link rel="stylesheet"
        href="{{ asset('template/assets/vendor/daterangepicker/daterangepicker.css') }}?v={{ time() }}">

    <!-- Vector Map css -->
    <link rel="stylesheet"
        href="{{ asset('template/assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}?v={{ time() }}">

    <!-- Theme Config Js -->
    <script src="{{ asset('template/assets/js/config.js') }}?v={{ time() }}"></script>

    <!-- App css -->
    <link href="{{ asset('template/assets/css/app.min.css') }}?v={{ time() }}" rel="stylesheet" type="text/css"
        id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('template/assets/css/icons.min.css') }}?v={{ time() }}" rel="stylesheet"
        type="text/css" />

    <!-- Photoswipe css -->
    <link rel="stylesheet" href="{{ asset('css/photoswipe.css') }}">

    {{-- <link href="{{ asset('resources/css/bundle/gen_cssbudle.css') }}?v={{ time() }}" rel="stylesheet" type="text/css" /> --}}


    <!-- Select2 CSS -->
    <link href="{{ asset('custom/select2/dist/css/select2.min.css') }}?v={{ time() }}" rel="stylesheet"
        type="text/css" />





</head>
