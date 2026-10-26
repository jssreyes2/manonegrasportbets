@extends('layouts.app-backend')
@section('title', __t('text.backend.customer.my_account'))

@php
    $C = fn($key, $replace = []) => __t('text.backend.customer.' . $key, null, $replace);
    $photoUrl = getImageUrl('users/' . $user->id, $user->photo);
    $phoneCode = $phoneCodes[$user->country_id] ?? null;
    // El teléfono se guarda con el código de país: en el campo se muestra solo el número local
    $localPhone = $user->phone && $phoneCode && str_starts_with((string)$user->phone, (string)$phoneCode)
        ? substr((string)$user->phone, strlen((string)$phoneCode))
        : $user->phone;
@endphp

@section('content')
    <div class="card">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs tbh-tabs" role="tablist">
                @foreach(['profile' => ['tab_profile', 'fa-user'], 'security' => ['tab_security', 'fa-lock'], 'preferences' => ['tab_preferences', 'fa-sliders-h']] as $key => [$label, $icon])
                    <li class="nav-item">
                        <a class="nav-link {{ $tab === $key ? 'active' : '' }}" id="tab-{{ $key }}-link" data-toggle="tab" href="#tab-{{ $key }}" role="tab"
                           aria-controls="tab-{{ $key }}" aria-selected="{{ $tab === $key ? 'true' : 'false' }}">
                            <i class="fas {{ $icon }} mr-1"></i>{{ $C($label) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="tab-content">

            {{-- ============ DATOS PERSONALES ============ --}}
            <div class="tab-pane fade {{ $tab === 'profile' ? 'show active' : '' }}" id="tab-profile" role="tabpanel" aria-labelledby="tab-profile-link">
                <form id="customer-profile" enctype="multipart/form-data" novalidate>
                    <div class="card-body">

                        @if(!$user->completed_profile)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                {{__t('text.backend.messages.warning_description', 'Por favor complete su perfil para poder acceder a todas las funcionalidades.')}}
                            </div>
                        @endif

                        {{-- Avatar editable: se recorta en cuadrado antes de subirlo --}}
                        <div class="tbh-avatar-edit mb-4">
                            <img src="{{ $photoUrl }}" alt="" id="photo-preview" class="tbh-avatar-xl">
                            <div>
                                <label for="photo" class="btn btn-outline-dark btn-sm mb-1">
                                    <i class="fas fa-camera mr-1"></i>{{ $C('photo_change') }}
                                </label>
                                <input type="file" id="photo" name="photo" accept="image/jpeg,image/png" class="sr-only">
                                <div class="small text-muted">{{ $C('photo_hint') }}</div>
                                <div class="invalid-feedback d-block" data-error-for="photo"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6 col-12">
                                <label for="first_name">{{__t('text.backend.forms.names', 'Nombres')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" maxlength="50" required
                                       autocomplete="given-name" value="{{ $user->first_name }}">
                                <div class="invalid-feedback" data-error-for="first_name"></div>
                            </div>

                            <div class="form-group col-lg-6 col-12">
                                <label for="last_name">{{__t('text.backend.forms.surnames', 'Apellidos')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" maxlength="50" required
                                       autocomplete="family-name" value="{{ $user->last_name }}">
                                <div class="invalid-feedback" data-error-for="last_name"></div>
                            </div>

                            <div class="form-group col-lg-6 col-12">
                                <label for="country_id">{{__t('text.backend.forms.country', 'País')}} <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="country_id" name="country_id" required autocomplete="country">
                                    <option value="">{{__t('text.backend.forms.select', 'Seleccione...')}}</option>
                                    @foreach($countries as $key => $name)
                                        <option value="{{ $key }}" data-code="{{ $phoneCodes[$key] ?? '' }}" @selected($user->country_id == $key)>{{ $name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" data-error-for="country_id"></div>
                            </div>

                            <div class="form-group col-lg-6 col-12">
                                <label for="phone">{{__t('text.backend.forms.phone', 'Teléfono')}} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="phone-code">{{ $phoneCode ? '+' . $phoneCode : '+' }}</span>
                                    </div>
                                    <input type="tel" class="form-control" id="phone" name="phone" maxlength="15" required
                                           inputmode="tel" autocomplete="tel-national" value="{{ $localPhone }}" aria-describedby="phone-code phone-hint">
                                </div>
                                <small id="phone-hint" class="form-text text-muted">{{ $C('phone_hint') }}</small>
                                <div class="invalid-feedback d-block" data-error-for="phone"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="tbh-form-actions">
                            <button type="submit" class="btn btn-brand"><i class="fas fa-check mr-1"></i>{{ $C('save') }}</button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ============ SEGURIDAD ============ --}}
            <div class="tab-pane fade {{ $tab === 'security' ? 'show active' : '' }}" id="tab-security" role="tabpanel" aria-labelledby="tab-security-link">
                <form id="update-password" novalidate>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{__t('text.backend.messages.notification_change_email', 'Al cambiar tu correo electrónico, la sesión se cerrará automáticamente. Te enviaremos un mensaje de verificación a tu nueva dirección; una vez confirmado, podrás volver a iniciar sesión con los cambios aplicados.')}}
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6 col-12">
                                <label for="email">{{__t('text.backend.forms.email', 'Correo electrónico')}} <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" maxlength="191" required
                                       autocomplete="email" inputmode="email" value="{{ $account->email }}">
                                <div class="invalid-feedback" data-error-for="email"></div>
                            </div>

                            @if($account->password)
                                <div class="form-group col-lg-6 col-12">
                                    <label for="current_password">{{ $C('current_password') }} <span class="text-danger">*</span></label>
                                    @include('dashboard.partials.password-input', ['name' => 'current_password', 'autocomplete' => 'current-password'])
                                    <small class="form-text text-muted">{{ $C('current_password_hint') }}</small>
                                </div>
                            @endif

                            <div class="form-group col-lg-6 col-12">
                                <label for="password">{{ $C('new_password') }}</label>
                                @include('dashboard.partials.password-input', ['name' => 'password', 'autocomplete' => 'new-password'])
                                <small class="form-text text-muted">{{ $C('leave_blank') }}</small>
                            </div>

                            <div class="form-group col-lg-6 col-12">
                                <label for="password_confirmation">{{ $C('confirm_password') }}</label>
                                @include('dashboard.partials.password-input', ['name' => 'password_confirmation', 'autocomplete' => 'new-password'])
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="tbh-form-actions">
                            <button type="submit" class="btn btn-brand"><i class="fas fa-check mr-1"></i>{{ $C('save') }}</button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ============ PREFERENCIAS ============ --}}
            <div class="tab-pane fade {{ $tab === 'preferences' ? 'show active' : '' }}" id="tab-preferences" role="tabpanel" aria-labelledby="tab-preferences-link">
                <form id="preferences" novalidate>
                    <div class="card-body">
                        <fieldset class="mb-4">
                            <legend class="tbh-legend">{{ $C('language_label') }}</legend>
                            <p class="small text-muted">{{ $C('language_help') }}</p>
                            @php $currentLanguage = $account->language ?? app()->getLocale(); @endphp
                            <div class="tbh-choice-group">
                                @foreach(['es' => 'Español', 'en' => 'English'] as $code => $languageName)
                                    <label class="tbh-choice">
                                        <input type="radio" name="language" value="{{ $code }}" @checked($currentLanguage === $code)>
                                        <span><strong>{{ strtoupper($code) }}</strong> {{ $languageName }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>

                        <div class="tbh-info-row">
                            <i class="far fa-envelope"></i>
                            <div>
                                <div class="font-weight-bold">{{ $C('picks_email') }}</div>
                                <div>{{ $account->email }}</div>
                                <a href="#tab-security" class="small js-open-tab">{{ $C('change_in_security') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="tbh-form-actions">
                            <button type="submit" class="btn btn-brand"><i class="fas fa-check mr-1"></i>{{ $C('save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('dashboard.views.function-account')
@endsection
