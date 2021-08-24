<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContratosController;

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

// Main Page Route
// Route::get('/', [DashboardController::class,'dashboardEcommerce'])->name('dashboard-ecommerce')->middleware('verified');

Route::get('/', [DashboardController::class, 'dashboardAnalytics'])->name('dashboard-analytics');

Route::group(['prefix' => 'contratos'], function () {
    Route::get('/', [ContratosController::class, 'index'])->name('contratos.index');

});

Route::prefix('shop')->group(function ()
{
    Route::get('/', 'TiendaController@index')->name('shop');
    Route::get('/groups/{idgroup}/products', 'TiendaController@products')->name('shop.products');
    Route::post('/procces', 'TiendaController@procesarOrden')->name('shop.procces');
    Route::post('/ipn', 'TiendaController@ipn')->name('shop.ipn');
    Route::get('/{status}/estado', 'TiendaController@statusProcess')->name('shop.proceso.status');
    Route::post('cambiarStatus', 'TiendaController@cambiar_status')->name('cambiarStatus');
});

//Rutas para los reportes
Route::prefix('reports')->group(function(){
    Route::get('purchase', 'ReporteController@indexPedidos')->name('reports.pedidos');
    Route::get('commission', 'ReporteController@indexComision')->name('reports.comision');
});

Auth::routes(['verify' => true]);


// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
