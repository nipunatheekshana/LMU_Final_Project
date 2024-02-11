<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Inventory\Http\Controllers\API\deliveryController;
use Modules\Inventory\Http\Controllers\API\deliveryTripsController;

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

Route::prefix('inventory')->group(function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {






    });
});
