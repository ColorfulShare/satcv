<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContratosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;

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

// Auth::routes(['verify' => true]);

// Main Page Route
Route::get('/', [DashboardController::class, 'dashboardAnalytics'])->name('dashboard-analytics')->middleware(['auth']);

Route::get('/', [DashboardController::class,'dashboardEcommerce'])->name('dashboard-ecommerce')->middleware(['auth']);

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


//Ruta de los Tickets
Route::prefix('ticket')->middleware(['auth'])->group(function(){

    // Para el usuario
    Route::get('create', [TicketController::class,'create'])->name('ticket.create');
    Route::post('store', [TicketController::class,'store'])->name('ticket.store');
    Route::get('edit-user/{id}', [TicketController::class,'editUser'])->name('ticket.edit-user');
    Route::patch('update-user/{id}', [TicketController::class,'editUser'])->name('ticket.update-user');
    Route::get('list-user', [TicketController::class,'indexUser'])->name('ticket.list-user');
    Route::get('show-user/{id}', [TicketController::class,'showUser'])->name('ticket.show-user');

    // Para el Admin
    Route::get('edit-admin/{id}', [TicketController::class,'editAdmin'])->name('ticket.edit-admin');
    Route::patch('update-admin/{id}', [TicketController::class,'updateAdmin'])->name('ticket.update-admin');
    Route::get('list-admin', [TicketController::class,'indexAdmin'])->name('ticket.list-admin');
    Route::get('show-admin/{id}', [TicketController::class,'showAdmin'])->name('ticket.show-admin');
});



// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
