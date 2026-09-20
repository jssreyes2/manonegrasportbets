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
                        <li class="breadcrumb-item"><a href="#">Productos</a></li>
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

                    <form role="form" id="frm-search">
                        <div class="card-body">
                            <div class="row">
                                @include('layouts.search', [$filter])

                                <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                    <label for="type">Categoría </label>
                                    <select class='form-control required select2' id='category_id' name="filter[category_id]">
                                        <option value=''>
                                            Seleccione...
                                        </option>
                                        @foreach($categories AS $item)
                                            <option value='{{$item->id}}' {{(isset($filter['category_id']) and $filter['category_id']==$item->id) ?  'selected=selected': ''}}>
                                                {{$item->name_category}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Sub-Categorias -->
                                <div class="form-group col-lg-4 col-md-12 col-sm-12 col-12">
                                    <label for="subcategory_id">Subcategorías</label>
                                    <div class="select2-purple">
                                        <select class='form-control required select2' id='subcategory_id' name="filter[subcategory_id]">
                                            <option value=''>
                                                Seleccione una categoría primero...
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                    <label for="price">Precio </label>
                                    <select class='form-control required' id='price' name="filter[price]">
                                        <option value=''>
                                            Seleccione...
                                        </option>

                                        <option value='500' {{(isset($filter['price']) and $filter['price']==500) ?  'selected=selected': ''}}>
                                            Menor a 500
                                        </option>

                                        <option value='600' {{(isset($filter['price']) and $filter['price']==600) ?  'selected=selected': ''}}>
                                            Mayor a 500
                                        </option>

                                    </select>
                                </div>

                                @if($rolAdmin|| $rolSeller)
                                    <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                        <label for="is_approved">Tipo de publicación</label>
                                        <select class='form-control' id='is_approved' name="filter[is_approved]">
                                            <option value=''>Seleccione...</option>
                                            <option value='1' {{ (array_key_exists('is_approved', $filter) && $filter['is_approved'] === '1') ? 'selected' : '' }}>
                                                Productos aprobados
                                            </option>
                                            <option value='0' {{ (array_key_exists('is_approved', $filter) && $filter['is_approved'] === '0') ? 'selected' : '' }}>
                                                Productos por aprobar
                                            </option>
                                        </select>
                                    </div>
                                @endif

                            </div>
                        </div>

                        @include('layouts.button-from-table', ['route_cancel' => $routeBack, 'new'=>false])

                    </form>
                </div>
            </div>
        </div>

        <div class="row">

            @if(count($products)<=0)
                @include('layouts.alert_warning')
            @else

                <div class="col-12">
                    <div class="card card-purple">
                        <div class="card-header">
                            <h3 class="card-title">PRODUCTOS</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <div class="card card-solid">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        @foreach($products AS $item)

                                            @php
                                                $classStatus = $item->is_active == 1 ? 'bg-success' : 'bg-danger';
                                                $classIsApproved = $item->is_approved == 1 ? 'bg-success' : 'bg-danger';

                                                $textIsApproved = $item->is_approved == 1 ? 'Aprobado' : 'Por aprobar';
                                            @endphp
                                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                                <div class="card bg-light d-flex flex-fill">
                                                    <div class="card-header text-muted border-bottom-0">
                                                        Creado: {{date('d/m/Y', strtotime($item->created_at))}}
                                                    </div>
                                                    <div class="card-body pt-0">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="lead"><b>{{capitalize_first($item->first_name.' '.$item->last_name)}}</b></h2>
                                                                <p class="text-muted text-sm"><b>Nombre: </b> {{$item->name_prod}} </p>
                                                                <p class="text-muted text-sm"><b>Estatus: </b>
                                                                    <span class="badge {{$classStatus}}">{{status_register($item->is_active)}}</span>
                                                                    @if($rolAdmin || $rolSeller)
                                                                        / <span class="badge {{$classIsApproved}}">{{$textIsApproved}}</span>
                                                                    @endif
                                                                </p>

                                                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fas fa-hashtag"></i></span> Código: {{$item->short_code}}</li>
                                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa fa-briefcase"></i></span> Categoría: {{capitalize_first($item->category_name)}}</li>
                                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-book"></i></span> Subcategoría: {{capitalize_first($item->subcategory_name)}}</li>
                                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-dollar-sign"></i></span>Precio: <span class="badge bg-info" style="font-size: 13px">{{$item->price}}</span></li>

                                                                    {{-- Un solo li para todas las estrellas --}}
                                                                    <li class="small">
                                                                        {!! showStar($item->punctuation) !!}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-5 text-center">

                                                                @if(!empty($rolCustomer))
                                                                    <a href="{{route('product.detail', ['id' =>encrypt($item->id), 'back' => encrypt($back)])}}" title="Ver detalle del producto">
                                                                        <img src="{{ getImageUrl('products/'.$item->id, $item->photo) }}" class="img-circle img-fluid img-photo">
                                                                    </a>
                                                                @else
                                                                    <img src="{{ getImageUrl('products/'.$item->id, $item->photo) }}" class="img-circle img-fluid img-photo">
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="text-right">

                                                            @if(!empty($rolAdmin))
                                                                <a class="btn btn-sm btn-outline-info" href="{{route('product.detail', ['id' =>encrypt($item->id), 'back' => encrypt($back)])}}"><i class="fas fa-search"></i> Ver</a>
                                                            @endif

                                                            @if(!empty($rolSeller))
                                                                <a class="btn btn-sm btn-outline-danger confirm_action" href="javascript:void(0)" data-id="{{$item->id}}" data-name="{{route('user.destroy.product')}}"><i class="fas fa-trash"></i>
                                                                    Eliminar</a>
                                                                <a class="btn btn-sm btn-outline-primary" href="{{route('user.edit.product', ['id'=>encrypt($item->id)])}}"><i class="fas fa-pencil"></i> Modificar</a>
                                                                <a class="btn btn-sm btn-outline-info" href="{{route('product.detail', ['id' =>encrypt($item->id), 'back' => encrypt($back)])}}"><i class="fas fa-search"></i> Ver</a>
                                                            @endif

                                                            @if(!empty($rolCustomer))
                                                                <a class="btn btn-sm btn-outline-success" href="{{route('product.shopping', ['id' =>encrypt($item->id), 'back' => encrypt($back)])}}"><i class="fas fa-shopping-cart"></i> Comprar</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            @include('layouts.paginate', ['variable' => $products])

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
    @include('admin.product.function-product')
@endsection
