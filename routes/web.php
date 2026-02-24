<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\PermisosController;
use App\Http\Controllers\ActivoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParametroController;
use App\Http\Controllers\EdificioController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\DireccionesController;
use App\Http\Controllers\DepartamentoController;


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

        Route::post(
            '/{folio}/resguardo',
            [ActivoController::class, 'resguardo']
        )->name('resguardo');


        Route::get(
            '/{folio}/modal-resguardo',
            [ActivoController::class, 'mostrarModalResguardo']
        )->name('modal-resguardo');

        Route::get(
            '/{folio}/print/frm23',
            [ActivoController::class, 'printFrm23']
        )->name('print.frm23');

        Route::get('/create', [ActivoController::class, 'create'])->name('create');
        Route::post('/', [ActivoController::class, 'store'])->name('store');
        Route::get('/{id}', [ActivoController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ActivoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ActivoController::class, 'update'])->name('update');
        Route::get('/create/{tipo}', [ActivoController::class, 'create'])->name('create.tipo');
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

        Route::get('/edificios', [EdificioController::class, 'index'])->name('edificios');
        Route::post('/edificios', [EdificioController::class, 'store'])->name('edificios.store');
        Route::put('/edificios/{id}', [EdificioController::class, 'update'])->name('edificios.update');

        Route::get('/departamentos', [DepartamentoController::class, 'index'])->name('departamentos');
        Route::post('/departamentos', [DepartamentoController::class, 'store'])->name('departamentos.store');
        Route::put('/departamentos/{id}', [DepartamentoController::class, 'update'])->name('departamentos.update');

        Route::get('/direcciones', [DireccionesController::class, 'index'])->name('direcciones');
        Route::post('/direcciones', [DireccionesController::class, 'store'])->name('direcciones.store');
        Route::put('/direcciones/{id}', [DireccionesController::class, 'update'])->name('direcciones.update');

        Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados');
        Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');
        Route::put('/empleados/{id}', [EmpleadoController::class, 'update'])->name('empleados.update');
    });


    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');

    Route::get('/admin/permisos', [PermisosController::class, 'index'])->name('admin.permisos');
    Route::post('/permisos/crear-rol', [PermisosController::class, 'storeRole'])->name('admin.permisos.storeRole');
    Route::get('/admin/permisos/rol/{role}/edit-ajax', [PermisosController::class, 'editRoleAjax'])->name('admin.permisos.edit-ajax');
    Route::put('/permisos/rol/{role}/actualizar', [PermisosController::class, 'updateRole'])->name('admin.permisos.updateRole');
});
