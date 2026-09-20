<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
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
