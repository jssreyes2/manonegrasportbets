@extends('layouts.app-backend')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-eye mr-2"></i>Detalle del Producto
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ $routeBack }}">Productos</a></li>
                        <li class="breadcrumb-item active">Detalle</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Botones de acción -->
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ $routeBack }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Columna izquierda - Imagen e información básica -->
                <div class="col-md-4">
                    <!-- Card de imagen principal -->
                    <div class="card card-purple card-outline shadow">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-image mr-2"></i>Imagen del Producto
                            </h3>
                        </div>
                        <div class="card-body text-center">
                            @if($product->photo ?? false)
                                <div class="product-image-container mb-3">
                                    <img src="{{ getImageUrl('products/'.$product->id, $product->photo) }}"
                                         class="img-fluid rounded shadow"
                                         alt="{{ $product->name_prod }}"
                                         style="max-height: 300px; width: auto;">
                                </div>
                            @else
                                <div class="no-image-placeholder bg-light p-5 rounded">
                                    <i class="fas fa-image fa-4x text-muted"></i>
                                    <p class="mt-2 text-muted">Sin imagen disponible</p>
                                </div>
                            @endif

                            <!-- Badge de estado -->
                            <div class="mt-3">
                                @if($product->is_active ?? true)
                                    <span class="badge badge-success p-2">
                                        <i class="fas fa-check-circle mr-1"></i>Activo
                                    </span>
                                @else
                                    <span class="badge badge-danger p-2">
                                        <i class="fas fa-times-circle mr-1"></i>Inactivo
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Card de información adicional -->
                    <div class="card card-purple card-outline shadow mt-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle mr-2"></i>Información Adicional
                            </h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-hashtag mr-2 text-purple"></i>Código Producto:</span>
                                    <span class="badge badge-purple badge-lg">{{ $product->short_code }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-calendar-plus mr-2 text-purple"></i>Fecha Creación:</span>
                                    <span>{{ $product->created_at->format('d/m/Y') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-calendar-check mr-2 text-purple"></i>Última Actualización:</span>
                                    <span>{{ $product->updated_at->format('d/m/Y') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- detalle d ela compra -->
                    <div class="card card-purple card-outline shadow mt-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-shopping-cart mr-2"></i>Resumen de Compra
                            </h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-dollar-sign mr-2 text-purple"></i>Total:</span>
                                    <span class="info-box-number h3 mb-0">{{ $product->price }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-calendar-plus mr-2 text-purple"></i>Métodos de Pago:</span>
                                    <span>Pago Móvil</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-home mr-2 text-purple"></i>Banco:</span>
                                    <span>{{$parameter->bank->bank}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-hashtag mr-2 text-purple"></i>Cédula:</span>
                                    <span>{{$parameter->identity_mobile_payment}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-phone-square mr-2 text-purple"></i>Teléfono:</span>
                                    <span>{{$parameter->phone_mobile_payment}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <button type="submit" class="btn btn-block btn-outline-success" id="send_form">
                                        <i class="fas fa-check-circle"></i> Reportar Pago
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Columna derecha - Información detallada -->
                <div class="col-md-8">
                    <!-- Card de información principal -->
                    <div class="card card-purple card-outline shadow">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-box mr-2"></i>Información del Producto
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Nombre del producto -->
                                <div class="col-12 mb-4">
                                    <h2 class="text-purple border-bottom pb-2">
                                        {{ $product->name_prod }}
                                    </h2>
                                </div>

                                <!-- Precio -->
                                <div class="col-md-6 mb-4">
                                    <div class="info-box bg-light p-3 rounded">
                                        <span class="info-box-icon bg-purple rounded-circle">
                                            <i class="fas fa-tag"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Precio</span>
                                            <span class="info-box-number h3 mb-0">${{ number_format($product->price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Categoría -->
                                <div class="col-md-6 mb-4">
                                    <div class="info-box bg-light p-3 rounded">
                                        <span class="info-box-icon bg-info rounded-circle">
                                            <i class="fas fa-folder"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Categoría</span>
                                            <span class="info-box-number h3 mb-0">
                                                {{ $product->category->name_category ?? 'Sin categoría' }}
                                                @if($product->subcategory)
                                                    <small class="text-muted">
                                                        <i class="fas fa-angle-right"></i>
                                                        {{ $product->subcategory->name_subcategory ?? '' }}
                                                    </small>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Descripción -->
                                <div class="col-12">
                                    <div class="card card-outline card-purple">
                                        <div class="card-header">
                                            <h5 class="card-title">
                                                <i class="fas fa-align-left mr-2"></i>Descripción del Producto
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="product-description p-3 bg-light rounded">
                                                {!! $product->description_prod ?? '<p class="text-muted">Sin descripción disponible</p>' !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product_detail.css') }}">
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Inicializar tooltips si los hay
            $('[data-toggle="tooltip"]').tooltip();

            // Efecto de carga suave
            $('.card').hide().fadeIn(500);

            // Animación para los productos relacionados
            $('.product-related-card').each(function(index) {
                $(this).delay(100 * index).animate({
                    opacity: 1
                }, 500);
            });
        });
    </script>
@endsection