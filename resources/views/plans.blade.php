@extends('layouts.app-backend')

@section('content')
    <div class="container py-5">

        <h1 class="mb-4">Selecciona tu plan</h1>

        <p class="mb-4">
            Tu pago quedará vinculado automáticamente con:
            <strong>{{ auth()->user()->email }}</strong>
        </p>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            @foreach($plans as $slug => $plan)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h2 class="h4">
                                {{ $plan['name'] }}
                            </h2>

                            <p class="display-6">
                                ${{ number_format($plan['price'], 2) }}
                            </p>

                            <p>
                                Acceso por
                                {{ $plan['duration_days'] }}
                                {{ $plan['duration_days'] === 1 ? 'día' : 'días' }}
                            </p>

                            <form method="POST" action="{{ route('checkout.whop', $slug) }}" target="_blank">
                                @csrf
                                <input type="text" name="plan_slug" value="{{ $slug }}">
                                <input type="text" name="user_id" value="{{ auth()->id() }}">
                                <button type="submit" class="btn btn-success w-100">
                                    Pagar con Whop
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection