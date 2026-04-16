<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::paginate(8);

        return view('productos.index', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer'
        ]);

        Producto::create($request->all());

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        $producto->update($request->all());

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $producto = Producto::find($id);

        $producto->delete();

        return response()->json(['success' => true]);
    }

    // 🔥 BUSCADOR CON AJAX
    public function buscar(Request $request)
    {
        $texto = $request->texto;

        $productos = Producto::where('nombre', 'like', "%$texto%")->get();

        return view('productos.resultados', compact('productos'));
    }
}
