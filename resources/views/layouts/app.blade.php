<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.ico') }}">
    @include('layouts.partials.styles')
    <title>{{ config('app.name', 'La Mano Negra') }}</title>
    @yield('style')
</head>
<body>
<div id="app">
    <main class="py-4">
        @yield('content')
    </main>
</div>
@include('layouts.partials.scripts')
@yield('script')
</body>
</html>
