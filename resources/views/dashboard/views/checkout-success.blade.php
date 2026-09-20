<!DOCTYPE html>
<html>
<head>
    <title>Éxito</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background: #f0f9f0;
            margin: 0;
        }
        .success-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            max-width: 400px;
        }
        .icon { font-size: 70px; margin-bottom: 20px; }
        h2 { color: #28a745; margin-bottom: 10px; }
        p { color: #666; }
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #28a745;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<div class="success-box">
    <div class="icon">✅</div>
    <h2>¡Pago exitoso!</h2>
    <p>{{ $message }}</p>
    <div class="loader"></div>
    <p style="margin-top:15px; font-size:14px; color:#999;">Recargando la página principal...</p>
</div>

<script>
    // Recargar la página principal después de 2 segundos
    setTimeout(() => {
        if (window.opener) {
            window.opener.location.reload();
        }
        window.close();
    }, 2000);
</script>
</body>
</html>