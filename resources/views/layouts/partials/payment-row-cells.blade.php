{{-- Celdas comunes de una fila de pago. Recibe $payment; las columnas propias de cada vista se agregan antes --}}
@php
    [$statusClass, $statusIcon, $statusText] = match ($payment->substatus) {
        \App\Models\Payment::PAYMENT_SUCCESS  => ['bg-success', 'fas fa-check-circle', __t('text.backend.tables.successful', 'Exitoso')],
        \App\Models\Payment::PAYMENT_REFUNDED => ['bg-warning', 'fas fa-undo', __t('text.backend.tables.refunded', 'Reembolsado')],
        default                               => ['bg-danger', 'fas fa-times-circle', __t('text.backend.tables.failed', 'Fallido')],
    };
@endphp

<td>
    <span class="badge bg-light">{{ capitalize_first($payment->website_plan ?? '-') }}</span>
</td>
<td class="text-right text-nowrap">
    <span class="tbh-amount">${{ number_format((float)$payment->total, 2) }}</span>
    <span class="tbh-cell-sub">{{ strtoupper($payment->currency ?? '') }}</span>
</td>
<td>
    <span class="badge {{ $statusClass }}"><i class="{{ $statusIcon }} mr-1"></i>{{ $statusText }}</span>
</td>
<td class="text-nowrap">
    @if($payment->card_last4)
        <i class="far fa-credit-card text-muted mr-1"></i>{{ capitalize_first($payment->card_brand ?? '') }} •••• {{ $payment->card_last4 }}
    @else
        <span class="text-muted">—</span>
    @endif
</td>
<td>
    <span class="tbh-mono" title="{{ $payment->payment_id }}">{{ $payment->payment_id }}</span>
</td>
