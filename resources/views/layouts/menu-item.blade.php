@php
    // Ícono por ruta para los submenús que no tienen uno cargado en BD
    $routeIcons = [
        'get.subscription'      => 'fas fa-id-card',
        'pick.index'            => 'fas fa-futbol',
        'get.web.subscription'  => 'fas fa-envelope-open-text',
        'notification.index'    => 'fas fa-bell',
        'get.payment.user'      => 'fas fa-dollar-sign',
        'my.payment'            => 'fas fa-receipt',
        'get.report.user'       => 'fas fa-users',
        'get.user.subscription' => 'fas fa-user-check',
        'rol.index'             => 'fas fa-user-shield',
        'user.index'            => 'fas fa-user-cog',
        'menu.index'            => 'fas fa-bars',
        'submenu.index'         => 'fas fa-stream',
        'parameter.index'       => 'fas fa-sliders-h',
        'plan.index'            => 'fas fa-layer-group',
        'faq.index'             => 'fas fa-question-circle',
        'staticpage.index'      => 'fas fa-file-alt',
        'staticpage.contacts'   => 'fas fa-comments',
        'profile'               => 'fas fa-user',
        'change.password'       => 'fas fa-key',
        'subscription'          => 'fas fa-crown',
    ];

    $iconFor = fn($menu) => ($menu['icono'] ?? null) ?: ($routeIcons[$menu['route']] ?? 'far fa-circle');

    $ruta = $item['route'] ? route($item['route']) : '';
@endphp

@if ($item['submenu'] == [])
    <li class="nav-item">
        <a href="{{ $ruta }}" class="nav-link {{ $item['route'] && Route::currentRouteName() == $item['route'] ? 'active' : '' }}">
            <i class="nav-icon {{ $iconFor($item) }}"></i>
            <p>{{ $item['name'] }}</p>
        </a>
    </li>
@else
    @php
        $isOpen = array_search(Route::currentRouteName(), array_column($item['submenu'], 'route')) !== false;
    @endphp
    <li class="nav-item has-treeview {{ $isOpen ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ $isOpen ? 'active' : '' }}">
            <i class="nav-icon {{ $iconFor($item) }}"></i>
            <p>
                {{ $item['name'] }}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview">
            @foreach ($item['submenu'] as $submenu)
                @if ($submenu['submenu'] == [])
                    @php
                        $subRuta = $submenu['route'] ? route($submenu['route']) : '';
                    @endphp
                    <li class="nav-item">
                        <a href="{{ $subRuta }}" class="nav-link @if($subRuta && Request::url() == $subRuta) active @endif">
                            <i class="nav-icon {{ $iconFor($submenu) }}"></i>
                            <p>{{ $submenu['name'] }}</p>
                        </a>
                    </li>
                @else
                    @include('layouts.menu-item', [ 'item' => $submenu ])
                @endif
            @endforeach
        </ul>
    </li>
@endif
