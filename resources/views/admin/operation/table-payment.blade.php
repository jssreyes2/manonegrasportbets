@extends('layouts.app-backend')
@section('title', 'Pagos')
@section('content')

    <x-admin.table-default cancelRoute="{{ route('get.payment.user') }}"
                           paginate="{{ $payments->appends(request()->input())->links('pagination::bootstrap-4') }}"
                           :filter="$filter"
                           :showBtnNew="false"
                           :extraFilterStatusPick="true"
                           :dateFilter="true"
                           routeExport=""
    >
        <thead>
        <tr>
            <th>ID Pago</th>
            <th>Cliente</th>
            <th>Cliente</th>
            <th>Correo Electrónico</th>
            <th>Estatus</th>
            <th>Monto</th>
            <th>Moneda</th>
            <th>Creado</th>
        </tr>
        </thead>
        <tbody>
        @if (count($payments) > 0)
            @foreach ($payments as $payment)
                @php
                    $classStatus = $payment->substatus == \App\Models\Payment::PAYMENT_SUCCESS ? 'bg-success' : 'bg-danger';

                    $substatus=$payment->substatus=='succeeded' ? __t('text.backend.tables.successful', 'Successful'): __t('text.backend.tables.failed', 'Failed');

                @endphp

                <tr>

                    <td>{{ $payment->payment_id }}</td>
                    <td>{{capitalize_first($payment->first_name.' '.$payment->last_name)}}</td>
                    <td>{{$payment->email}}</td>
                    <td>{{ capitalize_first($payment->website_plan ?? '') }}</td>
                    <td><span class="badge {{$classStatus}}">{{$substatus}}</span></td>
                    <td>{{$payment->total}}</td>
                    <td>{{$payment->currency}}</td>
                    <td>{{ date('d/m/Y', strtotime($payment->paid_at)) }}</td>
                </tr>
            @endforeach
        @else
            @include('layouts.alert_warning')
        @endif

        </tbody>

    </x-admin.table-default>

@endsection
