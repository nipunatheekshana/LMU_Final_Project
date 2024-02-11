<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Mnu\Http\Controllers\API\distributionController;
use Modules\Mnu\Http\Controllers\API\PackingController;
use Modules\Mnu\Http\Controllers\API\pickListController;
use Modules\Mnu\Http\Controllers\API\ProductionController;
use Modules\Mnu\Http\Controllers\API\WsController;

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

Route::prefix('mnu')->group(function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::post("production/save_production_dtl", [ProductionController::class, 'save_production_dtl']);
        Route::patch("production/change_production_status", [ProductionController::class, 'change_production_status']);
        Route::get("production/search_fish", [ProductionController::class, 'search_fish']);
        Route::get("production/search_pcs", [ProductionController::class, 'search_pcs']);

        Route::get("ws/get_ws_plans", [WsController::class, 'get_ws_plans']);
        Route::patch("ws/update_mobile_active_list", [WsController::class, 'update_mobile_active_list']);

        Route::get("packing/get_box_details_by_scan", [PackingController::class, 'get_box_details_by_scan']);
        Route::get("packing/finish_box", [PackingController::class, 'finish_box']);
        Route::get("packing/get_box_details", [PackingController::class, 'get_box_details']);
        Route::get("packing/reweigh_box", [PackingController::class, 'reweigh_box']);
        Route::post("packing/entire_box_unpack", [PackingController::class, 'entire_box_unpack']);
        Route::post("packing/box_pcs_unpack", [PackingController::class, 'box_pcs_unpack']);
        Route::post("packing/change_box_no", [PackingController::class, 'change_box_no']);


        Route::get("distribution/get_vehicles", [distributionController::class, 'get_vehicles']);
        Route::get("distribution/get_drivers", [distributionController::class, 'get_drivers']);
        Route::get("distribution/get_delivery_trips", [distributionController::class, 'get_delivery_trips']);
        Route::patch("distribution/load_box", [distributionController::class, 'load_box']);
        Route::patch("distribution/unload_all_boxes", [distributionController::class, 'unload_all_boxes']);
        Route::patch("distribution/close_loading", [distributionController::class, 'close_loading']);
        Route::patch("distribution/unload_box", [distributionController::class, 'unload_box']);
        Route::post("distribution/save_update_delivery_trip_header", [distributionController::class, 'save_update_delivery_trip_header']);

        Route::post("picklist/create_update_pick_list", [pickListController::class, 'create_update_pick_list']);
        Route::post("picklist/scan_add_remove_boxes", [pickListController::class, 'scan_add_remove_boxes']);





    });
});
