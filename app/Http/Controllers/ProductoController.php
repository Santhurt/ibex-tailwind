<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Mostrar solo productos activos (estado = 1)
        $productos = Producto::where('estado', 1)->paginate();

        return view('producto.index', compact('productos'))
            ->with('i', ($request->input('page', 1) - 1) * $productos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $producto = new Producto();

        return view('producto.create', compact('producto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoRequest $request): RedirectResponse
    {
        Producto::create($request->validated());

        return Redirect::route('productos.index')
            ->with('success', 'Producto creado con exito.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $producto = Producto::find($id);

        return view('producto.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $producto = Producto::find($id);

        return view('producto.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductoRequest $request, Producto $producto): RedirectResponse
    {
        $producto->update($request->validated());

        return Redirect::route('productos.index')
            ->with('success', 'Producto actualizado con exito');
    }

    public function destroy($id): RedirectResponse
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return Redirect::route('productos.index')
                ->with('error', 'Producto no encontrado');
        }

        try {
            // Cambiar estado a 0 en lugar de eliminar físicamente
            $producto->update(['estado' => 0]);

            return Redirect::route('productos.index')
                ->with('success', 'Producto desactivado con éxito');
        } catch (\Exception $e) {
            return Redirect::route('productos.index')
                ->with('error', 'Error al desactivar el producto: ' . $e->getMessage());
        }
    }
}
