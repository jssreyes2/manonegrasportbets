<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'La Mano Negra') | Sport Insights</title>
    <meta name="description" content="{{ __t('text.frontend.landing.meta_description') }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="La Mano Negra">
    <meta property="og:title" content="La Mano Negra | Sport Insights">
    <meta property="og:description" content="{{ __t('text.frontend.landing.meta_description') }}">
    <meta property="og:image" content="{{ asset('img/logo-faro.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="theme-color" content="#050505">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Oculta [data-reveal] solo para animarlo; si app_web.js no arranca en 2.5s, se muestra todo --}}
    <script>
        document.documentElement.classList.add('js');
        setTimeout(function () { if (!window.__revealReady) document.documentElement.classList.remove('js'); }, 2500);
    </script>
    <script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    @vite(['resources/css/app_web.css', 'resources/js/app_web.js'])
    <script src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js"></script>
    <script>document.addEventListener('DOMContentLoaded', function () { if (window.lucide) window.lucide.createIcons(); });</script>

</head>

@php
    $panelRoute = auth()->check() && auth()->user()->rol_id == \App\Models\Rol::ROL_CUSTOMER ? 'customer.home' : 'admin.panel';
@endphp
<body class="bg-plasma text-neutral-100 font-sans antialiased @guest has-mobile-cta @endguest" @yield('body_attrs')>
<a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-[70] focus:bg-lime-400 focus:text-black focus:px-4 focus:py-2 focus:rounded-lg focus:font-bold">{{ __t('text.frontend.ux.skip_to_content') }}</a>
<header class="border-b border-neutral-800/60 bg-black/50 backdrop-blur-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 md:h-[100px] flex items-center justify-between md:justify-start md:gap-16">

        <div class="md:hidden flex items-center">
            <button id="menu-btn" type="button" aria-controls="mobile-menu" aria-expanded="false" aria-label="Menu" class="text-neutral-400 hover:text-lime-400 focus:outline-none p-2">
                <svg id="menu-icon-open" class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg id="menu-icon-close" class="w-6 h-6 pointer-events-none hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <a href="/" class="text-xl font-black tracking-widest text-white hover:opacity-90 transition-opacity flex items-center gap-2 shrink-0">
            <img src="{{ asset('img/logo.png') }}" alt="La Mano Negra" class="tbh-logo">
        </a>

        <nav class="hidden md:flex items-center gap-8 text-sm font-semibold tracking-wide text-neutral-400">
            <a href="{{route('show.how-it-works')}}" class="hover:text-lime-400 transition-colors {{$classHowItWorks ?? ''}}">{{__t('text.frontend.menu_how_it_works', 'How It Works')}}</a>
            <a href="{{route('show.members')}}" class="hover:text-lime-400 transition-colors {{$classMembers ?? ''}}">{{__t('text.frontend.menu_members', 'Members')}}</a>
            <a href="{{route('show.plans')}}" class="hover:text-lime-400 transition-colors {{$classPlans ?? ''}}">{{__t('text.frontend.menu_plans', 'Plans')}}</a>
            <a href="{{route('show.who-we-are')}}" class="hover:text-lime-400 transition-colors  {{$classWhoWeAre ?? ''}}">{{__t('text.frontend.menu_about_us', 'About Us')}}</a>

            <div class="relative" id="auth-dropdown-container">
                <button id="auth-dropdown-btn" class="flex items-center gap-2 text-neutral-400 hover:text-lime-400 transition-colors rounded-md" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="auth-dropdown">
                    <span class="text-sm font-semibold">{{__t('text.frontend.menu_my_account', 'My Account')}}</span>
                    <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div id="auth-dropdown"
                     class="absolute top-full left-1/2 -translate-x-1/2 mt-2 w-56 bg-black/95 backdrop-blur-xl border border-neutral-800/60 rounded-xl shadow-2xl overflow-hidden transition-all duration-200 opacity-0 invisible -translate-y-2 pointer-events-none z-50">
                    <div class="p-4 space-y-3">
                        <div class="text-xs text-neutral-500 uppercase tracking-wider font-semibold mb-2">{{__t('text.frontend.menu_access', 'Access')}}</div>
                        @auth
                        <a href="{{ route($panelRoute) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-neutral-300 hover:bg-lime-400/10 hover:text-lime-400 transition-all group">
                            <i data-lucide="layout-dashboard" class="w-5 h-5 text-neutral-500 group-hover:text-lime-400 transition-colors"></i>
                            {{__t('text.frontend.landing.my_dashboard')}}
                        </a>
                        <a href="{{ route('logout') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-neutral-300 hover:bg-lime-400/10 hover:text-lime-400 transition-all group">
                            <i data-lucide="log-out" class="w-5 h-5 text-neutral-500 group-hover:text-lime-400 transition-colors"></i>
                            {{__t('text.frontend.landing.logout')}}
                        </a>
                        @else
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
                        @endauth
                    </div>
                </div>
            </div>

            <div class="tbh-lang-switch" role="group" aria-label="{{ __t('text.frontend.ux.language') }}">
                <a href="{{ route('lang.switch', 'es') }}" class="{{ app()->getLocale() == 'es' ? 'active' : '' }}" lang="es" title="Español" @if(app()->getLocale() == 'es') aria-current="true" @endif>ES</a>
                <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}" lang="en" title="English" @if(app()->getLocale() == 'en') aria-current="true" @endif>EN</a>
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
        <a href="{{route('show.who-we-are')}}" class="block text-neutral-300 hover:text-lime-400 font-semibold py-2 transition-colors">{{__t('text.frontend.menu_about_us', 'About Us')}}</a>

        <div class="pt-4 border-t border-neutral-800/40 flex flex-col gap-3">
            @auth
            <a href="{{ route($panelRoute) }}" class="flex items-center justify-center gap-2 text-neutral-300 hover:text-lime-400 font-semibold py-2 transition-colors">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                {{__t('text.frontend.landing.my_dashboard')}}
            </a>
            <a href="{{ route('logout') }}" class="flex items-center justify-center gap-2 text-neutral-300 hover:text-lime-400 font-semibold py-2 transition-colors">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                {{__t('text.frontend.landing.logout')}}
            </a>
            @else
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
            @endauth

            <div class="flex justify-center">
                <div class="tbh-lang-switch" role="group" aria-label="{{ __t('text.frontend.ux.language') }}">
                    <a href="{{ route('lang.switch', 'es') }}" class="{{ app()->getLocale() == 'es' ? 'active' : '' }}" lang="es" title="Español" @if(app()->getLocale() == 'es') aria-current="true" @endif>ES</a>
                    <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}" lang="en" title="English" @if(app()->getLocale() == 'en') aria-current="true" @endif>EN</a>
                </div>
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

