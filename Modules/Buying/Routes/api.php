<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Buying\Http\Controllers\API\FishController;
use Modules\Buying\Http\Controllers\API\GrnController;
use Modules\Buying\Http\Controllers\API\grnTicketController;
use Modules\Buying\Http\Controllers\API\QGRNController;

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

Route::prefix('buying')->group(function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get("grn/get_grn_hd_list", [GrnController::class, 'get_grn_hd_list']);
        Route::get("grn/get_grn_details_list", [GrnController::class, 'get_grn_details_list']);

        Route::patch("grn/reject_fish", [FishController::class, 'reject_fish']);

        Route::post("grn_ticket/create_update_grn_ticket", [grnTicketController::class, 'create_update_grn_ticket']);
        Route::get("grn_ticket/get_grn_tickets", [grnTicketController::class, 'get_grn_tickets']);

        Route::post("qgrn/save_qgrn_header", [QGRNController::class, 'save_qgrn_header']);
        Route::post("qgrn/transfer_grn_fish_to_qgrn", [QGRNController::class, 'transfer_grn_fish_to_qgrn']);
        Route::get("qgrn/get_qgrn_fish_details", [QGRNController::class, 'get_qgrn_fish_details']);
        Route::get("qgrn/get_qgrn_hd_list", [QGRNController::class, 'get_qgrn_hd_list']);
        Route::get("qgrn/get_fish_qgrn_status", [QGRNController::class, 'get_fish_qgrn_status']);
        Route::post("qgrn/transfer_qgrn_fish_to_qgrn", [QGRNController::class, 'transfer_qgrn_fish_to_qgrn']);

    });
});
