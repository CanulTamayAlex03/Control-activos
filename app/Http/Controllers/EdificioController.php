<?php

namespace App\Http\Controllers;

use App\Models\CatalogoEdificio;
use Illuminate\Http\Request;

class EdificioController extends Controller
{
    public function index(Request $request)
    {
        $query = CatalogoEdificio::withTrashed()
            ->orderBy('id', 'asc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('descripcion', 'LIKE', "%{$search}%");
            });
        }

        $edificios = $query->paginate(20);

        return view('catalogos.edificios', compact('edificios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        CatalogoEdificio::create([
            'descripcion' => $request->descripcion,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Edificio creado correctamente'
        ]);
    }

    public function update(Request $request, $id)
    {
        $edificio = CatalogoEdificio::withTrashed()->findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        $edificio->descripcion = $request->descripcion;

        if ($request->has('active')) {
            if ($request->active == "1" || $request->active === 1 || $request->active === true) {
                if ($edificio->trashed()) {
                    $edificio->restore();
                }
            } else {
                if (!$edificio->trashed()) {
                    $edificio->delete();
                }
            }
        }

        $edificio->save();

        return response()->json([
            'success' => true,
            'message' => 'Edificio actualizado correctamente'
        ]);
    }
}