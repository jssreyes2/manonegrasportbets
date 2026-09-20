@extends('layouts.frontend.heard')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- ============================== -->
        <!-- ENCABEZADO DE LA SECCIÓN       -->
        <!-- ============================== -->
        <section class="mb-12">
            <div class="bg-neutral-900/30 p-8 rounded-2xl border border-neutral-800/80 backdrop-blur-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative overflow-hidden">

                <div>
                    <span class="text-xs font-mono tracking-widest text-lime-400 uppercase block mb-1">// MARCO LEGAL</span>
                    <h1 class="text-3xl sm:text-4xl font-black tracking-tighter text-white uppercase">
                        Términos y <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-emerald-400">Condiciones</span>
                    </h1>
                    <p class="text-neutral-400 text-sm mt-1">Al acceder a la red de La Mano Negra, aceptas los siguientes términos de uso y compromisos éticos.</p>
                </div>

                <div class="flex items-center gap-4 bg-black/40 p-4 rounded-xl border border-neutral-800 font-mono text-xs w-full md:w-auto">
                    <div class="space-y-1 w-full">
                        <div class="flex justify-between gap-8 text-neutral-400">
                            <span>VIGENCIA:</span>
                            <span class="text-white font-bold tracking-wider">Desde Jun-2026</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================== -->
        <!-- CUERPO DE TÉRMINOS Y CONDICIONES -->
        <!-- ============================== -->
        <section class="w-full mb-16">

            <div class="w-full space-y-8">

                <div id="clausula-1" class="bg-neutral-900/20 rounded-2xl border border-neutral-800/80 p-8 scroll-mt-20">
                    <div class="flex items-start gap-4">

                        <div class="w-full">
                            {!! $legaldocument->body !!}
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>
@endsection