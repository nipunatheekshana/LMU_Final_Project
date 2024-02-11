<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Assets\Http\Controllers\Masters\AssetCategoryController;

Route::prefix('assets')->group(function() {
    Route::group(['middleware' => ['is.logged']], function () { //logged users route group

        // AssetCategory list
        Route::get('/assetCategory_list', function () {
            return view('assets::pages.masters.assetCategory');
        });
        Route::get('/assetCategory/loadAssetCategories', [AssetCategoryController::class, 'loadAssetCategories']);
        Route::delete('/assetCategory/delete/{id}', [AssetCategoryController::class, 'delete']);

        // AssetCategory configure
        Route::get('/assetCategory_configure', function () {
            return view('assets::pages.masters.assetCategoryConfigure');
        });
        Route::post('/assetCategoryConfigure/save', [AssetCategoryController::class, 'save']);
        Route::post('/assetCategoryConfigure/update', [AssetCategoryController::class, 'update']);
        Route::get('/assetCategoryConfigure/loadAssetCategory/{id}', [AssetCategoryController::class, 'loadAssetCategory']);
        Route::get('/assetCategoryConfigure/loadCompanies', [AssetCategoryController::class, 'loadCompanies']);



    });
});
