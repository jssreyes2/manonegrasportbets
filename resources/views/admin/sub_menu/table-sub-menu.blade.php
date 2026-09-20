@extends('layouts.app-backend')
@section('title', 'Sub Menú')
@section('content')

    <div id="form-modal"></div>

    <x-admin.table-default
            routeExport=""
            cancelRoute="{{route('submenu.index')}}"
            paginate="{{ $subMenus->appends(request()->input())->links('pagination::bootstrap-4') }}"
            :filter="$filter"
            :showStatus="true"
            :showBtnNew="false"
    >
        <thead>
        <tr>
            <th style="width: 10%!important; text-align: center">Acciones</th>
            <th>Nombre</th>
            <th>Ruta</th>
            <th class="text-center">Estatus</th>
            <th>Creación</th>
        </tr>
        </thead>
        <tbody>
        @if(count($subMenus) > 0)
            @foreach($subMenus AS $item)

                @php
                    $classStatus = $item->is_active == 1 ? 'bg-success' : 'bg-danger';
                @endphp

                <tr>
                    <td style="text-align: center">
                        
                        <x-admin.actions-dropdown
                                :item="$item"
                                route="submenu"
                        />

                    </td>

                    <td>{{$item->name}}</td>

                    <td>{{$item->route}}</td>

                    <td class="text-center">
                        <span class="badge {{$classStatus}}">{{status_register($item->is_active)}}</span>
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
    @include('admin.global_script.function-form-modal', ['route' => route('submenu.index')])
    @include('admin.sub_menu.function-sub-menu')
@endsection
