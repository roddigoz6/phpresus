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
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });

    Route::resource('categoria', CategoriaController::class);
    Route::resource('cliente', ClienteController::class);
    Route::resource('factura', FacturaController::class);
    Route::resource('orden', OrdenController::class);
    Route::resource('presupuesto', PresupuestoController::class);
    Route::resource('producto', ProductoController::class);
    Route::resource('user', UserController::class);

    Route::get('/presupuesto/create/getProductos', [PresupuestoController::class, 'getProductos'])->name('presupuesto.getProductos');

    Route::get('/presupuesto/{presupuesto}/download', [PresupuestoController::class, 'download'])->name('presupuesto.download');
    Route::post('/presupuesto/send-mail/{presupuestoId}', [PresupuestoController::class, 'sendMail'])->name('presupuesto.sendMail');

    Route::get('/orden/{orden}/download', [OrdenController::class, 'download'])->name('orden.download');
    Route::post('/orden/send-mail/{ordenId}', [OrdenController::class, 'sendMail'])->name('orden.sendMail');

    Route::get('/productos/bajo-stock', [DashboardController::class, 'getProductosBajoStock'])->name('productos.bajo.stock');

});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
