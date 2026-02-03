<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\PermisosController;
use App\Http\Controllers\ActivoController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ActivoController::class, 'dashboard'])->name('dashboard');

    // Rutas de Activos agrupadas
    Route::prefix('activos')->group(function () {
        Route::get('/create', [ActivoController::class, 'create'])->name('activos.create');
        Route::post('/', [ActivoController::class, 'store'])->name('activos.store');
        Route::get('/{id}', [ActivoController::class, 'show'])->name('activos.show');
        Route::get('/{id}/edit', [ActivoController::class, 'edit'])->name('activos.edit');
        Route::put('/{id}', [ActivoController::class, 'update'])->name('activos.update');
    });;

    // Rutas de Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');

    Route::get('/admin/permisos', [PermisosController::class, 'index'])->name('admin.permisos');
    Route::post('/permisos/crear-rol', [PermisosController::class, 'storeRole'])->name('admin.permisos.storeRole');
    Route::get('/admin/permisos/rol/{role}/edit-ajax', [PermisosController::class, 'editRoleAjax'])->name('admin.permisos.edit-ajax');
    Route::put('/permisos/rol/{role}/actualizar', [PermisosController::class, 'updateRole'])->name('admin.permisos.updateRole');
});
