{{-- Totales por estatus de pago (admin y cliente). $stats viene de PaymentServices::index --}}
<div class="row">
    @foreach($stats as $stat)
        <div class="col-lg-4 col-md-4 col-12 mb-3">
            <div class="tbh-stat">
                <div class="tbh-stat-icon is-{{ $stat['tone'] }}"><i class="{{ $stat['icon'] }}"></i></div>
                <div>
                    <div class="tbh-stat-label">{{ $stat['label'] }}</div>
                    <div class="tbh-stat-value">${{ number_format($stat['amount'], 2) }}</div>
                    <div class="tbh-stat-meta">
                        {{ $stat['quantity'] }} {{ $stat['quantity'] === 1 ? __t('text.backend.tables.payment', 'pago') : __t('text.backend.tables.payments', 'pagos') }}
                    </div>
                </div>
                <span class="tbh-stat-tag is-{{ $stat['tone'] }}">USD</span>
            </div>
        </div>
    @endforeach
</div>
