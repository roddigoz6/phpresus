<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Proforma Enviada</title>
    <style>
        /* Base */
        body {
            background-color: #ffffff;
            color: #718096;
            margin: 0;
            padding: 0;
            width: 100%;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            text-align: center;
        }

        p {
            line-height: 1.5;
            font-size: 16px;
            color: #718096;
        }

        h1, h2 {
            margin: 0;
            color: #3d4852;
        }

        h1 {
            font-size: 24px;
        }

        h2 {
            font-size: 18px;
        }

        img {
            max-width: 100%;
        }

        /* Layout */
        .wrapper {
            background-color: #edf2f7;
            width: 100%;
            padding: 0;
        }

        .content {
            margin: 0 auto;
            padding: 0;
        }

        .header {
            padding: 25px 0;
        }

        /* Body */
        .body {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .inner-body {
            background-color: #ffffff;
            border-radius: 5px;
            margin: 0 auto;
            padding: 20px;
            max-width: 570px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Button */
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #74c8f8; /* Azul claro */
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 4px;
            margin-top: 20px;
            text-align: center;
        }

        .button:hover {
            color: white;
            background-color: rgb(28, 108, 143);
        }

        /* Footer */
        .footer {
            margin-top: 25px;
            text-align: center;
        }

        .footer p {
            color: #b0adc5;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="content">
            <div class="header"></div>
            <div class="body">
                <div class="inner-body">
                    <h1>Kasier</h1>
                    <h2>Hola, te envío el presupuesto de tu proyecto :)</h2>
                    <p>Haz clic en el botón de abajo para descargarlo:</p>
                    <a href="{{ $pdfUrl }}" class="button">Descargar PDF</a>
                </div>
            </div>

            <div class="footer">
                <p><strong>Copyright © <?php echo date("Y"); ?> {{ config('app.name', 'Kasier') }}</strong></p>
            </div>
        </div>
    </div>
</body>
</html>
