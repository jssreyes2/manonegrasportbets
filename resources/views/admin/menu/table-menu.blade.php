@extends('layouts.app-backend')
@section('title', 'Menú')
@section('content')

    <div id="form-modal"></div>

    <x-admin.table-default
            routeExport=""
            cancelRoute="{{route('menu.index')}}"
            paginate="{{ $menus->appends(request()->input())->links('pagination::bootstrap-4') }}"
            :filter="$filter"
            :showStatus="true"
            :extraFilterLanguage="true"
    >
        <thead>
        <tr>
            <th style="width: 10%!important; text-align: center">Acciones</th>
            <th>Nombre</th>
            <th class="text-center">Icono</th>
            <th class="text-center">Posición</th>
            <th style="text-align: center;">Estatus</th>
            <th style="text-align: center;">Lenguaje</th>
            <th>Creación</th>
        </tr>
        </thead>
        <tbody>
        @if(count($menus) > 0)
            @foreach($menus AS $item)

                @php
                    $classStatus = $item->is_active == 1 ? 'bg-success' : 'bg-danger';
                @endphp

                <tr>
                    <td style="text-align: center">

                        <x-admin.actions-dropdown
                                :item="$item"
                                route="menu"
                        />

                    </td>

                    <td>{{$item->name}}</td>

                    <td class="text-center"><i class="fa {{$item->icono}}"></i></td>

                    <td class="text-center">{{$item->position}}</td>

                    <td class="text-center">
                        <span class="badge {{$classStatus}}">{{status_register($item->is_active)}}</span>
                    </td>

                    <td style="text-align: center;">
                        <span class="badge bg-info">{{$item->language}}</span>
                    </td>

                    <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                </tr>
            @endforeach
        @else
            @include('layouts.alert_warning')
        @endif
        </tbody>
    </x-admin.table-default>

@endsection

@section('script')
    @include('admin.global_script.function-form-modal', ['route' => route('menu.create')])
    @include('admin.menu.function-menu')
@endsection
