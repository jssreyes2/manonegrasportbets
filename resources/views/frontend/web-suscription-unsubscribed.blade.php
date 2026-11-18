@extends('layouts.frontend.heard')

@section('title', __t('text.frontend.ux.unsubscribed_title', 'Unsubscribed'))

@section('content')
    <main class="flex-1 flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="bg-neutral-900/40 border border-neutral-800/80 rounded-2xl p-6 sm:p-8 backdrop-blur-md shadow-2xl text-center">
                <h1 class="text-xl font-black text-white uppercase tracking-tight">{{ __t('text.frontend.ux.unsubscribed_title', 'Unsubscribed') }}</h1>
                <p class="text-neutral-300 text-sm mt-3">{{ __t('text.frontend.ux.unsubscribed_text', 'You will no longer receive promotional emails from us.') }}</p>
                <a href="{{ route('show.principal') }}" class="inline-flex mt-6 btn-neon font-bold uppercase tracking-wider text-xs px-5 py-3 rounded-xl">{{ __t('text.frontend.ux.back_home', 'Back to home') }}</a>
            </div>
        </div>
    </main>
@endsection
