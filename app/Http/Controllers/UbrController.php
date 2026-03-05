<?php

namespace App\Http\Controllers;

use App\Models\CatalogoUbr;
use App\Models\CatalogoMunicipio;
use Illuminate\Http\Request;

class UbrController extends Controller
{
    public function index(Request $request)
    {
        $query = CatalogoUbr::withTrashed()
            ->with('municipio')
            ->orderBy('id', 'asc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('descripcion', 'LIKE', "%{$search}%");
            });
        }

        $ubrs = $query->paginate(20);
        $municipios = CatalogoMunicipio::orderBy('descripcion')->get();

        return view('catalogos.ubr', compact('ubrs', 'municipios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'mun_id' => 'required|exists:catalogo_municipios,id'
        ]);

        CatalogoUbr::create([
            'descripcion' => $request->descripcion,
            'mun_id' => $request->mun_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'UBR creado correctamente'
        ]);
    }

    public function update(Request $request, $id)
    {
        $ubr = CatalogoUbr::withTrashed()->findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:255',
            'mun_id' => 'required|exists:catalogo_municipios,id'
        ]);

        $ubr->descripcion = $request->descripcion;
        $ubr->mun_id = $request->mun_id;

        if ($request->has('active')) {
            if ($request->active == 1) {
                if ($ubr->trashed()) $ubr->restore();
            } else {
                if (!$ubr->trashed()) $ubr->delete();
            }
        }

        $ubr->save();

        return response()->json([
            'success' => true,
            'message' => 'UBR actualizado correctamente'
        ]);
    }
}