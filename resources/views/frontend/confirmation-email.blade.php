@extends('layouts.frontend.heard')

@section('content')
    <main class="flex-1 flex items-center justify-center p-4">
        <div class="w-full max-w-md">

            <!-- CONTENEDOR DEL MENSAJE DE ÉXITO -->
            <div class="bg-neutral-900/40 border border-neutral-800/80 rounded-2xl p-6 sm:p-8 backdrop-blur-md relative overflow-hidden shadow-2xl">

                <!-- Encabezado del Estado -->
                <div class="mb-6 text-center">
                    <span class="text-[10px] font-mono tracking-widest text-lime-400 uppercase block mb-1">{{__t('text.frontend.verify_email_verification', 'VERIFICATION')}}</span>
                    <h1 class="text-xl font-black text-white uppercase tracking-tight">{{__t('text.frontend.verify_email_confirmed_email', 'Confirmed Email')}}</h1>
                    <p class="text-neutral-400 text-xs mt-1">{{__t('text.frontend.verify_email_description', 'Your identity has been successfully validated in the system.')}}</p>
                </div>

                <!-- Icono de Éxito Central -->
                <div class="flex justify-center my-8">
                    <div class="relative flex items-center justify-center w-20 h-20 bg-lime-500/10 border border-lime-500/30 rounded-full animate-pulse">
                        <i data-lucide="mail-check" class="w-10 h-10 text-lime-400"></i>
                    </div>
                </div>

                <!-- Caja de Información de la Cuenta -->
                <div class="bg-black/60 border border-neutral-800 rounded-xl p-4 mb-6 text-center font-mono">
                    <p class="text-[10px] text-neutral-500 uppercase tracking-wider mb-1">{{__t('text.frontend.verify_email_access_status', 'Access Status')}}</p>
                    <p class="text-xs text-white uppercase font-bold tracking-widest">
                        <span class="inline-block w-2 h-2 bg-lime-500 rounded-full mr-1.5 animate-ping"></span>
                        {{__t('text.frontend.verify_email_active_account', 'Active account')}}
                    </p>
                </div>

                <!-- Botón de Envío / Redirección -->
                <a href="{{ route('show.login-customer') }}" class="w-full inline-flex items-center justify-center gap-2 btn-neon font-bold uppercase tracking-wider text-xs px-5 py-3.5 rounded-xl transition-all font-sans">
                    <i data-lucide="log-in" class="w-4 h-4"></i> {{__t('text.frontend.verify_email_continue', 'Continue')}}
                </a>

                <!-- Separador Táctico -->
                <div class="relative my-6 flex items-center justify-center">
                    <div class="border-t border-neutral-800/80 w-full"></div>
                </div>
            </div>

        </div>
    </main>
@endsection