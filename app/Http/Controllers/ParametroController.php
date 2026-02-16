<?php

namespace App\Http\Controllers;

use App\Models\Parametro;
use Illuminate\Http\Request;

class ParametroController extends Controller
{
    public function index(Request $request)
    {
        $query = Parametro::withTrashed()
            ->orderBy('id', 'asc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre_completo', 'LIKE', "%{$search}%")
                  ->orWhere('descripcion', 'LIKE', "%{$search}%")
                  ->orWhere('formato', 'LIKE', "%{$search}%");
            });
        }

        $parametros = $query->paginate(10);

        return view('catalogos.parametros-firmas', compact('parametros'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'formato' => 'nullable|string|max:100'
        ]);

        Parametro::create([
            'nombre_completo' => $request->nombre_completo,
            'descripcion' => $request->descripcion,
            'formato' => $request->formato
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Parámetro de firma creado correctamente'
        ]);
    }

    public function update(Request $request, $id)
    {
        $parametro = Parametro::withTrashed()->findOrFail($id);

        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'formato' => 'nullable|string|max:100'
        ]);

        $parametro->nombre_completo = $request->nombre_completo;
        $parametro->descripcion = $request->descripcion;
        $parametro->formato = $request->formato;

        if ($request->active == 1) {
            if ($parametro->trashed()) {
                $parametro->restore();
            }
        } else {
            if (!$parametro->trashed()) {
                $parametro->delete();
            }
        }

        $parametro->save();

        return response()->json([
            'success' => true,
            'message' => 'Parámetro de firma actualizado correctamente'
        ]);
    }
}