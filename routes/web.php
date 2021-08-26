<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SolicitudController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// middleware auth: no da acceso a la ruta si el usuario no esta logueado
// middleware verified: no da acceso a la ruta si el usuario no verifico su email

Auth::routes(['verify' => true]);

// Main Page Route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth']);
Route::get('/getContrato/{id}', [DashboardController::class, 'getContrato'])->name('get.contrato');


// Route::get('/', [DashboardController::class,'dashboardEcommerce'])->name('dashboard-ecommerce')->middleware(['auth']);

Route::group(['prefix' => 'contratos'], function () {
    Route::get('/', [ContractsController::class, 'index'])->name('contratos.index');

});

Route::group(['prefix' => 'shop'], function () {
    Route::get('/', [TiendaController::class, 'index'])->name('shop');
    Route::post('/procces', [TiendaController::class, 'procesarOrden'])->name('shop.procces');
    Route::post('/ipn', [TiendaController::class, 'ipn'])->name('shop.ipn');
    Route::post('/{status}/estado', [TiendaController::class, 'statusProcess'])->name('shop.proceso.status');
    Route::post('/cambiarStatus', [TiendaController::class, 'cambiar_status'])->name('cambiarStatus');
});

Route::group(['prefix' => 'reports'], function () {
    Route::get('/purchase', [ReportController::class, 'indexPedidos'])->name('reports.pedidos');
});

Route::group(['prefix' => 'solicitud'], function () {
    Route::get('/retiro', [SolicitudController::class, 'index_retiros'])->name('solicitud.retiros');
});

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
