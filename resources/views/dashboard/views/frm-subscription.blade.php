@extends('layouts.app-backend')
@section('title', 'Suscripción')
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Capa oscura que bloquea toda la web -->
            <div id="whop-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.7); z-index: 9999; justify-content: center; align-items: center;">

                <div id="cargando" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; justify-content:center; align-items:center;">
                    <div style="background:white; padding:30px 40px; border-radius:15px; text-align:center;">
                        <div style="width:50px; height:50px; border:4px solid #f3f3f3; border-top:4px solid #3498db; border-radius:50%; animation: girar 0.8s linear infinite; margin:0 auto;"></div>
                        <p style="margin-top:15px; font-weight:500;">{{__t('text.backend.messages.opening_whop', 'Opening Whop')}} </p>
                    </div>
                </div>


                <!-- Tu contenedor de confirmación de pago -->
                <div class="div-confirm-pay" style="display: none; background: white; padding: 30px; border-radius: 12px; text-align: center; max-width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
                    <h4 class="mb-3">{{__t('text.backend.messages.paying_on_whop', 'Paying on Whop')}}</h4>
                    <p class="text-muted">{{__t('text.backend.messages.paying_on_whop_text_modal', 'Do not close this tab until you complete the payment in the pop-up window.')}}</p>
                    <button type="button" class="btn btn-secondary btn-sm mt-3" id="cerrar-overlay">{{__t('text.backend.forms.close', 'close')}}</button>
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

            <div class="row">

                @if(count($plans) <= 0)
                    @include('layouts.alert_warning')
                @else
                    @foreach($plans as $item )
                        @php

                            $textAplnActive = $txtSureBettor = null;
                           // Verificamos si hay planes activos
                            if (isset($plansActive['plans']) && count($plansActive['plans']) > 0) {

                                // Buscamos si el slug del ítem actual coincide con algún 'name' en el array de activos
                                $activePlanMatch = collect($plansActive['plans'])->first(function ($activePlan) use ($item) {
                                    return strtolower($activePlan['name']) === strtolower($item->source);
                                });

                                if ($activePlanMatch) {
                                    $expiryDate = $activePlanMatch['expiration_date'] ?? null;
                                    $textAplnActive = __t('text.backend.messages.active_plan', 'Activo y vence el') . ' ' . $expiryDate;
                                    if($activePlanMatch['sure_bettor']){
                                        $txtSureBettor=' / '.__t('text.backend.messages.betting_insurance', 'Seguro de apostador');
                                    }
                                }
                            }

                            // Lógica limpia y optimizada para la imagen según el idioma y el source
                            $lang = (app()->getLocale() == \App\Models\Country::LANGUAGE_EN) ? 'en' : 'es';

                            $tipoPlan = match($item->source) {
                                \App\Models\Plan::PLAN_SOURCE_SUSCRIPCION => '50',
                                \App\Models\Plan::PLAN_SOURCE_VIP => '100',
                                default => '30', // Por defecto o PLAN_SOURCE_ELITE
                            };

                            $imgPlan = "img/plan-{$lang}-{$tipoPlan}.jpg";

                        @endphp

                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-lg rounded-4 overflow-hidden"
                                 style="background: #ffffff; transition: transform 0.3s ease; border: 1px solid rgba(212, 175, 55, 0.2);">

                                <div class="card-body d-flex flex-column align-items-center text-center p-4">
                                    <!-- Imagen completa con marco elegante -->
                                    <div class="position-relative mb-3" style="width: 100%; padding: 8px; border-radius: 16px; background: linear-gradient(135deg, #d4af37, #f5e6a3);">
                                        <div class="rounded-3 overflow-hidden" style="background: #fff;">
                                            <img src="{{ asset($imgPlan) }}"
                                                 alt="La Mano Negra"
                                                 class="img-fluid w-100"
                                                 style="display: block; height: auto; object-fit: contain;">
                                        </div>
                                    </div>

                                    <div class="mt-3 w-100">
                                        @if($textAplnActive)
                                            <button type="button" class="btn btn-default btn-lg btn-block rounded-pill py-3" disabled>
                                                <i class="fas fa-check-circle mr-2"></i> {{$textAplnActive}} {{$txtSureBettor}}
                                            </button>
                                        @else

                                            <form method="POST" class="frm-plan w-100" action="{{ route('checkout.whop', $item->source) }}" target="whop_checkout">
                                                @csrf
                                                <input type="hidden" name="plan_slug" value="{{$item->source}}">
                                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                                                <button type="submit" class="btn btn-info btn-lg w-100 rounded-pill py-3 font-weight-bold shadow-lg"
                                                        style="transition: all 0.3s ease; background: linear-gradient(135deg, #667eea, #764ba2); border: none; letter-spacing: 0.5px;"
                                                        onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 12px 35px rgba(102,126,234,0.4)';"
                                                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)';">
                                                    <i class="fas fa-credit-card me-2"></i> {{__t('text.backend.forms.pay_with_whop', 'Pagar con Whop')}}
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

        </div>
    </section>
@endsection

@section('script')
    @include('admin.user.function_subscription')
    <link rel="stylesheet" href="{{ asset('css/styles-plans.css') }}">
@endsection