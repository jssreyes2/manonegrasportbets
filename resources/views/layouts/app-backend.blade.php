<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>La Mano Negra</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.ico') }}">

    @include('layouts.partials.styles')

    @vite(['resources/css/app.css'])

    @yield('style')
</head>

<body class="sidebar-mini layout-fixed text-sm">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
        <!-- Botón del menú lateral (Izquierda) -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color: #ffffff"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Elementos de la derecha -->
        <ul class="navbar-nav ml-auto align-items-center">

            @if(\Illuminate\Support\Facades\Auth::user()->rol_id == \App\Models\Rol::ROL_CUSTOMER)
                <li class="nav-item d-flex align-items-center px-2" style="gap: 8px;">
                    <!-- Botón Español -->
                    <a href="{{ route('lang.switch', 'es') }}" class="nav-link px-1 {{ app()->getLocale() == 'es' ? 'font-weight-bold text-warning' : 'text-light' }}" title="Español" style="display: inline-flex; align-items: center; gap: 6px;">
                          {{__t('text.frontend.menu_es_spanish', '🇪🇸 Spanish')}}
                    </a>

                    <span class="text-muted">|</span>

                    <!-- Botón Inglés -->
                    <a href="{{ route('lang.switch', 'en') }}" class="nav-link px-1 {{ app()->getLocale() == 'en' ? 'font-weight-bold text-warning' : 'text-light' }}" title="English" style="display: inline-flex; align-items: center; gap: 6px;">
                          {{__t('text.frontend.menu_en_english', '🇺🇸 English')}}
                    </a>
                </li>
            @endif

            <!-- Botón de Salir -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #ffffff">
                    <i class="fas fa-sign-out-alt"></i> {{(\Illuminate\Support\Facades\Auth::user()->rol_id == \App\Models\Rol::ROL_CUSTOMER) ? __t('text.backend.messages.log_out', 'Cerrar Sesión') : 'Cerrar Sesión'}}
                </a>
            </li>
        </ul>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </nav>

    <aside class="main-sidebar sidebar-dark-info elevation-4">
        <a href="" class="brand-link">
            <span class="brand-text font-weight-light">La Mano Negra</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item"><i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{__t('text.backend.messages.control_panel', 'Panel de Control') }}</p>
                    </li>
                    @auth
                        @include('layouts.menu-backend')
                    @endauth
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item" style="color: #2a2a2a">@yield('title')</li>
                            <li class="breadcrumb-item active">{{ __t('text.backend.messages.control_panel', 'Panel de Control') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" id="successAlert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" id="errorAlert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif
                @yield('content')
            </div>
        </section>
    </div>

    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2026 </strong>
        La Mano Negra
    </footer>

    @include('layouts.modal-confirmation')
    @include('layouts.function_backend')

    @include('layouts.partials.scripts')

    @yield('script')
</div>
</body>
</html>