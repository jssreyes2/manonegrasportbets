@extends('layouts.app-backend')
@section('title', 'Usuarios')
@section('content')

    <div id="form-modal"></div>

    <x-admin.table-default
            routeExport=""
            cancelRoute="{{route('user.index')}}"
            paginate="{{ $users->appends(request()->input())->links('pagination::bootstrap-4') }}"
            :filter="$filter"
            :showStatus="true"
    >
        <thead>
        <tr>
            <th style="width: 10%!important; text-align: center">Acciones</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Status</th>
            <th>Creación</th>
        </tr>
        </thead>
        <tbody>
        @if(count($users) > 0)
            @foreach($users AS $item)

                @php
                    $classStatus = $item->is_active == 1 ? 'bg-success' : 'bg-danger';
                @endphp

                <tr>
                    <td style="text-align: center">

                        <x-admin.actions-dropdown
                                :item="$item"
                                route="user"
                        />
                        
                    </td>
                    <td>{{$item->email}}</td>
                    <td>{{tranform_string($item->name)}}</td>
                    <td>
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
    @include('admin.global_script.function-form-modal', ['route' => route('user.create')])
    @include('admin.user.function-user')
@endsection