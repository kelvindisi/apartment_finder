<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartment Finder</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('header_scripts')
    @yield('styles')
    
</head>
<body>
@yield('navbar')
<div style="margin-top: 65px;">   
    @yield('content')
</div>

<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>