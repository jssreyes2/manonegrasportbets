@extends('layouts.frontend.heard')

@section('title', __t('text.frontend.menu_plans', 'Plans'))

@guest
    @section('body_attrs', 'data-freepick-auto')
@endguest

@section('content')
    @php $L = fn($key) => __t('text.frontend.landing.' . $key); @endphp
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- ============ CABECERA ============ --}}
        <section class="mb-16" data-reveal>
            <div class="bg-neutral-900/30 p-8 rounded-2xl border border-neutral-800/80 backdrop-blur-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative overflow-hidden">
                <div>
                    <span class="text-xs font-mono tracking-widest text-lime-400 uppercase block mb-1">{{__t('text.frontend.plans_choose_your_plan', 'CHOOSE YOUR PLAN AND TAKE YOUR BANKING TO THE NEXT LEVEL')}}</span>
                    <h1 class="text-3xl sm:text-4xl font-black tracking-tighter text-white uppercase">
                        {{__t('text.frontend.plans_join_today_and', 'JOIN TODAY AND')}} <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-emerald-400">
                            {{__t('text.frontend.plans_be_part_of_the_winners', 'BE ONE OF THE WINNERS')}}
                        </span>
                    </h1>
                    <p class="text-neutral-400 text-sm mt-1">{{__t('text.frontend.plans_a_single_goal', 'A single goal')}}</p>
                </div>

                <div class="flex items-center gap-4 bg-black/40 p-4 rounded-xl border border-neutral-800 font-mono text-xs w-full md:w-auto">
                    <div class="space-y-1 w-full">
                        <div class="flex justify-between gap-8 text-neutral-400">
                            <span>{{__t('text.frontend.plans_active_personnel', 'ACTIVE PERSONNEL:')}}</span>
                            <span class="text-lime-400 font-bold flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-lime-400 animate-ping"></span> 12/12 ONLINE
                            </span>
                        </div>
                        <div class="flex justify-between gap-8 text-neutral-400">
                            <span>{{__t('text.frontend.plans_support', 'SUPPORT:')}}</span>
                            <span class="text-white font-bold">24/7</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ============ TARJETAS ============ --}}
        <section class="mb-24">
            @include('frontend.partials.plan-cards')
        </section>

        {{-- ============ TABLA COMPARATIVA ============ --}}
        @php
            // Precios de la tabla desde la BD (si un plan no está activo se oculta su precio)
            $priceOf = function ($source) use ($activePlans) {
                $price = $activePlans->firstWhere('source', $source)?->price;
                return $price === null ? '' : '$' . (fmod((float) $price, 1) == 0 ? number_format($price, 0) : number_format($price, 2));
            };
            $rows = [
                ['table_picks',     '2 ' . $L('val_elite'), '2 ' . $L('val_standard'), '2 VIP'],
                ['table_analysis',  $L('val_elite'),        $L('val_standard'),        $L('val_advanced')],
                ['table_insurance', true,                   false,                     false],
                ['table_support',   $L('val_priority24'),   $L('val_standard'),        $L('val_priority')],
                ['table_billing',   $L('val_daily'),        $L('val_monthly'),         $L('val_weekly')],
            ];
        @endphp
        <section class="mb-24" data-reveal>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white uppercase text-center mb-8">{{ $L('table_title') }}</h2>
            <div class="overflow-x-auto rounded-2xl border border-neutral-800/80">
                <table class="w-full min-w-[560px] text-sm">
                    <thead>
                        <tr class="bg-neutral-900/60 text-xs uppercase tracking-wider">
                            <th class="text-left p-4 text-neutral-500 font-semibold">{{ $L('table_feature') }}</th>
                            <th class="p-4 text-amber-400 font-bold">{{ $L('plan_elite_name') }}<span class="block text-[11px] text-neutral-500 font-mono normal-case">{{ $priceOf('elite') }} {{ $L('period_day') }}</span></th>
                            <th class="p-4 text-lime-400 font-bold bg-lime-400/5">{{ $L('plan_sub_name') }}<span class="block text-[11px] text-neutral-500 font-mono normal-case">{{ $priceOf(\App\Models\Plan::PLAN_SOURCE_SUSCRIPCION) }} {{ $L('period_month') }}</span></th>
                            <th class="p-4 text-sky-400 font-bold">{{ $L('plan_vip_name') }}<span class="block text-[11px] text-neutral-500 font-mono normal-case">{{ $priceOf(\App\Models\Plan::PLAN_SOURCE_VIP) }} {{ $L('period_week') }}</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as [$label, $elite, $sub, $vip])
                            <tr class="border-t border-neutral-800/60">
                                <td class="p-4 text-neutral-300 font-semibold">{{ $L($label) }}</td>
                                @foreach([$elite, $sub, $vip] as $col => $value)
                                    <td class="p-4 text-center {{ $col === 1 ? 'bg-lime-400/5' : '' }}">
                                        @if($value === true)
                                            <i data-lucide="check" class="w-5 h-5 text-lime-400 mx-auto"></i>
                                        @elseif($value === false)
                                            <i data-lucide="minus" class="w-5 h-5 text-neutral-700 mx-auto"></i>
                                        @else
                                            <span class="text-neutral-200">{{ $value }}</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        {{-- ============ GARANTÍAS ============ --}}
        <section class="mb-24">
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white uppercase text-center mb-10" data-reveal>{{ $L('why_title') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach([['shield-check', 'why_secure'], ['zap', 'why_instant'], ['smartphone', 'why_device'], ['headphones', 'why_support']] as $i => [$icon, $key])
                    <div class="p-6 rounded-2xl bg-neutral-900/40 border border-neutral-800/60 neon-glow-hover transition-all" data-reveal style="--reveal-delay: {{ $i * 100 }}ms">
                        <div class="w-11 h-11 rounded-xl bg-black/60 border border-lime-400/30 flex items-center justify-center text-lime-400 mb-4">
                            <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
                        </div>
                        <h3 class="text-sm font-bold text-white uppercase tracking-wide mb-1">{{ $L($key) }}</h3>
                        <p class="text-xs text-neutral-400 leading-relaxed">{{ $L($key . '_d') }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ============ FAQ ============ --}}
        @if($faqs->isNotEmpty())
            <section class="max-w-3xl mx-auto mb-24">
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white uppercase text-center mb-8" data-reveal>{{ $L('faq_title') }}</h2>
                <div class="space-y-3">
                    @foreach($faqs as $item)
                        <details class="group bg-neutral-900/30 border border-neutral-800/80 rounded-xl open:border-lime-400/40 transition-colors" data-reveal>
                            <summary class="flex justify-between items-center p-5 cursor-pointer select-none list-none">
                                <h3 class="text-sm sm:text-base font-bold text-white pr-4">{{ $item->question }}</h3>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-lime-400 shrink-0 group-open:rotate-180 transition-transform duration-300"></i>
                            </summary>
                            <div class="px-5 pb-5 border-t border-neutral-800/40 pt-4 text-sm text-neutral-400 leading-relaxed space-y-2">
                                {!! $item->answer !!}
                            </div>
                        </details>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ============ AYUDA ============ --}}
        <section class="max-w-3xl mx-auto" data-reveal>
            <div class="flex flex-col sm:flex-row items-center gap-6 p-6 sm:p-8 rounded-2xl border border-neutral-800/80 bg-neutral-900/20 text-center sm:text-left">
                <div class="w-12 h-12 shrink-0 rounded-xl bg-lime-400/10 border border-lime-400/30 flex items-center justify-center text-lime-400">
                    <i data-lucide="message-circle" class="w-6 h-6"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-bold text-white uppercase">{{ $L('help_title') }}</h3>
                    <p class="text-sm text-neutral-400">{{ $L('help_text') }}</p>
                </div>
                <a href="{{ route('show.comments') }}" class="inline-flex items-center gap-2 border border-neutral-700 hover:border-lime-400 text-white hover:text-lime-300 font-bold uppercase text-xs px-5 py-3 rounded-xl transition-all whitespace-nowrap">
                    {{ $L('help_cta') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </section>

    </main>
@endsection
