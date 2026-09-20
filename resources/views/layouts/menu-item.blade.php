@if ($item['submenu'] == [])
    @php
        $ruta = '';
        if ($item['route']) {
            try {
                $ruta = route($item['route']);
            } catch (\Throwable $e) {
                throw $e;
            }
        } // <-- Faltaba cerrar esta llave
    @endphp
    <li class="nav-item">
        <a href="{{ $ruta }}" class="nav-link">
            <i class="{{$item['icono']}}"></i>
            <p>
                {{$item['name']}}
            </p>
        </a>
    </li>
@else

    @php
        $ruta = '';
        if ($item['route']) {
            try {
                $ruta = route($item['route']);
            } catch (\Throwable $e) {
                throw $e;
            }
        }

        $display = '';
        $menuOpen = '';
        if (array_search(Route::currentRouteName(), array_column($item['submenu'], 'route')) !== false) {
            $menuOpen = 'menu-open';
            $display = 'active';
        }
    @endphp
    <li class="nav-item has-treeview {{$menuOpen}}">
        <a href="#" class="nav-link {{$display}}">
            <i class="nav-icon {{$item['icono']}}"></i>
            <p>
                {{$item['name']}}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview">
            @foreach ($item['submenu'] as $submenu)
                @if ($submenu['submenu'] == [])
                    @php
                        $ruta = '';
                        if ($submenu['route']) {
                            try {
                                $ruta = route($submenu['route']);
                            } catch (\Throwable $e) {
                                throw $e;
                            }
                        } // <-- Faltaba cerrar esta llave
                    @endphp
                    <li class="nav-item">
                        <a href="{{ $ruta }}" class="nav-link @if(Request::url() == $ruta) active @endif">
                            <i class="nav-icon fas fa-list-ol green"></i>
                            <p>
                                {{ $submenu['name'] }}
                            </p>
                        </a>
                    </li>
                @else
                    @include('layouts.menu-item', [ 'item' => $submenu ])
                @endif
            @endforeach
        </ul>
    </li>
@endif