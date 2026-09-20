@extends('layouts.app-backend')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pago Móvil</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Mis operaciones</a></li>
                        <li class="breadcrumb-item active">Pago móvil</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <!-- Filtros de búsqueda -->
        <div class="row">
            <div class="col-12">
                <!-- Sección de información de Pago Móvil -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card card-info card-outline shadow-sm">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-mobile-alt mr-2"></i>Información de Pago Móvil
                                </h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-box bg-light">
                                            <div class="info-box-icon bg-info rounded-circle">
                                                <i class="fas fa-university"></i>
                                            </div>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-muted">Banco</span>
                                                <span class="info-box-number font-weight-bold">{{ $bank ?? 'No especificado' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-box bg-light">
                                            <div class="info-box-icon bg-success rounded-circle">
                                                <i class="fas fa-phone-alt"></i>
                                            </div>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-muted">Número de Teléfono</span>
                                                <span class="info-box-number font-weight-bold">{{ $parameter?->phone_mobile_payment ?? 'No especificado' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-box bg-light">
                                            <div class="info-box-icon bg-warning rounded-circle">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-muted">Beneficiario</span>
                                                <span class="info-box-number font-weight-bold">{{ $parameter?->identity_mobile_payment  ?? 'No especificado' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-box bg-light">
                                            <div class="info-box-icon bg-danger rounded-circle">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-muted">Reportar Pago</span>
                                                <span class="info-box-number font-weight-bold">{{ $parameter?->email ?? 'No especificado' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Instrucciones de pago -->
                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Instrucciones para realizar el Pago Móvil:</strong>
                                    <ul class="mt-2 mb-0">
                                        <li>Ingresa a la aplicación de tu banco</li>
                                        <li>Selecciona la opción de Pago Móvil</li>
                                        <li>Ingresa los datos del beneficiario mostrados arriba</li>
                                        <li>Verifica que los datos sean correctos</li>
                                        <li>Confirma la operación y guarda el comprobante, reportalo al correo electónico <b>{{ $parameter?->email ?? 'No especificado' }}</b> </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
