@extends('layouts.app-backend')
@section('title', __t('text.backend.dashboard.title', 'Resumen'))
@section('content')

    @php
        $money = fn($value) => '$' . number_format((float)$value, 2);
    @endphp

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            {{-- Indicadores principales --}}
            <div class="row">
                <div class="col-xl-3 col-md-6 col-12 mb-3">
                    <a href="{{ route('get.payment.user') }}" class="tbh-stat">
                        <div class="tbh-stat-icon"><i class="fas fa-dollar-sign"></i></div>
                        <div>
                            <div class="tbh-stat-label">{{ __t('text.backend.dashboard.revenue_month', 'Ingresos del mes') }}</div>
                            <div class="tbh-stat-value">{{ $money($revenueMonth) }}</div>
                            <div class="tbh-stat-meta">
                                @if($revenueDelta === null)
                                    {{ __t('text.backend.dashboard.no_previous_month', 'Sin ventas el mes anterior') }}
                                @else
                                    <span class="tbh-delta {{ $revenueDelta >= 0 ? 'is-up' : 'is-down' }}">
                                        <i class="fas {{ $revenueDelta >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i> {{ abs($revenueDelta) }}%
                                    </span>
                                    {{ __t('text.backend.dashboard.vs_previous_month', 'vs. mes anterior') }}
                                @endif
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6 col-12 mb-3">
                    <a href="{{ route('get.subscription') }}" class="tbh-stat">
                        <div class="tbh-stat-icon"><i class="fas fa-id-card"></i></div>
                        <div>
                            <div class="tbh-stat-label">{{ __t('text.backend.dashboard.active_subscriptions', 'Suscripciones activas') }}</div>
                            <div class="tbh-stat-value">{{ $activeTotal }}</div>
                            <div class="tbh-stat-meta">
                                <i class="fas fa-shield-alt mr-1"></i>{{ $insuranceActive }} {{ __t('text.backend.dashboard.with_insurance', 'con seguro del apostador') }}
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6 col-12 mb-3">
                    <a href="{{ route('get.report.user') }}" class="tbh-stat">
                        <div class="tbh-stat-icon"><i class="fas fa-users"></i></div>
                        <div>
                            <div class="tbh-stat-label">{{ __t('text.backend.dashboard.customers', 'Clientes') }}</div>
                            <div class="tbh-stat-value">{{ $customersTotal }}</div>
                            <div class="tbh-stat-meta">
                                <i class="fas fa-user-plus mr-1"></i>{{ $customersNew }} {{ __t('text.backend.dashboard.new_this_month', 'nuevos este mes') }}
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6 col-12 mb-3">
                    <a href="{{ route('pick.index') }}" class="tbh-stat {{ $pendingTotal > 0 ? 'is-attention' : '' }}">
                        <div class="tbh-stat-icon {{ $pendingTotal > 0 ? 'is-warning' : '' }}"><i class="fas fa-clipboard-check"></i></div>
                        <div>
                            <div class="tbh-stat-label">{{ __t('text.backend.dashboard.picks_to_grade', 'Picks por calificar') }}</div>
                            <div class="tbh-stat-value">{{ $pendingTotal }}</div>
                            <div class="tbh-stat-meta">
                                @if($pendingTotal > 0)
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ __t('text.backend.dashboard.grade_hint', 'Califícalos para aplicar el seguro') }}
                                @else
                                    <i class="fas fa-check mr-1"></i>{{ __t('text.backend.dashboard.all_graded', 'Todo calificado') }}
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                {{-- Ingresos por mes --}}
                <div class="col-lg-8 col-12 mb-3">
                    @php
                        $maxRevenue = max(1, $revenueChart->max('amount'));
                        $peakIndex  = $revenueChart->search(fn($m) => $m['amount'] === $revenueChart->max('amount'));
                        $lastIndex  = $revenueChart->count() - 1;
                    @endphp
                    <div class="card h-100 mb-0">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title">{{ __t('text.backend.dashboard.revenue_chart', 'Ingresos de los últimos 6 meses') }}</h3>
                            <span class="ml-auto text-muted small">USD</span>
                        </div>
                        <div class="card-body">
                            <div class="tbh-chart" role="img" aria-label="{{ __t('text.backend.dashboard.revenue_chart', 'Ingresos de los últimos 6 meses') }}">
                                <div class="tbh-chart-grid">
                                    <span data-value="{{ $money($maxRevenue) }}"></span>
                                    <span data-value="{{ $money($maxRevenue / 2) }}"></span>
                                    <span data-value="$0"></span>
                                </div>
                                <div class="tbh-chart-bars">
                                    @foreach($revenueChart as $i => $month)
                                        <div class="tbh-chart-col" tabindex="0">
                                            <div class="tbh-chart-tip">
                                                <strong>{{ $money($month['amount']) }}</strong>
                                                <span>{{ $month['title'] }}</span>
                                            </div>
                                            {{-- Solo se rotulan el pico y el mes actual; el resto queda en el tooltip y la tabla --}}
                                            @if(($i === $peakIndex || $i === $lastIndex) && $month['amount'] > 0)
                                                <span class="tbh-chart-value">{{ $money($month['amount']) }}</span>
                                            @endif
                                            <div class="tbh-chart-bar" style="height: {{ $month['amount'] > 0 ? max(2, $month['amount'] / $maxRevenue * 100) : 0 }}%"></div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="tbh-chart-labels">
                                    @foreach($revenueChart as $month)
                                        <span>{{ $month['label'] }}</span>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Vista en tabla del gráfico para lectores de pantalla --}}
                            <table class="sr-only">
                                <caption>{{ __t('text.backend.dashboard.revenue_chart', 'Ingresos de los últimos 6 meses') }}</caption>
                                @foreach($revenueChart as $month)
                                    <tr><th>{{ $month['title'] }}</th><td>{{ $money($month['amount']) }}</td></tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Planes y acierto --}}
                <div class="col-lg-4 col-12 mb-3">
                    <div class="card h-100 mb-0">
                        <div class="card-header">
                            <h3 class="card-title">{{ __t('text.backend.dashboard.active_by_plan', 'Activas por plan') }}</h3>
                        </div>
                        <div class="card-body">
                            @forelse($activeByPlan as $plan)
                                <div class="tbh-hbar">
                                    <div class="tbh-hbar-head">
                                        <span>{{ $plan['name'] }}</span>
                                        <strong>{{ $plan['total'] }}</strong>
                                    </div>
                                    <div class="tbh-hbar-track">
                                        <div class="tbh-hbar-fill" style="width: {{ $plan['total'] / max(1, $activeTotal) * 100 }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">{{ __t('text.backend.dashboard.no_active_subscriptions', 'No hay suscripciones activas.') }}</p>
                            @endforelse

                            <div class="tbh-accuracy">
                                <div class="tbh-stat-label">{{ __t('text.backend.dashboard.pick_accuracy', 'Acierto de picks (30 días)') }}</div>
                                @if($accuracy)
                                    <div class="tbh-accuracy-value">{{ $accuracy['percent'] }}%</div>
                                    <div class="tbh-stat-meta">
                                        {{ $accuracy['won'] }} {{ __t('text.backend.dashboard.of', 'de') }} {{ $accuracy['total'] }} {{ __t('text.backend.dashboard.picks_won', 'picks ganados') }}
                                    </div>
                                @else
                                    <div class="tbh-stat-meta">{{ __t('text.backend.dashboard.no_graded_picks', 'Aún no hay picks calificados.') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Picks pendientes --}}
                <div class="col-lg-6 col-12 mb-3">
                    <div class="card h-100 mb-0">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title">{{ __t('text.backend.dashboard.picks_to_grade', 'Picks por calificar') }}</h3>
                            <a href="{{ route('pick.index') }}" class="ml-auto small">{{ __t('text.backend.dashboard.view_all', 'Ver todos') }} <i class="fas fa-arrow-right"></i></a>
                        </div>
                        <div class="card-body p-0">
                            <ul class="tbh-list">
                                @forelse($pendingPicks as $pick)
                                    <li>
                                        <div class="tbh-list-icon is-warning"><i class="fas fa-hourglass-half"></i></div>
                                        <div class="tbh-list-main">
                                            <span class="tbh-cell-main">{{ $pick->plan?->name ?? '-' }}</span>
                                            <span class="tbh-cell-sub">{{ \Illuminate\Support\Str::limit(trim(html_entity_decode(strip_tags($pick->body))), 70) }}</span>
                                        </div>
                                        <span class="tbh-list-aside">{{ $pick->created_at?->format('d/m H:i') }}</span>
                                    </li>
                                @empty
                                    <li class="tbh-list-empty"><i class="fas fa-check-circle mr-1"></i>{{ __t('text.backend.dashboard.all_graded', 'Todo calificado') }}</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Por vencer --}}
                <div class="col-lg-6 col-12 mb-3">
                    <div class="card h-100 mb-0">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title">{{ __t('text.backend.dashboard.expiring_soon', 'Vencen en los próximos 3 días') }}</h3>
                            <a href="{{ route('get.subscription') }}" class="ml-auto small">{{ __t('text.backend.dashboard.view_all', 'Ver todos') }} <i class="fas fa-arrow-right"></i></a>
                        </div>
                        <div class="card-body p-0">
                            <ul class="tbh-list">
                                @forelse($expiringSoon as $subscription)
                                    <li>
                                        <div class="tbh-list-icon"><i class="fas fa-calendar-day"></i></div>
                                        <div class="tbh-list-main">
                                            <span class="tbh-cell-main">{{ capitalize_first($subscription->first_name . ' ' . $subscription->last_name) }}</span>
                                            <span class="tbh-cell-sub">{{ capitalize_first($subscription->subscription_plan) }} · {{ $subscription->email }}</span>
                                        </div>
                                        <span class="tbh-list-aside">{{ $subscription->subscription_expires_at?->format('d/m/Y') }}</span>
                                    </li>
                                @empty
                                    <li class="tbh-list-empty">{{ __t('text.backend.dashboard.none_expiring', 'Ninguna suscripción vence en estos días.') }}</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Últimos pagos --}}
                <div class="col-lg-7 col-12 mb-3">
                    <div class="card h-100 mb-0">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title">{{ __t('text.backend.dashboard.latest_payments', 'Últimos pagos') }}</h3>
                            <a href="{{ route('get.payment.user') }}" class="ml-auto small">{{ __t('text.backend.dashboard.view_all', 'Ver todos') }} <i class="fas fa-arrow-right"></i></a>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table text-nowrap">
                                <thead>
                                <tr>
                                    <th>{{ __t('text.backend.tables.client', 'Cliente') }}</th>
                                    <th>{{ __t('text.backend.tables.plan', 'Plan') }}</th>
                                    <th class="text-right">{{ __t('text.backend.tables.amount', 'Monto') }}</th>
                                    <th>{{ __t('text.backend.tables.status', 'Estatus') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($latestPayments as $payment)
                                    @php
                                        [$statusClass, $statusText] = match ($payment->substatus) {
                                            \App\Models\Payment::PAYMENT_SUCCESS  => ['bg-success', __t('text.backend.tables.successful', 'Exitoso')],
                                            \App\Models\Payment::PAYMENT_REFUNDED => ['bg-warning', __t('text.backend.tables.refunded', 'Reembolsado')],
                                            default                               => ['bg-danger', __t('text.backend.tables.failed', 'Fallido')],
                                        };
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="tbh-cell-main">{{ capitalize_first($payment->first_name . ' ' . $payment->last_name) }}</span>
                                            <span class="tbh-cell-sub">{{ $payment->paid_at?->format('d/m/Y h:i A') }}</span>
                                        </td>
                                        <td><span class="badge bg-light">{{ capitalize_first($payment->website_plan ?? '-') }}</span></td>
                                        <td class="text-right"><span class="tbh-amount">{{ $money($payment->total) }}</span></td>
                                        <td><span class="badge {{ $statusClass }}">{{ $statusText }}</span></td>
                                    </tr>
                                @empty
                                    @include('layouts.partials.table-empty', ['colspan' => 4])
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Clientes nuevos --}}
                <div class="col-lg-5 col-12 mb-3">
                    <div class="card h-100 mb-0">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title">{{ __t('text.backend.dashboard.new_customers', 'Clientes recientes') }}</h3>
                            <a href="{{ route('get.report.user') }}" class="ml-auto small">{{ __t('text.backend.dashboard.view_all', 'Ver todos') }} <i class="fas fa-arrow-right"></i></a>
                        </div>
                        <div class="card-body p-0">
                            <ul class="tbh-list">
                                @forelse($latestCustomers as $customer)
                                    <li>
                                        <div class="tbh-avatar">{{ strtoupper(mb_substr($customer->first_name ?? $customer->email, 0, 1)) }}</div>
                                        <div class="tbh-list-main">
                                            <span class="tbh-cell-main">{{ ucwords($customer->first_name . ' ' . $customer->last_name) }}</span>
                                            <span class="tbh-cell-sub">{{ $customer->email }}{{ $customer->name ? ' · ' . $customer->name : '' }}</span>
                                        </div>
                                        <span class="tbh-list-aside">{{ $customer->created_at?->format('d/m/Y') }}</span>
                                    </li>
                                @empty
                                    <li class="tbh-list-empty">{{ __t('text.backend.messages.alert_table', 'No se encontraron resultados.') }}</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
