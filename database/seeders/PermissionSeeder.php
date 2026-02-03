<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permisos = [
            // Activos
            'ver activos',
            'crear activos',
            'editar activos',
            'eliminar activos',
            'importar activos',
            'exportar activos',

            // Usuarios
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',

            // Roles y permisos
            'ver permisos',
            'crear roles',
            'editar permisos',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        $superadmin = Role::firstOrCreate(['name' => 'superadmin']);
        $admin      = Role::firstOrCreate(['name' => 'admin']);
        $user       = Role::firstOrCreate(['name' => 'user']);


        $superadmin->syncPermissions(Permission::all());

        $admin->syncPermissions([
            // Activos
            'ver activos',
            'crear activos',
            'editar activos',
            'eliminar activos',
            'importar activos',
            'exportar activos',

            // Usuarios
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',

            // Permisos (solo ver)
            'ver permisos',
        ]);

        // User = solo lectura
        $user->syncPermissions([
            'ver activos',
        ]);

        // ===== USUARIO SUPERADMIN =====
        $superUser = User::firstOrCreate(
            ['email' => 'superadmin@yucatan.gob.mx'],
            [
                'name' => 'Super Administrador',
                'password' => Hash::make('admin2019'),
            ]
        );

        if (!$superUser->hasRole('superadmin')) {
            $superUser->assignRole('superadmin');
        }

        echo "Roles, permisos y SuperAdmin creados correctamente\n";
    }
}
