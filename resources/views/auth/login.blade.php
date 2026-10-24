@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/style-frm-login-admin.css') }}">
@endsection

@section('content')
    <div class="lg-shell">
        <aside class="lg-brand">
            <a href="{{ route('show.principal') }}" class="lg-logo">
                <img src="{{ asset('img/logo.png') }}" alt="">
                <span>La Mano <b>Negra</b></span>
            </a>

            <div class="lg-headline">
                <span class="lg-eyebrow">Panel de administración</span>
                <h2>Todo tu negocio de <span>picks</span> en un solo lugar.</h2>
                <p>Publica jugadas, califica resultados y controla suscripciones y pagos.</p>
            </div>

            <ul class="lg-features">
                <li><i class="fas fa-futbol"></i> Picks y calificación de resultados</li>
                <li><i class="fas fa-id-card"></i> Suscripciones y seguro del apostador</li>
                <li><i class="fas fa-chart-line"></i> Pagos y reportes de clientes</li>
            </ul>
        </aside>

        <main class="lg-main">
            <div class="lg-card">
                <div class="lg-card-logo">
                    <a href="{{ route('show.principal') }}" class="lg-logo">
                        <img src="{{ asset('img/logo.png') }}" alt="">
                        <span>La Mano <b>Negra</b></span>
                    </a>
                </div>

                <h1>Iniciar sesión</h1>
                <p class="lg-sub">Acceso exclusivo para el equipo administrativo.</p>

                <div class="lg-alert" id="login-alert" role="alert">
                    <i class="fas fa-exclamation-circle mt-1"></i>
                    <span></span>
                </div>

                <form action="" id="login" method="post" novalidate>
                    @csrf

                    <div class="lg-field">
                        <label for="email">Correo electrónico</label>
                        <div class="lg-input">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" class="form-control required email" placeholder="nombre@correo.com" autocomplete="username" autofocus>
                        </div>
                    </div>

                    <div class="lg-field">
                        <label for="password">Contraseña</label>
                        <div class="lg-input">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" name="password" class="form-control required" placeholder="••••••••" autocomplete="current-password">
                            <button type="button" class="lg-toggle" id="toggle-password" aria-label="Mostrar contraseña">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="lg-submit" id="btn-login">
                        <span class="lg-spinner"></span>
                        <i class="fas fa-sign-in-alt mr-2 lg-icon"></i>
                        <span class="lg-label">Ingresar al panel</span>
                    </button>
                </form>

                <a href="{{ route('show.principal') }}" class="lg-back"><i class="fas fa-arrow-left"></i> Volver al sitio</a>

                <p class="lg-foot">&copy; {{ date('Y') }} La Mano Negra</p>
            </div>
        </main>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            const $form = $('#login');
            const $btn = $('#btn-login');
            const $alert = $('#login-alert');

            $form.validate({
                errorPlacement: function (error, element) {
                    error.insertAfter(element.closest('.lg-input'));
                },
                messages: {
                    email: {required: 'Ingresa tu correo electrónico.', email: 'Ingresa un correo válido.'},
                    password: {required: 'Ingresa tu contraseña.'}
                }
            });

            $('#toggle-password').on('click', function () {
                const $input = $('#password');
                const show = $input.attr('type') === 'password';
                $input.attr('type', show ? 'text' : 'password');
                $(this).attr('aria-label', show ? 'Ocultar contraseña' : 'Mostrar contraseña')
                    .find('i').toggleClass('fa-eye', !show).toggleClass('fa-eye-slash', show);
            });

            function setLoading(loading) {
                $btn.prop('disabled', loading).toggleClass('is-loading', loading);
                $btn.find('.lg-label').text(loading ? 'Verificando…' : 'Ingresar al panel');
            }

            function showError(message) {
                $alert.find('span').text(message);
                $alert.addClass('show');
            }

            $form.on('submit', function (event) {
                event.preventDefault();
                $alert.removeClass('show');

                if (!$form.valid()) {
                    return;
                }

                const formData = new FormData(this);
                formData.append('source', 'admin');

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    url: "{{ route('verify.authenticate') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    data: formData,
                    beforeSend: function () {
                        setLoading(true);
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            $btn.find('.lg-label').text('Entrando…');
                            window.location.href = "{{ route('admin.panel') }}";
                            return;
                        }

                        setLoading(false);

                        if (response.error_time) {
                            showError('Demasiados intentos. Espera un momento antes de volver a intentarlo.');
                            return;
                        }

                        showError(response.message || 'Correo electrónico o contraseña incorrectos.');
                    },
                    error: function (xhr) {
                        setLoading(false);

                        if (xhr.status === 419) {
                            showError('La sesión expiró. Recarga la página e intenta de nuevo.');
                            return;
                        }

                        showError('No se pudo conectar con el servidor. Intenta de nuevo.');
                    }
                });
            });
        });
    </script>
@endsection
