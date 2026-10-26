@extends('layouts.app-backend')
@section('title', __t('text.backend.tables.my_payments', 'Mis Pagos'))
@section('content')

    @include('layouts.partials.payment-stats')

    <x-admin.table-default cancelRoute="{{ route('my.payment') }}"
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
            <th>{{__t('text.backend.tables.plan', 'Plan')}}</th>
            <th class="text-right">{{__t('text.backend.tables.amount', 'Monto')}}</th>
            <th>{{__t('text.backend.tables.status', 'Estatus')}}</th>
            <th>{{__t('text.backend.tables.method', 'Método')}}</th>
            <th>{{__t('text.backend.tables.payment_id', 'ID Pago')}}</th>
            <th class="text-center">{{ __t('text.backend.customer.receipt') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($payments as $payment)
            <tr>
                <td class="text-nowrap">
                    {{ $payment->paid_at?->format('d/m/Y') ?? '-' }}
                    <span class="tbh-cell-sub">{{ $payment->paid_at?->format('h:i A') }}</span>
                </td>
                @include('layouts.partials.payment-row-cells')
                <td class="text-center">
                    <a href="{{ route('my.payment.receipt', $payment->payment_id) }}" class="btn btn-sm btn-outline-dark"
                       title="{{ __t('text.backend.customer.download_receipt') }}" aria-label="{{ __t('text.backend.customer.download_receipt') }}">
                        <i class="fas fa-file-download"></i>
                    </a>
                </td>
            </tr>
        @empty
            @include('layouts.partials.table-empty', [
                'colspan'     => 7,
                'emptyText'   => request()->has('filter') ? null : __t('text.backend.customer.empty_payments'),
                'actionUrl'   => request()->has('filter') ? null : route('subscription'),
                'actionLabel' => __t('text.backend.customer.view_plans'),
            ])
        @endforelse
        </tbody>

    </x-admin.table-default>

@endsection

@section('script')
    @include('admin.global_script.function-form-modal', ['route' => route('my.payment')])
    @include('admin.operation.function-pick')
@endsection
