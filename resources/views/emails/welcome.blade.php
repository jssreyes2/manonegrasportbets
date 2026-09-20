@section('title', __t('text.email.template.welcome', 'Welcome'))

@extends('emails.template')

@section('content')

    <!-- Contenido principal -->
    <div class="content">
        <h1 class="greeting">{{__t('text.email.template.hello', 'Hello')}} {{ $data['name'] }}</h1>


        <p class="info-text">{{__t('text.email.template.thank_you_for_choosing_us', 'Thank you for choosing us')}}</p>

        <div class="message-box">
            <div class="message-title">{{__t('text.email.template.dear', 'Dear')}}:</div>
            <div class="message-content">
                {!! $data['message'] !!}
            </div>
        </div>

        <!-- Botón de confirmación centrado -->
        <div class="button-container">
            <a href="{{ route('verify.email', ['email' => $data['email_encrypt']]) ?? '#' }}" class="button" target="_blank">{{__t('text.email.template.confirm_email', 'CONFIRM MY EMAIL ADDRESS')}}</a>
        </div>

        <p class="info-text">{{__t('text.email.template.you_need_help', 'If you have any questions or need assistance, please do not hesitate to contact us by replying to this email.')}}</p>

        @if(!empty($data['tracking_token'] ?? null))
            <img src="{{config('app.url')}}/tracking/email-open?token={{$data['tracking_token']}}" width="1" height="1" alt=""/>
        @endif
    </div>

@endsection