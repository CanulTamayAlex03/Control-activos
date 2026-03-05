<?php

namespace App\Http\Controllers;

use App\Models\CatalogoEade;
use Illuminate\Http\Request;

class EadeController extends Controller
{
    public function index(Request $request)
    {
        $query = CatalogoEade::withTrashed()
            ->orderBy('id', 'asc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('descripcion', 'LIKE', "%{$search}%");
            });
        }

        $eades = $query->paginate(20);

        return view('catalogos.eade', compact('eades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        CatalogoEade::create([
            'descripcion' => $request->descripcion,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'EAD creado correctamente'
        ]);
    }

    public function update(Request $request, $id)
    {
        $eade = CatalogoEade::withTrashed()->findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        $eade->descripcion = $request->descripcion;

        if ($request->has('active')) {
            if ($request->active == "1" || $request->active === 1 || $request->active === true) {
                if ($eade->trashed()) {
                    $eade->restore();
                }
            } else {
                if (!$eade->trashed()) {
                    $eade->delete();
                }
            }
        }

        $eade->save();

        return response()->json([
            'success' => true,
            'message' => 'EAD actualizado correctamente'
        ]);
    }
}