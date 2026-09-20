<!DOCTYPE html>
<html lang="es">
<head>
    <style>
        /* Estilos generales y reseteo para email */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #334155;
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
            -webkit-font-smoothing: antialiased;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        .email-wrapper {
            width: 100%;
            background-color: #f1f5f9;
            padding: 40px 0;
        }

        .email-container {
            max-width: 770px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.08);
            border: 1px solid #e2e8f0;
        }

        /* Estilos para el contenedor del banner */
        .header {
            /* Fondo sólido de respaldo */
            background-color: #2c3e50;
            /* Gradiente moderno */
            background: linear-gradient(135deg, #2c3e50 0%, #4a6278 100%);
            padding: 25px 20px;
            text-align: center;
            border-bottom: 4px solid #75c256;
        }

        /* Contenedor del logo */
        .logo-container {
            width: 120px;
            margin: 0 auto 10px auto;
        }

        /* Imagen del logo */
        .logo-container img {
            width: 120px !important;
            height: 120px !important;
            display: block;
            border-radius: 50%;
            border: 2px solid #ffffff; /* Borde blanco fino para que resalte más */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        /* Subtítulo */
        .logo-subtitle {
            color: #75c256; /* Mismo color verde del borde */
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 10px;
        }

        /* Contenido principal */
        .content {
            padding: 40px 35px;
        }

        .greeting {
            color: #0f172a;
            font-size: 24px;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 15px;
        }

        .info-text {
            color: #475569;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .message-box {
            background-color: #f8fafc;
            border-left: 4px solid #75c256;
            padding: 24px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
            border-top: 1px solid #f1f5f9;
            border-right: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
        }

        .message-title {
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .message-content {
            color: #334155;
            font-size: 16px;
            line-height: 1.7;
        }

        .message-content p {
            margin: 0 0 15px 0;
        }

        .message-content p:last-child {
            margin-bottom: 0;
        }

        /* Botón de acción optimizado */
        .button-container {
            text-align: center;
            margin: 30px 0;
        }

        .button {
            display: inline-block;
            padding: 14px 28px;
            background-color: #75c256;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 15px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(117, 194, 86, 0.3);
            transition: background-color 0.2s;
        }

        .button:hover {
            background-color: #65ab49;
        }

        /* Pie de página */
        .footer {
            background-color: #f8fafc;
            padding: 30px 35px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .footer-text {
            color: #64748b;
            margin: 0 0 15px 0;
            font-size: 14px;
        }

        .app-name {
            color: #0f172a;
            font-weight: 700;
        }

        .signature {
            color: #64748b;
            font-size: 15px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .signature p {
            margin: 0;
            line-height: 1.5;
        }

        .signature strong {
            color: #1e293b;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .email-wrapper {
                padding: 10px;
            }

            .content, .header, .footer {
                padding: 25px 20px;
            }

            .greeting {
                font-size: 22px;
            }
        }

        /* Quita el subrayado y cambia el color a negro para todos los enlaces */
        a {
            text-decoration: none;
            color: #000000;
        }

        /* Opcional: Si quieres que cambie de color o mantenga el negro al pasar el mouse */
        a:hover {
            color: #000000;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="email-wrapper">
    <div class="email-container">

        <!-- Encabezado -->
        <div class="header">
            <div class="logo-container">
                <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}">
            </div>
            <div class="logo-subtitle">@yield('title')</div>
        </div>

        @yield('content')

        <!-- Redes sociales -->
        <div class="social-box" style="margin: 20px 0; padding: 15px; background-color: #f8f9fa; border-radius: 8px; text-align: center;">
            <p class="info-text" style="margin-bottom: 10px;">
                {{__t('text.email.template.social_networks', 'For more information or inquiries, you can message us on the following social media platforms:')}}
            </p>
            <p style="margin: 8px 0;">
                <a href="https://www.instagram.com/manonegrasportbets?stkn=dW5pemYybjlwZmJu" target="_blank" style="color: #E1306C; text-decoration: none; font-weight: bold;">
                    📸 Instagram: @manonegrasportbets
                </a>
            </p>
            <p style="margin: 8px 0;">
                <a href="https://t.me/manonegrasportbets" target="_blank" style="color: #0088cc; text-decoration: none; font-weight: bold;">
                    ✈️ Telegram: @manonegrasportbets
                </a>
            </p>
        </div>

        <!-- Pie de página -->
        <div class="footer">
            <p class="footer-text">{{__t('text.email.template.email_sent_by', 'This email was sent automatically by')}} <span class="app-name">{{ config('app.name') }}</span>.</p>

            <div class="signature">
                <p>{{__t('text.email.template.kind_regards', 'Kind regards,')}} <br><strong>{{__t('text.email.template.team_of', 'Team of')}} {{ config('app.name') }}</strong></p>
            </div>
        </div>

    </div>
</div>
</body>
</html>