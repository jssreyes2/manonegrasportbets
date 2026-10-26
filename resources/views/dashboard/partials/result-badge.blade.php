{{-- Resultado de un pick en el panel. Recibe $result: 'won' | 'lost' | 'pending' --}}
@php
    [$class, $icon] = match ($result) {
        'won'   => ['bg-success', 'fa-check'],
        'lost'  => ['bg-danger', 'fa-times'],
        default => ['bg-light', 'fa-clock'],
    };
@endphp
<span class="badge {{ $class }}"><i class="fas {{ $icon }} mr-1"></i>{{ __t('text.frontend.ux.result_' . $result) }}</span>
