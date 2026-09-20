@section('title', __t('text.email.template.recover_password') ?: 'Recover Password')

@extends('emails.template')

@section('content')

    <!-- Contenido principal -->
    <div class="content">
        <h1 class="greeting">{{__t('text.email.template.hello', 'Hello')}} {{ $data['name'] }},</h1>

        <p class="info-text">{{__t('text.email.template.thank_you_for_choosing_us', 'Thank you for choosing us')}}</p>

        <div class="message-box">
            <div class="message-title">{{__t('text.email.template.dear', 'Dear')}}</div>
            <div class="message-content">{!! $data['message'] !!}</div>
        </div>

        <p>
            {{__t('text.email.template.button_to_make_the_change', 'Click this button to make the change:')}}<br><br>
            <a href="{{ route('user.recover.password', ['email' => $data['email_encrypt']]) ?? '#' }}" class="button">{{strtoupper(__t('text.email.template.recover_password', 'Recover Password'))}}</a>
        </p>
        
        <p class="info-text">{{__t('text.email.template.ignore_password_change', 'If you did not request a password change, you can ignore this email.')}}</p>
    </div>

@endsection