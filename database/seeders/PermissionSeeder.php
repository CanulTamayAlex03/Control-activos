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
            // ===== ACTIVOS FIJO =====
            'administrar activos',
            'ver activos',
            'crear activos',
            'editar activos',

            // Movimientos
            'administrar movimientos',
            'traspasos individuales',
            'traspasos multiples',
            'bajas individuales',
            'bajas multiples',
            
            'ver tipos activo',
            'crear tipos activo',
            'editar tipos activo',
            
            'ver status activos',
            'crear status activos',
            'editar status activos',
            
            'ver reportes activos',

            // ===== HERRAMIENTA MENOR =====
            'administrar herramienta',
            'ver herramienta',
            'crear herramienta',
            'editar herramienta',
            
            'ver tipos herramienta',
            'crear tipos herramienta',
            'editar tipos herramienta',
            
            'ver status herramienta',
            'crear status herramienta',
            'editar status herramienta',
            
            'ver reportes herramienta',

            // ===== CATÁLOGOS =====
            'administrar catalogos',
            'ver parametros',
            'crear parametros',
            'editar parametros',
            
            'ver edificios',
            'crear edificios',
            'editar edificios',
            
            'ver departamentos',
            'crear departamentos',
            'editar departamentos',
            
            'ver direcciones',
            'crear direcciones',
            'editar direcciones',
            
            'ver empleados',
            'crear empleados',
            'editar empleados',
            
            'ver eade',
            'crear eade',
            'editar eade',
            
            'ver ubr',
            'crear ubr',
            'editar ubr',
            
            'ver proveedores',
            'crear proveedores',
            'editar proveedores',

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
            'administrar activos',
            'ver activos',
            'crear activos',
            'editar activos',

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
