<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DomainServiceController;
use App\Http\Controllers\HostingServiceController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('accounts', AccountController::class);
Route::apiResource('hosting-services', HostingServiceController::class);
Route::apiResource('domain-services', DomainServiceController::class);
