@extends('layouts.frontend.heard')

@section('title', __t('text.frontend.ux.forgot_title'))

@section('content')
    <main class="flex-1 flex items-center justify-center p-4 py-12">
        <div class="w-full max-w-md">
            <div class="bg-neutral-900/40 border border-neutral-800/80 rounded-2xl p-6 sm:p-8 backdrop-blur-md shadow-2xl">

                <div class="mb-6 text-center">
                    <div class="mx-auto mb-4 w-12 h-12 rounded-xl bg-lime-400/10 border border-lime-400/30 flex items-center justify-center text-lime-400">
                        <i data-lucide="key-round" class="w-6 h-6"></i>
                    </div>
                    <span class="text-xs font-mono tracking-widest text-lime-400 uppercase block mb-1">{{ __t('text.frontend.ux.forgot_kicker') }}</span>
                    <h1 class="text-xl font-black text-white uppercase tracking-tight">{{ __t('text.frontend.ux.forgot_title') }}</h1>
                    <p class="text-neutral-400 text-sm mt-2">{{ __t('text.frontend.ux.forgot_text') }}</p>
                </div>

                @if (session('status'))
                    <div class="mb-4 flex items-start gap-2 rounded-xl border border-lime-400/30 bg-lime-400/5 p-3 text-sm text-lime-200" role="status">
                        <i data-lucide="check-circle-2" class="w-4 h-4 mt-0.5 shrink-0"></i> {{ session('status') }}
                    </div>
                @endif

                <form id="forgot" method="POST" action="{{ route('password.email') }}" class="space-y-4" novalidate>
                    @csrf

                    <x-web.input name="email" type="email" icon="mail" :label="__t('text.backend.forms.email', 'Email')" :value="old('email')"
                                 placeholder="user@gmail.com" required autofocus autocomplete="email" inputmode="email" autocapitalize="off" spellcheck="false"/>

                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 btn-neon font-bold uppercase tracking-wider text-xs px-5 py-3.5 rounded-xl cursor-pointer">
                        <i data-lucide="send" class="w-4 h-4"></i> {{ __t('text.frontend.ux.forgot_cta') }}
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('show.login-customer') }}" class="inline-flex items-center gap-1 text-sm text-lime-400 font-semibold hover:underline">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __t('text.frontend.ux.back_to_login') }}
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script type="text/javascript">
        document.getElementById('forgot').addEventListener('submit', function (event) {
            var valid = TBHForm.validate(this, [
                {name: 'email', test: TBHForm.rules.required, message: TBH_I18N.required},
                {name: 'email', test: TBHForm.rules.email, message: TBH_I18N.email},
            ]);
            if (!valid) {
                event.preventDefault();
                return;
            }
            TBHForm.loading(this.querySelector('button[type="submit"]'), true, @json(__t('text.frontend.ux.sending')));
        });
    </script>
@endsection
