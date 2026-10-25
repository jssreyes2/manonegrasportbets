@extends('layouts.app-backend')
@section('title', __t('text.backend.tables.payments_title', 'Pagos'))
@section('content')

    @include('layouts.partials.payment-stats')

    <x-admin.table-default cancelRoute="{{ route('get.payment.user') }}"
                           paginate="{{ $payments->appends(request()->input())->links('pagination::bootstrap-4') }}"
                           :filter="$filter"
                           :showBtnNew="false"
                           :extraFilterStatusPayment="true"
                           :dateFilter="true"
                           routeExport=""
    >
        <thead>
        <tr>
            <th>{{__t('text.backend.tables.date', 'Fecha')}}</th>
            <th>{{__t('text.backend.tables.client', 'Cliente')}}</th>
            <th>{{__t('text.backend.tables.plan', 'Plan')}}</th>
            <th class="text-right">{{__t('text.backend.tables.amount', 'Monto')}}</th>
            <th>{{__t('text.backend.tables.status', 'Estatus')}}</th>
            <th>{{__t('text.backend.tables.method', 'Método')}}</th>
            <th>{{__t('text.backend.tables.payment_id', 'ID Pago')}}</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($payments as $payment)
            <tr>
                <td class="text-nowrap">
                    {{ $payment->paid_at?->format('d/m/Y') ?? '-' }}
                    <span class="tbh-cell-sub">{{ $payment->paid_at?->format('h:i A') }}</span>
                </td>
                <td>
                    <span class="tbh-cell-main">{{ capitalize_first($payment->first_name . ' ' . $payment->last_name) }}</span>
                    <span class="tbh-cell-sub">{{ $payment->email }}</span>
                </td>
                @include('layouts.partials.payment-row-cells')
            </tr>
        @empty
            @include('layouts.partials.table-empty', ['colspan' => 7])
        @endforelse
        </tbody>

    </x-admin.table-default>

@endsection
