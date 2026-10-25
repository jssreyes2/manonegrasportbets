@extends('layouts.app-backend')
@section('title', 'Suscripción')
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            {{-- Capa que bloquea la página mientras el pago está abierto en Whop (ids usados por function_subscription) --}}
            <div id="whop-overlay" class="tbh-pay-overlay" style="display: none;">
                <div id="cargando" class="tbh-pay-dialog" style="display: none;">
                    <div class="tbh-spinner"></div>
                    <p class="mb-0 mt-3 font-weight-bold">{{__t('text.backend.messages.opening_whop', 'Abriendo Whop...')}}</p>
                </div>

                <div class="div-confirm-pay tbh-pay-dialog" style="display: none;">
                    <div class="tbh-pay-dialog-icon"><i class="fas fa-lock"></i></div>
                    <h4 class="mb-2">{{__t('text.backend.messages.paying_on_whop', 'Pagando en Whop')}}</h4>
                    <p class="text-muted mb-4">{{__t('text.backend.messages.paying_on_whop_text_modal', 'No cierres esta pestaña hasta completar el pago en la ventana emergente.')}}</p>
                    <button type="button" class="btn btn-outline-secondary px-4" id="cerrar-overlay">
                        <i class="fas fa-check mr-1"></i> {{__t('text.backend.forms.close', 'Cerrar')}}
                    </button>
                </div>
            </div>

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Planes vigentes del cliente --}}
            @if($activePlans->isNotEmpty())
                <div class="tbh-my-plans mb-4">
                    <div class="tbh-section-title">
                        <i class="fas fa-crown"></i> {{__t('text.backend.messages.my_active_plans', 'Tus planes activos')}}
                    </div>
                    <div class="row">
                        @foreach($activePlans as $source => $active)
                            @php
                                $catalogPlan = $plans->firstWhere('source', $source);
                                $isEliteActive = $source === \App\Models\Subscription::PLAN_ELITE;
                                $days = (int)$active['remainingDays'];
                            @endphp
                            <div class="col-lg-4 col-md-6 col-12 mb-2">
                                <div class="tbh-my-plan">
                                    <div class="tbh-my-plan-icon"><i class="fas {{ $isEliteActive ? 'fa-gem' : 'fa-star' }}"></i></div>
                                    <div class="flex-grow-1">
                                        <div class="tbh-my-plan-name">{{ $catalogPlan->name ?? capitalize_first($source) }}</div>
                                        <div class="tbh-my-plan-date">
                                            @if($isEliteActive)
                                                {{__t('text.backend.messages.your_day', 'Tu día')}}: {{ $active['expiration_date'] }}
                                            @else
                                                {{__t('text.backend.messages.expires_on', 'Vence el')}} {{ $active['expiration_date'] }}
                                            @endif
                                        </div>
                                        @if($active['sure_bettor'])
                                            <span class="badge bg-info mt-1"><i class="fas fa-shield-alt mr-1"></i>{{__t('text.backend.messages.betting_insurance', 'Seguro de apostador')}}</span>
                                        @endif
                                    </div>
                                    <div class="tbh-my-plan-days">
                                        @if($days === 0)
                                            <strong>{{__t('text.backend.messages.today', 'Hoy')}}</strong>
                                        @else
                                            <strong>{{ $days }}</strong>
                                            <span>{{ $days === 1 ? __t('text.backend.messages.day', 'día') : __t('text.backend.messages.days', 'días') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="tbh-section-title">
                <i class="fas fa-layer-group"></i> {{__t('text.backend.messages.choose_plan', 'Elige tu plan')}}
            </div>

            <div class="row">

                @if(count($plans) <= 0)
                    @include('layouts.alert_warning')
                @else
                    @foreach($plans as $item)
                        @php
                            $active  = $activePlans->get(strtolower($item->source));
                            $isElite = (int)$item->id === \App\Models\Plan::ID_PLAN_ELITE;
                            $days    = max(1, (int)$item->duration_days);

                            // Imagen del plan según el idioma y el source
                            $lang = (app()->getLocale() == \App\Models\Country::LANGUAGE_EN) ? 'en' : 'es';

                            $tipoPlan = match($item->source) {
                                \App\Models\Plan::PLAN_SOURCE_SUSCRIPCION => '50',
                                \App\Models\Plan::PLAN_SOURCE_VIP => '100',
                                \App\Models\Plan::PLAN_SOURCE_VEP => '40',
                                \App\Models\Plan::PLAN_SOURCE_SUS => '15',
                                \App\Models\Plan::PLAN_SOURCE_ELIT => '70',
                                default => '30', // Por defecto o PLAN_SOURCE_ELITE
                            };

                            $imgPlan = "img/plan-{$lang}-{$tipoPlan}.jpg";
                        @endphp

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card h-100 tbh-plan-card {{ $active ? 'is-active' : '' }}">

                                @if($active)
                                    <span class="tbh-plan-ribbon is-active"><i class="fas fa-check mr-1"></i>{{__t('text.backend.messages.active', 'Activo')}}</span>
                                @elseif($item->recommended)
                                    <span class="tbh-plan-ribbon"><i class="fas fa-fire mr-1"></i>{{__t('text.backend.messages.recommended', 'Recomendado')}}</span>
                                @endif

                                <div class="card-body d-flex flex-column p-3">
                                    <img src="{{ asset($imgPlan) }}" alt="{{ $item->name }}" class="img-fluid w-100 d-block" loading="lazy">

                                    <div class="tbh-plan-summary">
                                        <div>
                                            <div class="tbh-plan-name">{{ $item->name }}</div>
                                            <div class="tbh-plan-duration">
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                {{ $days }} {{ $days === 1 ? __t('text.backend.messages.day', 'día') : __t('text.backend.messages.days', 'días') }}
                                            </div>
                                        </div>
                                        <div class="tbh-plan-price">
                                            ${{ rtrim(rtrim(number_format((float)$item->price, 2), '0'), '.') }}
                                            <span>{{ strtoupper($item->currency ?? 'usd') }}</span>
                                        </div>
                                    </div>

                                    <div class="mt-auto w-100">
                                        @if($active)
                                            <div class="tbh-plan-active">
                                                <i class="fas fa-check-circle"></i>
                                                {{ $isElite ? __t('text.backend.messages.your_day', 'Tu día') . ':' : __t('text.backend.messages.active_plan', 'Activo y vence el') }}
                                                {{ $active['expiration_date'] }}
                                            </div>
                                            <p class="tbh-plan-note">
                                                <i class="fas fa-info-circle mr-1"></i>{{__t('text.backend.messages.renew_after_expiry', 'Podrás comprarlo de nuevo cuando venza.')}}
                                            </p>
                                        @else
                                            @if($isElite && $eliteStartsOn->isTomorrow())
                                                <p class="tbh-plan-note is-warning">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{__t('text.backend.messages.elite_starts_tomorrow', 'El pick de hoy ya fue enviado: tu día Élite será mañana')}} ({{ $eliteStartsOn->format('d/m/Y') }}).
                                                </p>
                                            @endif

                                            <form method="POST" class="frm-plan w-100" action="{{ route('checkout.whop', $item->source) }}" target="whop_checkout">
                                                @csrf
                                                <input type="hidden" name="plan_slug" value="{{$item->source}}">
                                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                                                <button type="submit" class="btn btn-brand btn-lg w-100 tbh-btn-pay">
                                                    <i class="fas fa-credit-card mr-2"></i> {{__t('text.backend.forms.pay_with_whop', 'Pagar con Whop')}}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Cómo funciona la compra --}}
            <div class="tbh-how row">
                <div class="col-md-4 col-12">
                    <div class="tbh-how-step">
                        <span>1</span>
                        <div>
                            <strong>{{__t('text.backend.messages.step_choose', 'Elige tu plan')}}</strong>
                            <p>{{__t('text.backend.messages.step_choose_text', 'Puedes tener varios planes distintos a la vez.')}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="tbh-how-step">
                        <span>2</span>
                        <div>
                            <strong>{{__t('text.backend.messages.step_pay', 'Paga seguro en Whop')}}</strong>
                            <p>{{__t('text.backend.messages.step_pay_text', 'Pago único, sin cobros automáticos.')}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="tbh-how-step">
                        <span>3</span>
                        <div>
                            <strong>{{__t('text.backend.messages.step_receive', 'Recibe tus picks')}}</strong>
                            <p>{{__t('text.backend.messages.step_receive_text', 'Te llegan por correo apenas se publican.')}}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('script')
    @include('admin.user.function_subscription')
@endsection
