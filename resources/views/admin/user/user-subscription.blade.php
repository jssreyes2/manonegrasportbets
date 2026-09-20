@extends('layouts.app-backend')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-crown mr-2 text-warning"></i>Planes de Servicio
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-tachometer-alt mr-1"></i>Dashboard</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-tags mr-1"></i>Planes</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Mostrar plan activo del cliente - Diseño mejorado -->
            @if(isset($planActive) && $planActive)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card card-success card-outline shadow-sm border-left border-success border-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="mr-4 text-success">
                                        <i class="fas fa-check-circle fa-3x"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">
                                            <span class="badge badge-success px-3 py-2 mr-2">
                                                <i class="fas fa-star mr-1"></i>PLAN ACTIVO
                                            </span>
                                            <strong class="text-success">{{ $planName }}</strong>
                                        </h5>
                                        <div class="d-flex align-items-center mt-2">
                                            <div class="mr-4">
                                                <i class="far fa-calendar-alt text-muted mr-1"></i>
                                                <span class="text-muted">Vence el:</span>
                                                <strong class="ml-1">{{ date('d/m/Y', strtotime($expirationDate)) }}</strong>
                                            </div>
                                            <div>
                                                <i class="far fa-hourglass text-muted mr-1"></i>
                                                <span class="text-muted">Tiempo restante:</span>
                                                @if(isset($remainingDays))
                                                    <span class="badge badge-{{ $remainingDays <= 7 ? 'warning' : 'success' }} px-3 py-1 ml-1">
                                                        <strong>{{ $remainingDays }}</strong> días
                                                        @if($remainingDays <= 7)
                                                            <i class="fas fa-exclamation-circle ml-1"></i>
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Pricing Plan Row - Diseño mejorado -->
            <div class="row">
                @if(count($plans)<=0)
                    @include('layouts.alert_warning')
                @else
                    @foreach($plans as $index => $item)
                        @php
                            $classBtn = $item->id == \App\Models\Plan::ID_PLAN_FREE ? 'btn-select-plan-free' : 'btn-select-plan';

                            // Verificar si este plan es el que tiene activo el cliente
                            $isActivePlan = isset($activePlan) && $activePlan && $activePlan->plan_id == $item->id;

                            // Deshabilitar el plan si el cliente ya tiene un plan activo y no es el plan gratuito
                            $isDisabled = isset($activePlan) && $activePlan && $item->id != \App\Models\Plan::ID_PLAN_FREE;

                            // Colores degradados para cada plan (efecto visual)
                            $cardColors = ['primary', 'success', 'warning', 'info', 'danger'];
                            $cardColor = $cardColors[$index % count($cardColors)];

                            // Iconos para cada plan
                            $planIcons = [
                                'free' => 'fa-gift',
                                'basic' => 'fa-rocket',
                                'premium' => 'fa-crown',
                                'enterprise' => 'fa-building'
                            ];

                            // Determinar icono basado en nombre o ID
                            $planIcon = 'fa-tag';
                            $planNameLower = strtolower($item->name);
                            if (strpos($planNameLower, 'free') !== false || strpos($planNameLower, 'gratis') !== false) {
                                $planIcon = 'fa-gift';
                            } elseif (strpos($planNameLower, 'basic') !== false || strpos($planNameLower, 'basico') !== false) {
                                $planIcon = 'fa-rocket';
                            } elseif (strpos($planNameLower, 'premium') !== false) {
                                $planIcon = 'fa-crown';
                            } elseif (strpos($planNameLower, 'enterprise') !== false || strpos($planNameLower, 'empresa') !== false) {
                                $planIcon = 'fa-building';
                            }
                        @endphp

                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-lg hover-shadow-lg transition-all {{ $isActivePlan ? 'border border-success border-3' : '' }}"
                                 style="border-radius: 15px; overflow: hidden;">

                                <!-- Cabecera con degradado -->
                                <div class="card-header text-center py-4 position-relative
                                    @if($isActivePlan)
                                        bg-success text-white
                                    @elseif($item->recommended)
                                        bg-gradient-{{$cardColor}} text-white
                                    @else
                                        bg-light
                                    @endif"
                                     style="border-bottom: none;">

                                    @if($item->recommended && !$isActivePlan)
                                        <div class="ribbon-wrapper ribbon-xl">
                                            <div class="ribbon bg-warning text-sm">
                                                RECOMENDADO
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <i class="fas {{$planIcon}} fa-3x {{ $isActivePlan || $item->recommended ? 'text-white' : 'text-muted' }}"></i>
                                    </div>

                                    <h3 class="card-title font-weight-bold" style="font-size: 1.8rem;">
                                        {{$item->name}}
                                    </h3>

                                    @if($isActivePlan)
                                        <div class="mt-2">
                                            <span class="badge badge-light py-2 px-3">
                                                <i class="fas fa-check-circle mr-1 text-success"></i>PLAN ACTIVO
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body text-center d-flex flex-column h-100 pt-4">
                                    <!-- Precio -->
                                    <div class="py-3 border-bottom">
                                        <span class="display-4 font-weight-bold text-{{ $cardColor }}">${{number_format($item->price, 0)}}</span>
                                        <span class="text-muted">/mes</span>
                                        <div class="mt-1 text-muted small">
                                            ≈ {{USDConversion($item->price)}} VES
                                        </div>
                                    </div>

                                    <!-- Características del plan -->
                                    <div class="flex-grow-1 my-3 text-left px-3"
                                         style="min-height: 180px; max-height: 250px; overflow-y: auto;">
                                        <div class="description-content">
                                            {!! $item->description !!}
                                        </div>
                                    </div>

                                    <img src="{{asset('img/loadingfrm.gif')}}"
                                         id="loading_form_{{encrypt($item->id)}}"
                                         style="display: none; width: 30px; margin: 10px auto;">

                                    <!-- Botón de acción -->
                                    <div class="mt-auto px-3 pb-3">
                                        @if($isActivePlan)
                                            <button type="button" class="btn btn-success btn-lg btn-block rounded-pill py-3" disabled>
                                                <i class="fas fa-check-circle mr-2"></i>Plan Activo
                                                @if(isset($remainingDays))
                                                    <span class="ml-2 badge badge-light">{{ $remainingDays }} días</span>
                                                @endif
                                            </button>
                                        @elseif($planActive)
                                            <button type="button" class="btn btn-secondary btn-lg btn-block rounded-pill py-3" disabled>
                                                <i class="fas fa-lock mr-2"></i>No disponible
                                            </button>
                                        @else
                                            <button type="button"
                                                    data-plan-id="{{encrypt($item->id)}}"
                                                    data-name="{{route('save.pay.subscription')}}"
                                                    class="{{$classBtn}} btn btn-{{ $item->recommended ? $cardColor : 'outline-' . $cardColor }} btn-lg btn-block rounded-pill py-3 font-weight-bold
                                                           {{ $item->recommended ? 'shadow-lg' : '' }}">
                                                <i class="fas {{$item->recommended ? 'fa-crown' : 'fa-arrow-right'}} mr-2"></i>
                                                Seleccionar Plan
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- /.row -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    @include('admin.user.function_subscription')
    <link rel="stylesheet" href="{{ asset('css/styles-plans.css') }}">
@endsection