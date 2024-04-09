<?php

use Illuminate\Http\Request;
use Api\V1\ConsultasCIController;
use Illuminate\Support\Facades\Route;
use Api\V1\VirtualController as VirtualV1;
use Api\V1\ConsultarSDController;
use Api\V1\CreacionRFTriaraController;
use Api\V1\AsociarRFaSDController;
use Api\V1\ConsultaCI_CSController;

//use Api\V1\LoginController as LoginV1;

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
Route::apiResource('v1/virtualhost', VirtualV1::class)
    ->only(['index', 'show', 'destroy'])
    ->middleware('auth:sanctum');

Route::post('login', [
    App\Http\Controllers\Api\V1\LoginController::class,
    'login'
]);



/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => ["apikey.validate"]], function() {
    /// Cloud
    Route::get('cloud/accountAdd/{account}', 'CloudApiAccountController@show');
    Route::post('cloud/accountAdd/{account}', 'CloudApiAccountController@update');
});

/*
Route::apiResources([
    'v1/virtualhost' => 'Api\V1\VirtualController'
]);*/
//Route::apiResource('v1/virtual', App\Http\Controllers\Api\V1\VirtualController::class)->only('show');

Route::apiResource('v1/ConsultarSDusr', ConsultarSDController::class)
->only(['store']);

Route::apiResource('v1/ConsultarCICliente', ConsultasCIController::class)
->only(['store']);

//RFTriara
Route::apiResource('v1/CreacionRF', CreacionRFTriaraController::class)
->only(['store']);

//AsignacionSD
Route::apiResource('v1/AsociarRFaSD', AsociarRFaSDController::class)
->only(['store']);

//ConsultaCI_ServiceCode
Route::apiResource('v1/ConsultaCS_SC', ConsultaCI_CSController::class)
->only(['store']);

