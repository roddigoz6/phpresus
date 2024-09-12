<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            box-sizing: border-box;
        }
        .details-content h3 {
            margin-top: 0;
        }
        .details-img {
            float: left;
            width: 50%;
            padding-right: 20px;
        }
        .details-img img {
            width: 250px;
            max-height: auto;
            object-fit: contain;
            display: block;
        }
        .details-content {
            float: left;
            width: 50%;
        }
        .user-info {
            border-radius: 10px;
            background-color: #F9F9F9;
            padding: 10px;
        }
        .details::after {
            content: "";
            display: table;
            clear: both;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 20px;
            background-color: #F9F9F9;
        }
        thead {
            background-color: #252129;
            color: white;
        }
        th, td {
            padding: 8px;
            border: none;
        }
        .fin {
            border-top: 1px solid black;
        }
        tbody tr:last-child {
            border-bottom: none;
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            border-radius: 10px;
        }

        @media print {
            .details {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <div id="orden" class="container">
        <div class="details">
            <div class="details-img">
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('assets/media/logos/kasier-logo.jpg'))) }}" alt="Kasier">
            </div>

            <div class="details-content">
                <h3><strong>AUXILIAR DE LA CONSTRUCCIÓN-ESTUDIOS-IMPERMEABILIZACIONES</strong></h3>
                <p>TEJADOS Y FACHADAS, PLACAS ASFÁLTICAS, AISLAMIENTOS, TERRAZAS, CUBIERTAS DE ASFALTO Y TEJAS, ETC.</p>
                <div class="user-info">
                    <p><strong>KASIER</strong> - Pedro Icaza Nº 24 lonja, 48980 SANTURTZI Tel. 94 447 56 88</p>
                    <p><strong>{{$cliente->nombre}} {{$cliente->apellido}}</strong></p>
                    <p>{{$cliente->direccion}}</p>
                    <p>{{$cliente->cp}} {{$cliente->poblacion}}</p>
                    <p>{{$cliente->provincia}}</p>
                </div>
            </div>
        </div>

        <div class="project-info">
            <p style="margin: 0;">
                Proforma:
                <strong>{{ $proyecto->proyecto_id }}</strong>

                Referencia:
                <strong>{{ $proyecto->serie_ref ?? 'No registrado' }}</strong>

                Nº referencia:
                <strong>{{ $proyecto->num_ref }}</strong>

                BILBAO
                <strong>{{ date('d/m/Y') }}</strong>
            </p>
        </div>

        <div class="table-responsive">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Precio Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productoPresupuestos as $productoPresupuesto)
                        @switch($productoPresupuesto->tipo)
                            @case('linea')
                                <tr>
                                    <td>{{ $productoPresupuesto->producto->nombre }}</td>
                                    <td style="text-align:justify;">{{ $productoPresupuesto->descripcion }}</td>
                                    <td>{{ $productoPresupuesto->cantidad }}</td>
                                    <td>{{ $productoPresupuesto->precio }}€</td>
                                    <td>{{ $productoPresupuesto->cantidad * $productoPresupuesto->precio }}€</td>
                                </tr>
                                @break

                            @case('capitulo')
                                <tr style="border-top:solid 1px black; background-color:#F9F9F9;">
                                    <td colspan="2"><strong>{{ $productoPresupuesto->titulo }}</strong></td>
                                    <td colspan="2" style="text-align:justify;">{{ $productoPresupuesto->descripcion }}</td>
                                    <td>-</td>
                                </tr>
                                @break

                            @default
                                <tr>
                                    <td colspan="6">Tipo de producto no reconocido</td>
                                </tr>
                        @endswitch
                    @endforeach
                    <tr class="fin">
                        <td colspan="3"></td>
                        <td>Total productos</td>
                        <td>{{ $productoPresupuestos->sum(function ($pp) { return $pp->cantidad * $pp->precio; }) }}€</td>
                    </tr>

                    <tr>
                        <td colspan="3"></td>
                        <td>I.V.A ({{$proyecto->iva}}%)</td>
                        <td>{{ round($proyecto->presupuesto->precio_total * $proyecto->iva / 100, 2) }}€</td>
                    </tr>

                    <tr>
                        <td><p style="margin: 0;">Pago: </p></td>
                        <td colspan="2"><strong>{{$proyecto->pago}}</strong></td>
                        <td><strong>Total proforma</strong></td>
                        <td><strong>{{ round($productoPresupuestos->sum(function ($pp) use ($proyecto) {
                                return ($pp->cantidad * $pp->precio) * (1 + ($proyecto->iva / 100));
                            }), 2) }}€
                        </strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