{{-- Menú hamburguesa inline: no depende de app_web.js, así funciona aunque el bundle de Vite no cargue --}}
<script>
    (function () {
        var btn = document.getElementById('menu-btn');
        var menu = document.getElementById('mobile-menu');
        if (!btn || !menu) return;

        var iconOpen = document.getElementById('menu-icon-open');
        var iconClose = document.getElementById('menu-icon-close');

        btn.addEventListener('click', function () {
            var isOpen = menu.classList.toggle('hidden') === false;
            btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            if (iconOpen) iconOpen.classList.toggle('hidden', isOpen);
            if (iconClose) iconClose.classList.toggle('hidden', !isOpen);
        });
    })();
</script>

<div id="main-content" tabindex="-1">
@yield('content')
</div>

@guest
<div id="mobile-cta" class="md:hidden fixed bottom-0 inset-x-0 z-40 bg-black/90 backdrop-blur-xl border-t border-neutral-800/80 px-4 py-3 flex gap-3">
    <button type="button" data-open-freepick class="flex-1 inline-flex items-center justify-center gap-2 border border-lime-400/40 text-lime-300 rounded-xl py-3 text-xs font-bold uppercase tracking-wider">
        <i data-lucide="gift" class="w-4 h-4"></i> {{__t('text.frontend.landing.mobile_free')}}
    </button>
    <a href="{{route('show.plans')}}" class="flex-1 inline-flex items-center justify-center gap-2 btn-neon rounded-xl py-3 text-xs font-bold uppercase tracking-wider">
        <i data-lucide="zap" class="w-4 h-4"></i> {{__t('text.frontend.landing.mobile_plans')}}
    </a>
</div>
@endguest

@include('layouts.frontend.footer')
@include('layouts.frontend.form-kit')
@yield('script')

<script type="text/javascript">
    window.errorHandler = function (xhr, status, error) {
        $('#loading_form').hide();
        $(':button').prop('disabled', false);

        let responseJson = xhr.responseJSON;

        // Si es un error 422 nativo de Laravel, aquí es donde se van a desglosar uno por uno
        if (xhr.status === 422 && responseJson && responseJson.errors) {
            $.each(responseJson.errors, function (field, messages) {
                $.each(messages, function (index, message) {
                    toastr.error(message);
                });
            });
        } else if (responseJson && responseJson.message) {
            toastr.error(responseJson.message);
        } else {
            toastr.error(xhr.status === 0 ? TBH_I18N.connection : TBH_I18N.unexpected);
        }
    };
</script>

</body>
</html>