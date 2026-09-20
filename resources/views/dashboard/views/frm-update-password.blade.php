@extends('layouts.app-backend')
@section('title', __t('text.backend.messages.update_login_details', 'Actualizar datos de acceso'))
@section('content')
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">

                    <form role="form" id="update-password">

                        <div class="card-body">

                            <div class="row">

                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="alert alert-warning alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h5><i class="icon fas fa-exclamation-triangle"></i> ¡{{__t('text.backend.messages.attention', 'Atención')}}!</h5>
                                        {{__t('text.backend.messages.notification_change_email', 'Al cambiar tu correo electrónico, la sesión se cerrará automáticamente. Te enviaremos un mensaje de verificación a tu nueva dirección; una vez confirmado, podrás volver a iniciar sesión con los cambios aplicados.')}}
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="email">{{__t('text.backend.forms.email', 'Correo electrónico')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control required email" id="email" name="email"
                                           maxlength="50" autocomplete="off"
                                           value='{{(isset($user) ? $user->email : '')}}'>
                                </div>

                                <!-- Password -->
                                <div class="form-group col-lg-6 col-md-4 col-sm-6 col-12">
                                    <label for="password">{{__t('text.backend.forms.password', 'Contraseña')}}  <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control required" id="password"
                                           name="password" maxlength="10" autocomplete="off">
                                </div>

                            </div>

                            <!-- Botón de envío -->
                            @include('layouts.button-from-modal', ['route_cancel' => route('subscription'), 'colLg' => 'col-lg-1'])
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('script')
    @include('dashboard.views.function-update-password')
@endsection