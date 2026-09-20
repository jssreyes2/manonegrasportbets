@extends('layouts.app-backend')

@section('content')
    <div id="form-modal"></div>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Biblioteca de Documentos PDF</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Descargas</a></li>
                        <li class="breadcrumb-item active">Documentos PDF</li>
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
                <div class="card card-purple card-outline">
                    <form role="form" id="frm-search-pdf">
                        <div class="card-body">
                            <div class="row">
                                {{-- Campo de búsqueda general --}}
                                <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                    <label for="search">Buscar documento</label>
                                    <input type="text" class="form-control" id="search" name="filter[search]"
                                           placeholder="Nombre..."
                                           value="{{ $filter['search'] ?? '' }}">
                                </div>


                                <div class="form-group col-lg-4 col-md-12 col-sm-12 col-12">
                                    <label for="category_id">Categorías</label>
                                    <select class='form-control' id='category_id' name="filter[category_id]">
                                        <option value=''>Todas las categorías</option>
                                        @foreach($categories AS $item)
                                            <option value='{{$item->id}}' {{(isset($filter['category_id']) and $filter['category_id']==$item->id) ? 'selected=selected': ''}}>
                                                {{$item->name_category}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>

                        @include('layouts.button-from-table', ['route_cancel' => route('resource.get.resource'), 'new'=>false])
                    </form>
                </div>
            </div>
        </div>

        <!-- Listado de documentos PDF -->
        <div class="row">
            @if(count($documents) <= 0)
                @include('layouts.alert_warning', ['message' => 'No se encontraron documentos PDF disponibles'])
            @else
                <div class="col-12">
                    <div class="card card-purple">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-file-pdf mr-2"></i> DOCUMENTOS PDF
                                <span class="badge badge-info ml-2">{{ $documents->total() }} total</span>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">

                            <div class="card-body pb-0">
                                <div class="row">
                                    @foreach($documents AS $item)
                                        @php
                                            // Determinar clases según el estado y tipo de acceso
                                            $statusClass = $item->is_active == 1 ? 'bg-success' : 'bg-warning';
                                             $statusDonwload = $item->total_download > 0 ? 'bg-success' : 'bg-danger';
                                             $donwload = $item->total_download > 0 ? $item->total_download : 0;
                                        @endphp
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch flex-column">
                                            <div class="card bg-light d-flex flex-fill">
                                                <div class="card-header text-muted border-bottom-0">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <small>
                                                            <i class="far fa-calendar-alt"></i> {{ date('d/m/Y', strtotime($item->created_at)) }}
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            {{-- Icono PDF destacado --}}
                                                            <div class="text-center mb-3 mt-2">
                                                                <i class="fas fa-file-pdf" style="font-size: 4rem; color: #dc3545;"></i>
                                                            </div>

                                                            <h5 class="text-center"><b>{{ $item->name }}</b></h5>

                                                            <p class="text-muted text-sm">
                                                                <i class="fas fa-tag"></i> <b>Categoría:</b> {{ tranform_string($item->category_name) }}
                                                            </p>

                                                            <p class="text-muted text-sm">
                                                                <i class="fas fa-book-open"></i> <b>Descripción:</b> {!! Str::limit($item->description, 255) !!}
                                                            </p>

                                                            {{-- Estado del documento --}}
                                                            <p class="text-muted text-sm">
                                                                <i class="fas fa-circle" style="color: {{ $item->is_active == 1 ? '#28a745' : '#ffc107' }}"></i>
                                                                <b>Estado:</b> <span class="badge {{ $statusClass }}"> {{status_register($item->is_active)}} </span>
                                                            </p>

                                                            {{-- Contador de descargas --}}
                                                            <p class="text-muted text-sm">
                                                                <i class="fas fa-download"></i> <b>Descargas:</b> <span class="badge {{$statusDonwload}}" style="font-size: 15px;">{{$donwload}}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="text-right">
                                                        <a class="btn btn-sm btn-outline-primary download-button" data-url="{{route('resource.download.resource', ['id'=>encrypt($item->id)])}}" title="Descargar PDF">
                                                            <i class="fas fa-download"></i> Descargar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @include('layouts.paginate', ['variable' => $documents])

                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            @endif
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('script')
    @include('admin.resource_manager.function-resource-manager')
@endsection
