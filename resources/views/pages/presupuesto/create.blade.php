<x-default-layout>
    @section('title')
        Crear presupuesto
    @endsection

<div class="container mt-3">
    <div class="row">
        <div class="col-md-4">
            <div class="row align-items-center mb-3">
                <div class="col">
                    <h3 class="mb-0">Productos</h3>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#crearProductoModal">
                        Nuevo producto <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
            </div>

            <div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form action="{{ route('producto.store') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="crearProductoModalLabel">Nuevo producto</h5>
                                </div>
                                <div class="mb-3">
                                    <label for="nombre">Nombre del Producto</label> <strong class="required"></strong>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="precio">Precio</label> <strong class="required"></strong>
                                    <input type="number" class="form-control" id="precio" name="precio" min="0" step="0.01" required>
                                </div>
                                <div class="mb-3">
                                    <label for="leyenda">Leyenda</label>
                                    <textarea class="form-control" id="leyenda" name="leyenda" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="stock">Stock</label> <strong class="required"></strong>
                                    <input type="number" class="form-control" id="stock" name="stock" min="0" required>
                                </div>
                                <input type="hidden" id="tipo" name="tipo" value="linea" required>

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
                    <input type="text" name="search" id="search-input" class="form-control" placeholder="Buscar productos..." value="{{ request('search') }}" style="border-radius:5px;">
                    <div class="input-group-append">
                    <button class="btn btn-light-primary mx-3" id="search-button" type="button" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Buscar producto por nombre">
                        <i class="fas fa-search"></i>
                    </button>
                    </div>

                    <input type="hidden" name="sort_by" id="sort_by-input" value="{{ $sort_by ?? 'nombre' }}">

                    <input type="hidden" name="order" id="order-input" value="{{ $order ?? 'asc' }}">
                    <button type="button" id="orderButton" class="nav-link ms-2 d-flex align-items-center mx-3" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Ordenar productos por nombre">
                        <i class="fa-solid fa-up-down"></i>
                    </button>

                    <input type="hidden" name="precio_order" id="precio_order-input" value="{{ $precio_order ?? 'asc' }}">
                    <button type="button" id="precioButton" class="nav-link ms-2 d-flex align-items-center" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Ordenar productos por precio">
                        <i class="fa-solid fa-euro-sign"></i>
                    </button>
                </div>
            </form>
            <div id="productos-content">
            </div>

        </div>

        <div class="col-md-8">
            <form action="{{ route('presupuesto.store') }}" method="POST" class="mb-3">
                @csrf

                <h3>Crear proyecto</h3>

                <div class="col">
                    <hr />
                    <p class="mb-0">Datos del cliente</p>
                    <div class="col form-group">

                        Cliente: <strong>{{$cliente->nombre}} {{$cliente->apellido}}</strong>
                        <input type="hidden" value="{{$cliente->id}}" id="cliente_id" name="cliente_id">
                    </div>

                    <div class="col form-group">

                        Contacto: <strong>{{$cliente->contacto ?: "No registrado" }}</strong>
                        Forma de pago de cliente: <strong>{{$cliente->pago ?: "No registrado"}}</strong>

                    </div>
                </div>

                <div class="col">
                    <hr />
                    <p class="mb-0">Info del proyecto</p>

                    <div>
                        <input class="form-control" type="text" placeholder="Nombre del proyecto / Título de referencia">
                    </div>

                    <div>
                        <label for="pago">Forma de pago</label>
                            <select class="form-select" id="pago" name="pago">
                                <option value="Ver condiciones">Ver condiciones</option>
                                <option value="50% inicio, 50% fin">50% inicio, 50% fin</option>
                                <option value="50% termino de obra, resto a 90 dias">50% termino de obra, resto a 90 días</option>
                                <option value="50% comienzo de obra, resto a convenir">50% comienzo de obra, resto a convenir</option>
                                <option value="Certificaciones quincenales">Certificaciones quincenales</option>
                                <option value="Como siempre">Como siempre</option>
                                <option value="Contado termino de obra">Contado termino de obra</option>
                                <option value="Convenir">Convenir</option>
                                <option value="Fin de ejercicio, 15 de diciembre">Fin de ejercicio, 15 de diciembre</option>
                                <option value="Letra de 90 dias">Letra de 90 días</option>
                                <option value="Letra a la vista">Letra a la vista</option>
                            </select>
                    </div>
                    <hr />
                </div>

                <p>Arrastra aquí los productos para agregarlos al presupuesto.</p>
                <div id="canvas" class="border p-2" style="min-height: 500px; overflow-y: auto;" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div id="lista-presupuesto" class="table-responsive">
                        <table  class="table table-light text-center table-hover rounded-table">
                            <thead class="table-dark">
                                <tr>
                                    <th class="icon-table">Nombre</th>
                                    <th class="icon-table">Descripción</th>
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
                    <div class="col col-auto me-auto">
                        <!-- Contenedor flex para asegurar el tamaño uniforme de los botones -->
                        <div class="btn-container d-flex gap-2">
                            <button type="submit" class="btn btn-light-primary">
                                Guardar presupuesto <i class="fas fa-check-circle"></i>
                            </button>
                            <button id="agregarCap" type="button" class="btn btn-light-success">
                                Agregar capítulo <i class="fas fa-plus-circle"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col col-auto">
                        <button type="button" class="btn btn-light-danger" id="limpiarCanvas" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Quitar todos los productos de la lista.">
                            Quitar todos <i class="fas fa-trash"></i>
                        </button>
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

