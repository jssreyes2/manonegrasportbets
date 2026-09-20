@section('title', __t('text.email.template.important_notice') ?: 'Important Notice')

@extends('emails.template')

@section('content')

    <!-- Contenido principal -->
    <div class="content">

        <p class="info-text">{{__t('text.email.template.hello', 'Hello')}} {{$data['name'] ?? ''}},</p>
        <p class="info-text">{{__t('text.email.template.thank_you_for_choosing_us', 'Thank you for choosing us')}}.</p>

        <div class="message-box">
            <div class="message-content">
                {!! $data['message'] !!}
            </div>
        </div>

        @if(!empty($data['tracking_token'] ?? null))
            <img src="{{config('app.url')}}/tracking/email-open?token={{$data['tracking_token']}}" width="1" height="1" alt=""/>
        @endif

    </div>

@endsection