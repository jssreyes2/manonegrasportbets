<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #1a1a1a;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .email-body {
            padding: 30px;
            line-height: 1.6;
        }
        .email-footer {
            background-color: #f4f4f7;
            color: #888888;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="email-wrapper">
    <div class="email-header">
        Mi Sistema
    </div>

    <div class="email-body">
        <p>Hola, <strong>Usuario de Prueba</strong>:</p>

        <p>Tu suscripción ha vencido y requiere atención para su renovación.</p>

        <p><strong>Plan afectado:</strong> Elite</p>
    </div>

    <div class="email-footer">
        Este es un correo automático, por favor no respondas a este mensaje.
    </div>
</div>
</body>
</html>