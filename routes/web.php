<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| PhPresus
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\VisitaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });

    //
    Route::resource('cliente', ClienteController::class);
    Route::get('/clientes/data', [ClienteController::class, 'getClientesData'])->name('clientes.data');

    //
    Route::resource('presupuesto', PresupuestoController::class);
    Route::get('/presupuesto/{id}/create', [PresupuestoController::class, 'create'])
        ->where('id', '.*')
        ->name('presupuesto.create');
    Route::get('/presupuesto/create/getProductos', [PresupuestoController::class, 'getProductos'])->name('presupuesto.getProductos');

    //
    Route::resource('proyecto', ProyectoController::class);
    Route::get('/proyecto/{id}/show', [ProyectoController::class, 'show'])
        ->where('id', '.*')
        ->name('proyecto.show');

    Route::get('/proyecto/{id}/details', [ProyectoController::class, 'details'])
        ->where('id', '.*')
        ->name('proyecto.details');

    Route::get('/proyecto/{id}/download', [ProyectoController::class, 'download'])
        ->where('id', '.*')
        ->name('proyecto.download');

    Route::get('/proyecto/{id}/downloadBudget', [ProyectoController::class, 'downloadBudget'])
        ->where('id', '.*')
        ->name('proyecto.downloadBudget');

    Route::post('/proyecto/{id}/send-mail', [ProyectoController::class, 'sendMail'])
        ->where('id', '.*')
        ->name('proyecto.sendMail');

    Route::post('/proyecto/{id}/send-mail-budget', [ProyectoController::class, 'sendMailBudget'])
        ->where('id', '.*')
        ->name('proyecto.sendMailBudget');

    Route::delete('/proyecto/{id}', [ProyectoController::class, 'destroy'])
        ->where('id', '.*')
        ->name('proyecto.destroy');

    Route::post('/proyecto/{id}/aceptar', [ProyectoController::class, 'aceptar'])
        ->where('id', '.*')
        ->name('proyecto.aceptar');

    Route::post('/proyecto/{id}/cerrar', [ProyectoController::class, 'cerrar'])
        ->where('id', '.*')
        ->name('proyecto.cerrar');

    //
    Route::resource('visita', VisitaController::class);
    Route::post('/visita/{id}/cerrar', [VisitaController::class, 'cerrar'])->name('visita.cerrar');
    Route::get('/visitas/semana', [DashboardController::class, 'getVisitasSemana'])->name('visita.semana');
    //
    Route::resource('producto', ProductoController::class);
    Route::get('/productos/bajo-stock', [DashboardController::class, 'getProductosBajoStock'])->name('productos.bajo.stock');

    //
    Route::resource('user', UserController::class);
    Route::get('/user/{id}/getUltimaModif', [UserController::class, 'getUltimaModif'])->name('user.getUltimaModif');

    Route::resource('log', LogController::class);
});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
