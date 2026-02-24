<?php

namespace App\Http\Controllers;

use App\Models\CatalogoDepartamento;
use App\Models\CatalogoDirecciones;
use App\Models\CatalogoEdificio;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = CatalogoDepartamento::withTrashed()
            ->with(['direccion', 'edificio'])
            ->orderBy('id', 'asc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('descripcion', 'LIKE', "%{$search}%");
            });
        }

        $departamentos = $query->paginate(20);
        
        $direcciones = CatalogoDirecciones::all();
        $edificios = CatalogoEdificio::all();

        return view('catalogos.departamentos', compact('departamentos', 'direcciones', 'edificios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'id_edif' => 'nullable|integer|exists:catalogo_edificio,id',
            'direccion_id' => 'nullable|integer|exists:catalogo_direcciones,id',
        ]);

        CatalogoDepartamento::create([
            'descripcion' => $request->descripcion,
            'id_edif' => $request->id_edif,
            'direccion_id' => $request->direccion_id,
            'status' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Departamento creado correctamente'
        ]);
    }

    public function update(Request $request, $id)
    {
        $departamento = CatalogoDepartamento::withTrashed()->findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:255',
            'id_edif' => 'nullable|integer|exists:catalogo_edificio,id',
            'direccion_id' => 'nullable|integer|exists:catalogo_direcciones,id',
        ]);

        $departamento->descripcion = $request->descripcion;
        $departamento->id_edif = $request->id_edif;
        $departamento->direccion_id = $request->direccion_id;

        if ($request->has('active')) {
            if ($request->active == 1) {
                if ($departamento->trashed()) {
                    $departamento->restore();
                }
                $departamento->status = 1;
            } else {
                if (!$departamento->trashed()) {
                    $departamento->delete();
                }
                $departamento->status = 0;
            }
        }

        $departamento->save();

        return response()->json([
            'success' => true,
            'message' => 'Departamento actualizado correctamente'
        ]);
    }
}