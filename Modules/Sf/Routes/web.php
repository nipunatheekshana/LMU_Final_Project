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
use Modules\Sf\Http\Controllers\BoatCategoryController;
use Modules\Sf\Http\Controllers\BoatController;
use Modules\Sf\Http\Controllers\BoatHoldTypesController;
use Modules\Sf\Http\Controllers\CatchAreaMasterController;
use Modules\Sf\Http\Controllers\CatchMethodMasterController;
use Modules\Sf\Http\Controllers\CompanyBoatsController;
use Modules\Sf\Http\Controllers\CuttingtypeMasterController;
use Modules\Sf\Http\Controllers\FishCoolingMethodsController;
use Modules\Sf\Http\Controllers\FishGradesMasterController;
use Modules\Sf\Http\Controllers\FishReceiveParamSettingsController;
use Modules\Sf\Http\Controllers\FishSizeController;
use Modules\Sf\Http\Controllers\FishspeciesMasterController;
use Modules\Sf\Http\Controllers\LandingsiteMasterController;
use Modules\Sf\Http\Controllers\ManufacturingItemController;
use Modules\Sf\Http\Controllers\PresentationTypeMasterController;
use Modules\Sf\Http\Controllers\ProductQualitiesController;
use Modules\Sf\Http\Controllers\SeaFoodRawMaterialController;
use Modules\Sf\Http\Controllers\ByproductItemController;
use Modules\Sf\Http\Controllers\FishRejectReasonsController;

