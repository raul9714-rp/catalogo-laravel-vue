<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        // parametros ?sort=asc o ?sort=desc para ordenar
        $sort = $request->query('sort', 'desc');

        // Retornar productos con paginacion 
        return Producto::orderBy('created_at', $sort)->paginate(3);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|alpha_num|unique:productos,codigo',
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'fotografia' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1536',
            'fecha_ingreso' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_ingreso',
        ]);

        if ($request->hasFile('fotografia')) {
            $path = $request->file('fotografia')->store('productos', 'public');
            $validated['fotografia'] = $path;
        }
    

        $producto = Producto::create($validated);

        return response()->json($producto, 201);
    }

    public function show($id)
    {
        return Producto::findOrFail($id);
    }

    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'codigo' => 'required|alpha_num|unique:productos,codigo,' . $producto->id,
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'fotografia' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1536',
            'fecha_ingreso' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_ingreso',
        ]);

        if ($request->hasFile('fotografia')) {
            $path = $request->file('fotografia')->store('productos', 'public');
            $validated['fotografia'] = $path;
        }


        $producto->update($validated);

        return response()->json($producto);
    }

    public function destroy($id)
    {
        Producto::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
