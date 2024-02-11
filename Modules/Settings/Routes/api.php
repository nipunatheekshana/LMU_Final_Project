<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Settings\Http\Controllers\API\driverController;
use Modules\Settings\Http\Controllers\API\PrinterController;
use Modules\Settings\Http\Controllers\API\ProcessActivityController;
use Modules\Settings\Http\Controllers\API\scaleController;
use Modules\Settings\Http\Controllers\API\TableController;
use Modules\Settings\Http\Controllers\API\VehicleController;
use Modules\Settings\Http\Controllers\API\workstationController;

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
Route::prefix('settings')->group(function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::get("printers/get_printers", [PrinterController::class, 'get_printers']);
        Route::get("workstation/get_process_workstation", [workstationController::class, 'get_process_workstation']);

        Route::get("scales/get_scales", [scaleController::class, 'get_scales']);

        Route::patch("tables/bulkupdatefields", [TableController::class, 'bulkupdatefields']);

        Route::post("process_activity/employee_combination", [ProcessActivityController::class, 'employee_combination']);







    });
});
