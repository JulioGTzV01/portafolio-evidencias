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

@if($productos->isEmpty())
<tr>
    <td colspan="4" class="text-center">No se encontraron productos</td>
</tr>
@endif