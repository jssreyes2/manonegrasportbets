<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>@hasSection('title')@yield('title') · @endif La Mano Negra</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.ico') }}">

    @include('layouts.partials.styles')

    @vite(['resources/css/app.css'])

    @yield('style')
</head>

@php
    $authUser   = \Illuminate\Support\Facades\Auth::user();
    $isCustomer = $authUser->rol_id == \App\Models\Rol::ROL_CUSTOMER;
    $userName   = $authUser?->profile?->first_name ? userShortName() : explode('@', $authUser?->email)[0];
    $userPhoto  = getImageUrl('users/' . $authUser?->id, $authUser?->profile?->photo);
    $panelText  = __t('text.backend.messages.control_panel', 'Panel de Control');
@endphp

<body class="hold-transition sidebar-mini layout-fixed tbh-admin {{ $isCustomer ? 'tbh-customer' : '' }}">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white">
        <ul class="navbar-nav align-items-center">
            <li class="nav-item">
                <a class="nav-link tbh-toggle" data-widget="pushmenu" href="#" role="button" aria-label="Menú"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto align-items-center">
            @if($isCustomer)
                <li class="nav-item">
                    <div class="tbh-lang">
                        <a href="{{ route('lang.switch', 'es') }}" class="{{ app()->getLocale() == 'es' ? 'active' : '' }}" title="Español">ES</a>
                        <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}" title="English">EN</a>
                    </div>
                </li>
            @endif

            <li class="nav-item d-none d-md-flex tbh-header-user">
                <img src="{{ $userPhoto }}" alt="">
                <div>
                    <div class="tbh-user-name">{{ capitalize_first($userName) }}</div>
                    <div class="tbh-user-role">{{ $authUser->rol->name }}</div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link tbh-logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="d-none d-sm-inline">{{ $isCustomer ? __t('text.backend.messages.log_out', 'Cerrar Sesión') : 'Cerrar Sesión' }}</span>
                </a>
            </li>
        </ul>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary">
        @auth
            @include('layouts.menu-backend', ['isCustomer' => $isCustomer, 'userName' => $userName, 'userPhoto' => $userPhoto, 'panelText' => $panelText])
        @endauth
    </aside>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="tbh-page-head">
                    <div>
                        <h1 class="tbh-page-title">@yield('title')</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route($route) }}">{{ $panelText }}</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                    @yield('page-actions')
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" id="successAlert">
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" id="errorAlert">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif
                {{-- Planes del cliente que vencen pronto (no hay renovación anticipada: solo se avisa) --}}
                @if($isCustomer && $expiringPlans->isNotEmpty())
                    <div class="tbh-banner mb-3" role="status">
                        <i class="fas fa-hourglass-half"></i>
                        <div>
                            @foreach($expiringPlans as $plan)
                                <div>
                                    {{ (int)$plan['remainingDays'] === 0
                                        ? __t('text.backend.customer.expires_today', null, ['plan' => $plan['label']])
                                        : __t('text.backend.customer.expires_soon', null, ['plan' => $plan['label'], 'n' => $plan['remainingDays'], 'date' => $plan['expiration_date']]) }}
                                </div>
                            @endforeach
                            <small>{{ __t('text.backend.customer.expiring_note') }}</small>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer">
        &copy; {{ date('Y') }} La Mano Negra
    </footer>

    @include('layouts.modal-confirmation')
    @include('layouts.function_backend')

    @include('layouts.partials.scripts')

    @yield('script')
</div>
</body>
</html>
