@extends('layouts.app-backend')
@section('title', 'Suscripción Web')
@section('content')

    <x-admin.table-default
            routeExport=""
            cancelRoute="{{route('get.web.subscription')}}"
            paginate="{{ $webSubscriptions->appends(request()->input())->links('pagination::bootstrap-4') }}"
            filter="{{ json_encode($filter) }}"
            :filter="$filter"
            :showStatus="false"
            :showBtnNew="false"
    >
            <thead>
            <tr>
                <th>Cliente</th>
                <th>Email</th>
                <th>Email enviado</th>
                <th>Creación</th>
            </tr>
            </thead>
            <tbody>
            @if(count($webSubscriptions) > 0)
                @foreach($webSubscriptions AS $item)

                    @php
                        $classStatus = $item['send_email'] == 1 ? 'bg-success' : 'bg-danger';
                    @endphp

                    <tr>
                        <td>{{capitalize_first($item['full_name'])}}</td>
                        <td>{{$item['email']}}</td>
                        <td><span class="badge {{$classStatus}}">{{convert_option($item['send_email'])}}</span></td>
                        <td>{{date_formt($item['created_at'])}}</td>
                    </tr>
                @endforeach
            </tbody>
            @else
                @include('layouts.alert_warning')
            @endif
            </tbody>
        </x-admin.table-default>
    </section>
    <!-- /.content -->

@endsection