<x-default-layout>
    @section('title')
        Editar presupuesto
    @endsection

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4">
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <h3 class="mb-0">Productos</h3>
                    </div>
                    <div class="col text-end">
                        <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#crearProductoModal" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Crear un nuevo producto y agregar a la lista">
                            Agregar producto <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form action="{{ route('producto.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="crearProductoModalLabel">Nuevo producto</h5>
                                    </div>
                                    <div class="">
                                        <label for="nombre">Nombre del Producto</label> <strong class="required"></strong>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="">
                                        <label for="precio">Precio</label> <strong class="required"></strong>
                                        <input type="number" class="form-control" id="precio" name="precio" min="0" step="0.01" required>
                                    </div>
                                    <div class="">
                                        <label for="descripcion">Descripción</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                                    </div>
                                    <div class="">
                                        <label for="stock">Stock</label> <strong class="required"></strong>
                                        <input type="number" class="form-control" id="stock" name="stock" min="0" required>
                                    </div>
                                    <div class="">
                                        <label for="tipo">Tipo</label> <strong class="required"></strong>
                                        <select class="form-select" id="tipo" name="tipo" required>
                                            <option value="Artículo">Artículo</option>
                                            <option value="Visita">Visita</option>
                                        </select>
                                    </div>
                                    <div class="mt-3">Los campos con <strong class="required"></strong> son requeridos.</div>
                                    <button type="submit" class="btn btn-primary mt-3" id="CreaProd">Ingresar nuevo producto</button>
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
                        <input type="text" name="search" id="search-input" class="form-control" placeholder="Buscar productos..." value="{{ request('search') }}">
                        <div class="input-group-append">
                        <button class="btn btn-light-primary mx-3" id="search-button" type="button" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Buscar producto por nombre">
                            <i class="fas fa-search"></i>
                        </button>
                        </div>
                        <input type="hidden" name="order" id="order-input" value="{{ $order ?? 'asc' }}">
                        <button type="button" id="orderButton" class="nav-link ms-2 d-flex align-items-center" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Ordenar productos por nombre">
                            <i class="fa-solid fa-up-down"></i>
                        </button>
                        <input type="hidden" name="precio_order" id="precio_order-input" value="{{ $precio_order ?? 'asc' }}">
                        <button type="button" id="precioButton" class="nav-link ms-2 d-flex align-items-center" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Ordenar productos por precio">
                            <i class="fa-solid fa-euro-sign"></i>
                        </button>
                    </div>
                </form>
                <div id="productos-container">
                </div>

            </div>



            <div class="col-md-8">

                <form action="{{ route('presupuesto.update', $presupuesto->id) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PUT')
                    <div class="input-group mb-3 mt-3">
                        <h3>Editar proyecto {{ $proyecto->proyecto_id }}, cliente {{ $presupuesto->cliente->nombre }}.</h3>

                        <select class="form-select select2" id="cliente" name="cliente_id" required>
                            <option value="">Seleccionar cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}"
                                    {{ $presupuesto->cliente_id == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <hr />
                        <p class="mb-0">Datos del cliente</p>
                        <div class="col form-group">
                            Cliente: <strong>{{ $presupuesto->cliente->nombre }} {{ $presupuesto->cliente->apellido }}</strong>
                            <input type="hidden" value="{{ $presupuesto->cliente->id }}" id="cliente_id" name="cliente_id">
                        </div>

                        <div class="col form-group">
                            Contacto: <strong>{{ $presupuesto->cliente->contacto ?: 'No registrado' }}</strong><br>
                            Forma de pago de cliente: <strong>{{ $presupuesto->cliente->pago ?: 'No registrado' }}</strong>
                        </div>
                    </div>


                    <p>Arrastra aquí los productos para agregarlos al presupuesto.</p>

                    <div id="canvas" class="border p-2" style="min-height: 300px; overflow-y: auto;"
                        ondrop="drop(event)" ondragover="allowDrop(event)">
                        <div id="lista-presupuesto" class="table-responsive">
                            <table class="table table-light text-center table-hover rounded-table">
                                <thead class="table-dark">
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
                            <button type="submit" class="btn btn-light-primary" data-bs-toggle="popover"
                                data-bs-trigger="hover focus"
                                title="Actualizar el presupuesto con los datos en lista.">Actualizar presupuesto <i class="fas fa-check-circle"></i></button>
                        </div>
                        <div class="col text-end">
                            <button type="button" class="btn btn-light-danger" id="limpiarCanvas" data-bs-toggle="popover"
                                data-bs-trigger="hover focus" title="Quitar todos los productos de la lista.">Quitar
                                todos <i class="fas fa-trash"></i></button>
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
            console.log(productosArrastrados);
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
                    cantidad: 1,
                    orden_prod: productosArrastrados.length + 1,
                    tipo: '', // Agregar un valor predeterminado o lo que sea apropiado
                    titulo: '', // Agregar un valor predeterminado o lo que sea apropiado
                    descripcion: ''
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
                //$(elementoDebajoDelRaton).css('border', '2px solid red');
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

                const tdNombre = $('<td class="align-middle"></td>');
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

                const tdPrecio = $('<td class="align-middle"></td>');
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

                const tdPrecioTotal = $('<td class="align-middle"></td>');
                tdPrecioTotal.addClass('precio-total-producto text-center');
                tdPrecioTotal.text((producto.cantidad * producto.precio).toFixed(2) + '€');

                const tdAcciones = $('<td class="align-middle"></td>');
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
