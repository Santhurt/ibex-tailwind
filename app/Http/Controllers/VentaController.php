<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\VentaRequest;
use App\Models\Empleado;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $ventas = Venta::paginate();

        return view('venta.index', compact('ventas'))
            ->with('i', ($request->input('page', 1) - 1) * $ventas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $productos = Producto::where("stock", ">", 0)->get();
        $empleados = Empleado::all();

        return view('venta.create', compact('productos', 'empleados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
 #       dd("entro");

        DB::beginTransaction();

        try {
            foreach ($request->productos as $producto) {
                $productosModel = Producto::find($producto["id"]);

                if ($productosModel->stock < $producto["cantidad"]) {
                    throw new \Exception("Stock insuficiente para el producto: {$productosModel->nombre}");
                }
            }

            $total = 0;

            foreach ($request->productos as $producto) {
                $subtotal = $producto["cantidad"] * $producto["precio"];
                $total += $subtotal;
            }

            $venta = Venta::create([
                "fecha" => Carbon::now(),
                "total" => $total,
                "empleado_id" => Auth::id()
            ]);

            foreach ($request->productos as $producto) {
                $subtotal = $producto["cantidad"] * $producto["precio"];

                DB::table("venta_producto")->insert([
                    "id_venta" => $venta->id,
                    "id_producto" => $producto["id"],
                    "cantidad" => $producto["cantidad"],
                    "subtotal" => $subtotal

                ]);

                $productosModel = Producto::find($producto["id"]);
                $productosModel->decrement("stock", $producto["cantidad"]);
            }

            DB::commit();


            return Redirect::route('ventas.index')
                ->with('success', 'Venta creada exitosamente.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear la venta: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $venta = Venta::with(["empleado", "productos"])->findOrFail($id);

        return view("venta.show", compact("venta"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $venta = Venta::find($id);

        return view('venta.edit', compact('venta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VentaRequest $request, Venta $venta): RedirectResponse
    {
        $venta->update($request->validated());

        return Redirect::route('ventas.index')
            ->with('success', 'Venta updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Venta::find($id)->delete();

        return Redirect::route('ventas.index')
            ->with('success', 'Venta deleted successfully');
    }

    public function getProductPrice($id)
    {
        $producto = Producto::find($id);

        if ($producto) {
            return response()->json([
                "precio" => $producto->precio,
                "stock" => $producto->stock,
                "nombre" => $producto->nombre
            ]);
        }

        return response()->json(["error" => "Producto no encontrado"], 404);
    }
}
