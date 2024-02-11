<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Quality\Http\Controllers\API\QcRuleParameterController;
use Modules\Quality\Http\Controllers\API\QcRulesController;

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


Route::prefix('quality')->group(function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::get("qc/get_qc_rule_parameters", [QcRuleParameterController::class, 'get_qc_rule_parameters']);
        Route::get("qc/get_qc_rules", [QcRulesController::class, 'get_qc_rules']);
    });
});
