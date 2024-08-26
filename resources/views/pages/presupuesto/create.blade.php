<x-default-layout>
    @section('title')
        Nuevo presupuesto
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
                                    <label for="leyenda">Leyenda</label>
                                    <textarea class="form-control" id="leyenda" name="leyenda" rows="3"></textarea>
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

                            Cliente: <strong>{{$cliente->nombre}}</strong>

                            <strong>{{$cliente->apellido}}</strong>

                    </div>

                    <div class="col form-group">

                            Contacto: <strong>{{$cliente->contacto}}</strong>



                            Forma de pago de cliente: <strong>{{$cliente->pago ?: "No hay"}}</strong>

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
                            <button id="agregarCap" class="btn btn-light-success">
                                Agregar capítulo <i class="fas fa-plus-circle"></i>
                            </button>
                        </div>
                    </div>
<script>
var agregarCap = document.getElementById("agregarCap");
agregarCap.addEventListener('click', function(e) {
    e.preventDefault();
    alert("agregar capítulo al presupollo");
});
</script>
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

@push('scripts')
<script>
let productosArrastrados = [];

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
        //console.log("CAMBIANDO A DROP2");
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
    //console.log("DEV: DROP-EVENT 2");
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

        const tdDesc = $('<td class="align-middle"></td>');
        const descInput = $('<textarea></textarea>'); // Cambiado a textarea
        descInput.attr({
            value: producto.leyenda,
            class: 'form-control',
            rows: 2, // Ajustar el número de filas según sea necesario
            cols: 30 // Ajustar el número de columnas según sea necesario
        });
        descInput.text(producto.leyenda); // Usar text en lugar de value para textarea
        tdDesc.append(descInput);

        const tdCantidad = $('<td class="align-middle"></td>');
        const cantidadInput = $('<input>');
        cantidadInput.attr({
            type: 'number',
            value: producto.cantidad,
            min: 1,
            max: producto.stock,
            size: producto.cantidad.toString().length // Ajusta el tamaño al ancho del valor
        });

        cantidadInput.addClass('cantidad-producto form-control');
        cantidadInput.on('input', function() {
            const cantidad = parseInt($(this).val());
            producto.cantidad = cantidad;
            $(this).attr('size', cantidad.toString().length); // Ajusta el ancho al nuevo valor
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
            step: 0.01,
            size: producto.precio.toFixed(2).length // Ajusta el tamaño al ancho del valor
        });

        precioInput.addClass('input-precio-producto form-control');
        precioInput.on('input', function() {
            const precio = parseFloat($(this).val());
            producto.precio = precio;
            $(this).attr('size', precio.toFixed(2).length); // Ajusta el ancho al nuevo valor
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

        tr.append(tdNombre, tdDesc, tdCantidad, tdPrecio, tdPrecioTotal, tdAcciones, ordenInput);
        tableBody.append(tr);

        tr.on('dragstart', function(e) {
            $(this).addClass('dragging');

            window.fila_original = tr;

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
