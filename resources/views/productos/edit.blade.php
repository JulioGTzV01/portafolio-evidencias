<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <h1 class="text-center mb-4">Editar Producto</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/productos/{{ $producto->id }}" method="POST" class="card p-4 shadow">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ $producto->nombre }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <input type="text" name="descripcion" value="{{ $producto->descripcion }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Precio</label>
            <input type="number" name="precio" step="0.01" value="{{ $producto->precio }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="stock" value="{{ $producto->stock }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">
            Actualizar
        </button>

        <a href="/productos" class="btn btn-secondary">
            Volver
        </a>

    </form>

</div>

</body>
</html>