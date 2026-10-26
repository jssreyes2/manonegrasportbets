{{--
    Historial verificable de picks: acierto real (columna picks.right) y últimos picks calificados.
    Se muestra solo con SHOW_PICK_RESULTS=true en el .env. Recibe $results = ['month' => resumen 30 días, 'all' => histórico, 'latest' => Collection<Pick>]; si no hay picks calificados no se muestra.
--}}
@if(config('app.show_pick_results') && !empty($results) && $results['all']['total'] > 0)
    @php $U = fn($key, $replace = []) => __t('text.frontend.ux.' . $key, null, $replace); @endphp

    <section id="resultados" class="py-24 border-y border-neutral-900 bg-black/30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12" data-reveal>
                <span class="text-xs font-bold uppercase tracking-widest text-lime-400 block mb-2">{{ $U('results_kicker') }}</span>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white uppercase">{{ $U('results_title') }}</h2>
                <p class="mt-4 text-neutral-300">{{ $U('results_text') }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">
                @foreach([['month', 'results_rate_30', 'calendar-days'], ['all', 'results_rate_all', 'history']] as [$period, $label, $icon])
                    @php $summary = $results[$period]; @endphp
                    <div class="rounded-2xl border border-neutral-800 bg-neutral-950/70 p-6" data-reveal>
                        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-neutral-400">
                            <i data-lucide="{{ $icon }}" class="w-4 h-4 text-lime-400"></i> {{ $U($label, ['date' => $results['since']->format('d/m/Y')]) }}
                        </div>
                        <div class="mt-3 text-4xl font-black text-white tabular-nums">
                            {{ $summary['rate'] !== null ? $summary['rate'] . '%' : '—' }}
                        </div>
                        <div class="mt-1 text-sm text-neutral-400">
                            {{ $U('results_of', ['won' => $summary['won'], 'total' => $summary['total']]) }}
                        </div>
                        @if($summary['rate'] !== null)
                            <div class="mt-4 h-1.5 rounded-full bg-neutral-800 overflow-hidden" aria-hidden="true">
                                <div class="h-full rounded-full bg-lime-400" style="width: {{ $summary['rate'] }}%"></div>
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="rounded-2xl border border-neutral-800 bg-neutral-950/70 p-6" data-reveal>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-neutral-400">
                        <i data-lucide="list-checks" class="w-4 h-4 text-lime-400"></i> {{ $U('results_graded') }}
                    </div>
                    <div class="mt-3 flex items-end gap-6">
                        <div>
                            <div class="text-4xl font-black text-lime-400 tabular-nums">{{ $results['all']['won'] }}</div>
                            <div class="text-sm text-neutral-400">{{ $U('results_won') }}</div>
                        </div>
                        <div>
                            <div class="text-4xl font-black text-red-400 tabular-nums">{{ $results['all']['lost'] }}</div>
                            <div class="text-sm text-neutral-400">{{ $U('results_lost') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            @if($results['latest']->isNotEmpty())
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4">{{ $U('results_latest') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($results['latest'] as $pick)
                        @php
                            $result = $pick->resultKey();
                            $lines  = $pick->lines();
                        @endphp
                        <article class="rounded-xl border {{ $result === 'won' ? 'border-lime-400/30' : 'border-red-500/25' }} bg-black/40 p-5" data-reveal>
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <span class="text-xs font-semibold uppercase tracking-wider text-neutral-400">
                                    {{ $pick->plan->name ?? '' }} · {{ $pick->created_at?->format('d/m/Y') }}
                                </span>
                                @include('frontend.partials.result-badge', ['result' => $result])
                            </div>
                            @forelse($lines as $line)
                                <p class="{{ $loop->first ? 'text-white font-bold' : 'text-sm text-neutral-300' }}">{{ $line }}</p>
                            @empty
                                <p class="text-sm text-neutral-500">—</p>
                            @endforelse
                        </article>
                    @endforeach
                </div>
            @endif

            <p class="mt-8 text-center text-xs text-neutral-500">{{ $U('results_note') }}</p>
        </div>
    </section>
@endif
