{{-- Tarjeta de un pick enviado al cliente. Recibe $pick (Pick con send_date de Pick::sentToUser) --}}
@php
    $lines  = $pick->lines();
    $result = $pick->resultKey();
@endphp
<div class="tbh-pick is-{{ $result }}">
    <div class="tbh-pick-head">
        <span class="tbh-pick-plan"><i class="fas fa-futbol mr-1"></i>{{ $pick->plan->name ?? '' }}</span>
        @include('dashboard.partials.result-badge', ['result' => $result])
    </div>

    @forelse($lines as $line)
        <div class="{{ $loop->first ? 'tbh-pick-main' : 'tbh-pick-line' }}">{{ $line }}</div>
    @empty
        <div class="tbh-pick-line">—</div>
    @endforelse

    <div class="tbh-pick-meta">
        <i class="far fa-envelope mr-1"></i>{{ __t('text.backend.customer.sent_on') }} {{ \Carbon\Carbon::parse($pick->send_date)->format('d/m/Y') }}
    </div>
</div>
