<?php

use App\Http\Controllers\API\Buying\FishGRNController;
use App\Http\Controllers\API\Buying\GrnController;
use App\Http\Controllers\API\Quality\QcRuleParameterController;
use App\Http\Controllers\API\Quality\QcRulesController;
use App\Http\Controllers\API\Settings\PrinterController;
use App\Http\Controllers\API\Settings\workstationController;
use App\Http\Controllers\ApiUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//return bayer token to the correct login credintials
Route::post("login", [ApiUserController::class, 'index']);



Route::group(['middleware' => 'auth:sanctum'], function () {


});
