<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withTrashed()
            ->with('roles')
            ->orderBy('id', 'asc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('email', 'LIKE', "%{$search}%");
        }

        $users = $query->paginate(10);
        $roles = Role::orderBy('name')->get();

        return view('admin.usuarios.usuarios', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado correctamente'
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required'
        ]);

        $user->email = $request->email;

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6'
            ]);
            $user->password = Hash::make($request->password);
        }

        if ($request->active == 1) {
            if ($user->trashed()) {
                $user->restore();
            }
        } else {
            if (!$user->trashed()) {
                $user->delete();
            }
        }

        $user->save();
        $user->syncRoles([$request->role]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente'
        ]);
    }
}