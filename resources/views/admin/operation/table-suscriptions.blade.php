@extends('layouts.app-backend')
@section('title', 'Suscripción')
@section('content')

    <x-admin.table-default
            routeExport=""
            cancelRoute="{{route('get.subscription')}}"
            paginate="{{ $subscriptions->appends(request()->input())->links('pagination::bootstrap-4') }}"
            filter="{{ json_encode($filter) }}"
            :filter="$filter"
            :showStatus="false"
            :extraFilterStatus="true"
            :extraFilterPlans="true"
            :plans="$plans"
            :showBtnNew="false"
    >
            <thead>
            <tr>
                <th>Email</th>
                <th>Cliente</th>
                <th>Phone</th>
                <th>Plan</th>
                <th>Pago</th>
                <th>Vencimiento</th>
                <th>Estatus</th>
                <th>País</th>
                <th>Creación</th>
            </tr>
            </thead>
            <tbody>
            @if(count($subscriptions) > 0)
                @foreach($subscriptions AS $item)

                    @php
                        $classStatus = $item['subscription_status'] == 'active' ? 'bg-success' : 'bg-danger';
                    @endphp

                    <tr>
                        <td>{{$item['email']}}</td>
                        <td>{{capitalize_first($item['first_name']).' '.capitalize_first($item['last_name'])}}</td>
                        <td>{{$item['phone']}}</td>
                        <td>{{capitalize_first($item['subscription_plan'])}}</td>
                        <td>{{date_formt($item['payment_date'])}}</td>
                        <td>{{date_formt($item['subscription_expires_at'])}}</td>
                        <td><span class="badge {{$classStatus}}">{{$item['subscription_status']}}</span></td>
                        <td>{{$item['country_name']}}</td>
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