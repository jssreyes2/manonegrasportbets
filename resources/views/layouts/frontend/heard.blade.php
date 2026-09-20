<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Mano Negra</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    @vite(['resources/css/app_web.css', 'resources/js/app_web.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="bg-plasma text-neutral-100 font-sans antialiased">
<header class="border-b border-neutral-800/60 bg-black/50 backdrop-blur-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between md:justify-start md:gap-16" style="height: 100px;">

        <div class="md:hidden flex items-center">
            <button id="menu-btn" class="text-neutral-400 hover:text-lime-400 focus:outline-none p-2">
                <i id="menu-icon" data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>

        <a href="/" class="text-xl font-black tracking-widest text-white hover:opacity-90 transition-opacity flex items-center gap-2 shrink-0">
            <img src="{{ asset('img/logo.png') }}" alt="La Mano Negra" style="height: 80px;">
        </a>

        <nav class="hidden md:flex items-center gap-8 text-sm font-semibold tracking-wide text-neutral-400">
            <a href="{{route('show.how-it-works')}}" class="hover:text-lime-400 transition-colors {{$classHowItWorks ?? ''}}">{{__t('text.frontend.menu_how_it_works', 'How It Works')}}</a>
            <a href="{{route('show.members')}}" class="hover:text-lime-400 transition-colors {{$classMembers ?? ''}}">{{__t('text.frontend.menu_members', 'Members')}}</a>
            <a href="{{route('show.plans')}}" class="hover:text-lime-400 transition-colors {{$classPlans ?? ''}}">{{__t('text.frontend.menu_plans', 'Plans')}}</a>
            <a href="{{route('show.who-we-are')}}" class="hover:text-lime-400 transition-colors  {{$classWhoWeAre ?? ''}}">{{__t('text.frontend.menu_about_us', 'About Us')}}</a>

            <div class="relative" id="auth-dropdown-container">
                <button id="auth-dropdown-btn" class="flex items-center gap-2 text-neutral-400 hover:text-lime-400 transition-colors focus:outline-none" type="button">
                    <span class="text-sm font-semibold">{{__t('text.frontend.menu_my_account', 'My Account')}}</span>
                    <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div id="auth-dropdown"
                     class="absolute top-full left-1/2 -translate-x-1/2 mt-2 w-56 bg-black/95 backdrop-blur-xl border border-neutral-800/60 rounded-xl shadow-2xl overflow-hidden transition-all duration-200 opacity-0 invisible -translate-y-2 pointer-events-none z-50">
                    <div class="p-4 space-y-3">
                        <div class="text-xs text-neutral-500 uppercase tracking-wider font-semibold mb-2">{{__t('text.frontend.menu_access', 'Access')}}</div>
                        <a href="{{ route('show.login-customer') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-neutral-300 hover:bg-lime-400/10 hover:text-lime-400 transition-all group">
                            <svg class="w-5 h-5 text-neutral-500 group-hover:text-lime-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            {{__t('text.frontend.menu_login', 'Login')}}
                        </a>
                        <a href="{{ route('show.register') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-neutral-300 hover:bg-lime-400/10 hover:text-lime-400 transition-all group">
                            <svg class="w-5 h-5 text-neutral-500 group-hover:text-lime-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            {{__t('text.frontend.menu_sign_up', 'Sign up')}}
                        </a>
                    </div>
                </div>
            </div>

            <div class="language-selector">
                <a href="{{ route('lang.switch', 'es') }}" class="{{ (app()->getLocale() ?? 'en') == 'es' ? 'active' : '' }}">
                    {{__t('text.frontend.menu_es_spanish', '🇪🇸 Spanish')}}
                </a>
                |
                <a href="{{ route('lang.switch', 'en') }}" class="{{ (app()->getLocale() ?? 'en') == 'en' ? 'active' : '' }}">
                    {{__t('text.frontend.menu_en_english', '🇺🇸 English')}}
                </a>
            </div>

            <a href="{{route('show.plans')}}" class="btn-neon px-5 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all whitespace-nowrap">
                {{__t('text.frontend.menu_instant_vip_access', 'Instant VIP Access')}}
            </a>
        </nav>

    </div>


{{--    MENU DISPOSITICVO MOVILES--}}
    <div id="mobile-menu" class="hidden md:hidden bg-black/95 backdrop-blur-xl border-b border-neutral-800/60 px-4 pt-2 pb-6 space-y-4 text-center">
        <a href="{{route('show.how-it-works')}}" class="block text-neutral-300 hover:text-lime-400 font-semibold py-2 transition-colors">{{__t('text.frontend.menu_how_it_works', 'How It Works')}}</a>
        <a href="{{route('show.members')}}" class="block text-neutral-300 hover:text-lime-400 font-semibold py-2 transition-colors">{{__t('text.frontend.menu_members', 'Members')}}</a>
        <a href="{{route('show.plans')}}" class="block text-neutral-300 hover:text-lime-400 font-semibold py-2 transition-colors">{{__t('text.frontend.menu_plans', 'Plans')}}</a>
        <a href="{{route('show.who-we-are')}}" class="block text-lime-400 font-bold py-2 border-b border-lime-400/20 max-w-[150px] mx-auto">{{__t('text.frontend.menu_about_us', 'About Us')}}</a>

        <div class="pt-4 border-t border-neutral-800/40 flex flex-col gap-3">
            <a href="{{ route('show.login-customer') }}" class="flex items-center justify-center gap-2 text-neutral-300 hover:text-lime-400 font-semibold py-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                {{__t('text.frontend.menu_login', 'Login')}}
            </a>
            <a href="{{ route('show.register') }}" class="flex items-center justify-center gap-2 text-neutral-300 hover:text-lime-400 font-semibold py-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                {{__t('text.frontend.menu_sign_up', 'Sign up')}}
            </a>

            <div class="language-selector">
                <a href="{{ route('lang.switch', 'es') }}" class="{{ app()->getLocale() == 'es' ? 'active' : '' }}">
                    {{__t('text.frontend.menu_es_spanish', '🇪🇸 Spanish')}}
                </a>
                |
                <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">
                    {{__t('text.frontend.menu_en_english', '🇺🇸 English')}}
                </a>
            </div>

            <a href="{{route('show.plans')}}" class="flex items-center justify-center gap-2 btn-neon px-5 py-3 rounded-lg text-xs font-bold uppercase tracking-wider">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                {{__t('text.frontend.menu_access.vip.instantaneo', 'Instant VIP Access')}}
            </a>
        </div>
    </div>
</header>

@yield('content')
@yield('script')
@include('layouts.frontend.footer')

<script type="text/javascript">
    window.errorHandler = function (xhr, status, error) {
        $('#loading_form').hide();
        $(':button').prop('disabled', false);

        let responseJson = xhr.responseJSON;

        // Si es un error 422 nativo de Laravel, aquí es donde se van a desglosar uno por uno
        if (xhr.status === 422 && responseJson && responseJson.errors) {
            $.each(responseJson.errors, function (field, messages) {
                $.each(messages, function (index, message) {
                    toastr.error(message, 'Validación');
                });
            });
        } else if (responseJson && responseJson.message) {
            toastr.error(responseJson.message, 'Error');
        } else {
            toastr.error('Ocurrió un error inesperado en el servidor.', 'Error Crítico');
        }
    };
</script>

</body>
</html>