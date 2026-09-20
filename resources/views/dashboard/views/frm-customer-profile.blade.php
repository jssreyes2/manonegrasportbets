@extends('layouts.app-backend')
@section('title', __t('text.backend.messages.user_profile', 'Perfil Usuario'))
@section('content')


    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <form role="form" id="customer-profile" enctype="multipart/form-data">

                        <div class="card-body">

                            @if(!$user->completed_profile)
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> {{__t('text.backend.messages.warning', 'Advertencia')}}!</h5>
                                    {{__t('text.backend.messages.warning_description', 'Por favor complete su perfil para poder acceder a todas las funcionalidades.')}}
                                </div>
                            @endif

                            <div class="row">
                                <div class="form-group col-md-3 col-sm-6 col-12">
                                    <img src="{{ getImageUrl('users/'.$user->id, $user->photo) }}" class="img-circle img-fluid img-photo" style="width: 100px">
                                </div>
                            </div>

                            <div class="row">
                                <!-- Nombres -->
                                <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                    <label for="first_name">{{__t('text.backend.forms.names', 'Nombres')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control required input_string" id="first_name" name="first_name"
                                           maxlength="50" autocomplete="off"
                                           value='{{(isset($user) ? $user->first_name : '')}}'>
                                </div>

                                <!-- Apellidos -->
                                <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                    <label for="last_name">{{__t('text.backend.forms.surnames', 'Apellidos')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control required input_string" id="last_name" name="last_name"
                                           maxlength="50" autocomplete="off"
                                           value='{{(isset($user) ? $user->last_name : '')}}'>
                                </div>

                                <!-- Teléfono -->
                                <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                    <label for="phone">{{__t('text.backend.forms.phone', 'Teléfono')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control required input_number" id="phone"
                                           name="phone" maxlength="50" autocomplete="off"
                                           value='{{(isset($user) ? $user->phone : '')}}' placeholder="4245698525">
                                </div>
                                
                                <!-- Paises -->
                                <div class="form-group col-lg-4 col-md-12 col-sm-12 col-12">
                                    <label for="country_id">{{__t('text.backend.forms.country', 'País')}}</label>
                                    <select class='form-control required inputform select2' id='country_id' name="country_id">
                                        <option value=''>
                                            {{__t('text.backend.forms.select', 'Seleccione...')}}
                                        </option>
                                        @foreach($countries AS $key =>$name)
                                            <option value='{{$key}}' {{(isset($user->country_id) and $user->country_id==$key) ?  'selected=selected': ''}}>
                                                {{$name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <!-- Vista previa de imagen -->
                            <div class="row">
                                <div class="form-group col-12">
                                    <div id="previewContainer" class="mt-2"></div>
                                </div>
                            </div>

                            <!-- Subir foto -->
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-8 col-sm-12 col-12">
                                    <label for="photo">{{__t('text.backend.forms.photo', 'Foto')}}</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="photo" name="photo" accept=".jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="photo" data-browse="Buscar">
                                                {{__t('text.backend.forms.select', 'Seleccione...')}}
                                            </label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        {{__t('text.backend.messages.formats_image', 'Formatos aceptados: JPG, PNG, JPEG. Tamaño máximo: 1MB')}}
                                    </small>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Contenedor de vista previa -->
                                <div class="form-group col-lg-4 col-md-8 col-sm-12 col-12">
                                    <div id="image-preview-container" class="mt-2"></div>
                                </div>
                            </div>

                        </div>

                        <!-- Botón de envío -->
                        @include('layouts.button-from-modal', ['route_cancel' => route('subscription'), 'colLg' => 'col-lg-1'])
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('script')
    @include('admin.user.function-profile')
@endsection