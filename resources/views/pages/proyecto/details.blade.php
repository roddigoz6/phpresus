<div id="orden" class="container">
    <div class="details" style="display: flex; justify-content: space-between; ">
        <div class="row">
            <div class="col">
                <div class="header text-center">
                    <img src="{{ asset('assets/media/logos/kasier.jpg') }}" style="height:300px; margin-bottom:25px;" alt="Kasier">
                </div>
            </div>
            <div class="col">
                <h3><strong>AUXILIAR DE LA CONSTRUCCIÓN-ESTUDIOS-IMPERMEABILIZACIONES</strong></h3>
                <p>TEJADOS Y FACHADAS, PLACAS ASFÁLTICAS, AISLAMIENTOS, TERRAZAS, CUBIERTAS DE ASFALTO Y TEJAS, ETC.</p>
                <fieldset style="border-radius: 10px; background-color:#F9F9F9; padding:5px;">
                    <p><strong>KASIER</strong> - Pedro Icaza Nº 24 lonja, 48980 SANTURTZI Tel. 94 447 56 88</p>
                    <p><strong>{{$cliente->nombre}} {{$cliente->apellido}}</strong></p>
                    <p>{{$cliente->direccion}}</p>
                    <p>{{$cliente->cp}} {{$cliente->poblacion}}</p>
                    <p>{{$cliente->provincia}}</p>
                </fieldset>

            </div>
        </div>

    </div>

    <div class="row" style="width:100%; box-sizing:border-box;">
        <p style="margin: 0;">
            Proyecto:
            <strong>
                {{ $proyecto->proyecto_id }}
            </strong>

            Referencia:
            <strong>
                {{ $proyecto->serie_ref ?? 'No registrado'}}
            </strong>

            Nº referencia:
            <strong>
                {{ $proyecto->num_ref }}
            </strong>

            BILBAO
            <strong>
                {{ date('d/m/Y') }}
            </strong>
        </p>
    </div>
    <div class="table-responsive" style="width: 100%; overflow-x: auto; border-radius: 10px;">
        <table class="table table-light text-center table-hover rounded-table" style="width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden;">
            <thead class="table-dark" style="background-color: #252129; color: white;">
                <tr style="margin-top: 8px; margin-bottom: 8px;">
                    <th class="icon-table">Motivo de visita</th>
                    <th class="icon-table">Contacto de visita</th>
                    <th class="icon-table">Fecha de visita</th>
                    <th class="icon-table">Fin de visita</th>
                    <th class="icon-table">Comentario de cierre</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                @if ($visitas->isEmpty())
                <tr style="margin-top: 8px; margin-bottom: 8px;">
                    <td class="align-middle" colspan="5">No hay visitas registradas.</td>
                </tr>
                @else
                    @foreach ($visitas as $visita)
                    <tr style="margin-top: 8px; margin-bottom: 8px;">
                        <td class="align-middle">{{ $visita->descripcion ?? 'No registrado' }}</td>
                        <td class="align-middle">{{ $visita->contacto_visita }}</td>
                        <td class="align-middle">{{ $visita->fecha_inicio }} a las {{ $visita->hora_inicio }}</td>

                        @if ($visita->fecha_fin == null)
                        <td class="align-middle">No registrado</td>
                        @else
                        <td class="align-middle">{{ $visita->fecha_fin }} a las {{ $visita->hora_fin }}</td>
                        @endif

                        <td class="align-middle">{{ $visita->nota_cerrar ?? 'No registrado'}}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>

        </table>
    </div>

    <div class="table-responsive" style="width: 100%; overflow-x: auto; border-radius: 10px;">
        <table class="table table-light text-center table-hover rounded-table" style="width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden;">
            <thead class="table-dark" style="background-color: #252129; color: white;">
                <tr style="margin-top: 8px; margin-bottom: 8px;">
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Precio Total</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                @foreach ($productoPresupuestos as $productoPresupuesto)
                    @switch($productoPresupuesto->tipo)
                        @case('linea')
                            <tr style="margin-top: 8px; margin-bottom: 8px;">
                                <td>{{ $productoPresupuesto->producto->nombre }}</td>
                                <td style="text-align:justify;">{{ $productoPresupuesto->descripcion }}</td>
                                <td>{{ $productoPresupuesto->cantidad }}</td>
                                <td>{{ $productoPresupuesto->precio }}€</td>
                                <td>{{ $productoPresupuesto->cantidad * $productoPresupuesto->precio }}€</td>
                            @break

                        @case('capitulo')
                            <tr style="margin-top: 8px; margin-bottom: 8px; border-top:solid 1px black; background-color:rgb(223, 223, 223);">
                                <td colspan="2"><strong>{{ $productoPresupuesto->titulo }}</strong></td>
                                <td colspan="2" style="text-align:justify;">{{ $productoPresupuesto->descripcion }}</td>
                                <td>-</td>
                            </tr>
                            @break

                        @default
                            <tr style="margin-top: 8px; margin-bottom: 8px;">
                                <td colspan="6">Tipo de producto no reconocido</td>
                            </tr>
                    @endswitch
                @endforeach
                <tr style="border-top:1px solid black; margin-top: 8px; margin-bottom: 8px;">
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
                    <td><strong>Total</strong></td>
                    <td><strong>{{ round($productoPresupuestos->sum(function ($pp) use ($proyecto) {
                            return ($pp->cantidad * $pp->precio) * (1 + ($proyecto->iva / 100));
                        }), 2) }}€
                    </strong></td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
