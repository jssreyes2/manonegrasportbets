@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/style-frm-login-admin.css') }}">
@endsection

@section('content')
    <div class="login-wrapper" style="width: 400px;">
        <div class="card formulario">
            <div class="card-header">
                <h3 class="title">
                <span class="icono-login">
                    <i class="fas fa-user-astronaut"></i>
                </span>
                    {{__t('text.frontend.login_customer_authentication', 'AUTHENTICATION')}}
                </h3>
                <p class="subtitle">La Mano Negra</p>
            </div>
            <div class="card-body">
                <form action="" id="login" method="post">
                    @csrf

                    <!-- Campo Email -->
                    <div class="input-group mb-3">
                        <input type="email" id="email" name="email" class="form-control required email" placeholder="{{__t('text.backend.forms.email', 'Email')}}" autocomplete="off">
                        <span class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </span>
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control required" placeholder="{{__t('text.backend.forms.password', 'Password')}}" autocomplete="off">
                        <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                    </div>

                    <!-- Botón y Loading -->
                    <div class="row g-0">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btn-login">
                                <i class="fas fa-arrow-right-to-bracket me-2"></i>
                                {{__t('text.frontend.login_customer_authenticate', 'Authenticate and Access')}}
                            </button>
                        </div>

                        <div id="loading_form" class="loading-container" style="display: none;">
                            <div class="spinner"></div>
                        </div>
                    </div>
                </form>

{{--                <!-- Enlaces adicionales -->--}}
{{--                <div class="footer-links">--}}
{{--                    <a href="#"><i class="far fa-question-circle me-1"></i> ¿Olvidaste tu contraseña?</a>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        $("body").on('submit', '#login', function (event) {
            event.preventDefault()
            if ($('#login').valid()) {

                var formData = new FormData(document.getElementById("login"));
                formData.append("source", "admin");
                $('#loading_form').css('display', 'flex');

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "POST",
                    url: "{{ route('verify.authenticate') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    data: formData,
                    beforeSend: function () {
                        $(':button').prop('disabled', true);
                    },
                    success: function (response) {

                        if (response.status == 'success') {
                            toastr.success(response.message)

                            setTimeout(function () {
                                window.location.href = "{{route('admin.panel')}}";
                            }, 1000);
                        }

                        if (response.status == 'fail') {
                            $(':button').prop('disabled', false);
                            $('#loading_form').hide();
                            toastr.error(response.message)
                        }
                    }
                });
            }
        });
    </script>
@endsection