Route::prefix('sf')->group(function () {
    Route::group(['middleware' => ['is.logged']], function () { //logged users route group


        //fish grades list
        Route::get('/fishGradesMaster_list', function () {
            return view('sf::pages.masters.fishGradesMaster');
        });

        Route::get('/fishGradesMaster/loadFishGrades', [FishGradesMasterController::class, 'loadFishGrades']);
        Route::delete('/fishGradesMaster/delete/{id}', [FishGradesMasterController::class, 'delete']);

        //fish grades Configure
        Route::get('/fishGradesMaster_Configure', function () {
            return view('sf::pages.masters.fishGradesMasterConfiger');
        });
        Route::post('/fishGradesMasterConfigure/save', [FishGradesMasterController::class, 'save']);
        Route::post('/fishGradesMasterConfigure/update', [FishGradesMasterController::class, 'update']);
        Route::get('/fishGradesMasterConfigure/loadFishSpecies', [FishGradesMasterController::class, 'loadFishSpecies']);
        Route::get('/fishGradesMasterConfigure/loadRelatedGrades/{id}', [FishGradesMasterController::class, 'loadRelatedGrades']);
        Route::get('/fishGradesMasterConfigure/loadFishGrade/{id}', [FishGradesMasterController::class, 'loadFishGrade']);
        Route::get('/fishGradesMasterConfigure/view/{id}', [FishGradesMasterController::class, 'view']);

        //presentationType list
        Route::get('/presentationTypeMaster_list', function () {
            return view('sf::pages.masters.presentationTypeMaster');
        });
        Route::get('/presentationTypeMaster/loadPresentationTypes', [PresentationTypeMasterController::class, 'loadPresentationTypes']);
        Route::delete('/presentationTypeMaster/delete/{id}', [PresentationTypeMasterController::class, 'delete']);

        //presentationType Configure
        Route::get('/presentationTypeMaster_Configure', function () {
            return view('sf::pages.masters.presentationTypeMasterConfigure');
        });
        Route::post('/presentationTypeMasterConfigure/save', [PresentationTypeMasterController::class, 'save']);
        Route::post('/presentationTypeMasterConfigure/update', [PresentationTypeMasterController::class, 'update']);
        Route::get('/presentationTypeMasterConfigure/loadPresentationType/{id}', [PresentationTypeMasterController::class, 'loadPresentationType']);
        Route::get('/presentationTypeMasterConfigure/loadFishSpecies', [PresentationTypeMasterController::class, 'loadFishSpecies']);
        Route::get('/presentationTypeMasterConfigure/loadRelatedPresentationTypes/{id}', [PresentationTypeMasterController::class, 'loadRelatedPresentationTypes']);


        // cuttingtype list
        Route::get('/cuttingtypeMaster_list', function () {
            return view('sf::pages.masters.cuttingtypeMaster');
        });
        Route::get('/cuttingtypeMaster/loadCuttingTypes', [CuttingtypeMasterController::class, 'loadCuttingTypes']);
        Route::delete('/cuttingtypeMaster/delete/{id}', [CuttingtypeMasterController::class, 'delete']);

        //cuttingtype Configure
        Route::get('/cuttingtypeMaster_configure', function () {
            return view('sf::pages.masters.cuttingtypeMasterConfigure');
        });
        Route::post('/cuttingtypeMasterConfigure/save', [CuttingtypeMasterController::class, 'save']);
        Route::post('/cuttingtypeMasterConfigure/update', [CuttingtypeMasterController::class, 'update']);

        Route::get('/cuttingtypeMasterConfigure/loadcuttingtypeMaster/{id}', [CuttingtypeMasterController::class, 'loadcuttingtypeMaster']);


        // catchArea list
        Route::get('/catchAreaMaster_list', function () {
            return view('sf::pages.masters.catchAreaMaster');
        });
        Route::get('/catchAreaMaster/loadCatchAreas', [CatchAreaMasterController::class, 'loadCatchAreas']);
        Route::delete('/catchAreaMaster/delete/{id}', [CatchAreaMasterController::class, 'delete']);

        // catchArea configure
        Route::get('/catchAreaMaster_configure', function () {
            return view('sf::pages.masters.catchAreaMasterConfigure');
        });
        Route::post('/catchAreaMasterConfigure/save', [CatchAreaMasterController::class, 'save']);
        Route::post('/catchAreaMasterConfigure/update', [CatchAreaMasterController::class, 'update']);
        Route::get('/catchAreaMasterConfigure/loadcatchAreaMaster/{id}', [CatchAreaMasterController::class, 'loadcatchAreaMaster']);

        // catchMethod list
        Route::get('/catchMethodMaster_list', function () {
            return view('sf::pages.masters.catchMethodMaster');
        });
        Route::get('/catchMethodMaster/loadCatchMethods', [CatchMethodMasterController::class, 'loadCatchMethods']);
        Route::delete('/catchMethodMaster/delete/{id}', [CatchMethodMasterController::class, 'delete']);

        // catchMethod configure
        Route::get('/catchMethodMaster_configure', function () {
            return view('sf::pages.masters.catchMethodMasterConfigure');
        });
        Route::post('/catchMethodMasterConfigure/save', [CatchMethodMasterController::class, 'save']);
        Route::post('/catchMethodMasterConfigure/update', [CatchMethodMasterController::class, 'update']);
        Route::get('/catchMethodMasterConfigure/loadcatchMethodMaster/{id}', [CatchMethodMasterController::class, 'loadcatchMethodMaster']);


        // landingsite list
        Route::get('/landingsiteMaster_list', function () {
            return view('sf::pages.masters.landingsiteMaster');
        });
        Route::get('/landingsiteMaster/loadLandingsites', [LandingsiteMasterController::class, 'loadLandingsites']);
        Route::delete('/landingsiteMaster/delete/{id}', [LandingsiteMasterController::class, 'delete']);

        // landingsite configure
        Route::get('/landingsiteMaster_configure', function () {
            return view('sf::pages.masters.landingsiteMasterConfigure');
        });
        Route::post('/landingsiteMasterConfigure/save', [LandingsiteMasterController::class, 'save']);
        Route::post('/landingsiteMasterConfigure/update', [LandingsiteMasterController::class, 'update']);
        Route::get('/landingsiteMasterConfigure/loadlandingsiteMaster/{id}', [LandingsiteMasterController::class, 'loadlandingsiteMaster']);
        Route::get('/landingsiteMasterConfigure/loadCountries', [LandingsiteMasterController::class, 'loadCountries']);
        Route::delete('/landingsiteMasterConfigure/DeleteImage/{id}', [LandingsiteMasterController::class, 'DeleteImage']);

        // fishSpecies list
        Route::get('/fishSpeciesMaster_list', function () {
            return view('sf::pages.masters.fishSpeciesMaster');
        });
        Route::get('/fishSpeciesMaster/loadFishSpecies', [FishspeciesMasterController::class, 'loadFishSpecies']);
        Route::delete('/fishSpeciesMaster/delete/{id}', [FishspeciesMasterController::class, 'delete']);

        // fishSpecies configure
        Route::get('/fishSpeciesMaster_configure', function () {
            return view('sf::pages.masters.fishSpeciesMasterConfigure');
        });
        Route::post('/fishSpeciesMasterConfigure/save', [FishspeciesMasterController::class, 'save']);
        Route::post('/fishSpeciesMasterConfigure/update', [FishspeciesMasterController::class, 'update']);
        Route::get('/fishSpeciesMasterConfigure/loadfishSpeciesMaster/{id}', [FishspeciesMasterController::class, 'loadfishSpeciesMaster']);
        Route::get('/fishSpeciesMasterConfigure/loadUOM', [FishspeciesMasterController::class, 'loadUOM']);
        Route::delete('/fishSpeciesMasterConfigure/deleteImage/{id}', [FishspeciesMasterController::class, 'deleteImage']);



        // boatCategory list
        Route::get('/boatCategory_list', function () {
            return view('sf::pages.masters.boatCategory');
        });
        Route::get('/boatCategory/loadboatCategories', [BoatCategoryController::class, 'loadboatCategories']);
        Route::delete('/boatCategory/delete/{id}', [BoatCategoryController::class, 'delete']);
        Route::get('/boatCategory/view/{id}', [BoatCategoryController::class, 'view']);

        // boatCategory configure
        Route::get('/boatCategory_configure', function () {
            return view('sf::pages.masters.boatCategoryConfigure');
        });
        Route::post('/boatCategoryConfigure/save', [BoatCategoryController::class, 'save']);
        Route::post('/boatCategoryConfigure/update', [BoatCategoryController::class, 'update']);
        Route::get('/boatCategoryConfigure/loadBoatCategory/{id}', [BoatCategoryController::class, 'loadBoatCategory']);


        // boat list
        Route::get('/boat_list', function () {
            return view('sf::pages.masters.boat');
        });
        Route::get('/boat/loadboats', [BoatController::class, 'loadboats']);
        Route::delete('/boat/delete/{id}', [BoatController::class, 'delete']);
        Route::get('/boat/view/{id}', [BoatController::class, 'view']);

        // boat configure
        Route::get('/boat_configure', function () {
            return view('sf::pages.masters.boatConfigure');
        });
        Route::post('/boatConfigure/save', [BoatController::class, 'save']);
        Route::post('/boatConfigure/update', [BoatController::class, 'update']);
        Route::get('/boatConfigure/loadboat/{id}', [BoatController::class, 'loadboat']);
        Route::get('/boatConfigure/loadCountries', [BoatController::class, 'loadCountries']);
        Route::get('/boatConfigure/loadBoatCategories', [BoatController::class, 'loadBoatCategories']);
        Route::get('/boatConfigure/loadBoatHoldReason', [BoatController::class, 'loadBoatHoldReason']);
        Route::delete('/boatConfigure/deleteImage/{id}/{img}', [BoatController::class, 'deleteImage']);



        // fishReceiveParamSettings list
        Route::get('/fishReceiveParamSettings_list', function () {
            return view('sf::pages.masters.fishReceiveParamSettings');
        });
        Route::get('/fishReceiveParamSettings/loadfishReceiveParamSettings', [FishReceiveParamSettingsController::class, 'loadfishReceiveParamSettings']);
        Route::delete('/fishReceiveParamSettings/delete/{id}', [FishReceiveParamSettingsController::class, 'delete']);
        Route::get('/fishReceiveParamSettings/view/{id}', [FishReceiveParamSettingsController::class, 'view']);

        // fishReceiveParamSettings configure
        Route::get('/fishReceiveParamSettings_configure', function () {
            return view('sf::pages.masters.fishReceiveParamSettingsConfigure');
        });
        Route::post('/fishReceiveParamSettingsConfigure/save', [FishReceiveParamSettingsController::class, 'save']);
        Route::post('/fishReceiveParamSettingsConfigure/update', [FishReceiveParamSettingsController::class, 'update']);
        Route::get('/fishReceiveParamSettingsConfigure/loadfishReceiveParamSetting/{id}', [FishReceiveParamSettingsController::class, 'loadfishReceiveParamSetting']);
        Route::get('/fishReceiveParamSettingsConfigure/loadFishSpecies', [FishReceiveParamSettingsController::class, 'loadFishSpecies']);
        Route::get('/fishReceiveParamSettingsConfigure/loadCompanies', [FishReceiveParamSettingsController::class, 'loadCompanies']);
        Route::get('/fishReceiveParamSettingsConfigure/loadQParamID', [FishReceiveParamSettingsController::class, 'loadQParamID']);
        Route::get('/fishReceiveParamSettingsConfigure/loadFishPrasentation', [FishReceiveParamSettingsController::class, 'loadFishPrasentation']);
        Route::get('/fishReceiveParamSettingsConfigure/loadMinMaxValue/{id}', [FishReceiveParamSettingsController::class, 'loadMinMaxValue']);
        Route::post('/fishReceiveParamSettingsConfigure/loadRelatedParam', [FishReceiveParamSettingsController::class, 'loadRelatedParam']);


        // companyBoats list
        Route::get('/companyBoats_list', function () {
            return view('sf::pages.masters.companyBoats');
        });
        Route::get('/companyBoats/loadCompanyBoats', [CompanyBoatsController::class, 'loadCompanyBoats']);
        Route::delete('/companyBoats/delete/{id}', [CompanyBoatsController::class, 'delete']);
        Route::get('/companyBoats/view/{id}', [CompanyBoatsController::class, 'view']);

        // companyBoats configure
        Route::get('/companyBoats_configure', function () {
            return view('sf::pages.masters.companyBoatsConfigure');
        });
        Route::post('/companyBoatsConfigure/save', [CompanyBoatsController::class, 'save']);
        Route::post('/companyBoatsConfigure/update', [CompanyBoatsController::class, 'update']);
        Route::get('/companyBoatsConfigure/loadCompanyBoat/{id}', [CompanyBoatsController::class, 'loadCompanyBoat']);
        Route::get('/companyBoatsConfigure/loadCompanies', [CompanyBoatsController::class, 'loadCompanies']);
        Route::get('/companyBoatsConfigure/loadBoats', [CompanyBoatsController::class, 'loadBoats']);
        Route::get('/companyBoatsConfigure/loadHoldTypes', [CompanyBoatsController::class, 'loadHoldTypes']);

        // BoatHoldType list
        Route::get('/boatHoldType_list', function () {
            return view('sf::pages.masters.boatHoldTypeBoats');
        });
        Route::get('/boatHoldType/loadBoatHoldTypes', [BoatHoldTypesController::class, 'loadBoatHoldTypes']);
        Route::delete('/boatHoldType/delete/{id}', [BoatHoldTypesController::class, 'delete']);
        Route::get('/boatHoldType/view/{id}', [BoatHoldTypesController::class, 'view']);

        // BoatHoldType configure
        Route::get('/boatHoldType_configure', function () {
            return view('sf::pages.masters.boatHoldTypeConfigure');
        });
        Route::post('/boatHoldTypeConfigure/save', [BoatHoldTypesController::class, 'save']);
        Route::post('/boatHoldTypeConfigure/update', [BoatHoldTypesController::class, 'update']);
        Route::get('/boatHoldTypeConfigure/loadBoatHoldType/{id}', [BoatHoldTypesController::class, 'loadBoatHoldType']);

        // FishCoolingMethod list
        Route::get('/fishCoolingMethod_list', function () {
            return view('sf::pages.masters.fishCoolingMethod');
        });
        Route::get('/fishCoolingMethod/loadFishCoolingMethods', [FishCoolingMethodsController::class, 'loadFishCoolingMethods']);
        Route::delete('/fishCoolingMethod/delete/{id}', [FishCoolingMethodsController::class, 'delete']);
        Route::get('/fishCoolingMethod/view/{id}', [FishCoolingMethodsController::class, 'view']);

        // FishCoolingMethod configure
        Route::get('/fishCoolingMethod_configure', function () {
            return view('sf::pages.masters.fishCoolingMethodConfigure');
        });
        Route::post('/fishCoolingMethodConfigure/save', [FishCoolingMethodsController::class, 'save']);
        Route::post('/fishCoolingMethodConfigure/update', [FishCoolingMethodsController::class, 'update']);
        Route::get('/fishCoolingMethodConfigure/loadFishCoolingMethod/{id}', [FishCoolingMethodsController::class, 'loadFishCoolingMethod']);


        // seaFoodRawMaterial list
        Route::get('/seaFoodRawMaterial_list', function () {
            return view('sf::pages.masters.seaFoodRawMaterial');
        });
        Route::get('/seaFoodRawMaterial/loadseaFoodRawMaterials', [SeaFoodRawMaterialController::class, 'loadseaFoodRawMaterials']);
        Route::delete('/seaFoodRawMaterial/delete/{id}', [SeaFoodRawMaterialController::class, 'delete']);
        Route::get('/seaFoodRawMaterial/view/{id}', [SeaFoodRawMaterialController::class, 'view']);

        // seaFoodRawMaterial configure
        Route::get('/seaFoodRawMaterial_configure', function () {
            return view('sf::pages.masters.seaFoodRawMaterialConfigure');
        });
        Route::post('/seaFoodRawMaterialConfigure/save', [SeaFoodRawMaterialController::class, 'save']);
        Route::post('/seaFoodRawMaterialConfigure/update', [SeaFoodRawMaterialController::class, 'update']);
        Route::get('/seaFoodRawMaterialConfigure/loadseaFoodRawMaterial/{id}', [SeaFoodRawMaterialController::class, 'loadseaFoodRawMaterial']);
        Route::get('/seaFoodRawMaterialConfigure/loadFishSpecis', [SeaFoodRawMaterialController::class, 'loadFishSpecis']);
        Route::get('/seaFoodRawMaterialConfigure/loadReceivePresentation/{id}', [SeaFoodRawMaterialController::class, 'loadReceivePresentation']);
        Route::get('/seaFoodRawMaterialConfigure/loadReceiveGrade/{id}', [SeaFoodRawMaterialController::class, 'loadReceiveGrade']);
        Route::get('/seaFoodRawMaterialConfigure/loaditemGoup', [SeaFoodRawMaterialController::class, 'loaditemGoup']);
        Route::get('/seaFoodRawMaterialConfigure/loaduom', [SeaFoodRawMaterialController::class, 'loaduom']);
        Route::get('/seaFoodRawMaterialConfigure/loadDefaultWeightAndUom/{id}', [SeaFoodRawMaterialController::class, 'loadDefaultWeightAndUom']);
        Route::get('/seaFoodRawMaterialConfigure/loaCompanies', [SeaFoodRawMaterialController::class, 'loaCompanies']);


        // fishSize list
        Route::get('/fishSize_list', function () {
            return view('sf::pages.masters.fishSize');
        });
        Route::get('/fishSize/loadFishSizes', [FishSizeController::class, 'loadFishSizes']);
        Route::delete('/fishSize/delete/{id}', [FishSizeController::class, 'delete']);
        Route::get('/fishSize/view/{id}', [FishSizeController::class, 'view']);

        // fishSize configure
        Route::get('/fishSize_configure', function () {
            return view('sf::pages.masters.fishSizeConfigure');
        });
        Route::post('/fishSizeConfigure/save', [FishSizeController::class, 'save']);
        Route::post('/fishSizeConfigure/update', [FishSizeController::class, 'update']);
        Route::get('/fishSizeConfigure/loadFishSize/{id}', [FishSizeController::class, 'loadFishSize']);
        Route::get('/fishSizeConfigure/loadCompanies', [FishSizeController::class, 'loadCompanies']);
        Route::get('/fishSizeConfigure/loadFishSpecis', [FishSizeController::class, 'loadFishSpecis']);
        Route::get('/fishSizeConfigure/getNewMinValue/{compid}/{fishSPid}', [FishSizeController::class, 'getNewMinValue']);
        Route::get('/fishSizeConfigure/loadRelatedFishSizes/{compid}/{fishSPid}', [FishSizeController::class, 'loadRelatedFishSizes']);


        // ProductQuality list
        Route::get('/productQuality_list', function () {
            return view('sf::pages.masters.productQuality');
        });
        Route::get('/productQuality/loadProductQualities', [ProductQualitiesController::class, 'loadProductQualities']);
        Route::delete('/productQuality/delete/{id}', [ProductQualitiesController::class, 'delete']);
        Route::get('/productQuality/view/{id}', [ProductQualitiesController::class, 'view']);

        // ProductQuality configure
        Route::get('/productQuality_configure', function () {
            return view('sf::pages.masters.productQualityConfigure');
        });
        Route::post('/productQualityConfigure/save', [ProductQualitiesController::class, 'save']);
        Route::post('/productQualityConfigure/update', [ProductQualitiesController::class, 'update']);
        Route::get('/productQualityConfigure/loadProductQuality/{id}', [ProductQualitiesController::class, 'loadProductQuality']);
        Route::get('/productQualityConfigure/loadCompanies', [ProductQualitiesController::class, 'loadCompanies']);
        Route::get('/productQualityConfigure/loadFishSpecies', [ProductQualitiesController::class, 'loadFishSpecies']);


        // manufacturingItem list
        Route::get('/manufacturingItem_list', function () {
            return view('sf::pages.masters.manufacturingItem');
        });
        Route::get('/manufacturingItem/loadmanufacturingItems', [ManufacturingItemController::class, 'loadmanufacturingItems']);
        Route::delete('/manufacturingItem/delete/{id}', [ManufacturingItemController::class, 'delete']);
        Route::get('/manufacturingItem/view/{id}', [ManufacturingItemController::class, 'view']);

        // manufacturingItem configure
        Route::get('/manufacturingItem_configure', function () {
            return view('sf::pages.masters.manufacturingItemConfigure');
        });
        Route::post('/manufacturingItemConfigure/save', [ManufacturingItemController::class, 'save']);
        Route::post('/manufacturingItemConfigure/update', [ManufacturingItemController::class, 'update']);
        Route::get('/manufacturingItemConfigure/loadmanufacturingItem/{id}', [ManufacturingItemController::class, 'loadmanufacturingItem']);
        Route::get('/manufacturingItemConfigure/loadcompanies', [ManufacturingItemController::class, 'loadcompanies']);
        Route::get('/manufacturingItemConfigure/loadFishSpecis', [ManufacturingItemController::class, 'loadFishSpecis']);
        Route::get('/manufacturingItemConfigure/loadCuttingType', [ManufacturingItemController::class, 'loadCuttingType']);
        Route::get('/manufacturingItemConfigure/loadUom', [ManufacturingItemController::class, 'loadUom']);
        Route::get('/manufacturingItemConfigure/loadItemGroup', [ManufacturingItemController::class, 'loadItemGroup']);
        Route::get('/manufacturingItemConfigure/loadReceivePresentation/{id}', [ManufacturingItemController::class, 'loadReceivePresentation']);
        Route::get('/manufacturingItemConfigure/loadReceiveGrade/{id}', [ManufacturingItemController::class, 'loadReceiveGrade']);
        Route::get('/manufacturingItemConfigure/loadDefaultWeightAndUom/{id}', [ManufacturingItemController::class, 'loadDefaultWeightAndUom']);
        Route::get('/manufacturingItemConfigure/loadProcess', [ManufacturingItemController::class, 'loadProcess']);
        Route::get('/manufacturingItemConfigure/loadProcessWorkstations/{ProcessId}', [ManufacturingItemController::class, 'loadProcessWorkstations']);
        Route::delete('/manufacturingItemConfigure/deleteImage/{id}', [ManufacturingItemController::class, 'deleteImage']);

        // byproductItem list
        Route::get('/byproductItem_list', function () {
            return view('sf::pages.masters.byproductItem');
        });
        Route::get('/byproductItem/loadbyproductItems', [byproductItemController::class, 'loadbyproductItems']);
        Route::delete('/byproductItem/delete/{id}', [byproductItemController::class, 'delete']);
        Route::get('/byproductItem/view/{id}', [byproductItemController::class, 'view']);

        // byproductItem configure
        Route::get('/byproductItem_configure', function () {
            return view('sf::pages.masters.byproductItemConfigure');
        });
        Route::post('/byproductItemConfigure/save', [byproductItemController::class, 'save']);
        Route::post('/byproductItemConfigure/update', [byproductItemController::class, 'update']);
        Route::get('/byproductItemConfigure/loadbyproductItem/{id}', [byproductItemController::class, 'loadbyproductItem']);
        Route::get('/byproductItemConfigure/loadcompanies', [byproductItemController::class, 'loadcompanies']);
        Route::get('/byproductItemConfigure/loadFishSpecis', [byproductItemController::class, 'loadFishSpecis']);
        Route::get('/byproductItemConfigure/loadUom', [byproductItemController::class, 'loadUom']);
        Route::get('/byproductItemConfigure/loadItemGroup', [byproductItemController::class, 'loadItemGroup']);
        Route::get('/byproductItemConfigure/loadDefaultWeightAndUom/{id}', [byproductItemController::class, 'loadDefaultWeightAndUom']);
        Route::get('/byproductItemConfigure/loadProcessWorkstations', [byproductItemController::class, 'loadProcessWorkstations']);
        Route::post('/byproductItemConfigure/saveItemProcessWorkstation', [byproductItemController::class, 'saveItemProcessWorkstation']);
        Route::get('/byproductItemConfigure/loadItemProcessWorkstation/{itemId}', [byproductItemController::class, 'loadItemProcessWorkstation']);
        Route::delete('/byproductItemConfigure/deleteItemProcessWorkstation/{id}', [byproductItemController::class, 'deleteItemProcessWorkstation']);
        Route::get('/byproductItemConfigure/loadPriceListModleData', [byproductItemController::class, 'loadPriceListModleData']);
        Route::post('/byproductItemConfigure/savePriceList', [byproductItemController::class, 'savePriceList']);
        Route::get('/byproductItemConfigure/loadItemPrice/{itemId}', [byproductItemController::class, 'loadItemPrice']);
        Route::delete('/byproductItemConfigure/deleteItemPriceList/{id}', [byproductItemController::class, 'deleteItemPriceList']);


        // Dashboard
        Route::get('/', function () {
            return view('sf::pages.masters.dashboardSf');
        });

        // Fish Reject Reason List
        Route::get('/fishrejectreason_list', function () {
            return view('sf::pages.masters.fishRejectReason');
        });
        Route::get('/fishRejectReason/loadRejectReasons', [FishRejectReasonsController::class, 'loadFishRejectReasons']);
        Route::delete('/fishRejectReason/delete/{id}', [FishRejectReasonsController::class, 'delete']);

        //Fish Reject Reason Configure
        Route::get('/fishrejectreason_configure', function () {
            return view('sf::pages.masters.fishRejectReasonConfigure');
        });
        Route::post('/fishRejectReasonConfigure/save', [FishRejectReasonsController::class, 'save']);
        Route::post('/fishRejectReasonConfigure/update', [FishRejectReasonsController::class, 'update']);

        Route::get('/fishRejectReasonConfigure/loadRejectReason/{id}', [FishRejectReasonsController::class, 'loadRejectReason']);
    });
});
