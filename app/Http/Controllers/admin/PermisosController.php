<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermisosController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('admin.permisos.permisos', compact('roles', 'permissions'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array'
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.permisos.permisos')->with('success', 'Rol creado correctamente');
    }

    public function editRoleAjax(Role $role)
    {
        $role->load('permissions');

        return response()->json([
            'rol' => $role,
            'permisos' => Permission::all()
        ]);
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'nullable|array'
        ]);

        $role->update(['name' => $request->name]);

        $role->syncPermissions($request->permissions ?? []);

        return response()->json([
            'success' => true,
            'message' => 'Rol actualizado correctamente'
        ]);
    }
}
