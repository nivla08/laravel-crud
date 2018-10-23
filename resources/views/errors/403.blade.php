<!DOCTYPE html>
<html>

<head>

	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Access Denied') |  {{ config('app.name') }}</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{  asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        <h1>403</h1>
        <h3 class="font-bold">Access Denied</h3>
        <div class="error-desc">
			You are not authorized to access this page.
        </div>
    </div>

    <!-- Mainly scripts -->
	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>

</body>

</html>
