<?php

namespace App\Http\Controllers;

use App\Models\CatalogoProveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $query = CatalogoProveedor::withTrashed()
            ->orderBy('id', 'asc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomcorto', 'LIKE', "%{$search}%")
                    ->orWhere('rz', 'LIKE', "%{$search}%")
                    ->orWhere('rfc', 'LIKE', "%{$search}%")
                    ->orWhere('telefono1', 'LIKE', "%{$search}%")
                    ->orWhere('telefono2', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('grupo') && !empty($request->grupo)) {
            $query->where('grupo', $request->grupo);
        }

        if ($request->has('con_adeudo') && $request->con_adeudo) {
            $query->where('adeudo', '>', 0);
        }

        $proveedores = $query->paginate(20);

        return view('catalogos.proveedores', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'rfc' => $request->rfc ? strtoupper(str_replace(' ', '', trim($request->rfc))) : null,
        ]);
        $request->validate(
            [
                'nomcorto' => 'required|string|max:255',
                'rz' => 'nullable|string|max:255|unique:catalogo_proveedor,rz',
                'rfc' => 'nullable|string|max:13|regex:/^[A-Z0-9]+$/|unique:catalogo_proveedor,rfc',
                'domicilio' => 'nullable|string|max:255',
                'ciudad' => 'nullable|string|max:100',
                'estado' => 'nullable|string|max:50',
                'fecha_alta' => 'nullable|date',
                'telefono1' => 'required|string|max:10',
                'telefono2' => 'nullable|string|max:10',
                'dcredito' => 'nullable|integer',
                'lcredito' => 'nullable|integer',
                'grupo' => 'nullable|integer',
            ],
            [
                'rfc.unique' => 'El RFC ya está registrado',
                'rz.unique' => 'La razón social ya está registrada',
            ]
        );

        CatalogoProveedor::create([
            'nomcorto' => $request->nomcorto,
            'rz' => $request->rz,
            'rfc' => $request->rfc,
            'domicilio' => $request->domicilio,
            'ciudad' => $request->ciudad,
            'estado' => $request->estado,
            'fecha_alta' => $request->fecha_alta ?? now(),
            'telefono1' => $request->telefono1,
            'telefono2' => $request->telefono2,
            'dcredito' => $request->dcredito ?? 0,
            'lcredito' => $request->lcredito ?? 0,
            'adeudo' => 0,
            'grupo' => $request->grupo ?? 0,
            'status' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proveedor creado correctamente'
        ]);
    }

    public function update(Request $request, $id)
    {
        $proveedor = CatalogoProveedor::withTrashed()->findOrFail($id);

        $request->validate([
            'nomcorto' => 'required|string|max:255',
            'rz' => 'nullable|string|max:255',
            'rfc' => 'nullable|string|max:50',
            'domicilio' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:50',
            'fecha_alta' => 'nullable|date',
            'telefono1' => 'required|string|max:10',
            'telefono2' => 'nullable|string|max:10',
            'dcredito' => 'nullable|integer',
            'lcredito' => 'nullable|integer',
            'adeudo' => 'nullable|integer',
            'grupo' => 'nullable|integer',
        ]);

        $proveedor->nomcorto = $request->nomcorto;
        $proveedor->rz = $request->rz;
        $proveedor->rfc = $request->rfc;
        $proveedor->domicilio = $request->domicilio;
        $proveedor->ciudad = $request->ciudad;
        $proveedor->estado = $request->estado;
        $proveedor->fecha_alta = $request->fecha_alta;
        $proveedor->telefono1 = $request->telefono1;
        $proveedor->telefono2 = $request->telefono2;
        $proveedor->dcredito = $request->dcredito ?? 0;
        $proveedor->lcredito = $request->lcredito ?? 0;
        $proveedor->adeudo = $request->adeudo ?? 0;
        $proveedor->grupo = $request->grupo ?? 0;

        if ($request->has('active')) {
            if ($request->active == "1" || $request->active === 1 || $request->active === true) {
                if ($proveedor->trashed()) {
                    $proveedor->restore();
                }
                $proveedor->status = 1;
            } else {
                if (!$proveedor->trashed()) {
                    $proveedor->delete();
                }
                $proveedor->status = 0;
            }
        }

        $proveedor->save();

        return response()->json([
            'success' => true,
            'message' => 'Proveedor actualizado correctamente'
        ]);
    }

    public function actualizarAdeudo(Request $request, $id)
    {
        $request->validate([
            'monto' => 'required|numeric',
            'operacion' => 'required|in:sumar,restar'
        ]);

        $proveedor = CatalogoProveedor::findOrFail($id);

        if ($request->operacion === 'sumar') {
            $proveedor->adeudo += $request->monto;
        } else {
            $proveedor->adeudo -= $request->monto;
        }

        $proveedor->save();

        return response()->json([
            'success' => true,
            'message' => 'Adeudo actualizado correctamente',
            'nuevo_adeudo' => $proveedor->adeudo
        ]);
    }

    public function getSelectList()
    {
        $proveedores = CatalogoProveedor::where('status', 1)
            ->orderBy('nomcorto')
            ->get(['id', 'nomcorto', 'rz', 'rfc']);

        return response()->json($proveedores);
    }
    public function search(Request $request)
    {
        $query = $request->q;

        $proveedores = CatalogoProveedor::where('nomcorto', 'LIKE', "%{$query}%")
            ->limit(10)
            ->pluck('nomcorto');

        return response()->json($proveedores);
    }
}
