<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\PermisosController;
use App\Http\Controllers\ActivoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParametroController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ACTIVOS
    Route::prefix('activos')->name('activos.')->group(function () {
        Route::get('/', [ActivoController::class, 'index'])->name('index');

        Route::view('/activos_tipos', 'activos.activos_tipos')
            ->name('activos_tipos');

        Route::view('/activos_estatus', 'activos.activos_estatus')
            ->name('activos_estatus');

        Route::view('/activos_reportes', 'activos.activos_reportes')
            ->name('activos_reportes');

        Route::get('/search', [ActivoController::class, 'search'])->name('search');

        Route::get(
            '/{folio}/resguardo',
            [ActivoController::class, 'resguardo']
        )->name('resguardo');

        Route::get(
            '/{folio}/print/frm23',
            [ActivoController::class, 'printFrm23']
        )->name('print.frm23');

        Route::get('/create', [ActivoController::class, 'create'])->name('create');
        Route::post('/', [ActivoController::class, 'store'])->name('store');
        Route::get('/{id}', [ActivoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ActivoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ActivoController::class, 'update'])->name('update');
    });

    Route::prefix('herramienta-menor')
        ->name('herramienta-menor.')
        ->group(function () {

            Route::get('/', function () {
                return view('herramienta-menor.index');
            })->name('index');

            Route::get('/tipos', function () {
                return view('herramienta-menor.tipos');
            })->name('tipos');

            Route::get('/estatus', function () {
                return view('herramienta-menor.estatus');
            })->name('estatus');

            Route::get('/reportes', function () {
                return view('herramienta-menor.reportes');
            })->name('reportes');
        });

    Route::prefix('catalogos')->name('catalogos.')->group(function () {

        Route::get('/parametros-firmas', [ParametroController::class, 'index'])->name('parametros-firmas');
        Route::post('/parametros-firmas', [ParametroController::class, 'store'])->name('parametros-firmas.store');
        Route::put('/parametros-firmas/{id}', [ParametroController::class, 'update'])->name('parametros-firmas.update');

        Route::get('/edificios', fn() => view('catalogos.edificios'))
            ->name('edificios');

        Route::get('/departamentos', fn() => view('catalogos.departamentos'))
            ->name('departamentos');

        Route::get('/subgerencias', fn() => view('catalogos.subgerencias'))
            ->name('subgerencias');

        Route::get('/empleados', fn() => view('catalogos.empleados'))
            ->name('empleados');
    });


    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');

    Route::get('/admin/permisos', [PermisosController::class, 'index'])->name('admin.permisos');
    Route::post('/permisos/crear-rol', [PermisosController::class, 'storeRole'])->name('admin.permisos.storeRole');
    Route::get('/admin/permisos/rol/{role}/edit-ajax', [PermisosController::class, 'editRoleAjax'])->name('admin.permisos.edit-ajax');
    Route::put('/permisos/rol/{role}/actualizar', [PermisosController::class, 'updateRole'])->name('admin.permisos.updateRole');
});
