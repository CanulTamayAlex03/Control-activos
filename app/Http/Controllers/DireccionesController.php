<?php

namespace App\Http\Controllers;

use App\Models\CatalogoDirecciones;
use Illuminate\Http\Request;

class DireccionesController extends Controller
{
    public function index(Request $request)
    {
        $query = CatalogoDirecciones::withTrashed()
            ->orderBy('id', 'asc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('descripcion', 'LIKE', "%{$search}%");
            });
        }

        $direcciones = $query->paginate(20);

        return view('catalogos.direcciones', compact('direcciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:150',
        ]);

        CatalogoDirecciones::create([
            'descripcion' => $request->descripcion,
            'status' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dirección creada correctamente'
        ]);
    }

    public function update(Request $request, $id)
    {
        $direccion = CatalogoDirecciones::withTrashed()->findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:150',
        ]);

        $direccion->descripcion = $request->descripcion;

        if ($request->has('active')) {
            if ($request->active == 1) {
                if ($direccion->trashed()) {
                    $direccion->restore();
                }
                $direccion->status = 1;
            } else {
                if (!$direccion->trashed()) {
                    $direccion->delete();
                }
                $direccion->status = 0;
            }
        }

        $direccion->save();

        return response()->json([
            'success' => true,
            'message' => 'Dirección actualizada correctamente'
        ]);
    }
}