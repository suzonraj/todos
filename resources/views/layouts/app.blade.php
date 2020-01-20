<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

    @stack('before-styles')
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
    @stack('after-styles')
</head>
<body>
<div id="app">
    <div class="container">
        @yield('content')
    </div><!-- container -->
</div><!-- #app -->

<!-- Scripts -->
@stack('before-scripts')
<script src="{{ asset(mix('js/manifest.js')) }} "></script>
<script src="{{ asset(mix('js/vendor.js')) }} "></script>
<script src="{{ asset(mix('js/app.js')) }} "></script>
@stack('after-scripts')

</body>
</html>
