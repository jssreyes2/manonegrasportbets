@extends('layouts.frontend.heard')

@section('content')

    <style>
        /* Estilo general para la cuadrícula */
        .grid-casas {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 1.5rem; /* gap-6 */
        }

        @media (min-width: 640px) {
            .grid-casas {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .grid-casas {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        /* Estilo para cada tarjeta */
        .tarjeta-casa {
            background-color: #1a1a1a; /* bg-neutral-900 */
            border-radius: 0.75rem; /* rounded-xl */
            padding: 1.5rem; /* p-6 */
            text-align: center;
        }

        /* Espaciado para el logotipo en la parte superior */
        .contenedor-logo {
            margin-bottom: 1.5rem; /* mb-6 */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .imagen-logo {
            max-width: 100%;
            height: auto;
        }
    </style>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <section class="mt-12">
            <!-- CABECERA -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-neutral-800/60 pb-5 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-lime-400 animate-pulse"></div>
                    <div>
                        <span class="text-[10px] font-mono tracking-widest text-lime-400 uppercase block">Encuentra tu mejor opción</span>
                        <h2 class="text-lg font-bold text-white uppercase tracking-wide">Nuestras casas de apuestas</h2>
                    </div>
                </div>
                <span class="text-xs font-mono text-neutral-500">4 de 4 bookies deportivas activas</span>
            </div>

            <!-- CUADRÍCULA -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- CASA 1: PINNACLE -->
                <div class="bg-neutral-900/40 p-5 rounded-xl border border-neutral-800/60 hover:border-lime-400/50 transition-all duration-300 flex flex-col justify-between group text-center">
                    <div>
                        <!-- CONTENEDOR LOGO BLINDADO -->
                        <div class="w-full h-24 p-2 flex justify-center items-center mb-4 border-b border-neutral-800/60 overflow-hidden">
                            <img src="{{ asset('img/logos/casa-1.png') }}"
                                 alt="Pinnacle Sports Logo"
                                 class="max-w-full max-h-full w-auto h-auto object-contain transition-transform duration-200 group-hover:scale-105">
                        </div>

                        <!-- BADGES DEPORTIVOS -->
                        <div class="mb-4 flex flex-wrap justify-center gap-1.5">
                            <span class="bg-lime-950/60 text-lime-400 text-[10px] font-mono px-2 py-1 rounded border border-lime-800/60 uppercase">FÚTBOL & NBA</span>
                            <span class="bg-neutral-800/60 text-neutral-300 text-[10px] font-mono px-2 py-1 rounded border border-neutral-700/60 uppercase">ALTO VOLUMEN</span>
                        </div>

                        <!-- DESCRIPCIÓN -->
                        <p class="text-neutral-400 text-xs leading-relaxed mb-6 text-left">
                            El referente mundial en **Hándicap Asiático para Fútbol** y líneas principales de la **NBA/MLB**. Margen de comisión más bajo del mercado, ideal para grandes volúmenes **sin riesgo de limitación** por ganar.
                        </p>
                    </div>

                    <!-- FOOTER -->
                    <div>
                        <a href="#" target="_blank" class="w-full bg-black/60 border border-neutral-800 hover:border-lime-400 text-neutral-300 hover:text-black hover:bg-lime-400 text-xs font-mono py-2.5 rounded-lg transition-all flex items-center justify-center gap-2 font-semibold tracking-wide">
                            Abrir Pinnacle <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>

                <!-- CASA 2: BETFAIR EXCHANGE -->
                <div class="bg-neutral-900/40 p-5 rounded-xl border border-neutral-800/60 hover:border-lime-400/50 transition-all duration-300 flex flex-col justify-between group text-center">
                    <div>
                        <!-- CONTENEDOR LOGO BLINDADO -->
                        <div class="w-full h-24 p-2 flex justify-center items-center mb-4 border-b border-neutral-800/60 overflow-hidden">
                            <img src="{{ asset('img/logos/casa-2.png') }}"
                                 alt="Betfair Exchange Logo"
                                 class="max-w-full max-h-full w-auto h-auto object-contain transition-transform duration-200 group-hover:scale-105">
                        </div>

                        <!-- BADGES DEPORTIVOS -->
                        <div class="mb-4 flex flex-wrap justify-center gap-1.5">
                            <span class="bg-lime-950/60 text-lime-400 text-[10px] font-mono px-2 py-1 rounded border border-lime-800/60 uppercase">TRADING</span>
                            <span class="bg-neutral-800/60 text-neutral-300 text-[10px] font-mono px-2 py-1 rounded border border-neutral-700/60 uppercase">EXCHANGE</span>
                        </div>

                        <!-- DESCRIPCIÓN -->
                        <p class="text-neutral-400 text-xs leading-relaxed mb-6 text-left">
                            La mayor plataforma de **apuestas cruzadas (Exchange)** del mundo. Permite actuar como corredor apostando a favor o en contra de un resultado, ideal para **hacer trading deportivo** en vivo con cuotas reales sin margen del bookie.
                        </p>
                    </div>

                    <!-- FOOTER -->
                    <div>
                        <a href="#" target="_blank" class="w-full bg-black/60 border border-neutral-800 hover:border-lime-400 text-neutral-300 hover:text-black hover:bg-lime-400 text-xs font-mono py-2.5 rounded-lg transition-all flex items-center justify-center gap-2 font-semibold tracking-wide">
                            Abrir Betfair <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>

                <!-- CASA 3: STAKE -->
                <div class="bg-neutral-900/40 p-5 rounded-xl border border-neutral-800/60 hover:border-lime-400/50 transition-all duration-300 flex flex-col justify-between group text-center">
                    <div>
                        <!-- CONTENEDOR LOGO BLINDADO -->
                        <div class="w-full h-24 p-2 flex justify-center items-center mb-4 border-b border-neutral-800/60 overflow-hidden">
                            <img src="{{ asset('img/logos/casa-3.png') }}"
                                 alt="Stake Sports Logo"
                                 class="max-w-full max-h-full w-auto h-auto object-contain transition-transform duration-200 group-hover:scale-105">
                        </div>

                        <!-- BADGES DEPORTIVOS -->
                        <div class="mb-4 flex flex-wrap justify-center gap-1.5">
                            <span class="bg-lime-950/60 text-lime-400 text-[10px] font-mono px-2 py-1 rounded border border-lime-800/60 uppercase">UFC & FÚTBOL</span>
                            <span class="bg-neutral-800/60 text-neutral-300 text-[10px] font-mono px-2 py-1 rounded border border-neutral-700/60 uppercase">CRYPTO</span>
                        </div>

                        <!-- DESCRIPCIÓN -->
                        <p class="text-neutral-400 text-xs leading-relaxed mb-6 text-left">
                            Líder indiscutible en **apuestas deportivas con criptomonedas**. Destaca por sus retiros instantáneos sin comisiones bancarias, excelentes cuotas en deportes de combate como la **UFC** y transmisiones en vivo en alta definición.
                        </p>
                    </div>

                    <!-- FOOTER -->
                    <div>
                        <a href="#" target="_blank" class="w-full bg-black/60 border border-neutral-800 hover:border-lime-400 text-neutral-300 hover:text-black hover:bg-lime-400 text-xs font-mono py-2.5 rounded-lg transition-all flex items-center justify-center gap-2 font-semibold tracking-wide">
                            Abrir Stake <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>

                <!-- CASA 4: BET365 -->
                <div class="bg-neutral-900/40 p-5 rounded-xl border border-neutral-800/60 hover:border-lime-400/50 transition-all duration-300 flex flex-col justify-between group text-center">
                    <div>
                        <!-- CONTENEDOR LOGO BLINDADO -->
                        <div class="w-full h-24 p-2 flex justify-center items-center mb-4 border-b border-neutral-800/60 overflow-hidden">
                            <img src="{{ asset('img/logos/casa-4.png') }}"
                                 alt="Bet365 Sports Logo"
                                 class="max-w-full max-h-full w-auto h-auto object-contain transition-transform duration-200 group-hover:scale-105">
                        </div>

                        <!-- BADGES DEPORTIVOS -->
                        <div class="mb-4 flex flex-wrap justify-center gap-1.5">
                            <span class="bg-lime-950/60 text-lime-400 text-[10px] font-mono px-2 py-1 rounded border border-lime-800/60 uppercase">TENIS & FÚTBOL</span>
                            <span class="bg-neutral-800/60 text-neutral-300 text-[10px] font-mono px-2 py-1 rounded border border-neutral-700/60 uppercase">MERCADOS VIVO</span>
                        </div>

                        <!-- DESCRIPCIÓN -->
                        <p class="text-neutral-400 text-xs leading-relaxed mb-6 text-left">
                            La plataforma con la mayor variedad de **mercados en directo** y líneas secundarias (córners, tarjetas, actuaciones del jugador). Indispensable para apostadores de **tenis** por su cobertura en torneos ITF y Challengers.
                        </p>
                    </div>

                    <!-- FOOTER -->
                    <div>
                        <a href="#" target="_blank" class="w-full bg-black/60 border border-neutral-800 hover:border-lime-400 text-neutral-300 hover:text-black hover:bg-lime-400 text-xs font-mono py-2.5 rounded-lg transition-all flex items-center justify-center gap-2 font-semibold tracking-wide">
                            Abrir Bet365 <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>

            </div>
        </section>
    </main>
@endsection