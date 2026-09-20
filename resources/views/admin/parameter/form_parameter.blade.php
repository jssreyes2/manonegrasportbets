@extends('layouts.app-backend')
@section('title', 'Parámetros')
@section('content')

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="card card-teal card-outline">

                    <form role="form" id="parameter" enctype="multipart/form-data">

                        @if(isset($parameter))
                            <input type="hidden" id="route_frm" name="route_frm" value='{{route('parameter.update')}}'>
                            <input type="hidden" id="id" name="id" value='{{(isset($parameter) ? $parameter->id : '')}}'>
                        @else
                            <input type="hidden" id="route_frm" name="route_frm" value='{{route('parameter.store')}}'>
                        @endif

                        <div class="card-body">

                            <div class="row">

                                @if(!empty($parameter->logo_path))
                                    <div class="row">
                                        <div class="form-group col-3">
                                            <img src="{{ url('storage/company/' . $parameter->logo_path) }}"
                                                 style="width: 100px!important; height: auto!important; max-width: 200px!important; max-height: 200px!important; border-radius: 50px!important;">
                                        </div>
                                    </div>
                                @endif

                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
                                        <label for="identification">Rif <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control required" id="identification" name="identification" maxlength="50" autocomplete="off" value='{{(isset($parameter) ? $parameter->identification : '')}}'>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
                                        <label for="company">Empresa <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control required" id="company" name="company" maxlength="50" autocomplete="off" value='{{(isset($parameter) ? $parameter->company : '')}}'>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
                                        <label for="phone">Teléfono <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control required input_number" id="phone" name="phone" maxlength="50" autocomplete="off" value='{{(isset($parameter) ? $parameter->phone : '')}}'>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
                                        <label for="email">Correo electrónico <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control required email" id="email" name="email" maxlength="191" autocomplete="off"
                                               value='{{(isset($parameter) ? $parameter->email : '')}}'>
                                    </div>

                                    <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                        <label for="social_network_facebook">Facebook</label>
                                        <input type="text" class="form-control" id="social_network_facebook" name="social_network_facebook" maxlength="191" autocomplete="off"
                                               value='{{(isset($parameter) ? $parameter->social_network_facebook : '')}}'>
                                    </div>

                                    <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                        <label for="social_network_tiktok">Tiktok</label>
                                        <input type="text" class="form-control" id="social_network_tiktok" name="social_network_tiktok" maxlength="191" autocomplete="off"
                                               value='{{(isset($parameter) ? $parameter->social_network_tiktok : '')}}'>
                                    </div>

                                    <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                        <label for="social_network_instagram">Instagram</label>
                                        <input type="text" class="form-control" id="social_network_instagram" name="social_network_instagram" maxlength="191" autocomplete="off"
                                               value='{{(isset($parameter) ? $parameter->social_network_instagram : '')}}'>
                                    </div>

                                    <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                        <label for="address">Dirección <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control required" id="address" name="address" maxlength="191" autocomplete="off" value='{{(isset($parameter) ? $parameter->address : '')}}'>
                                    </div>

                                </div>

                                <div class="row form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                    <div id="previewContainer"></div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="photo" name="photo">
                                                <label class="custom-file-label" for="photo" data-browse="Buscar">Seleccione el logo</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                        <div id="image-preview-container" class="mt-2"></div>
                                    </div>
                                </div>

                            </div>

                            @include('layouts.button-from-modal', ['route_cancel' => route('parameter.index'), 'colLg' => 'col-lg-1'])

                        </div>

                    </form>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection

@section('script')
    @include('admin.parameter.function_parameter')
@endsection
