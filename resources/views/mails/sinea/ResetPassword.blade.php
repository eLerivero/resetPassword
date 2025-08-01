<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecimiento de Contraseña - INEA</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logos/inea.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/reset-password.css') }}">
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <img src="{{ asset('assets/img/logos/inea.png') }}" alt="INEA Logo" class="logo"> <!-- Asegúrate de tener un logo -->
            <h3>Solicitud de Restablecimiento de Contraseña</h3>
        </div>
        <div class="body">
            <p>Estimado usuario,</p>
            <p>Su usuario es: <strong> {{ $login }} </strong></p>
            <p>Su nueva contraseña es: <strong> {{ $newPassword }} </strong></p>
            <p>Haga clic en el siguiente enlace para iniciar sesión en el sistema SINEA:</p>
            <center> <a href="http://10.10.0.206/sinea/authake/user/login" class="reset-button">Iniciar Sesión</a> </center>
            <p>Saludos,</p>
            <p>Equipo de Oficina de tecnología de la información y comunicación</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} INEA. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
