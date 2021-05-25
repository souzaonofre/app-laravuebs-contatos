<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::get(
    '/contatos/{bd}',
    [App\Http\Controllers\ContatosController::class, 'index']
);

Route::post(
    '/contatos',
    [App\Http\Controllers\ContatosController::class, 'store']
);

Route::put(
    '/contatos/{id}',
    [App\Http\Controllers\ContatosController::class, 'update']
);

Route::get(
    '/address/{cep}',
    [App\Http\Controllers\AddressController::class, 'getAddress']
);

