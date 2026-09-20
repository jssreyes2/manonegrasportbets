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
                        <li class="breadcrumb-item"><a href="#">Contenido Banner</a></li>
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
                        <div class="col-12 col-md-6 col-lg-1 mb-2" style="padding: 10px;">
                            <button type="button" class="btn btn-block btn-outline-success new_form"><i class="fas fa-check-circle"></i> Nuevo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">

            @if(count($contentsBanner)<=0)
                @include('layouts.alert_warning')
            @else

                <div class="col-12">
                    <div class="card card-purple">
                        <div class="card-header">
                            <h3 class="card-title">BANNERS</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">

                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th style="width: 10%!important; text-align: center">Acciones</th>
                                    <th>Foto</th>
                                    <th>Nombre</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center;">Orden</th>
                                    <th>Creación</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($contentsBanner AS $item)

                                    @php
                                        $classStatus = $item->is_active == 1 ? 'bg-success' : 'bg-danger';

                                    @endphp

                                    <tr>
                                        <td style="text-align: center">

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-block btn-outline-secondary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item edit_form" data-id="{{$item->id}}" data-url="{{route('content.banner.edit')}}">Modificar</a>
                                                    <a class="dropdown-item confirm_action" href="javascript:void(0)" data-id="{{$item->id}}" data-name="{{route('content.banner.destroy')}}">Eliminar</a>
                                                </div>
                                            </div>

                                        </td>

                                        <td>
                                            <div class="image">
                                                @if($item->photo)
                                                    <img src="{{ url('storage/photo_page/banner/' . $item->photo) }}" style="height: 50px; object-fit: cover">
                                                @else
                                                    <img src="{{asset('img/logo.png')}}" class="img-circle elevation-2" style="width: 30px; height: 30px; object-fit: cover">
                                                @endif

                                            </div>
                                        </td>

                                        <td>{{tranform_string($item->name)}}</td>

                                        <td style="text-align: center;">
                                            <span class="badge {{$classStatus}}">{{status_register($item->is_active)}}</span>
                                        </td>

                                        <td style="text-align: center;">
                                            <span class="badge bg-info">{{$item->orden_photo}}</span>
                                        </td>

                                        <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                            @include('layouts.paginate', ['variable' => $contentsBanner])

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
    @include('admin.global_script.function-form-modal', ['route' => route('content.banner.create')])
    @include('admin.web_content.static_page.function-content-banner')
@endsection
