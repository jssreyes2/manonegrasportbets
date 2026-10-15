{{--
    Tarjetas de planes generadas desde la BD: $activePlans = planes con is_active (los mismos de la vista Suscripción).
    Precio, duración y "recomendado" salen del admin; los textos de marketing se asocian por `source`.
--}}
@php
    $L = fn($key, $replace = []) => __t('text.frontend.landing.' . $key, null, $replace);
    $planCta = auth()->check() ? route('subscription') : route('show.register');

    $themes = [
        'amber' => [
            'card'   => 'border-amber-500/30 hover:-translate-y-1 hover:border-amber-400/70 hover:shadow-[0_0_40px_rgba(245,158,11,0.18)]',
            'accent' => 'text-amber-400',
            'chip'   => 'bg-amber-500/10 text-amber-300 border-amber-500/30',
            'check'  => 'text-amber-400 border-amber-500/40',
            'button' => 'bg-gradient-to-r from-amber-400 to-yellow-500 text-black hover:brightness-110',
        ],
        'lime' => [
            'card'   => 'border-lime-400/30 hover:-translate-y-1 hover:border-lime-400/70 hover:shadow-[0_0_40px_rgba(163,230,53,0.18)]',
            'accent' => 'text-lime-400',
            'chip'   => 'bg-lime-400/10 text-lime-300 border-lime-400/30',
            'check'  => 'text-lime-400 border-lime-400/40',
            'button' => 'btn-neon',
        ],
        'sky' => [
            'card'   => 'border-sky-500/30 hover:-translate-y-1 hover:border-sky-400/70 hover:shadow-[0_0_40px_rgba(56,189,248,0.18)]',
            'accent' => 'text-sky-400',
            'chip'   => 'bg-sky-500/10 text-sky-300 border-sky-500/30',
            'check'  => 'text-sky-400 border-sky-500/40',
            'button' => 'bg-gradient-to-r from-sky-500 to-blue-600 text-white hover:brightness-110',
        ],
    ];
    $featuredCard = 'border-lime-400/60 shadow-[0_0_50px_rgba(163,230,53,0.15)] lg:-translate-y-4';

    // source => presentación (clave de traducción, tema, icono, beneficios, si es Pase Flash)
    $catalog = [
        \App\Models\Plan::PLAN_SOURCE_SUSCRIPCION => ['key' => 'sub',         'theme' => 'lime',  'icon' => 'user-check', 'features' => ['f1', 'f2', 'f3', 'f4'], 'flash' => false],
        \App\Models\Plan::PLAN_SOURCE_VIP         => ['key' => 'vip',         'theme' => 'sky',   'icon' => 'crown',      'features' => ['f1', 'f2', 'f3'],       'flash' => false],
        'elite'                                   => ['key' => 'elite',       'theme' => 'amber', 'icon' => 'gem',        'features' => ['f1', 'f2', 'f3'],       'flash' => false],
        \App\Models\Plan::PLAN_SOURCE_SUS         => ['key' => 'flash_sub',   'theme' => 'lime',  'icon' => 'user-check', 'features' => ['f1', 'f2', 'f3'],       'flash' => true],
        \App\Models\Plan::PLAN_SOURCE_VEP         => ['key' => 'flash_vip',   'theme' => 'sky',   'icon' => 'crown',      'features' => ['f1', 'f2', 'f3'],       'flash' => true],
        \App\Models\Plan::PLAN_SOURCE_ELIT        => ['key' => 'flash_elite', 'theme' => 'amber', 'icon' => 'gem',        'features' => ['f1', 'f2', 'f3'],       'flash' => true],
    ];

    $featuredSource = $activePlans->firstWhere('recommended', 1)?->source ?? \App\Models\Plan::PLAN_SOURCE_SUSCRIPCION;

    $cards = $activePlans->map(function ($plan) use ($catalog, $themes, $featuredCard, $featuredSource, $L) {
        $meta = $catalog[$plan->source] ?? null;
        $days = (int) $plan->duration_days;
        $price = (float) $plan->price;

        $period = match (true) {
            $days <= 1  => $L('period_day'),
            $days === 7  => $L('period_week'),
            $days === 30 => $L('period_month'),
            default      => $L('period_days', ['n' => $days]),
        };

        // Plan sin textos de marketing: se muestra con su nombre y descripción del admin
        $features = $meta
            ? array_map(fn($f) => [$L('plan_' . $meta['key'] . '_' . $f), $L('plan_' . $meta['key'] . '_' . $f . 'd')], $meta['features'])
            : collect(preg_split('/\s*-\s+/', trim(html_entity_decode(strip_tags((string) $plan->description)))))->filter()->map(fn($f) => [$f, null])->values()->all();

        $featured = $plan->source === $featuredSource;
        $theme = $themes[$meta['theme'] ?? 'lime'];

        return [
            'name'     => $meta ? $L('plan_' . $meta['key'] . '_name') : ucwords(mb_strtolower($plan->name)),
            'tag'      => $meta ? $L('plan_' . $meta['key'] . '_tag') : null,
            'for'      => $meta ? $L('plan_' . $meta['key'] . '_for') : null,
            'icon'     => $meta['icon'] ?? 'star',
            'flash'    => $meta['flash'] ?? false,
            'price'    => fmod($price, 1) == 0 ? number_format($price, 0) : number_format($price, 2),
            'period'   => $period,
            'daily'    => $days > 1 ? $L('daily_equiv', ['amount' => number_format($price / $days, 2)]) : null,
            'features' => $features,
            'featured' => $featured,
            'theme'    => array_merge($theme, $featured ? ['card' => $featuredCard] : []),
        ];
    });

    $groups = [
        'main'  => $cards->where('flash', false)->values(),
        'flash' => $cards->where('flash', true)->values(),
    ];
