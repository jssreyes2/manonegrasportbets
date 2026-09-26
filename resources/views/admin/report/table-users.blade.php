@extends('layouts.app-backend')
@section('title', 'Usuarios')
@section('content')

    <div id="form-modal"></div>

    <x-admin.table-default
            routeExport=""
            cancelRoute="{{route('get.report.user')}}"
            paginate="{{ $users->appends(request()->input())->links('pagination::bootstrap-4') }}"
            :filter="$filter"
            :showStatus="true"
            :showBtnNew="false"
    >
        <thead>
        <tr>
            <th>Nombres y Apellidos</th>
            <th>Correo electrónico</th>
            <th>Teléfono</th>
            <th>País</th>
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
                    <td>{{capitalize_first($item->first_name) . ' ' . capitalize_first($item->last_name)}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item['phone']}}</td>
                    <td>{{$item['name']}}</td>
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