<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Duplicidad de Cédula - INEA</title>
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
            <h3>Reporte de Duplicidad de Cédula</h3>
        </div>
        <div class="body">
            <p>Se ha generado una solicitud debido a la detección de una cédula duplicada. A continuación, se detallan los datos relevantes:</p>
            <p><strong>Número de Cédula Duplicada:</strong> {{$rif}}</p>
            <p><strong>Correo del Usuario para Reportar Solución:</strong> {{$correo}}</p>
            <strong><p>Solicitud generada desde el servicio de Autogestión SINEA.</p></strong>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} INEA. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
