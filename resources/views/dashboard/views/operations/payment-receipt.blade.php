{{-- Recibo de pago en PDF (dompdf: HTML simple, CSS en línea y fuente DejaVu para las tildes) --}}
@php
    $R = fn($key) => __t('text.backend.customer.receipt_' . $key);
    $statusText = match ($payment->substatus) {
        \App\Models\Payment::PAYMENT_SUCCESS  => __t('text.backend.tables.successful', 'Exitoso'),
        \App\Models\Payment::PAYMENT_REFUNDED => __t('text.backend.tables.refunded', 'Reembolsado'),
        default                               => __t('text.backend.tables.failed', 'Fallido'),
    };
    $logo = imageToBase64(public_path('img/logo.png'));
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ $R('title') }} {{ $payment->payment_id }}</title>
    <style>
        * { font-family: 'DejaVu Sans', sans-serif; }
        body { color: #111827; font-size: 12px; margin: 0; }
        .head { border-bottom: 3px solid #a3e635; padding-bottom: 14px; margin-bottom: 24px; }
        .head td { vertical-align: middle; }
        .brand { font-size: 18px; font-weight: bold; letter-spacing: 1px; }
        .muted { color: #6b7280; }
        h1 { font-size: 20px; margin: 0 0 4px; }
        table { width: 100%; border-collapse: collapse; }
        .info td { padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
        .info td.label { color: #6b7280; width: 40%; }
        .total { margin-top: 24px; background: #f3fbe4; padding: 14px; }
        .total td { font-size: 16px; font-weight: bold; }
        .status { display: inline-block; padding: 2px 10px; border-radius: 10px; background: #dcfce7; color: #15803d; font-weight: bold; }
        .status.is-other { background: #fee2e2; color: #b91c1c; }
        .foot { margin-top: 40px; font-size: 10px; color: #6b7280; }
    </style>
</head>
<body>
    <table class="head">
        <tr>
            <td>
                @if($logo)<img src="{{ $logo }}" alt="" style="height: 54px">@endif
            </td>
            <td style="text-align: right">
                <div class="brand">LA MANO NEGRA</div>
                <div class="muted">Sport Insights</div>
            </td>
        </tr>
    </table>

    <h1>{{ $R('title') }}</h1>
    <div class="muted" style="margin-bottom: 18px">{{ $R('issued') }} {{ now()->format('d/m/Y') }}</div>

    <table class="info">
        <tr><td class="label">{{ $R('customer') }}</td><td>{{ capitalize_first(trim($payment->first_name . ' ' . $payment->last_name)) ?: $payment->email }}</td></tr>
        <tr><td class="label">{{ __t('text.backend.forms.email', 'Correo electrónico') }}</td><td>{{ $payment->email }}</td></tr>
        <tr><td class="label">{{ __t('text.backend.tables.date', 'Fecha') }}</td><td>{{ $payment->paid_at?->format('d/m/Y h:i A') ?? '—' }}</td></tr>
        <tr><td class="label">{{ __t('text.backend.tables.plan', 'Plan') }}</td><td>{{ capitalize_first($payment->website_plan ?? '—') }}</td></tr>
        <tr><td class="label">{{ __t('text.backend.tables.method', 'Método') }}</td>
            <td>{{ $payment->card_last4 ? capitalize_first($payment->card_brand ?? '') . ' •••• ' . $payment->card_last4 : 'Whop' }}</td></tr>
        <tr><td class="label">{{ __t('text.backend.tables.payment_id', 'ID Pago') }}</td><td>{{ $payment->payment_id }}</td></tr>
        <tr><td class="label">{{ __t('text.backend.tables.status', 'Estatus') }}</td>
            <td><span class="status {{ $payment->substatus === \App\Models\Payment::PAYMENT_SUCCESS ? '' : 'is-other' }}">{{ $statusText }}</span></td></tr>
    </table>

    <table class="total">
        <tr>
            <td>{{ $R('total') }}</td>
            <td style="text-align: right">${{ number_format((float)$payment->total, 2) }} {{ strtoupper($payment->currency ?? 'USD') }}</td>
        </tr>
    </table>

    <p class="foot">{{ $R('note') }}</p>
</body>
</html>
