<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\UserController;
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
Route::get('/getContrato/{id}', [DashboardController::class, 'getContrato'])->name('get.contrato');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'contratos'], function () {
    Route::post('/remove', [ContractsController::class, 'removeContract'])->name('contract.remove');
});

Route::group(['prefix' => 'user'], function () {
    Route::post('/sendMailFactorCode', [UserController::class, 'sendMailFactorCode'])->name('sendMailFactorCode');
});