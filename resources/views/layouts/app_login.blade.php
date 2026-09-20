<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.partials.styles')
    <title>{{ config('app.name', 'Atrévete') }}</title>
    @yield('style')
</head>
<body>
@yield('content')
</main>
</div>
@include('layouts.partials.scripts')
@yield('script')
</body>
</html>
