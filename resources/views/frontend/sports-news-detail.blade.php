@extends('layouts.frontend.heard')

@section('content')
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- HEADER DE LA SECCIÓN / TITULAR DEL BLOG -->
        <section class="mb-12 text-center md:text-left">
            <div class="bg-neutral-900/30 p-8 rounded-2xl border border-neutral-800/80 backdrop-blur-sm relative overflow-hidden">

                <span class="text-xs font-mono tracking-widest text-lime-400 uppercase block mb-1">// CRÓNICAS, ANÁLISIS Y TENDENCIAS</span>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tighter text-white uppercase">
                    El Centro de <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-emerald-400">Noticias & Radar</span>
                </h1>
                <p class="text-neutral-400 text-sm mt-1">Información de última hora analizada bajo modelos estadísticos y cobertura en tiempo real.</p>
            </div>
        </section>

        <!-- LAYOUT PRINCIPAL: CONTENIDO + SIDEBAR -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- COLUMNA IZQUIERDA: NOTICIAS (OCUPA 2 COLUMNAS EN ESCRITORIO) -->
            @if($news->count() >= 1)
                <div class="lg:col-span-2 space-y-8">

                    <article class="bg-neutral-900/20 border border-neutral-800/80 rounded-2xl overflow-hidden group transition-all duration-300 hover:border-neutral-700">
                        <div class="relative aspect-video w-full bg-neutral-950 overflow-hidden">
                            @if($news->photo)
                                <img src="{{ url('storage/blog/' .$news->id.'/'.$news->photo) }}" alt="{{ $news->title }}" class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-neutral-800 flex items-center justify-center text-neutral-500">Sin imagen</div>
                            @endif
                            <span class="absolute top-4 left-4 bg-lime-400 text-neutral-950 text-[10px] font-mono font-black uppercase px-2.5 py-1 rounded-md tracking-wider shadow-lg">
                NOTICIA EXCLUSIVA
            </span>
                        </div>
                        <div class="p-6 sm:p-8">
                            <div class="flex items-center gap-4 text-xs font-mono text-neutral-500 mb-3">
                                <span>{{ $news->created_at->diffForHumans() }}</span>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-black text-white uppercase tracking-tight group-hover:text-lime-400 transition-colors mb-3">
                                {{ $news->title }}
                            </h2>
                            <p class="text-sm text-neutral-400 leading-relaxed font-sans mb-4">
                                {!! $news->body !!}
                            </p>
                            <a href="{{ url('sports-news') }}" class="inline-flex items-center gap-1.5 text-xs font-mono text-lime-400 uppercase tracking-wider font-bold hover:underline">
                                Más noticias <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </article>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        @if(isset($news[1]))
                            <article class="bg-neutral-900/20 border border-neutral-800/40 rounded-xl p-5 hover:border-neutral-700/80 transition-all">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[10px] font-mono text-emerald-400 uppercase font-bold">// TÁCTICA</span>
                                    <span class="text-[10px] font-mono text-neutral-500">{{ $news[1]->created_at->diffForHumans() }}</span>
                                </div>
                                <h3 class="text-base font-bold text-white uppercase tracking-tight mb-2 line-clamp-2">
                                    {{ $news[1]->title }}
                                </h3>
                                <p class="text-xs text-neutral-400 line-clamp-3 mb-4">
                                    {{ $news[1]->content }}
                                </p>
                                <a href="{{ url('noticias/' . $news[1]->slug) }}" class="text-[11px] font-mono text-neutral-400 hover:text-white uppercase tracking-wider font-bold inline-flex items-center gap-1">
                                    Ver datos &rarr;
                                </a>
                            </article>
                        @endif

                        @if(isset($news[2]))
                            <article class="bg-neutral-900/20 border border-neutral-800/40 rounded-xl p-5 hover:border-neutral-700/80 transition-all">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[10px] font-mono text-lime-400 uppercase font-bold">// MERCADOS</span>
                                    <span class="text-[10px] font-mono text-neutral-500">{{ $news[2]->created_at->diffForHumans() }}</span>
                                </div>
                                <h3 class="text-base font-bold text-white uppercase tracking-tight mb-2 line-clamp-2">
                                    {{ $news[2]->title }}
                                </h3>
                                <p class="text-xs text-neutral-400 line-clamp-3 mb-4">
                                    {{ $news[2]->content }}
                                </p>
                                <a href="{{ url('noticias/' . $news[2]->slug) }}" class="text-[11px] font-mono text-neutral-400 hover:text-white uppercase tracking-wider font-bold inline-flex items-center gap-1">
                                    Ver datos &rarr;
                                </a>
                            </article>
                        @endif

                    </div>

                </div>
            @endif

            <!-- COLUMNA DERECHA: SIDEBAR (RADAR / EN DIRECTO) -->
            <aside class="space-y-6">

                <!-- WIDGET: MONITOR EN VIVO -->
                <div class="bg-neutral-900/30 border border-neutral-800/80 rounded-2xl p-6 backdrop-blur-sm">
                    <div class="flex items-center gap-2 mb-4 pb-3 border-b border-neutral-800/60">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>
                        <h4 class="text-xs font-mono font-black text-white uppercase tracking-wider">RADAR DE EVENTOS EN VIVO</h4>
                    </div>

                    <!-- Lista de Eventos rápidos -->
                    <div class="space-y-3">

                        <!-- Evento 1 -->
                        <div class="p-3 bg-neutral-950/40 border border-neutral-800/50 rounded-lg flex items-center justify-between text-xs">
                            <div>
                                <p class="font-bold text-white uppercase truncate max-w-[140px]">Real Madrid vs Man. City</p>
                                <p class="text-[10px] font-mono text-neutral-500">Minuto 74'</p>
                            </div>
                            <div class="text-right">
                                <span class="bg-neutral-900 border border-neutral-800 text-lime-400 font-mono px-2 py-0.5 rounded text-[10px] font-bold">
                                    Cuota: 2.10
                                </span>
                            </div>
                        </div>

                        <!-- Evento 2 -->
                        <div class="p-3 bg-neutral-950/40 border border-neutral-800/50 rounded-lg flex items-center justify-between text-xs">
                            <div>
                                <p class="font-bold text-white uppercase truncate max-w-[140px]">Lakers vs Celtics</p>
                                <p class="text-[10px] font-mono text-neutral-500">4to Cuarto</p>
                            </div>
                            <div class="text-right">
                                <span class="bg-neutral-900 border border-neutral-800 text-lime-400 font-mono px-2 py-0.5 rounded text-[10px] font-bold">
                                    U/O: 221.5
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- WIDGET: NEWSLETTER / ALERTAS -->
                <div class="bg-gradient-to-br from-neutral-900/40 to-neutral-950 border border-neutral-800/80 rounded-2xl p-6 text-center">
                    <div class="w-10 h-10 rounded-xl bg-neutral-950 border border-neutral-800 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="bell" class="w-5 h-5 text-lime-400"></i>
                    </div>
                    <h4 class="text-xs font-bold text-white uppercase mb-1">¿Quieres alertas de valor inmediato?</h4>
                    <p class="text-neutral-500 font-mono text-[10px] mb-4">Suscríbete al feed de noticias de última hora y no pierdas latencia.</p>

                    <form action="#" class="space-y-2">
                        <input type="email" placeholder="TU_EMAIL@DOMAIN.COM" class="w-full bg-neutral-950 border border-neutral-800 focus:border-lime-400/50 focus:ring-0 text-white font-mono text-xs px-3 py-2 rounded-lg text-center uppercase placeholder-neutral-700">
                        <button type="submit" class="w-full bg-neutral-900 border border-neutral-800 hover:border-neutral-700 text-lime-400 font-bold font-mono uppercase text-[10px] py-2 rounded-lg transition-all tracking-wider">
                            // SUSCRIBIR SEÑALES
                        </button>
                    </form>
                </div>

            </aside>

        </div>

    </main>
@endsection