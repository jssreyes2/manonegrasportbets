<a href="{{ route($route) }}" class="brand-link">
    <img src="{{ asset('img/logo.png') }}" class="brand-image" alt="La Mano Negra">
    <span class="brand-text">La Mano <b>Negra</b></span>
</a>

<div class="sidebar">
    <div class="user-panel d-flex">
        <div class="image">
            <img src="{{ $userPhoto }}" class="img-circle" alt="">
        </div>
        <div class="info">
            <div class="tbh-user-name">{{ capitalize_first($userName) }}</div>
            <span class="tbh-role-badge">{{ \Illuminate\Support\Facades\Auth::user()->rol->name }}</span>
        </div>
    </div>

    <nav>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            @unless($isCustomer)
                <li class="nav-item">
                    <a href="{{ route($route) }}" class="nav-link {{ Route::currentRouteName() == $route ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>{{ $panelText }}</p>
                    </a>
                </li>
            @endunless

            @foreach ($menus as $key => $item)
                @if ($item['parent'] != 0)
                    @break
                @endif
                @include('layouts.menu-item', ['item' => $item])
            @endforeach

        </ul>
    </nav>
</div>
