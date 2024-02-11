<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sea Food Pro</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url('assets/media/image/favicon.png') }}" />

    <!-- Plugin styles -->
    <link rel="stylesheet" href="{{ url('vendors/bundle.css') }}" type="text/css">

    <!-- App styles -->
    <link rel="stylesheet" href="{{ url('assets/css/app.min.css') }}" type="text/css">
    @yield('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="form-membership">

    <!-- begin::preloader-->
    <div class="preloader">
        <div class="preloader-icon"></div>
    </div>
    <!-- end::preloader -->

    <div class="form-wrapper">

        <!-- logo -->
        <div id="logo">
            <img class="img-rounded" src="{{ url('assets/media/image/sfp-logo.png') }}" alt="image" style="width:60%; height:60%;">
        </div>
        <!-- ./ logo -->

        @yield('content')

    </div>

    <!-- Plugin scripts -->
    <script src="{{ url('vendors/bundle.js') }}"></script>

    <!-- App scripts -->
    <script src="{{ url('assets/js/app.min.js') }}"></script>

</body>

</html>
