@extends('layouts.frontend.heard')

@section('content')
    <main class="flex-1 flex items-center justify-center p-4">
        <div class="w-full max-w-md">

            <!-- CONTENEDOR DEL MENSAJE DE ERROR -->
            <div class="bg-neutral-900/40 border border-neutral-800/80 rounded-2xl p-6 sm:p-8 backdrop-blur-md relative overflow-hidden shadow-2xl">

                <!-- Encabezado del Estado -->
                <div class="mb-6 text-center">
                    <span class="text-[10px] font-mono tracking-widest text-red-500 uppercase block mb-1">{{__t('text.frontend.verify_email_verification', 'AUTHENTICATION FAILURE')}}</span>
                    <h1 class="text-xl font-black text-white uppercase tracking-tight">{{__t('text.frontend.verify_email_error_verification_fail', 'Verificación Fallida')}}</h1>
                    <p class="text-neutral-400 text-xs mt-1">{{__t('text.frontend.verify_email_error_verification_fail_description', 'The account identity could not be validated.')}}</p>
                </div>

                <!-- Icono de Error Central -->
                <div class="flex justify-center my-8">
                    <div class="relative flex items-center justify-center w-20 h-20 bg-red-500/10 border border-red-500/30 rounded-full">
                        <i data-lucide="shield-alert" class="w-10 h-10 text-red-500"></i>
                    </div>
                </div>

                <!-- Caja de Información del Error -->
                <div class="bg-black/60 border border-neutral-800 rounded-xl p-4 mb-6 text-center font-mono">
                    <p class="text-[10px] text-neutral-500 uppercase tracking-wider mb-1">{{__t('text.frontend.verify_email_error_reason_rejection', 'Reason for Rejection')}}</p>
                    <p class="text-xs text-red-400 uppercase font-bold tracking-wider">
                        {{__t('text.frontend.verify_email_error_link_expired', 'The link has expired or is invalid.')}}
                    </p>
                </div>

                <!-- Botón de Acción Principal (Reenviar) -->
                <a href="{{ route('show.register') }}" class="w-full inline-flex items-center justify-center gap-2 bg-red-600/20 hover:bg-red-600/30 border border-red-500/40 text-red-200 font-bold uppercase tracking-wider text-xs px-5 py-3.5 rounded-xl transition-all font-sans">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>  {{__t('text.frontend.verify_email_error_request_new_link', 'Request New Link')}}
                </a>

                <!-- Separador Táctico -->
                <div class="relative my-6 flex items-center justify-center">
                    <div class="border-t border-neutral-800/80 w-full"></div>
                    <span class="absolute bg-[#0b0b0b] px-3 font-mono text-[9px] text-neutral-600 uppercase tracking-widest">Ó</span>
                </div>

                <!-- Enlace alternativo para volver -->
                <div class="text-center">
                    <p class="text-xs text-neutral-400 font-mono">
                        {{__t('text.frontend.verify_email_error_access_problem', 'Having trouble accessing the site?')}}
                        <a href="{{route('show.login-customer')}}" class="text-neutral-300 font-bold hover:text-white block sm:inline sm:ml-1 uppercase tracking-tight text-[11px] font-sans">
                            {{__t('text.backend.messages.login', 'Login')}} &rarr;
                        </a>
                    </p>
                </div>
            </div>

        </div>
    </main>
@endsection