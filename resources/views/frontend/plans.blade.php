@extends('layouts.frontend.heard')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <section class="mb-12">
            <div class="bg-neutral-900/30 p-8 rounded-2xl border border-neutral-800/80 backdrop-blur-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative overflow-hidden">

                <div>
                    <span class="text-xs font-mono tracking-widest text-lime-400 uppercase block mb-1">{{__t('text.frontend.plans_choose_your_plan', 'CHOOSE YOUR PLAN AND TAKE YOUR BANKING TO THE NEXT LEVEL')}}</span>
                    <h1 class="text-3xl sm:text-4xl font-black tracking-tighter text-white uppercase">
                        {{__t('text.frontend.plans_join_today_and', 'JOIN TODAY AND')}} <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-emerald-400">
                            {{__t('text.frontend.plans_be_part_of_the_winners', 'BE ONE OF THE WINNERS')}}
                        </span>
                    </h1>
                    <p class="text-neutral-400 text-sm mt-1"> {{__t('text.frontend.plans_a_single_goal', 'A single goal')}}</p>
                </div>

                <div class="flex items-center gap-4 bg-black/40 p-4 rounded-xl border border-neutral-800 font-mono text-xs w-full md:w-auto">
                    <div class="space-y-1 w-full">
                        <div class="flex justify-between gap-8 text-neutral-400">
                            <span>{{__t('text.frontend.plans_active_personnel', 'ACTIVE PERSONNEL:')}} </span>
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

        <section class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16 items-stretch">

            <div class="bg-neutral-900/20 rounded-2xl border border-neutral-800/80 p-8 flex flex-col justify-between transition-all duration-300 neon-glow-hover relative">
                <div style="padding-bottom: 20px;">
                    <div class="image-container">
                        <img src="{{ asset('img/plan-'.session_language().'-30.jpg') }}" alt="La Mano Negra">
                    </div>
                </div>

                <a href="{{route('show.register')}}"
                   class="w-full inline-flex items-center justify-center gap-2 bg-neutral-900 border border-neutral-800 text-white font-bold uppercase tracking-wider text-xs px-5 py-3.5 rounded-xl hover:border-neutral-700 transition-all font-sans">
                    {{__t('text.frontend.plans_elite', 'Purchase Elite Plan')}}
                </a>
            </div>

            <div class="bg-neutral-900/40 rounded-2xl neon-border-active p-8 flex flex-col justify-between transition-all duration-300 relative shadow-xl">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-lime-400 text-black font-mono text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full shadow-md">
                    {{__t('text.frontend.plans_recommended', 'RECOMMENDED')}}
                </div>

                <div style="padding-bottom: 20px;">
                    <div class="image-container">
                        <img src="{{ asset('img/plan-'.session_language().'-50.jpg') }}" alt="La Mano Negra">
                    </div>
                </div>

                <a href="{{route('show.register')}}" class="w-full inline-flex items-center justify-center gap-2 btn-neon font-bold uppercase tracking-wider text-xs px-5 py-3.5 rounded-xl transition-all font-sans">
                    {{__t('text.frontend.plans_purchase_subscription', 'Purchase Subscription Plan')}}
                </a>
            </div>

            <div class="bg-gradient-to-b from-neutral-950 to-neutral-900/40 rounded-2xl border border-neutral-800/80 p-8 flex flex-col justify-between transition-all duration-300 neon-glow-hover relative">
                <div style="padding-bottom: 20px;">
                    <div class="image-container">
                        <img src="{{ asset('img/plan-'.session_language().'-100.jpg') }}" alt="La Mano Negra">
                    </div>
                </div>

                <a href="{{route('show.register')}}"
                   class="w-full inline-flex items-center justify-center gap-2 bg-neutral-900 border border-neutral-700 text-white font-bold uppercase tracking-wider text-xs px-5 py-3.5 rounded-xl hover:bg-neutral-800 hover:border-lime-400/50 transition-all font-sans">
                    {{__t('text.frontend.plans_purchase_vip_plan', 'Purchase VIP Plan')}}
                </a>
            </div>

        </section>

    </main>
@endsection