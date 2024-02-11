<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Sf\Http\Controllers\API\FishGRNController;
use Modules\Sf\Http\Controllers\SfController;

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

Route::prefix('sf')->group(function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::post("grn/save_fish_grn_header", [FishGRNController::class, 'save_fish_grn_header']);
        Route::post("grn/save_fish_grn_details", [FishGRNController::class, 'save_fish_grn_details']);
        Route::get("grn/get_catch_area", [FishGRNController::class, 'get_catch_areas']);
        Route::get("grn/get_catch_methods", [FishGRNController::class, 'get_catch_methods']);
        Route::get("grn/get_fish_list", [FishGRNController::class, 'get_fish_list']);
        Route::get("grn/get_fishing_boats", [FishGRNController::class, 'get_fishing_boats']);
        Route::get("grn/get_landing_sites", [FishGRNController::class, 'get_landing_sites']);
        Route::get("grn/get_presentation_types", [FishGRNController::class, 'get_presentation_types']);
        Route::get("grn/get_suppliers", [FishGRNController::class, 'get_suppliers']);
    });
});
