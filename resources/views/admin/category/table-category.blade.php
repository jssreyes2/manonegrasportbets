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
                        <li class="breadcrumb-item"><a href="#">Categorías</a></li>
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
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="destination">Destino *</label>
                                    <select class='form-control' id='destination' name="filter[destination]">
                                        <option value='{{\App\Models\Category::DESTINATION_WEB}}' {{(isset($filter['destination']) and $filter['destination']==\App\Models\Category::DESTINATION_WEB) ?  'selected': ''}}>
                                            {{\App\Models\Category::DESTINATION_WEB}}
                                        </option>

                                        <option value='{{\App\Models\Category::DESTINATION_BACKEND}}' {{(isset($filter['destination']) and $filter['destination']==\App\Models\Category::DESTINATION_BACKEND) ?  'selected': ''}}>
                                            {{\App\Models\Category::DESTINATION_BACKEND}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @include('layouts.button-from-table', ['route_cancel' => route('category.index'), 'new'=>true])
                    </form>
                </div>
            </div>
        </div>

        <div class="row">

            @if(count($categories)<=0)
                @include('layouts.alert_warning')
            @else

                <div class="col-12">
                    <div class="card card-purple">
                        <div class="card-header">
                            <h3 class="card-title">CATEGORÍAS</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">

                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th style="width: 10%!important; text-align: center">Acciones</th>
                                    <th>Nombre</th>
                                    <th>Slug</th>
                                    <th>Destino</th>
                                    <th>Status</th>
                                    <th>Creación</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories AS $item)

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
                                                    <a class="dropdown-item edit_form" data-id="{{$item->id}}" data-url="{{route('category.edit')}}">Modificar</a>
                                                    <a class="dropdown-item confirm_action" href="javascript:void(0)" data-id="{{$item->id}}" data-name="{{route('category.destroy')}}">Eliminar</a>
                                                </div>
                                            </div>

                                        </td>

                                        <td>{{$item->name_category}}</td>
                                        <td>{{$item->source}}</td>
                                        <td>{{$item->destination}}</td>

                                        <td>
                                            <span class="badge {{$classStatus}}">{{status_register($item->is_active)}}</span>
                                        </td>

                                        <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                            @include('layouts.paginate', ['variable' => $categories])

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
    @include('admin.global_script.function-form-modal', ['route' => route('category.create')])
    @include('admin.category.function-category')
@endsection
