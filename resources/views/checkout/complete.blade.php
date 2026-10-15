@extends('layouts.app-backend')
@section('content')
    <div class="container py-5 text-center">

        @if($status === 'success')
            <h1>Pago recibido</h1>

            <p>
                Whop está confirmando tu pago.
                Tu acceso se activará automáticamente.
            </p>

            <a
                    href="{{ route('picks.index') }}"
                    class="btn btn-success"
            >
                Entrar a mis picks
            </a>
        @elseif($status === 'error')
            <h1>No se completó el pago</h1>

            <p>
                El pago fue cancelado o rechazado.
            </p>

            <a
                    href="{{ route('plans') }}"
                    class="btn btn-primary"
            >
                Intentar nuevamente
            </a>
        @else
            <h1>Procesando pago</h1>

            <p>
                Verificaremos el pago mediante Whop.
            </p>

            <a href="{{ route('plans') }}">
                Volver a los planes
            </a>
        @endif

    </div>
@endsection