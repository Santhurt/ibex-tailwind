<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EmpleadoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $empleados = Empleado::paginate();

        return view('empleado.index', compact('empleados'))
            ->with('i', ($request->input('page', 1) - 1) * $empleados->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $empleado = new Empleado();

        return view('empleado.create', compact('empleado'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmpleadoRequest $request): RedirectResponse
    {
        Empleado::create($request->validated());

        return Redirect::route('empleados.index')
            ->with('success', 'Empleado creado con exito.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $empleado = Empleado::find($id);

        return view('empleado.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $empleado = Empleado::find($id);

        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmpleadoRequest $request, Empleado $empleado): RedirectResponse
    {
        $empleado->update($request->validated());

        return Redirect::route('empleados.index')
            ->with('success', 'Empleado actualizado con exito');
    }

    public function destroy($id): RedirectResponse
    {
        $empleadoAutenticado = Auth::id();
        $empleadoAEliminar = Empleado::find($id);

        if (!$empleadoAEliminar) {
            return Redirect::route('empleados.index')
                ->with('error', 'Empleado no encontrado');
        }

        // Verificar que no sea el empleado autenticado
        if ($empleadoAEliminar->id == $empleadoAutenticado) {
            return Redirect::route('empleados.index')
                ->with('error', 'No puedes eliminarte a ti mismo');
        }

        // Verificar si el empleado tiene ventas asociadas
        $tieneVentas = $empleadoAEliminar->ventas()->exists();

        if ($tieneVentas) {
            $cantidadVentas = $empleadoAEliminar->ventas()->count();
            return Redirect::route('empleados.index')
                ->with('error', "No se puede eliminar el empleado porque tiene {$cantidadVentas} venta(s) asociada(s)");
        }

        try {
            $empleadoAEliminar->delete();
            return Redirect::route("empleados.index")
                ->with("success", "Empleado eliminado con éxito");
        } catch (\Exception $e) {
            return Redirect::route('empleados.index')
                ->with('error', 'Error al eliminar el empleado: ' . $e->getMessage());
        }
    }
}
