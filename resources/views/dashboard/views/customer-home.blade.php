@extends('layouts.app-backend')
@section('title', __t('text.backend.customer.home_title'))

@php
    $C = fn($key, $replace = []) => __t('text.backend.customer.' . $key, null, $replace);
    $firstName = capitalize_first($user->profile?->first_name ?? explode('@', $user->email)[0]);
@endphp

@section('page-actions')
    <div class="d-flex flex-wrap" style="gap: 8px">
        <a href="{{ route('picks.index') }}" class="btn btn-outline-dark"><i class="fas fa-futbol mr-1"></i>{{ $C('my_picks') }}</a>
        <a href="{{ route('subscription') }}" class="btn btn-brand"><i class="fas fa-crown mr-1"></i>{{ $C('view_plans') }}</a>
    </div>
@endsection

@section('content')

    <div class="tbh-hello mb-4">
        <h2 class="mb-1">{{ $C('greeting', ['name' => $firstName]) }}</h2>
        <p class="mb-0">{{ $activePlans->isNotEmpty() ? $C('greeting_active') : $C('greeting_no_plan') }}</p>
    </div>

    {{-- ============ PLANES VIGENTES ============ --}}
    <div class="tbh-section-title"><i class="fas fa-crown"></i> {{ __t('text.backend.messages.my_active_plans', 'Tus planes activos') }}</div>

    @if($activePlans->isEmpty())
        <div class="card mb-4">
            <div class="card-body tbh-empty-cta">
                <div class="tbh-empty-cta-icon"><i class="fas fa-layer-group"></i></div>
                <div class="flex-grow-1">
                    <h3 class="h6 mb-1">{{ $C('no_plan_title') }}</h3>
                    <p class="mb-0 text-muted">{{ $C('no_plan_text') }}</p>
                </div>
                <a href="{{ route('subscription') }}" class="btn btn-brand">{{ $C('view_plans') }} <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($activePlans as $plan)
                @php $days = (int)$plan['remainingDays']; @endphp
                <div class="col-xl-4 col-md-6 col-12 mb-3">
                    <div class="tbh-plan-status {{ $plan['expiring'] ? 'is-expiring' : '' }}">
                        <div class="d-flex align-items-center" style="gap: 12px">
                            <div class="tbh-my-plan-icon"><i class="fas {{ $plan['is_elite'] ? 'fa-gem' : 'fa-star' }}"></i></div>
                            <div class="flex-grow-1">
                                <div class="tbh-my-plan-name">{{ $plan['label'] }}</div>
                                <div class="tbh-my-plan-date">
                                    {{ $plan['is_elite'] ? __t('text.backend.messages.your_day', 'Tu día') . ':' : __t('text.backend.messages.expires_on', 'Vence el') }}
                                    {{ $plan['expiration_date'] }}
                                </div>
                            </div>
                            <div class="tbh-my-plan-days">
                                @if($days === 0)
                                    <strong>{{ __t('text.backend.messages.today', 'Hoy') }}</strong>
                                @else
                                    <strong>{{ $days }}</strong>
                                    <span>{{ $days === 1 ? __t('text.backend.messages.day', 'día') : __t('text.backend.messages.days', 'días') }}</span>
                                @endif
                            </div>
                        </div>

                        @unless($plan['is_elite'])
                            <div class="tbh-progress mt-3" role="progressbar" aria-valuenow="{{ $plan['progress'] }}" aria-valuemin="0" aria-valuemax="100"
                                 aria-label="{{ $C('plan_progress') }}">
                                <span style="width: {{ $plan['progress'] }}%"></span>
                            </div>
                            <div class="d-flex justify-content-between tbh-progress-legend">
                                <span>{{ $C('plan_progress') }}</span>
                                <span>{{ $C('days_of', ['used' => $plan['duration'] - $days, 'total' => $plan['duration']]) }}</span>
                            </div>
                        @endunless

                        @if($plan['sure_bettor'])
                            <span class="badge bg-info mt-2"><i class="fas fa-shield-alt mr-1"></i>{{ $C('insurance_active') }}</span>
                        @endif

                        @if($plan['expiring'])
                            <p class="tbh-plan-note is-warning mt-2 mb-0">
                                <i class="fas fa-clock mr-1"></i>{{ $C('expiring_note') }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row">
        {{-- ============ PICKS DE HOY ============ --}}
        <div class="col-lg-7 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title"><i class="fas fa-bolt mr-2"></i>{{ $C('today_picks') }}</h3>
                    <span class="ml-auto text-muted small">{{ now()->format('d/m/Y') }}</span>
                </div>
                <div class="card-body">
                    @forelse($todayPicks as $pick)
                        @include('dashboard.partials.pick-card', ['pick' => $pick])
                    @empty
                        <div class="tbh-empty">
                            <i class="far fa-paper-plane"></i>
                            <div>{{ $C('no_picks_today') }}</div>
                            <small>{{ $C('picks_by_email', ['email' => $user->email]) }}</small>
                            @if($activePlans->isEmpty())
                                <a href="{{ route('subscription') }}" class="btn btn-brand btn-sm mt-3">{{ $C('view_plans') }}</a>
                            @endif
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ============ RENDIMIENTO ============ --}}
        <div class="col-lg-5 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line mr-2"></i>{{ $C('my_stats') }}</h3>
                </div>
                <div class="card-body">
                    <div class="tbh-accuracy-value">{{ $stats['rate'] !== null ? $stats['rate'] . '%' : '—' }}</div>
                    <div class="text-muted small mb-2">{{ $C('rate') }}</div>
                    <div class="tbh-progress mb-4"><span style="width: {{ $stats['rate'] ?? 0 }}%"></span></div>

                    <div class="tbh-mini-stats">
                        <div><strong>{{ $stats['received'] }}</strong><span>{{ $C('received') }}</span></div>
                        <div class="is-won"><strong>{{ $stats['won'] }}</strong><span>{{ __t('text.frontend.ux.results_won') }}</span></div>
                        <div class="is-lost"><strong>{{ $stats['lost'] }}</strong><span>{{ __t('text.frontend.ux.results_lost') }}</span></div>
                        <div><strong>{{ $stats['pending'] }}</strong><span>{{ $C('pending') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- ============ ÚLTIMOS PICKS ============ --}}
        <div class="col-lg-7 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title"><i class="fas fa-history mr-2"></i>{{ $C('recent_picks') }}</h3>
                    <a href="{{ route('picks.index') }}" class="ml-auto small font-weight-bold">{{ $C('see_history') }} <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
                <div class="card-body p-0">
                    <ul class="tbh-list">
                        @forelse($recentPicks as $pick)
                            @php $lines = $pick->lines(); @endphp
                            <li>
                                <span class="tbh-list-icon"><i class="fas fa-futbol"></i></span>
                                <div class="tbh-list-main">
                                    <span class="tbh-cell-main">{{ $lines[0] ?? '—' }}</span>
                                    <span class="tbh-cell-sub">{{ $pick->plan->name ?? '' }} · {{ \Carbon\Carbon::parse($pick->send_date)->format('d/m/Y') }}</span>
                                </div>
                                @include('dashboard.partials.result-badge', ['result' => $pick->resultKey()])
                            </li>
                        @empty
                            <li class="tbh-list-empty">{{ $C('picks_empty') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- ============ SEGURO + ACCESOS ============ --}}
        <div class="col-lg-5 col-12 mb-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex" style="gap: 12px">
                        <div class="tbh-my-plan-icon"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <h3 class="h6 mb-1">{{ $C('insurance_title') }}</h3>
                            <p class="mb-0 small text-muted">{{ $C('insurance_text') }}</p>
                            @unless($hasElite)
                                <a href="{{ route('subscription') }}" class="small font-weight-bold d-inline-block mt-2">{{ $C('insurance_cta') }} <i class="fas fa-arrow-right ml-1"></i></a>
                            @endunless
                        </div>
                    </div>
                </div>
            </div>

            <div class="tbh-quick">
                <a href="{{ route('profile') }}"><i class="fas fa-user-cog"></i><span>{{ $C('my_account') }}</span></a>
                <a href="{{ route('my.payment') }}"><i class="fas fa-receipt"></i><span>{{ __t('text.backend.tables.my_payments', 'Mis Pagos') }}</span></a>
                <a href="{{ route('show.comments') }}"><i class="fas fa-headset"></i><span>{{ $C('support') }}</span></a>
            </div>
        </div>
    </div>
@endsection
