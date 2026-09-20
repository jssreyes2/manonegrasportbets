<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route($route)}}" class="nav-link">Inicio</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">

            <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="margin-left: -6px;">
                {{(\Illuminate\Support\Facades\Auth::user()->rol_id == \App\Models\Rol::ROL_CUSTOMER) ? __t('text.backend.messages.log_out', 'Cerrar Sesión') : 'Cerrar Sesión'}} <i class="nav-icon fas fa-power-off"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>

</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-dark-info">
    <!-- Brand Logo -->
    <a href="{{route($route)}}" class="brand-link">
        <img src="{{asset('img/logo.png')}}" class="brand-image">
        <span class="brand-text font-weight-light">La Mano Negra</span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ getImageUrl('users/'.Auth::user()?->id, Auth::user()?->profile?->photo) }}" class="img-circle elevation-2">
            </div>
            <div class="info">
                @php
                    $user = Auth::user();
                    $userName=$user?->profile?->first_name ? userShortName() : explode('@', $user?->email)[0];
                @endphp
                <strong style="color: #fff">{{capitalize_first($userName)}}</strong>
                <br>
                <p>
                    <span class="badge bg-success">
                        {{\Illuminate\Support\Facades\Auth::user()->rol->name}}
                    </span>
                </p>

            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                @foreach ($menus as $key => $item)
                    @if ($item['parent'] != 0)
                        @break
                    @endif
                    @include('layouts.menu-item', ['item' => $item])
                @endforeach

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
