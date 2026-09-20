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
                        <li class="breadcrumb-item"><a href="#">Perfil de usuario</a></li>
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
                        <h3 class="box-title">Perfil de usuario</h3>
                    </div>

                    <form role="form" id="profile" enctype="multipart/form-data">
                        <div class="card-body">
                            @if(!$user->completed_profile)
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Advertencia!</h5>
                                    Por favor complete su perfil para poder acceder a todas las funcionalidades.
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-12">
                                    <div class="card card-purple card-tabs">
                                        <div class="card-header p-0 pt-1">
                                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">
                                                        Datos personales
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">
                                                        Datos de tu formación
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">
                                                        Cuéntanos un poco de tí
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                                <!-- Tab 1: Datos personales -->
                                                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                                    <div class="row">
                                                        <div class="form-group col-md-3 col-sm-6 col-12">
                                                            <img src="{{ getImageUrl('users/'.$user->id, $user->photo) }}" class="img-circle img-fluid img-photo">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <!-- Cédula -->
                                                        <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                                            <label for="identification">Cédula <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required" id="identification" name="identification"
                                                                   maxlength="50" autocomplete="off"
                                                                   value='{{(isset($user) ? $user->identification : '')}}'>
                                                        </div>

                                                        <!-- Nombres -->
                                                        <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                                            <label for="first_name">Nombres <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required" id="first_name" name="first_name"
                                                                   maxlength="50" autocomplete="off"
                                                                   value='{{(isset($user) ? $user->first_name : '')}}'>
                                                        </div>

                                                        <!-- Apellidos -->
                                                        <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                                            <label for="last_name">Apellidos <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required" id="last_name" name="last_name"
                                                                   maxlength="50" autocomplete="off"
                                                                   value='{{(isset($user) ? $user->last_name : '')}}'>
                                                        </div>

                                                        <!-- Teléfono -->
                                                        <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                                            <label for="phone">Teléfono <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required input_number" id="phone"
                                                                   name="phone" maxlength="50" autocomplete="off"
                                                                   value='{{(isset($user) ? $user->phone : '')}}'>
                                                        </div>

                                                        <!-- Correo Electrónico -->
                                                        <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                                            <label for="email">Correo electrónico <span class="text-danger">*</span></label>
                                                            <input type="email" class="form-control required" id="email" name="email"
                                                                   maxlength="50" autocomplete="off"
                                                                   value='{{(isset($user) ? $user->email : '')}}'>
                                                        </div>

                                                        <!-- Paises -->
                                                        <div class="form-group col-lg-4 col-md-12 col-sm-12 col-12">
                                                            <label for="country_id">País</label>
                                                            <select class='form-control required inputform select2' id='country_id' name="country_id">
                                                                <option value=''>Seleccione...</option>
                                                                @foreach($countries AS $key => $name)
                                                                    <option value='{{$key}}' {{(isset($user->country_id) and $user->country_id==$key) ? 'selected=selected': ''}}>
                                                                        {{$name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Dirección -->
                                                        <div class="form-group col-12">
                                                            <label for="address">Dirección <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required" id="address" name="address"
                                                                   maxlength="191" autocomplete="off"
                                                                   value='{{(isset($user) ? $user->address : '')}}'>
                                                        </div>
                                                    </div>

                                                    <!-- Vista previa de imagen -->
                                                    <div class="row">
                                                        <div class="row form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                                            <div id="previewContainer"></div>
                                                        </div>
                                                    </div>

                                                    <!-- Subir foto -->
                                                    <div class="row">
                                                        <div class="row form-group col-lg-4 col-md-8 col-sm-12 col-12">
                                                            <label for="photo">Foto</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="photo" name="photo" accept=".jpg,.jpeg,.png">
                                                                    <label class="custom-file-label" for="photo" data-browse="Buscar">
                                                                        Seleccionar archivo
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <small class="form-text text-muted">
                                                                Formatos aceptados: JPG, PNG, JPEG. Tamaño máximo: 1MB
                                                            </small>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <!-- Contenedor de vista previa -->
                                                        <div class="form-group col-lg-6 col-md-8 col-sm-12 col-12">
                                                            <div id="image-preview-container" class="mt-2"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tab 2: Datos de tu formación -->
                                                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                                    <div class="row">
                                                        <!-- Categorias -->
                                                        <div class="form-group col-lg-4 col-md-12 col-sm-12 col-12">
                                                            <label for="category_id">Categorías</label>
                                                            <select class='form-control required inputform' id='category_id' name="category_id">
                                                                <option value=''>Seleccione...</option>
                                                                @foreach($categories AS $item)
                                                                    <option value='{{$item->id}}' {{(isset($user->category_id) and $user->category_id==$item->id) ? 'selected=selected': ''}}>
                                                                        {{$item->name_category}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Sub-Categorias -->
                                                        <div class="form-group col-lg-4 col-md-12 col-sm-12 col-12">
                                                            <label for="subcategory_id">Subcategorías</label>
                                                            <div class="select2-purple">
                                                                <select class='form-control required inputform select2' multiple="multiple" id='subcategory_id' name="subcategory_id[]">
                                                                    <option value=''>Seleccione una categoría primero...</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Profesión -->
                                                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <label for="profession">Profesión <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required" id="profession" name="profession"
                                                                   maxlength="50" autocomplete="off"
                                                                   value='{{(isset($user) ? $user->profession : '')}}'>
                                                        </div>

                                                        <!-- Idiomas -->
                                                        <div class="form-group col-lg-4 col-md-12 col-sm-12 col-12">
                                                            <label for="languages">Idiomas</label>
                                                            <div class="select2-purple">
                                                                <select class='form-control required inputform select2' multiple="multiple" id='languages' name="languages[]">
                                                                    <option value='Español' {{(isset($user) and !empty($languages) and in_array('Español', $languages)) ? 'selected=selected': ''}}>Español</option>
                                                                    <option value='Ingles' {{(isset($user) and !empty($languages) and in_array('Ingles', $languages)) ? 'selected=selected': ''}}>Ingles</option>
                                                                    <option value='Francés' {{(isset($user) and !empty($languages) and in_array('Francés', $languages)) ? 'selected=selected': ''}}>Francés</option>
                                                                    <option value='Alemán' {{(isset($user) and !empty($languages) and in_array('Alemán', $languages)) ? 'selected=selected': ''}}>Alemán</option>
                                                                    <option value='Portugués' {{(isset($user) and !empty($languages) and in_array('Portugués', $languages)) ? 'selected=selected': ''}}>Portugués</option>
                                                                    <option value='Chino' {{(isset($user) and !empty($languages) and in_array('Chino', $languages)) ? 'selected=selected': ''}}>Chino</option>
                                                                    <option value='Árabe' {{(isset($user) and !empty($languages) and in_array('Árabe', $languages)) ? 'selected=selected': ''}}>Árabe</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        @if($showInput)
                                                            <!-- Modalidad de trabajo -->
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-12">
                                                                <label for="work_modality">Modalidad trabajo *</label>
                                                                <select class='form-control' id='work_modality' name="work_modality">
                                                                    <option value='1' {{((isset($user) and $user->work_modality == 1) ? 'selected' : '')}}>Hora</option>
                                                                    <option value='2' {{((isset($user) and $user->work_modality == 2) ? 'selected' : '')}}>Proyecto</option>
                                                                </select>
                                                            </div>

                                                            <!-- Monto tasa -->
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-12">
                                                                <label for="amount">Monto<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control required input_number" id="amount"
                                                                       name="amount" maxlength="10" autocomplete="off"
                                                                       value='{{(isset($user) ? $user->amount : '')}}'>
                                                            </div>
                                                        @endif

                                                        <!-- Habilidades -->
                                                        <div class="form-group {{isset($showInput) ? 'col-lg-8' : 'col-lg-12'}} col-md-12 col-sm-12 col-12">
                                                            <label for="skills">Habilidades <span style="color: #b4b4b4">Ej: Illustrator, Photoshop, Diseño de Logos</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required" id="skills" name="skills"
                                                                   maxlength="255" autocomplete="off"
                                                                   value='{{(isset($user) ? $user->skills : '')}}'>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tab 3: Cuéntanos un poco de tí -->
                                                <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                                                    <div class="row">
                                                        @if($showInput)
                                                            <!-- Disponibilidad -->
                                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <label for="availability">Disponibilidad <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control required" id="availability" name="availability"
                                                                       maxlength="255" autocomplete="off"
                                                                       value='{{(isset($user) ? $user->availability : '')}}'>
                                                            </div>
                                                        @endif

                                                        <!-- Descripción -->
                                                        <div class="form-group col-12 summernote-container" id="summernote-wrapper">
                                                            <label for="description">Cuéntanos un poco de ti y tus proyectos <span class="text-danger">*</span></label>
                                                            <div id="summernote-wrapper">
                                                                <textarea id="summernote" name="description" class="summernote"
                                                                          data-config='{"height": 200, "minHeight": 150, "maxHeight": 400, "focus": true}'>{{(isset($user) ? $user->description : '')}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                        </div>

                        <!-- Botón de envío -->
                        @include('layouts.button-from-modal', ['route_cancel' => route('dasboard.index'), 'colLg' => 'col-lg-1'])
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('script')
    @include('admin.user.function-profile')
    @include('layouts.function-summernote')
@endsection