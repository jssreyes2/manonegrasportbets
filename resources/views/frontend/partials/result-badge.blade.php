{{-- Etiqueta de resultado de un pick. Recibe $result: 'won' | 'lost' | 'pending' --}}
@php
    [$classes, $icon] = match ($result) {
        'won'   => ['bg-lime-400/10 text-lime-300 border-lime-400/30', 'check'],
        'lost'  => ['bg-red-500/10 text-red-300 border-red-500/30', 'x'],
        default => ['bg-neutral-800 text-neutral-300 border-neutral-700', 'clock'],
    };
@endphp
<span class="inline-flex items-center gap-1 shrink-0 rounded-full border px-2.5 py-0.5 text-xs font-bold uppercase tracking-wider {{ $classes }}">
    <i data-lucide="{{ $icon }}" class="w-3 h-3"></i> {{ __t('text.frontend.ux.result_' . $result) }}
</span>
