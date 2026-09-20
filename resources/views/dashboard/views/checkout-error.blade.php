<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
        }
        .error-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 400px;
        }
        .icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
        .btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        .btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
<div class="error-box">
    <div class="icon">❌</div>
    <h2>Error</h2>
    <p>{{ $mensaje ?? 'El plan no está disponible' }}</p>
    <button class="btn" onclick="cerrarPopup()">Cerrar</button>
</div>

<script>
    function cerrarPopup() {
        window.close();
    }

    // Cerrar automáticamente después de 3 segundos
    setTimeout(() => {
        window.close();
    }, 3000);

    // Notificar a la ventana padre
    if (window.opener) {
        window.opener.location.reload();
    }
</script>
</body>
</html>