<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-3">
    <h4>Bienvenido, {{ auth()->user()->name }}</h4>

    <form method="POST" action="/logout">
        @csrf
        <button class="btn btn-danger btn-sm">Cerrar sesión</button>
    </form>
    </div>

    <h1 class="text-center mb-4">Lista de productos</h1>

    <button class="btn btn-success mb-3"
        data-bs-toggle="modal" 
        data-bs-target="#modalProducto"
        onclick="limpiarFormulario()">
        Agregar producto
    </button>

    <!-- 🔍 BUSCADOR -->
    <input type="text" id="buscador" class="form-control mb-3" placeholder="Buscar producto...">

    <table class="table table-bordered bg-white">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody id="tablaProductos">
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->precio }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>

                        <button class="btn btn-primary btn-sm"
                        onclick="editarProducto({{ $producto->id }}, '{{ $producto->nombre }}', {{ $producto->precio }}, {{ $producto->stock }})">
                        Editar
                        </button>

                        <button class="btn btn-danger btn-sm" onclick="eliminarProducto({{ $producto->id }}, this)">
                            Eliminar
                        </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $productos->links("pagination::bootstrap-5") }}

</div>

<!-- MODAL -->
<div class="modal fade" id="modalProducto">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Producto</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="formProducto">
            @csrf
            <input type="hidden" id="producto_id">

            <input type="text" id="nombre" placeholder="Nombre" class="form-control mb-2">
            <input type="number" step="0.01" id="precio" placeholder="Precio" class="form-control mb-2">
            <input type="number" id="stock" placeholder="Stock" class="form-control mb-2">

            <button class="btn btn-primary">Guardar</button>
        </form>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let editando = false;

// 🔥 LIMPIAR FORMULARIO
function limpiarFormulario() {
    editando = false;

    document.getElementById('producto_id').value = '';
    document.getElementById('nombre').value = '';
    document.getElementById('precio').value = '';
    document.getElementById('stock').value = '';
}

// ✏️ EDITAR
function editarProducto(id, nombre, precio, stock) {
    editando = true;

    document.getElementById('producto_id').value = id;
    document.getElementById('nombre').value = nombre;
    document.getElementById('precio').value = precio;
    document.getElementById('stock').value = stock;

    let modal = new bootstrap.Modal(document.getElementById('modalProducto'));
    modal.show();
}

// 💾 GUARDAR
document.getElementById('formProducto').addEventListener('submit', function(e){
    e.preventDefault();

    let id = document.getElementById('producto_id').value;
    let url = editando ? `/productos/${id}` : '/productos';

    let datos = {
        nombre: document.getElementById('nombre').value,
        precio: document.getElementById('precio').value,
        stock: document.getElementById('stock').value,
        _token: '{{ csrf_token() }}',
        _method: editando ? 'PUT' : 'POST'
    };

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: editando ? 'Producto actualizado' : 'Producto agregado',
            text: 'Todo salió correctamente',
            timer: 1500,
            showConfirmButton: false
        });

        setTimeout(() => {
            location.reload();
        }, 1500);
    });
});

// 🗑️ ELIMINAR
function eliminarProducto(id, boton) {

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Este producto se eliminará",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {

        if (result.isConfirmed) {

            fetch(`/productos/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                })
            })
            .then(res => res.json())
            .then(data => {

                Swal.fire({
                    icon: 'success',
                    title: 'Eliminado',
                    text: 'Producto eliminado correctamente',
                    timer: 1500,
                    showConfirmButton: false
                });

                let fila = boton.closest('tr');
                fila.remove();
            });
        }
    });
}

// 🔍 BUSCADOR CON DEBOUNCE
let timeoutBusqueda = null;

document.getElementById('buscador').addEventListener('keyup', function () {
    let texto = this.value;

    clearTimeout(timeoutBusqueda);

    timeoutBusqueda = setTimeout(() => {

        if (texto.trim() === '') {
            location.reload();
            return;
        }

        fetch(`/productos/buscar?texto=${texto}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById('tablaProductos').innerHTML = html;
            });
    }, 400);
});
</script>

</body>
</html>

