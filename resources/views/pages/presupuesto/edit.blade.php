<x-default-layout>
    @section('title')
        Editar presupuesto
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4">
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <h3 class="mb-0">Productos</h3>
                    </div>
                    <div class="col text-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#crearProductoModal" data-bs-toggle="popover" data-bs-trigger="hover focus"
                            title="Crear un nuevo producto y agregar a la lista">
                            Agregar producto
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="crearProductoModalLabel">Nuevo producto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('producto.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nombre">Nombre del Producto</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="precio">Precio</label>
                                        <input type="number" class="form-control" id="precio" name="precio"
                                            min="0" step="0.01" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion">Descripción</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stock">Stock</label>
                                        <input type="number" class="form-control" id="stock" name="stock"
                                            min="0" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tipo">Tipo</label>
                                        <select class="form-select" id="tipo" name="tipo" required>
                                            <option value="Artículo">Artículo</option>
                                            <option value="Visita">Visita</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="categoria">Categoría</label>
                                        <select class="form-select" id="categoria" name="categoria_id" required>
                                            @foreach ($categorias as $categoria)
                                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="CreaProd">Crear</button>
                                </form>
                                @if (session('success_prod'))
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: "top-end",
                                                showConfirmButton: false,
                                                timer: 3000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.onmouseenter = Swal.stopTimer;
                                                    toast.onmouseleave = Swal.resumeTimer;
                                                }
                                            });
                                            Toast.fire({
                                                icon: "success",
                                                title: "Producto agregado."
                                            });
                                        });
                                    </script>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <form method="GET" action="{{ route('presupuesto.getProductos') }}" id="search-form" class="d-flex">
                    <div class="input-group mb-3">
                        <input type="text" name="search" id="search-input" class="form-control"
                            placeholder="Buscar productos..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="search-button" type="button" data-bs-toggle="popover"
                                data-bs-trigger="hover focus" title="Buscar producto por nombre">Buscar</button>
                        </div>
                        <input type="hidden" name="order" id="order-input" value="{{ $order ?? 'asc' }}">
                        <button type="button" id="orderButton" class="nav-link ms-2 d-flex align-items-center"
                            data-bs-toggle="popover" data-bs-trigger="hover focus" title="Ordenar productos por nombre">
                            <i class="fa-solid fa-up-down"></i>
                        </button>
                        <input type="hidden" name="precio_order" id="precio_order-input"
                            value="{{ $precio_order ?? 'asc' }}">
                        <button type="button" id="precioButton" class="nav-link ms-2 d-flex align-items-center"
                            data-bs-toggle="popover" data-bs-trigger="hover focus" title="Ordenar productos por precio">
                            <i class="fa-solid fa-euro-sign"></i>
                        </button>
                    </div>
                </form>
                <div id="productos-container">
                </div>

            </div>

            <div class="col-md-8">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Clientes</h3>
                    </div>
                    <div class="col text-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#crearClienteModal" data-bs-toggle="popover" data-bs-trigger="hover focus"
                            title="Crear nuevo cliente y agregar a la lista">
                            Agregar cliente
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="crearClienteModal" tabindex="-1" aria-labelledby="crearClienteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form action="{{ route('cliente.store') }}" method="POST">
                                    @csrf
                                    <div class="row">

                                        <div class="col">
                                            <div class="modal-header">
                                                <h4>Datos del cliente</h4>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="">
                                                        <label for="nombre">Nombre</label>
                                                        <input type="text" class="form-control" id="nombre"
                                                            name="nombre" required>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="">
                                                        <label for="apellido">Apellido</label>
                                                        <input type="text" class="form-control" id="apellido"
                                                            name="apellido" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="">
                                                        <label for="dni">DNI</label>
                                                        <input type="text" class="form-control" id="dni"
                                                            name="dni" required>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div>
                                                        <label for="movil">Móvil</label>
                                                        <input type="text" class="form-control" id="movil"
                                                            name="movil" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label for="email">Correo Electrónico</label>
                                                <input type="email" class="form-control" id="email"
                                                    name="email">
                                            </div>
                                            <div class="">
                                                <label for="direccion">Direccion</label>
                                                <input type="text" class="form-control" id="direccion"
                                                    name="direccion" required>
                                            </div>
                                            <div class="">
                                                <label for="cp">Código postal</label>
                                                <input type="text" class="form-control" id="cp" name="cp"
                                                    required>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="">
                                                        <label for="poblacion">Población</label>
                                                        <input type="text" class="form-control" id="poblacion"
                                                            name="poblacion" required>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="">
                                                        <label for="provincia">Provincia</label>
                                                        <input type="text" class="form-control" id="provincia"
                                                            name="provincia" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="">
                                                        <label for="fax">Fax</label>
                                                        <input type="text" class="form-control" id="fax"
                                                            name="fax">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div>
                                                        <label for="cargo">Cargo</label>
                                                        <input type="text" class="form-control" id="cargo"
                                                            name="cargo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="modal-header">
                                                <h4>Datos de envío</h4>
                                            </div>
                                            <div class="">
                                                <label for="contacto">Contacto</label>
                                                <input type="text" class="form-control" id="contacto"
                                                    name="contacto">
                                            </div>
                                            <div class="">
                                                <label for="titular_nom">Nombre de titular</label>
                                                <input type="text" class="form-control" id="titular_nom"
                                                    name="titular_nom">
                                            </div>
                                            <div class="">
                                                <label for="titular_ape">Apellido de titular</label>
                                                <input type="text" class="form-control" id="titular_ape"
                                                    name="titular_ape">
                                            </div>
                                            <div class="">
                                                <label for="direccion_envio">Dirección de envío</label>
                                                <input type="text" class="form-control" id="direccion_envio"
                                                    name="direccion_envio">
                                            </div>
                                            <div class="">
                                                <label for="cp_envio">Código postal de dirección de envío</label>
                                                <input type="text" class="form-control" id="cp_envio"
                                                    name="cp_envio">
                                            </div>
                                            <div class="">
                                                <label for="poblacion_envio">Población de dirección de envío</label>
                                                <input type="text" class="form-control" id="poblacion_envio"
                                                    name="poblacion_envio">
                                            </div>
                                            <div class="">
                                                <label for="provincia_envio">Provincia de dirección de envío</label>
                                                <input type="text" class="form-control" id="provincia_envio"
                                                    name="provincia_envio">
                                            </div>

                                        </div>
                                        <div class="modal-header">
                                            <h4>Pago</h4>
                                        </div>
                                        <div class="">
                                            <label for="pago">Forma de pago</label>
                                            <select class="form-select" id="pago" name="pago">
                                                <option value="Ver condiciones">Ver condiciones</option>
                                                <option value="50% inicio, 50% fin">50% inicio, 50% fin</option>
                                                <option value="50% termino de obra, resto a 90 dias">50% termino de obra,
                                                    resto a 90 días</option>
                                                <option value="50% comienzo de obra, resto a convenir">50% comienzo de
                                                    obra, resto a convenir</option>
                                                <option value="Certificaciones quincenales">Certificaciones quincenales
                                                </option>
                                                <option value="Como siempre">Como siempre</option>
                                                <option value="Contado termino de obra">Contado termino de obra</option>
                                                <option value="Convenir">Convenir</option>
                                                <option value="Fin de ejercicio, 15 de diciembre">Fin de ejercicio, 15 de
                                                    diciembre</option>
                                                <option value="Letra de 90 dias">Letra de 90 días</option>
                                                <option value="Letra a la vista">Letra a la vista</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Guardar</button>
                                </form>
                                @if (session('success_cli'))
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: "top-end",
                                                showConfirmButton: false,
                                                timer: 3000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.onmouseenter = Swal.stopTimer;
                                                    toast.onmouseleave = Swal.resumeTimer;
                                                }
                                            });
                                            Toast.fire({
                                                icon: "success",
                                                title: "Cliente agregado."
                                            });
                                        });
                                    </script>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('presupuesto.update', $presupuesto->id) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PUT')
                    <div class="input-group mb-3 mt-3">
                        <select class="form-select select2" id="cliente" name="cliente_id" required>
                            <option value="">Seleccionar cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}"
                                    {{ $presupuesto->cliente_id == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h3>Editar presupuesto {{ $presupuesto->id }}, cliente {{ $presupuesto->cliente->nombre }}.</h3>
                    <p>Arrastra aquí los productos para agregarlos al presupuesto.</p>

                    <div id="canvas" class="border p-2" style="min-height: 300px; overflow-y: auto;"
                        ondrop="drop(event)" ondragover="allowDrop(event)">
                        <div id="lista-presupuesto" class="table-responsive">
                            <table class="table table-light table-hover ">
                                <thead>
                                    <tr>
                                        <th class="icon-table">Nombre</th>
                                        <th class="icon-table">Cantidad</th>
                                        <th class="icon-table">Precio x Unidad</th>
                                        <th class="icon-table">Precio</th>
                                        <th class="icon-table"></th>
                                    </tr>
                                </thead>
                                <tbody id="productos-table-body" class="list">


                                </tbody>
                            </table>
                        </div>
                    </div>

                    <label for="total">Total:</label>
                    €<h3 id="total">0.00 </h3>

                    <input type="hidden" id="precio_total" name="precio_total" value="0.00">
                    <input type="hidden" id="lista_productos" name="lista_productos" value="">
                    <div class="row mb-3">
                        <div class="col text-start">
                            <button type="submit" class="btn btn-primary" data-bs-toggle="popover"
                                data-bs-trigger="hover focus"
                                title="Actualizar el presupuesto con los datos en lista.">Actualizar presupuesto</button>
                        </div>
                        <div class="col text-end">
                            <button type="button" class="btn btn-danger" id="limpiarCanvas" data-bs-toggle="popover"
                                data-bs-trigger="hover focus" title="Quitar todos los productos de la lista.">Quitar
                                todos</button>
                        </div>
                    </div>
                </form>

                @if (session('success_pres'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "success",
                                title: "Presupuesto guardado."
                            });
                        });
                    </script>
                @endif
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() {
            // console.log(productosArrastrados);
            actualizarListaProductos();
        });

        let productosArrastrados = {!! json_encode($productosArrastrados) !!};

        function limpiarProductos() {
            localStorage.removeItem('productosArrastrados');
        }

        function allowDrop(event) {
            event.preventDefault();
        }

        function drag(event) {
            event.dataTransfer.setData("text", event.target.id);
        }

        function drop(event) {
            if (window.drop_function != undefined && window.drop_function === 2) {
                console.log("CAMBIANDO A DROP2");
                drop2(event);
                return;
            }
            console.log("DEV: DROP-EVENT 1");
            event.preventDefault();
            const data = event.dataTransfer.getData("text");
            const draggedElement = document.getElementById(data);
            const productoId = parseInt(draggedElement.querySelector('.producto-id').textContent);
            const productoNombre = draggedElement.querySelector('.producto-nombre').textContent;
            const productoPrecio = parseFloat(draggedElement.querySelector('.producto-precio').textContent);
            const productoStock = parseInt(draggedElement.querySelector('.producto-stock').textContent);

            const productoExistente = productosArrastrados.find(producto => producto.id === productoId);
            if (!productoExistente) {
                productosArrastrados.push({
                    id: productoId,
                    nombre: productoNombre,
                    precio: productoPrecio,
                    stock: productoStock,
                    cantidad: 1
                });

                actualizarListaProductos();
            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "error",
                    title: "Ya agregaste este producto"
                });
            }
        }

        function drop2(event) {
            window.drop_function = 1;
            console.log("DEV: DROP-EVENT 2");
            event.preventDefault();

            const x = event.clientX;
            const y = event.clientY;

            // Obtener el elemento DOM que está debajo del ratón
            const elementoDebajoDelRaton = document.elementFromPoint(x, y);
            const fila_destino = $(elementoDebajoDelRaton).closest("tr");

            // Validar que la fila destino no sea la misma que la fila original
            if (fila_destino.length && !fila_destino.is(window.fila_original)) {
                // Obtener las posiciones de la fila original y la fila destino
                const posicionOriginal = window.fila_original.index();
                const posicionDestino = fila_destino.index();

                console.log('Posición original:', posicionOriginal);
                console.log('Posición destino:', posicionDestino);

                // Reordenar dependiendo de la posición
                if (posicionOriginal < posicionDestino) {
                    fila_destino.after(window.fila_original);
                } else {
                    fila_destino.before(window.fila_original);
                }

                console.log('Elemento debajo del ratón:', $(elementoDebajoDelRaton));
                console.log('Fila destino:', fila_destino);

                // Aplicar estilo para confirmar la acción
                $(elementoDebajoDelRaton).css('border', '2px solid red');
            } else {
                console.log("No se puede soltar la fila sobre sí misma.");
            }

            actualizarOrdenProductos();
        }

        function actualizarListaProductos() {
            const tableBody = $('#productos-table-body');
            tableBody.empty();

            productosArrastrados.forEach((producto, index) => {
                const tr = $('<tr></tr>');
                tr.attr('data-producto-id', producto.id);
                tr.addClass('item');
                tr.attr('draggable', true);

                const ordenInput = $('<input>');
                ordenInput.attr({
                    type: 'hidden',
                    class: 'orden-producto',
                    name: `orden_producto_${producto.id}`,
                    value: index + 1
                });

                const tdNombre = $('<td></td>');
                tdNombre.text(producto.nombre);

                const tdCantidad = $('<td></td>');
                const cantidadInput = $('<input>');
                cantidadInput.attr({
                    type: 'number',
                    value: producto.cantidad,
                    min: 1,
                    max: producto.stock
                });
                cantidadInput.addClass('cantidad-producto form-control');
                cantidadInput.on('change', function() {
                    const cantidad = parseInt($(this).val());
                    producto.cantidad = cantidad;
                    tdPrecioTotal.text((cantidad * producto.precio).toFixed(2) + '€');
                    actualizarPrecioTotal();
                });
                tdCantidad.append(cantidadInput);

                const tdPrecio = $('<td></td>');
                const precioInput = $('<input>');
                precioInput.attr({
                    type: 'number',
                    value: producto.precio.toFixed(2),
                    min: 0,
                    step: 0.01
                });

                precioInput.addClass('input-precio-producto form-control');
                precioInput.on('change', function() {
                    const precio = parseFloat($(this).val());
                    producto.precio = precio;
                    tdPrecioTotal.text((producto.cantidad * precio).toFixed(2) + '€');
                    actualizarPrecioTotal();
                });
                tdPrecio.append(precioInput);

                const tdPrecioTotal = $('<td></td>');
                tdPrecioTotal.addClass('precio-total-producto text-center');
                tdPrecioTotal.text((producto.cantidad * producto.precio).toFixed(2) + '€');

                const tdAcciones = $('<td></td>');
                const eliminarBtn = $('<button></button>');
                eliminarBtn.attr('type', 'button');
                eliminarBtn.addClass('btn btn-danger btn-sm');
                eliminarBtn.html('<i class="fa-solid fa-trash"></i>');
                eliminarBtn.on('click', function() {
                    tr.remove();
                    productosArrastrados = productosArrastrados.filter(p => p.id !== producto.id);
                    actualizarOrdenProductos();
                    actualizarPrecioTotal();
                });
                tdAcciones.append(eliminarBtn);

                tr.append(tdNombre, tdCantidad, tdPrecio, tdPrecioTotal, tdAcciones, ordenInput);
                tableBody.append(tr);

                tr.on('dragstart', function(e) {
                    $(this).addClass('dragging');
                    window.fila_original = tr;
                    console.log("fila original"); // DEV
                    console.log(tr); // DEV
                    window.drop_function = 2;
                    console.log("dragging!");
                    e.originalEvent.dataTransfer.setData('text/plain', producto.id);
                });

                tr.on('dragend', function() {
                    console.log("dragend!");
                    $(this).removeClass('dragging');
                    actualizarOrdenProductos();
                });
            });
            actualizarPrecioTotal();
        }


        function actualizarOrdenProductos() {
            $('#productos-table-body tr').each((index, tr) => {
                $(tr).find('.orden-producto').val(index + 1);
            });
            productosArrastrados.sort((a, b) => a.orden - b.orden);
        }

        function actualizarPrecioTotal() {
            let precioTotal = 0;

            productosArrastrados.forEach(producto => {
                const cantidad = parseInt(producto.cantidad);
                const precioProducto = cantidad * producto.precio;
                precioTotal += precioProducto;
            });

            document.getElementById("total").innerText = precioTotal.toFixed(2);
            document.getElementById("precio_total").value = precioTotal.toFixed(2);
            document.getElementById("lista_productos").value = JSON.stringify(productosArrastrados);
        }

        document.getElementById("limpiarCanvas").addEventListener("click", function() {
            const tableBody = document.getElementById("productos-table-body");
            tableBody.innerHTML = "";
            productosArrastrados = [];
            actualizarPrecioTotal();
        });

        $(document).ready(function() {
            $('#cliente').select2({
                placeholder: 'Seleccionar cliente',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return 'No se encontraron clientes con ese nombre';
                    }
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
                templateResult: formatResult,
                dropdownCssClass: 'custom-dropdown', // Clase personalizada para el dropdown
                selectionCssClass: 'custom-selection' // Clase personalizada para la selección
            });

            function formatResult(result) {
                if (!result.id) {
                    return result.text;
                }

                const markup = "<div>" + result.text + "</div>";
                return markup;
            }
        });

        $(document).ready(function() {
            // Prevenir comportamiento por defecto del formulario
            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                cargarProductos();
            });

            // Manejar clic en botón de búsqueda
            $('#search-button').on('click', function() {
                cargarProductos();
            });

            // Manejar clic en botón de ordenar por nombre
            $('#orderButton').on('click', function() {
                const currentOrder = $('#order-input').val();
                const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
                $('#order-input').val(newOrder);
                cargarProductos();
            });

            // Manejar clic en botón de ordenar por precio
            $('#precioButton').on('click', function() {
                const currentPrecioOrder = $('#precio_order-input').val();
                const newPrecioOrder = currentPrecioOrder === 'asc' ? 'desc' : 'asc';
                $('#precio_order-input').val(newPrecioOrder);
                cargarProductos();
            });

            // Función para cargar productos al cargar la página
            cargarProductos();

            // Función para cargar productos al hacer clic en la paginación
            $('#productos-container').on('click', '.pagination a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                cargarProductos({
                    url: url
                });
            });

            // Función para cargar productos utilizando AJAX
            function cargarProductos(params = {}) {
                const url = params.url || '{{ route('presupuesto.getProductos') }}';
                const data = {
                    search: $('#search-input').val(),
                    order: $('#order-input').val(),
                    precio_order: $('#precio_order-input').val(),
                    _token: '{{ csrf_token() }}'
                };

                // Realizar solicitud AJAX para cargar productos
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: data,
                    success: function(response) {
                        $('#productos-container').html(response.html);
                        $('#pagination-container').html(response.pagination);
                    },
                    error: function(xhr, status, error) {
                        console.log('Error al cargar los productos: ', error);
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    </script>
    @endpush
</x-default-layout>
