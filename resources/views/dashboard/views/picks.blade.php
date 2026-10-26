@extends('layouts.app-backend')
@section('title', __t('text.backend.customer.picks_history'))

@php $C = fn($key, $replace = []) => __t('text.backend.customer.' . $key, null, $replace); @endphp

@section('content')

    {{-- Rendimiento de los picks recibidos --}}
    <div class="row">
        @foreach([
            ['received', 'fas fa-paper-plane', '', $stats['received']],
            ['rate', 'fas fa-bullseye', 'is-success', $stats['rate'] !== null ? $stats['rate'] . '%' : '—'],
            ['won_lost', 'fas fa-balance-scale', '', $stats['won'] . ' / ' . $stats['lost']],
            ['pending', 'fas fa-hourglass-half', 'is-warning', $stats['pending']],
        ] as [$label, $icon, $tone, $value])
            <div class="col-xl-3 col-md-6 col-12 mb-3">
                <div class="tbh-stat">
                    <div class="tbh-stat-icon {{ $tone }}"><i class="{{ $icon }}"></i></div>
                    <div>
                        <div class="tbh-stat-label">{{ $C($label) }}</div>
                        <div class="tbh-stat-value">{{ $value }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center" style="gap: 8px">
            <h3 class="card-title mr-auto"><i class="fas fa-history mr-2"></i>{{ $C('picks_history') }}</h3>

            {{-- Filtro por resultado --}}
            <div class="btn-group btn-group-sm" role="group" aria-label="{{ $C('filter_result') }}">
                @foreach([null => 'all', 'won' => 'won', 'lost' => 'lost', 'pending' => 'pending'] as $value => $key)
                    <a href="{{ route('picks.index', $value ? ['result' => $value] : []) }}"
                       class="btn {{ $result === ($value ?: null) ? 'btn-brand' : 'btn-outline-dark' }}"
                       @if($result === ($value ?: null)) aria-current="true" @endif>
                        {{ $key === 'all' ? $C('filter_all') : __t('text.frontend.ux.result_' . $key) }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="card-body">
            @if($picks->isEmpty())
                <div class="tbh-empty">
                    <i class="fas fa-futbol"></i>
                    <div>{{ $result ? $C('picks_empty_filter') : $C('picks_empty') }}</div>
                    @if($result)
                        <a href="{{ route('picks.index') }}" class="btn btn-outline-dark btn-sm mt-3">{{ $C('filter_all') }}</a>
                    @elseif(!$hasActive)
                        <small>{{ $C('picks_empty_text') }}</small>
                        <a href="{{ route('subscription') }}" class="btn btn-brand btn-sm mt-3">{{ $C('view_plans') }}</a>
                    @endif
                </div>
            @else
                <div class="row tbh-pick-grid">
                    @foreach($picks as $pick)
                        <div class="col-xl-4 col-md-6 col-12 mb-3">
                            @include('dashboard.partials.pick-card', ['pick' => $pick])
                        </div>
                    @endforeach
                </div>

                {{ $picks->links('pagination::bootstrap-4') }}
            @endif
        </div>
    </div>
@endsection
