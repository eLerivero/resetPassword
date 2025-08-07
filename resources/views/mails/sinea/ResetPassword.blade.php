<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecimiento de Contraseña - INEA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-wrapper {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background-color: #275C96; /* Color primario */
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .logo {
            max-width: 150px;
            height: auto;
        }
        .body {
            padding: 20px;
            color: #333333;
        }
        .reset-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #90AAC9; /* Segundo color */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .footer {
            background-color: #A2CACC; /* Tercer color */
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777777;
            font-weight: bold; /* Negrita para el pie de página */
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <img src="https://testr.inea.gob.ve/assets/img/logos/inea.png" alt="INEA" class="logo">
            <h3>Solicitud de Restablecimiento de Contraseña</h3>
        </div>
        <div class="body">
            <p>Estimado usuario,</p>
            <p>Su usuario es: <strong>{{ $login }}</strong></p>
            <p>Su nueva contraseña es: <strong>{{ $newPassword }}</strong></p>
            <p>Haga clic en el siguiente enlace para iniciar sesión en el sistema SINEA:</p>
            <center>
                <a href="http://10.10.0.206/sinea/authake/user/login" class="reset-button">Iniciar Sesión</a>
            </center>
            <p>Saludos,</p>
            <p>Equipo de Oficina de tecnología de la información y comunicación</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} INEA. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
