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
use App\Http\Controllers\liquidationController;
use App\Http\Controllers\walletController;
use App\Http\Controllers\RetirosController;
use App\Http\Controllers\DoubleAutenticationController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\Auth\TwoFactorController;

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
Route::middleware('auth')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    //ADMIN
    Route::middleware('admin')->group(function(){

        Route::group(['prefix' => 'contratos'], function () {

            Route::get('/', [ContractsController::class, 'index'])->name('contract.index');
            Route::get('/utilidades', [ContractsController::class, 'utilidades'])->name('contract.utilidades');
            Route::get('/utilidades/cartera', [ContractsController::class, 'utilidadesCartera'])->name('contract.utilidadesCartera');
            Route::post('/payUtility', [ContractsController::class, 'payUtility'])->name('payUtility');
            Route::post('/payUtilityCartera', [ContractsController::class, 'payUtilityCartera'])->name('payUtilityCartera');
        });

        Route::group(['prefix' => 'utilidad'], function () {
            Route::get('/', [WalletController::class,'utility'])->name('utilidad.utility');
        });

        Route::prefix('user')->group(function(){

            Route::get('/list-user',[UserController::class,'listUser'])->name('users.list-user');
            Route::get('/list-kyc',[UserController::class,'listKyc'])->name('users.list-kyc');
        
        });

        //ruta para administradores de carteras
        Route::prefix('administrators')->group(function (){

            Route::get('/',[UserController::class,'administrators'])->name('administrators.index');
        
            Route::post('/cambiarTipo',[UserController::class,'cambiar_type'])->name('cambiarTipo');
        
        });

        Route::group(['prefix' => 'solicitud'], function () {
            Route::get('/retiros', [SolicitudController::class, 'index_solicitudes'])->name('solicitud.remove');
        });

        Route::prefix('ticket')->group(function(){
            Route::get('edit-admin/{id}', [TicketController::class,'editAdmin'])->name('ticket.edit-admin');
            Route::patch('update-admin/{id}', [TicketController::class,'updateAdmin'])->name('ticket.update-admin');
            Route::get('list-admin', [TicketController::class,'indexAdmin'])->name('ticket.list-admin');
        });

        Route::group(['prefix' => 'shop'], function () {
            Route::post('/cambiarStatus', [TiendaController::class, 'cambiar_status'])->name('cambiarStatus');
        });
    });
    
    //USER
    Route::get('/ecommerce', function () { 
        return view('/content/dashboard/dashboard-ecommerce');
    });

    Route::group(['prefix' => 'contratos'], function () {
        Route::get('/user', [ContractsController::class, 'contratosUser'])->name('contract.user');
        Route::post('/form-pdf', [ContractsController::class, 'formPdf'])->name('contract.pdf');
        Route::get('/generatePdf/{id}', [ContractsController::class, 'generatePdf'])->name('contract.generatePdf');
    });

    Route::group(['prefix' => 'shop'], function () {
        Route::get('/', [TiendaController::class, 'index'])->name('shop');
        Route::post('/procces', [TiendaController::class, 'procesarOrden'])->name('shop.procces');
        Route::post('/ipn', [TiendaController::class, 'ipn'])->name('shop.ipn');
        Route::post('/{status}/estado', [TiendaController::class, 'statusProcess'])->name('shop.proceso.status');
        Route::get('/getStatus', [TiendaController::class, 'getStatus'])->name('getStatus');
    });

    Route::group(['prefix' => 'reports'], function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.pedidos');
        Route::get('/purchase', [ReportController::class, 'indexPedidos'])->name('reports.index');
        Route::get('/show-contrato{id}', [ReportController::class, 'indexShow'])->name('reports.show-contrato');
        Route::get('/comisiones', [ReportController::class, 'comisiones'])->name('reports.comisiones');
    });

    Route::group(['prefix' => 'solicitud'], function () {
        Route::get('/retiro', [SolicitudController::class, 'index_retiros'])->name('solicitud.retiros')->middleware('primerosCincoDias');
        Route::get('/history', [SolicitudController::class, 'history'])->name('solicitud.history');
    });

    //Ruta de los Tickets
    Route::prefix('ticket')->group(function(){

        // Para el usuario
        Route::get('create', [TicketController::class,'create'])->name('ticket.create');
        Route::post('store', [TicketController::class,'store'])->name('ticket.store'); 
        Route::get('edit-user/{id}', [TicketController::class,'editUser'])->name('ticket.edit-user');
        Route::patch('update-user/{id}', [TicketController::class,'updateUser'])->name('ticket.update-user');
        Route::get('list-user', [TicketController::class,'indexUser'])->name('ticket.list-user');
        Route::get('show-user/{id}', [TicketController::class,'showUser'])->name('ticket.show-user');
    });

    Route::group(['prefix' => 'retiros'], function () {
        Route::get('/retirar', [RetirosController::class, 'retirar'])->name('retiros.retirar');
        Route::post('/retirar', [RetirosController::class, 'retiro'])->name('retiro');
    });

    // 2fact
    Route::get('/2fact', [DoubleAutenticationController::class, 'index'])->name('2fact');
    Route::post('/2fact', [DoubleAutenticationController::class, 'checkCodeLogin'])->name('2fact.post');

    // locale Route
    /*
    Route::get('lang/{locale}', [LanguageController::class, 'swap']);
    */
    //rutas para la lista de usuarios
    Route::prefix('user')->group(function(){

        Route::get('show-user/{id}',[UserController::class,'showUser'])->name('users.show-user');

        Route::get('verificar/{id}',[UserController::class,'verifyUser'])->name('verify-user');
        Route::get('rechazar/{id}',[UserController::class,'denyUser'])->name('deny-user');
        
        Route::get('two_factor_challenge',[UserController::class,'two_factor_challenge'])->name('user.two_factor_challenge');

        Route::get('/inversion', [UserController::class,'administratorsCartera'])->name('contract.administrador');
        /*
        Route::get('/impersonate/stop', 'ImpersonateController@stop')->name('impersonate.stop');
        Route::post('/impersonate/{user}/start', 'ImpersonateController@start')->name('impersonate.start');
        */
    });

        // Ruta para la pagos
    Route::prefix('payments')->group(function (){
    //Vista de pagos Realizados  
    Route::get('/', [WalletController::class,'payments'])->name('payments.index');
    });

    Route::get('verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
    Route::resource('verify', TwoFactorController::class)->only('index', 'store');

    Route::get('/{id}', [DashboardController::class,'dashboard2'])->name('dashboard2')->middleware(['auth']);

});



