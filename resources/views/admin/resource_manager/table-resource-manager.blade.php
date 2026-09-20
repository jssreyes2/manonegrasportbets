@extends('layouts.app-backend')

@section('content')

    <div id="form-modal"></div>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Gestor de Recursos</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="card card-purple card-outline">

                    <form role="form">
                        <div class="card-body">
                            <div class="row">
                                @include('layouts.search', [$filter])
                            </div>
                        </div>

                        @include('layouts.button-from-table', ['route_cancel' => route('resource.index'), 'new'=>true])
                    </form>
                </div>
            </div>
        </div>

        <div class="row">

            @if(count($resources)<=0)
                @include('layouts.alert_warning')
            @else

                <div class="col-12">
                    <div class="card card-purple">
                        <div class="card-header">
                            <h3 class="card-title">ARCHIVOS</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">

                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th style="width: 10%!important; text-align: center">Acciones</th>
                                    <th>Categoría</th>
                                    <th>Nombre</th>
                                    <th style="text-align: center">Descargas</th>
                                    <th>Status</th>
                                    <th>Creación</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($resources AS $item)

                                    @php
                                        $classStatus = $item->is_active == 1 ? 'bg-success' : 'bg-danger';
                                        $donwload = $item->total_download > 0 ? $item->total_download : 0;
                                        $statusDonwload = $item->total_download > 0 ? 'bg-success' : 'bg-danger';
                                    @endphp

                                    <tr>
                                        <td style="text-align: center">

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-block btn-outline-secondary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item edit_form" data-id="{{$item->id}}" data-url="{{route('resource.edit')}}">Modificar</a>
                                                    <a class="dropdown-item confirm_action" href="javascript:void(0)" data-id="{{$item->id}}" data-name="{{route('resource.destroy')}}">Eliminar</a>
                                                </div>
                                            </div>

                                        </td>

                                        <td>{{tranform_string($item->category_name)}}</td>
                                        <td>{{tranform_string($item->name)}} <a href="{{Storage::url($item->path_file)}}" target="_blank"><i class="fa fas fa-file-pdf"></i></a></td>
                                        <td style="text-align: center"><span class="badge {{$statusDonwload}}">{{$donwload}}</span></td>

                                        <td>
                                            <span class="badge {{$classStatus}}">{{status_register($item->is_active)}}</span>
                                        </td>

                                        <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                            @include('layouts.paginate', ['variable' => $resources])

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

@section('script')
    @include('admin.global_script.function-form-modal', ['route' => route('resource.create')])
    @include('admin.resource_manager.function-resource-manager')
@endsection
