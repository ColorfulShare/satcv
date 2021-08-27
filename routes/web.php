<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;



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
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth']);


// Route::get('/', [DashboardController::class,'dashboardEcommerce'])->name('dashboard-ecommerce')->middleware(['auth']);

Route::group(['prefix' => 'contratos'], function () {
    Route::get('/', [ContractsController::class, 'index'])->name('contract.index');
    Route::get('/testCoin', [ContractsController::class, 'testCoin'])->name('contract.testCoin');
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

//Ruta de los Tickets
Route::prefix('ticket')->middleware(['auth'])->group(function(){

    // Para el usuario
    Route::get('create', [TicketController::class,'create'])->name('ticket.create');
    Route::post('store', [TicketController::class,'storeUser'])->name('ticket.store'); 
    Route::get('edit-user/{id}', [TicketController::class,'editUser'])->name('ticket.edit-user');
    Route::patch('update-user/{id}', [TicketController::class,'updateUser'])->name('ticket.update-user');
    Route::get('list-user', [TicketController::class,'indexUser'])->name('ticket.list-user');
    Route::get('show-user/{id}', [TicketController::class,'showUser'])->name('ticket.show-user');

    // Para el Admin
    Route::get('edit-admin/{id}', [TicketController::class,'editAdmin'])->name('ticket.edit-admin');
    Route::patch('update-admin/{id}', [TicketController::class,'updateAdmin'])->name('ticket.update-admin');
    Route::get('list-admin', [TicketController::class,'indexAdmin'])->name('ticket.list-admin');
});

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

//rutas para la lista de usuarios
 Route::prefix('user')->group(function(){

Route::get('/list-user',[UserController::class,'listUser'])->name('users.list-user');

Route::get('show-user/{id}',[UserController::class,'showUser'])->name('users.show-user');

});


 // Ruta para la pagos
 Route::prefix('payments')->group(function (){

Route::get('/',[WalletController::class,'payments'])->name('payments.index');

 });






