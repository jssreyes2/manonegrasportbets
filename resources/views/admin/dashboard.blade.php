@extends('layouts.app-backend')
@section('title', 'Resumen')
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @php
                    $stats = [
                        ['label' => 'Usuarios',        'value' => $totalCustomer >= 10 ? $totalCustomer : '0' . $totalCustomer, 'icon' => 'fas fa-users',       'route' => route('get.report.user')],
                        ['label' => 'Pagos exitosos',  'value' => is_numeric($totalSuccessful) ? '$' . number_format($totalSuccessful, 2) : $totalSuccessful, 'icon' => 'fas fa-dollar-sign',  'route' => route('get.payment.user')],
                        ['label' => 'Suscripciones',   'value' => $totalSubscriptions, 'icon' => 'fas fa-id-card',      'route' => route('get.subscription')],
                    ];
                @endphp

                @foreach($stats as $stat)
                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                        <a href="{{ $stat['route'] }}" class="tbh-stat">
                            <div class="tbh-stat-icon"><i class="{{ $stat['icon'] }}"></i></div>
                            <div>
                                <div class="tbh-stat-label">{{ $stat['label'] }}</div>
                                <div class="tbh-stat-value">{{ $stat['value'] }}</div>
                            </div>
                            <span class="tbh-stat-link"><i class="fas fa-arrow-right"></i></span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div><!-- /.container-fluid -->


        <div class="row">

            @if(empty($clients))
                @include('layouts.alert_warning')
            @else

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Usuarios con perfil completado</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">

                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Nombres y Apellidos</th>
                                    <th>Correo electrónico</th>
                                    <th>Teléfono</th>
                                    <th>País</th>
                                    <th>Status</th>
                                    <th>Creación</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clients AS $item)
                                    <tr>
                                        <td>{{ucwords($item['first_name'].' '.$item['last_name'])}}</td>
                                        <td>{{$item['email']}}</td>
                                        <td>{{$item['phone']}}</td>
                                        <td>{{$item['name']}}</td>
                                        <td>{!! $item['is_active'] ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-light">Inactivo</span>' !!}</td>
                                        <td>{{date('d/m/Y', strtotime($item['created_at'])),}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            @include('layouts.paginate', ['variable' => $clients])
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            @endif
        </div>

    </section>
    <!-- /.content -->

@endsection
