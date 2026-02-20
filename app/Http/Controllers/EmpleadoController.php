<?php

namespace App\Http\Controllers;

use App\Models\CatalogoEmpleado;
use App\Models\CatalogoDepartamento;
use App\Models\CatalogoEdificio;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        $query = CatalogoEmpleado::withTrashed()
            ->with(['departamento', 'edificio'])
            ->orderBy('id', 'asc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('no_nomi', 'LIKE', "%{$search}%");
            });
        }

        $empleados = $query->paginate(20);
        
        $departamentos = CatalogoDepartamento::all();
        $edificios = CatalogoEdificio::all();

        return view('catalogos.empleados', compact('empleados', 'departamentos', 'edificios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'no_nomi' => 'nullable|string|max:50',
            'id_depto' => 'nullable|exists:catalogo_departamento,id',
            'id_edif' => 'nullable|exists:catalogo_edificio,id',
        ]);

        CatalogoEmpleado::create([
            'nombre' => $request->nombre,
            'no_nomi' => $request->no_nomi,
            'id_depto' => $request->id_depto,
            'id_edif' => $request->id_edif,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Empleado creado correctamente'
        ]);
    }

    public function update(Request $request, $id)
    {
        $empleado = CatalogoEmpleado::withTrashed()->findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'no_nomi' => 'nullable|string|max:50',
            'id_depto' => 'nullable|exists:catalogo_departamento,id',
            'id_edif' => 'nullable|exists:catalogo_edificio,id',
        ]);

        $empleado->nombre = $request->nombre;
        $empleado->no_nomi = $request->no_nomi;
        $empleado->id_depto = $request->id_depto;
        $empleado->id_edif = $request->id_edif;

        if ($request->has('active')) {
            if ($request->active == "1" || $request->active === 1 || $request->active === true) {
                if ($empleado->trashed()) {
                    $empleado->restore();
                }
            } else {
                if (!$empleado->trashed()) {
                    $empleado->delete();
                }
            }
        }

        $empleado->save();

        return response()->json([
            'success' => true,
            'message' => 'Empleado actualizado correctamente'
        ]);
    }
}