<div class="modal fade" id="capituloModal" tabindex="-1" aria-labelledby="capituloModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="capituloModalLabel">Agregar Capítulo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col me-auto">
                        <input type="text" class="form-control" id="capituloTitulo" placeholder="Ingrese el título del capítulo">
                    </div>
                    <div class="col col-auto">
                        <button type="button" class="btn btn-light-primary" id="saveCapituloBtn">Guardar <i class="fa fa-check-circle"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let productosArrastrados = [];

// Función para limpiar productos del almacenamiento
function limpiarProductos() {
    localStorage.removeItem('productosArrastrados');
}

// Función para permitir el evento de arrastre
function allowDrop(event) {
    event.preventDefault();
}

// Función para manejar el evento de arrastre
function drag(event) {
    event.dataTransfer.setData("text", event.target.id);
}

// Función para manejar el evento de soltado (drop)
function drop(event) {
    if (window.drop_function !== undefined && window.drop_function === 2) {
        drop2(event);
        return;
    }

    console.log("DEV: DROP-EVENT 1");
    event.preventDefault();

    const data = event.dataTransfer.getData("text");
    const draggedElement = document.getElementById(data);

    if (!draggedElement) {
        console.error("Elemento arrastrado no encontrado.");
        return;
    }

    // Obtener los elementos del producto
    const productoIdElem = draggedElement.querySelector('.producto-id');
    const productoNombreElem = draggedElement.querySelector('.producto-nombre');
    const productoPrecioElem = draggedElement.querySelector('.producto-precio');
    const productoStockElem = draggedElement.querySelector('.producto-stock');
    const productoTipoElem = draggedElement.querySelector('.producto-tipo'); // Asegúrate de que el selector es correcto

    if (!productoIdElem || !productoNombreElem || !productoPrecioElem || !productoStockElem || !productoTipoElem) {
        console.error("Algunos elementos del producto no se encontraron.");
        console.log("ID Element:", productoIdElem);
        console.log("Nombre Element:", productoNombreElem);
        console.log("Precio Element:", productoPrecioElem);
        console.log("Stock Element:", productoStockElem);
        console.log("Tipo Element:", productoTipoElem);
        return;
    }

    const productoId = parseInt(productoIdElem.textContent.trim());
    const productoNombre = productoNombreElem.textContent.trim();
    const productoPrecio = parseFloat(productoPrecioElem.textContent.trim());
    const productoStock = parseInt(productoStockElem.textContent.trim());
    const productoTipo = productoTipoElem.textContent.trim(); // Asegúrate de que estás obteniendo el texto correctamente

    if (!productoTipo) {
        console.error("Tipo del producto es null o vacío.");
    }

    const productoExistente = productosArrastrados.find(producto => producto.id === productoId);
    if (!productoExistente) {
        productosArrastrados.push({
            id: productoId,
            nombre: productoNombre,
            precio: productoPrecio,
            stock: productoStock,
            cantidad: 1,
            tipo: productoTipo // Incluir el tipo
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

// Función para manejar el reordenamiento con drop2
function drop2(event) {
    window.drop_function = 1;
    console.log("DEV: DROP-EVENT 2");
    event.preventDefault();

    const x = event.clientX;
    const y = event.clientY;

    const elementoDebajoDelRaton = document.elementFromPoint(x, y);
    const fila_destino = $(elementoDebajoDelRaton).closest("tr");

    if (fila_destino.length && !fila_destino.is(window.fila_original)) {
        const posicionOriginal = window.fila_original.index();
        const posicionDestino = fila_destino.index();

        console.log('Posición original:', posicionOriginal);
        console.log('Posición destino:', posicionDestino);

        if (posicionOriginal < posicionDestino) {
            fila_destino.after(window.fila_original);
        } else {
            fila_destino.before(window.fila_original);
        }

        // Reordenar productosArrastrados
        const productoId = window.fila_original.data('producto-id');
        const producto = productosArrastrados.find(p => p.id === productoId);
        if (producto) {
            productosArrastrados = productosArrastrados.filter(p => p.id !== productoId);
            productosArrastrados.splice(posicionDestino, 0, producto);
        }

        // Aplicar estilo para confirmar la acción
        //$(elementoDebajoDelRaton).css('border', '2px solid red');
    } else {
        console.log("No se puede soltar la fila sobre sí misma.");
    }

    actualizarOrdenProductos();
}

// Evento para mostrar el modal de capítulo
$('#agregarCap').on('click', function() {
    $('#capituloModal').modal('show');
});

// Evento para agregar un capítulo cuando se hace clic en "Guardar"
$('#saveCapituloBtn').on('click', function() {
    const tituloCapitulo = $('#capituloTitulo').val().trim();

    if (tituloCapitulo === '') {
        alert('El título del capítulo no puede estar vacío.');
        return;
    }

    // Crear objeto capítulo y agregarlo a productosArrastrados
    const nuevoCapitulo = {
        id: null, // ID vacío o null para capítulos
        titulo: tituloCapitulo,
        tipo: 'capitulo',
        orden: productosArrastrados.length + 1, // Orden basado en la cantidad actual
        descripcion: '' // Puede ser rellenado o dejado vacío
    };

    productosArrastrados.push(nuevoCapitulo);

    // Actualizar la tabla con el nuevo capítulo
    actualizarListaProductos();

    // Cerrar el modal
    $('#capituloModal').modal('hide');
    $('#capituloTitulo').val(''); // Limpiar el campo de título
});

// Función para actualizar la lista de productos y capítulos
function actualizarListaProductos() {
    const tableBody = $('#productos-table-body');
    tableBody.empty();

    productosArrastrados.forEach((producto, index) => {
        console.log('Producto:', producto);

        const tr = $('<tr></tr>');
        tr.attr('data-producto-id', producto.id);
        tr.addClass('item');
        tr.attr('draggable', true);

        if (producto.tipo === 'capitulo') {
            // Para capítulos, solo muestra título y descripción
            const tdTitulo = $('<td class="align-middle"></td>');
            tdTitulo.text(producto.titulo);
            const tdDescripcion = $('<td class="align-middle"></td>');
            const descripcionInput = $('<textarea class="form-control"></textarea>');
            descripcionInput.attr('name', `descripcion_capitulo_${index + 1}`);
            descripcionInput.val(producto.descripcion || ''); // Asegúrate de que la descripción esté correctamente inicializada
            descripcionInput.on('change', function() {
                producto.descripcion = $(this).val();
            });
            tdDescripcion.append(descripcionInput);

            const tdAcciones = $('<td class="align-middle"></td>');
            const eliminarBtn = $('<button></button>');
            eliminarBtn.attr('type', 'button');
            eliminarBtn.addClass('btn btn-danger btn-sm');
            eliminarBtn.html('<i class="fa-solid fa-trash"></i>');
            eliminarBtn.on('click', function() {
                tr.remove();
                productosArrastrados = productosArrastrados.filter(p => p !== producto);
                actualizarOrdenProductos();
            });
            tdAcciones.append(eliminarBtn);

            const ordenInput = $('<input>');
            ordenInput.attr({
                type: 'hidden',
                class: 'orden-producto',
                name: `orden_producto_${index + 1}`,
                value: producto.orden
            });

            const tipoInput = $('<input>');
            tipoInput.attr({
                type: 'hidden',
                class: 'tipo-producto',
                name: `tipo_producto_${index + 1}`,
                value: producto.tipo
            });

            tr.append(tdTitulo, tdDescripcion, tdAcciones, ordenInput, tipoInput);
        } else {
            // Para productos normales (línea)
            const tdNombre = $('<td class="align-middle"></td>');
            tdNombre.text(producto.nombre);

            const tdDescripcion = $('<td class="align-middle"></td>');
            const descripcionInput = $('<textarea class="form-control"></textarea>');
            descripcionInput.attr('name', `descripcion_producto_${index + 1}`);
            descripcionInput.val(producto.descripcion || '');
            descripcionInput.on('change', function() {
                producto.descripcion = $(this).val();
            });
            tdDescripcion.append(descripcionInput);

            const tdCantidad = $('<td class="align-middle"></td>');
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
                productosArrastrados = productosArrastrados.filter(p => p !== producto);
                actualizarOrdenProductos();
                actualizarPrecioTotal();
            });
            tdAcciones.append(eliminarBtn);

            const ordenInput = $('<input>');
            ordenInput.attr({
                type: 'hidden',
                class: 'orden-producto',
                name: `orden_producto_${index + 1}`,
                value: index + 1
            });

            const tipoInput = $('<input>');
            tipoInput.attr({
                type: 'hidden',
                class: 'tipo-producto',
                name: `tipo_producto_${index + 1}`,
                value: producto.tipo
            });

            tr.append(tdNombre, tdDescripcion, tdCantidad, tdPrecio, tdPrecioTotal, tdAcciones, ordenInput, tipoInput);
        }

        tableBody.append(tr);

        // Hacer la fila arrastrable
        tr.on('dragstart', function(e) {
            $(this).addClass('dragging');
            window.fila_original = tr;
            window.drop_function = 2;
            e.originalEvent.dataTransfer.setData('text/plain', producto.id);
        });

        tr.on('dragend', function() {
            $(this).removeClass('dragging');
            actualizarOrdenProductos();
        });
    });

    actualizarPrecioTotal();
}

function actualizarOrdenProductos() {
    $('#productos-table-body tr').each(function(index) {
        const productoId = $(this).data('producto-id') || null; // Manejar null para capítulos
        const productoTipo = $(this).find('.tipo-producto').val();

        console.log(`Procesando producto de tipo: ${productoTipo}, ID: ${productoId}`);

        // Busca el producto o capítulo en la lista por su tipo y ID
        const producto = productosArrastrados.find(p => p.id === productoId && p.tipo === productoTipo);

        if (producto) {
            producto.orden = index + 1; // Actualiza el orden en el objeto
            $(this).find('.orden-producto').val(producto.orden); // Actualiza el valor en el input oculto
            console.log(`Orden actualizado para ${productoTipo} con ID ${productoId}: ${producto.orden}`);
        } else {
            console.log(`No se encontró producto o capítulo en la lista con tipo: ${productoTipo} y ID: ${productoId}`);
        }
    });
}




// Función para actualizar el precio total
function actualizarPrecioTotal() {
    let total = 0;
    productosArrastrados.forEach(producto => {
        if (producto.tipo !== 'capitulo') { // Los capítulos no afectan el precio total
            total += producto.precio * producto.cantidad;
        }
    });
    // Actualiza el campo del precio total en la interfaz (si existe)
    $('#precioTotal').text(total.toFixed(2) + '€');
}

// Evento para limpiar la tabla
document.getElementById("limpiarCanvas").addEventListener("click", function() {
    const tableBody = document.getElementById("productos-table-body");
    tableBody.innerHTML = "";
    productosArrastrados = [];
    actualizarPrecioTotal();
});

// Función para agregar un producto a la lista
function agregarProducto(productoId) {
    const productoElement = document.querySelector(`#producto-${productoId}`);

    if (!productoElement) {
        console.error('Producto no encontrado.');
        return;
    }

    const productoNombre = productoElement.querySelector('.producto-nombre').textContent;
    const productoPrecio = parseFloat(productoElement.querySelector('.producto-precio').textContent);
    const productoStock = parseInt(productoElement.querySelector('.producto-stock').textContent);

    const productoExistente = productosArrastrados.find(producto => producto.id === productoId);
    if (productoExistente) {
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
    } else {
        productosArrastrados.push({
            id: productoId,
            nombre: productoNombre,
            precio: productoPrecio,
            stock: productoStock,
            cantidad: 1
        });
    }
    actualizarListaProductos();
}


function agregarProducto(productoId) {
    const productoElement = document.querySelector(`#producto-${productoId}`);

    if (!productoElement) {
        console.error('Producto no encontrado.');
        return;
    }

    const productoNombre = productoElement.querySelector('.producto-nombre').textContent;
    const productoPrecio = parseFloat(productoElement.querySelector('.producto-precio').textContent);
    const productoStock = parseInt(productoElement.querySelector('.producto-stock').textContent);

    const productoExistente = productosArrastrados.find(producto => producto.id === productoId);
    if (productoExistente) {
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
    } else {
        productosArrastrados.push({
            id: productoId,
            nombre: productoNombre,
            precio: productoPrecio,
            stock: productoStock,
            cantidad: 1
        });
    }
    actualizarListaProductos();
}




$(document).ready(function() {
    function cargarProductos(params = {}) {
        const url = params.url || '{{ route('presupuesto.getProductos') }}';
        const data = {
            search: $('#search-input').val(),
            order: $('#order-input').val(),
            precio_order: $('#precio_order-input').val(),
            sort_by: $('#sort_by-input').val(),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: url,
            method: 'GET',
            data: data,
            success: function(response) {
                $('#productos-content').html(response.html);
            },
            error: function(xhr, status, error) {
                alert('Error al cargar los productos.');
                console.error(error);
            }
        });
    }

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
        $('#sort_by-input').val('nombre');
        cargarProductos();
    });

    // Manejar clic en botón de ordenar por precio
    $('#precioButton').on('click', function() {
        const currentPrecioOrder = $('#precio_order-input').val();
        const newPrecioOrder = currentPrecioOrder === 'asc' ? 'desc' : 'asc';
        $('#precio_order-input').val(newPrecioOrder);
        $('#sort_by-input').val('precio');
        cargarProductos();
    });

    // Función para cargar productos al hacer clic en la paginación
    $('#productos-container').on('click', '.pagination a', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        cargarProductos({ url: url });
    });

    cargarProductos();

    // Manejar el clic en los enlaces de paginación
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();

        const pageUrl = $(this).attr('href');
        cargarProductos({ url: pageUrl });
    });
});
</script>
@endpush
</x-default-layout>
