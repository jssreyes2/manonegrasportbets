@extends('layouts.app-backend')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Producto</a></li>
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
                    <div class="card-header with-border">
                        <h3 class="box-title">Producto</h3>
                    </div>

                    <form role="form" id="frm-product">

                        @if(isset($product))
                            <input type="hidden" id="route" name="route" value='{{route('user.update.product')}}'>
                            <input type="hidden" id="id" name="id" value='{{(isset($product) ? $product->id : '')}}'>
                        @else
                            <input type="hidden" id="route" name="route" value='{{route('user.store.product')}}'>
                        @endif

                        <div class="card-body">
                            <div class="row">

                                @if($product->photo ?? false)
                                    <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                        <img src="{{ getImageUrl('products/'.$product->id, $product->photo) }}" class="img-circle img-fluid img-photo">
                                    </div>
                                @endif

                                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                    <label for="name_prod">Nombre *</label>
                                    <input type="text" class="form-control required input_string" id="name_prod" name="name_prod" maxlength="200" autocomplete="off" value='{{(isset($product) ? $product->name_prod : '')}}'>
                                </div>

                                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                    <label for="description_prod">Descripción *</label>
                                    <div id="summernote-wrapper">
                                        <textarea id="summernote" name="description_prod" class="summernote" required>{{(isset($product) ? $product->description_prod : '')}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="type">Categoría *</label>
                                    <select class='form-control inputform select2' id='category_id' name="category_id" required>
                                        <option value=''>
                                            Seleccione...
                                        </option>
                                        @foreach($categories AS $item)
                                            <option value='{{$item->id}}' {{(isset($product->category_id) and $product->category_id==$item->id) ?  'selected=selected': ''}}>
                                                {{$item->name_category}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Sub-Categorias -->
                                <div class="form-group col-lg-6 col-md-12 col-sm-12 col-12">
                                    <label for="subcategory_id">Subcategorías</label>
                                    <div class="select2-purple">
                                        <select class='form-control inputform select2' id='subcategory_id' name="subcategory_id" required>
                                            <option value=''>
                                                Seleccione una categoría primero...
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    @include('layouts.select_is_active', ['item' =>$product ?? null])
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="price">Precio *</label>
                                    <input type="text" class="form-control required input_number" id="price" name="price" maxlength="200" autocomplete="off" value='{{(isset($product) ? $product->price : '')}}'>
                                </div>
                            </div>

                            <div class="row div_photo_content">
                                <div class="row form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div id="previewContainer"></div>
                                </div>
                            </div>

                            <div class="row div_photo_content">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="photo">Foto referencial de tu producto</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="photo" name="photo">
                                            <label class="custom-file-label" for="photo" data-browse="Buscar">Seleccionar archivo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row div_photo_content">
                                <!-- Contenedor de vista previa -->
                                <div class="form-group col-lg-6 col-md-8 col-sm-12 col-12">
                                    <div id="image-preview-container" class="mt-2"></div>
                                </div>
                            </div>

                        </div>

                        @include('layouts.button-from-modal', ['route_cancel' => route('user.get.products'), 'colLg' => 'col-lg-1'])
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    @include('admin.product.function-product')
    @include('layouts.function-summernote')
@endsection