@endphp

@foreach($groups as $group => $items)
    @continue($items->isEmpty())

    @if($group === 'flash')
        <div class="text-center max-w-2xl mx-auto mt-24 mb-12" data-reveal>
            <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-lime-400 mb-2">
                <i data-lucide="zap" class="w-4 h-4"></i> {{ $L('flash_kicker') }}
            </span>
            <h3 class="text-2xl sm:text-3xl font-black tracking-tight text-white uppercase">{{ $L('flash_title') }}</h3>
            <p class="mt-3 text-neutral-400 text-sm">{{ $L('flash_subtitle') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch {{ $group === 'main' ? 'lg:pt-6' : '' }}">
        @foreach($items as $i => $plan)
            @php $t = $plan['theme']; @endphp
            <div data-reveal style="--reveal-delay: {{ $i * 120 }}ms"
                 class="relative flex flex-col rounded-2xl border bg-neutral-950/70 backdrop-blur-sm p-7 sm:p-8 transition-all duration-300 {{ $t['card'] }}">

                @if($plan['featured'])
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-lime-400 text-black font-mono text-[10px] font-bold uppercase tracking-widest px-4 py-1.5 rounded-full shadow-[0_0_20px_rgba(163,230,53,0.6)] whitespace-nowrap">
                        ★ {{ $L('most_popular') }}
                    </div>
                @elseif($plan['flash'])
                    <div class="absolute -top-3 right-6 bg-black border border-neutral-700 text-neutral-200 font-mono text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full flex items-center gap-1">
                        <i data-lucide="zap" class="w-3 h-3 {{ $t['accent'] }}"></i> Flash
                    </div>
                @endif

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-black text-white uppercase tracking-tight">{{ $plan['name'] }}</h3>
                        @if($plan['tag'])
                            <span class="inline-block mt-2 text-[10px] font-mono uppercase tracking-widest px-2 py-1 rounded border {{ $t['chip'] }}">{{ $plan['tag'] }}</span>
                        @endif
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-black/60 border border-neutral-800 flex items-center justify-center {{ $t['accent'] }}">
                        <i data-lucide="{{ $plan['icon'] }}" class="w-6 h-6"></i>
                    </div>
                </div>

                <div class="mb-1 flex items-end gap-2">
                    <span class="text-5xl sm:text-6xl font-black tracking-tighter {{ $t['accent'] }}">${{ $plan['price'] }}</span>
                    <span class="text-neutral-400 font-bold uppercase text-sm mb-2">{{ $plan['period'] }}</span>
                </div>
                <p class="text-xs font-mono text-neutral-500 mb-6 min-h-[1rem]">{{ $plan['daily'] }}</p>

                <ul class="space-y-4 mb-8 flex-1">
                    @foreach($plan['features'] as [$title, $detail])
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 w-6 h-6 shrink-0 rounded-full border flex items-center justify-center {{ $t['check'] }}">
                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                            </span>
                            <span>
                                <span class="block text-sm font-bold text-white uppercase tracking-wide">{{ $title }}</span>
                                @if($detail)
                                    <span class="block text-xs text-neutral-400">{{ $detail }}</span>
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>

                @if($plan['for'])
                    <p class="text-xs font-semibold italic mb-5 {{ $t['accent'] }}">{{ $plan['for'] }}</p>
                @endif

                <a href="{{ $planCta }}"
                   class="w-full inline-flex items-center justify-center gap-2 font-bold uppercase tracking-wider text-xs px-5 py-4 rounded-xl transition-all {{ $t['button'] }}">
                    {{ $L('plan_cta') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        @endforeach
    </div>
@endforeach

@if($cards->isNotEmpty())
    <p class="mt-8 text-center text-xs text-neutral-500 flex items-center justify-center gap-2">
        <i data-lucide="lock" class="w-3.5 h-3.5 text-lime-400"></i> {{ $L('secure_note') }}
    </p>
@endif
