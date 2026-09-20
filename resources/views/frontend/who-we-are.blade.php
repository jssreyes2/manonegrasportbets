@extends('layouts.frontend.heard')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <section class="mb-12">
            <div class="bg-neutral-900/30 p-8 rounded-2xl border border-neutral-800/80 backdrop-blur-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative overflow-hidden">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-black tracking-tighter text-white uppercase">
                        {{__t('text.frontend.who_we_are_the_manifesto_behind', 'The Manifesto Behind')}} <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-emerald-400">La Mano Negra</span>
                    </h1>
                    <p class="text-neutral-400 text-sm mt-1">{{__t('text.frontend.who_we_are_get_to_know_the_union', 'Meet the union of analysts, data engineers, and quantitative minds dominating the predictive landscape.')}}</p>
                </div>
            </div>
        </section>


        <section class="mb-12">
            <div class="bg-neutral-900/30 p-8 rounded-2xl border border-neutral-800/80 backdrop-blur-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative overflow-hidden">
                <div>
                    <h2 class="text-2xl font-black text-white uppercase tracking-tight mb-4">¿{{__t('text.frontend.menu_about_us', 'About Us')}}?</h2>

                    <div class="space-y-4 text-neutral-400 text-sm leading-relaxed">
                        <p>
                            {!! $legaldocument->body ?? '' !!}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-16">
            <div class="text-center mb-10">
                <h3 class="text-2xl font-black text-white uppercase tracking-tight mt-1">{{__t('text.frontend.who_we_are_rules', 'Our Non-Negotiable Rules')}} </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-neutral-900/10 border border-neutral-800/60 rounded-xl p-6 relative">
                    <div class="w-8 h-8 rounded-lg bg-neutral-900/80 border border-neutral-800 flex items-center justify-center mb-4">
                        <i data-lucide="binary" class="w-4 h-4 text-lime-400"></i>
                    </div>
                    <h4 class="text-base font-bold text-white uppercase mb-2">01. {{__t('text.frontend.who_we_are_zero_emotions', 'Zero Emotions')}}</h4>
                    <p class="text-xs text-neutral-400 leading-relaxed font-mono">
                        {{__t('text.frontend.who_we_are_zero_emotions_description', 'Intuition is the enemy of capital. Every alert sent by our terminal is based on pure statistical deviations, asymmetric volume, and mathematical inefficiency.')}}
                    </p>
                </div>

                <div class="bg-neutral-900/10 border border-neutral-800/60 rounded-xl p-6 relative">
                    <div class="w-8 h-8 rounded-lg bg-neutral-900/80 border border-neutral-800 flex items-center justify-center mb-4">
                        <i data-lucide="activity" class="w-4 h-4 text-lime-400"></i>
                    </div>
                    <h4 class="text-base font-bold text-white uppercase mb-2">02. {{__t('text.frontend.who_we_are_volumetric_edge', 'Volumetric Edge')}} </h4>
                    <p class="text-xs text-neutral-400 leading-relaxed font-mono">
                        {{__t('text.frontend.who_we_are_volumetric_edge_description', 'We track smart money. We identify where bookmakers have exposed capital incorrectly due to the overreaction of the general public.')}}
                    </p>
                </div>

                <div class="bg-neutral-900/10 border border-neutral-800/60 rounded-xl p-6 relative">
                    <div class="w-8 h-8 rounded-lg bg-neutral-900/80 border border-neutral-800 flex items-center justify-center mb-4">
                        <i data-lucide="eye-off" class="w-4 h-4 text-lime-400"></i>
                    </div>
                    <h4 class="text-base font-bold text-white uppercase mb-2">03. {{__t('text.frontend.who_we_are_absolute_independence', 'Absolute Independence')}}</h4>
                    <p class="text-xs text-neutral-400 leading-relaxed font-mono">
                        {{__t('text.frontend.who_we_are_absolute_independence_description', "We do not accept sponsorships from gambling operators or commissions based on user losses. Our model is self-sustaining and aligns 100% with our members' profitability.")}}
                    </p>
                </div>
            </div>
        </section>

        <section class="max-w-3xl mx-auto bg-neutral-900/10 border border-neutral-800/60 rounded-xl p-6 text-center font-mono text-xs text-neutral-500">
            <p>
                <span class="text-neutral-400 font-bold">// {{__t('text.frontend.who_we_are_environmental', 'ENVIRONMENTAL WARNING:')}} </span>
                {{__t('text.frontend.who_we_are_environmental_description', 'Access to La Mano Negra does not guarantee risk-free future returns. We operate based on probabilistic variables involving statistical variance and strict bankroll management.')}}
            </p>
        </section>

    </main>
@endsection