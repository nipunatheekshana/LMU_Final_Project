<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\HRM\Entities\Employee;
use Modules\HRM\Http\Controllers\API\employeeController;

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

Route::prefix('hrm')->group(function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get("employees/get_employees", [employeeController::class, 'get_employees']);


    });
});
