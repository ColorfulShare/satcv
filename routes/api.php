<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\walletController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/getContrato/{id}', [ContractsController::class, 'getContrato'])->name('get.contrato');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'contratos'], function () {
    Route::post('/remove', [ContractsController::class, 'removeContract'])->name('contract.remove');
    
});

Route::group(['prefix' => 'user'], function () {
    Route::post('/sendMailFactorCode', [UserController::class, 'sendMailFactorCode'])->name('sendMailFactorCode');
    Route::post('/find', [UserController::class, 'find'])->name('user.find');
});

Route::group(['prefix' => 'solicitud'], function () {
    Route::post('/solicitar', [SolicitudController::class, 'solicitar'])->name('solicitud.solicitar');
    Route::post('/cancelar', [SolicitudController::class, 'cancelar'])->name('solicitud.cancelar');
});

Route::group(['prefix' => 'utilidad'], function () {
    Route::get('/', [WalletController::class,'dataUtilityServerSide'])->name('utilidad.dataUtilityServerSide');
});