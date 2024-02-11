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
use Modules\Mnu\Http\Controllers\Masters\BOMItemController;
use Modules\Mnu\Http\Controllers\Masters\CustomerItemsController;
use Modules\Mnu\Http\Controllers\Masters\ManufacturingSettingController;
use Modules\Mnu\Http\Controllers\Masters\newRequirementController;
use Modules\Mnu\Http\Controllers\Masters\PackingDetailsController;
use Modules\Mnu\Http\Controllers\Masters\PlaningDetailController;
use Modules\Mnu\Http\Controllers\Masters\ProductionPlanController;
use Modules\Mnu\Http\Controllers\ProductionRecoveryDetailsController;
use Modules\Mnu\Http\Controllers\Reports\PackingListController;
use Modules\Mnu\Http\Controllers\Masters\PackingDetailsReportsController;

Route::prefix('mnu')->group(function () {
    Route::group(['middleware' => ['is.logged']], function () { //logged users route group

        // ManufacturingSetting list
        Route::get('/manufacturingSetting_list', function () {
            return view('mnu::pages.masters.manufacturingSetting');
        });
        Route::get('/manufacturingSetting/loadManufacturingSettings', [ManufacturingSettingController::class, 'loadManufacturingSettings']);
        Route::delete('/manufacturingSetting/delete/{id}', [ManufacturingSettingController::class, 'delete']);

        // ManufacturingSetting configure
        Route::get('/manufacturingSetting_configure', function () {
            return view('mnu::pages.masters.manufacturingSettingConfigure');
        });
        Route::post('/manufacturingSettingConfigure/save', [ManufacturingSettingController::class, 'save']);
        Route::post('/manufacturingSettingConfigure/update', [ManufacturingSettingController::class, 'update']);
        Route::get('/manufacturingSettingConfigure/loadManufacturingSetting/{id}', [ManufacturingSettingController::class, 'loadManufacturingSetting']);
        Route::get('/manufacturingSettingConfigure/loadCompanies', [ManufacturingSettingController::class, 'loadCompanies']);


        // BOMItem list
        Route::get('/BOMItem_list', function () {
            return view('mnu::pages.masters.BOMItem');
        });
        Route::get('/BOMItem/loadBOMItems', [BOMItemController::class, 'loadBOMItems']);
        Route::delete('/BOMItem/delete/{id}', [BOMItemController::class, 'delete']);

        // BOMItem configure
        Route::get('/BOMItem_configure', function () {
            return view('mnu::pages.masters.BOMItemConfigure');
        });
        Route::post('/BOMItemConfigure/save', [BOMItemController::class, 'save']);
        Route::post('/BOMItemConfigure/update', [BOMItemController::class, 'update']);
        Route::get('/BOMItemConfigure/loadBOMItem/{id}', [BOMItemController::class, 'loadBOMItem']);
        Route::get('/BOMItemConfigure/loadOtherItems', [BOMItemController::class, 'loadOtherItems']);
        Route::get('/BOMItemConfigure/loadOtherItemUnitWeight/{itemId}', [BOMItemController::class, 'loadOtherItemUnitWeight']);
        Route::get('/BOMItemConfigure/loadMainItem', [BOMItemController::class, 'loadMainItem']);
        Route::get('/BOMItemConfigure/loadContainerItem', [BOMItemController::class, 'loadContainerItem']);
        Route::get('/BOMItemConfigure/loadLableItem', [BOMItemController::class, 'loadLableItem']);
        Route::get('/BOMItemConfigure/loadUnitWeight/{itemId}', [BOMItemController::class, 'loadUnitWeight']);
        Route::get('/BOMItemConfigure/loadMainItems', [BOMItemController::class, 'loadMainItems']);
        Route::get('/BOMItemConfigure/loadMainItemUnitWeight/{itemId}', [BOMItemController::class, 'loadMainItemUnitWeight']);
        Route::get('/BOMItemConfigure/loadProcess', [BOMItemController::class, 'loadProcess']);
        Route::get('/BOMItemConfigure/loadProcessWorkstations/{ProcessId}', [BOMItemController::class, 'loadProcessWorkstations']);


        // customerItem list
        Route::get('/customerItem_list', function () {
            return view('mnu::pages.masters.customerItem');
        });
        Route::get('/customerItem/loadCustomerItems', [CustomerItemsController::class, 'loadCustomerItems']);
        Route::delete('/customerItem/delete/{id}', [CustomerItemsController::class, 'delete']);
        Route::get('/customerItem/FilterCustomerItems/{customer}/{itemType}', [CustomerItemsController::class, 'FilterCustomerItems']);
        Route::get('/customerItem/loadCustomers', [CustomerItemsController::class, 'loadCustomers']);


        // customerItem configure
        Route::get('/customerItem_configure', function () {
            return view('mnu::pages.masters.customerItemConfigure');
        });
        Route::post('/customerItemConfigure/save', [CustomerItemsController::class, 'save']);
        Route::post('/customerItemConfigure/update', [CustomerItemsController::class, 'update']);
        Route::get('/customerItemConfigure/loadCustomerItem/{id}', [CustomerItemsController::class, 'loadCustomerItem']);
        Route::get('/customerItemConfigure/loadCustomers', [CustomerItemsController::class, 'loadCustomers']);
        Route::get('/customerItemConfigure/loadItems/{type}', [CustomerItemsController::class, 'loadItems']);
        Route::get('/customerItemConfigure/loadMasterLableParameters/{itemType}', [CustomerItemsController::class, 'loadMasterLableParameters']);
        Route::get('/customerItemConfigure/loadDataTypeFormats/{dataType}', [CustomerItemsController::class, 'loadDataTypeFormats']);
        Route::get('/customerItemConfigure/loadNumberOfLables/{type}', [CustomerItemsController::class, 'loadNumberOfLables']);
        Route::get('/customerItemConfigure/loadPrinters', [CustomerItemsController::class, 'loadPrinters']);


        // productionPlan configure
        Route::get('/productionPlan_configure', function () {
            return view('mnu::pages.masters.productionPlanConfigure');
        });
        Route::post('/productionPlanConfigure/save', [ProductionPlanController::class, 'save']);
        Route::post('/productionPlanConfigure/update', [ProductionPlanController::class, 'update']);
        Route::get('/productionPlanConfigure/loadproductionPlan/{id}', [ProductionPlanController::class, 'loadproductionPlan']);
        Route::post('/productionPlanConfigure/loadRequirements', [ProductionPlanController::class, 'loadRequirements']);
        Route::post('/productionPlanConfigure/loadTodayPlans', [ProductionPlanController::class, 'loadTodayPlans']);
        Route::get('/productionPlanConfigure/loadProcess', [ProductionPlanController::class, 'loadProcess']);
        Route::get('/productionPlanConfigure/loadProcessWorkstations/{ProcessId}', [ProductionPlanController::class, 'loadProcessWorkstations']);
        Route::post('/productionPlanConfigure/loadItemRequirements', [ProductionPlanController::class, 'loadItemRequirements']);
        Route::post('/productionPlanConfigure/loadPackingMaterialRequirements', [ProductionPlanController::class, 'loadPackingMaterialRequirements']);
        Route::get('/productionPlanConfigure/loadChangeRequest', [ProductionPlanController::class, 'loadChangeRequest']);
        Route::get('/productionPlanConfigure/viewChangeRequests/{wsReqId}', [ProductionPlanController::class, 'viewChangeRequests']);
        Route::get('/productionPlanConfigure/loadWorkSheetSToTheChangeRequest/{wsReqId}', [ProductionPlanController::class, 'loadWorkSheetSToTheChangeRequest']);
        Route::post('/productionPlanConfigure/updateWsChangeReq', [ProductionPlanController::class, 'updateWsChangeReq']);
        Route::get('/productionPlanConfigure/loadCounts', [ProductionPlanController::class, 'loadCounts']);




        //new Requirements
        Route::get('/NewRequirements_configure', function () {
            return view('mnu::pages.masters.newRequirementConfigure');
        });
        Route::post('/newRequirementConfigure/save', [newRequirementController::class, 'save']);
        Route::post('/newRequirementConfigure/update', [newRequirementController::class, 'update']);
        Route::get('/newRequirementConfigure/loadItems', [newRequirementController::class, 'loadItems']);
        Route::get('/newRequirementConfigure/getItem/{itemID}', [newRequirementController::class, 'getItem']);
        Route::get('/newRequirementConfigure/loadToday', [newRequirementController::class, 'loadToday']);



        Route::get('/productionPlanConfigure/loadproductionPlan/{id}', [ProductionPlanController::class, 'loadproductionPlan']);
        Route::get('/productionPlanConfigure/loadParentGroups', [ProductionPlanController::class, 'loadParentGroups']);

        // planing Detail Configure
        Route::get('/planingDetail_configure', function () {
            return view('mnu::pages.masters.planingDetailConfigure');
        });
        Route::post('/planingDetailConfigure/split', [PlaningDetailController::class, 'split']);
        Route::get('/planingDetailConfigure/loadProcess', [PlaningDetailController::class, 'loadProcess']);
        Route::get('/planingDetailConfigure/loadProcessWorkstations/{ProcessId}', [PlaningDetailController::class, 'loadProcessWorkstations']);
        Route::post('/planingDetailConfigure/loadPlans', [PlaningDetailController::class, 'loadPlans']);
        Route::get('/planingDetailConfigure/loadSplitModel/{wsId}', [PlaningDetailController::class, 'loadSplitModel']);
        Route::get('/planingDetailConfigure/changeState/{PlanID}/{state}', [PlaningDetailController::class, 'changeState']);
        Route::get('/planingDetailConfigure/loadLastCompleatedPlans', [PlaningDetailController::class, 'loadLastCompleatedPlans']);

        // Production Recovery Details
        Route::get('/reports/productionRecovery_details', function () {
            return view('mnu::pages.masters.productionRecoveryDetails');
        });
        Route::get('/productionRecoveryDetails/loadSuppliers', [ProductionRecoveryDetailsController::class, 'loadSuppliers']);
        Route::get('/productionRecoveryDetails/loadGrades', [ProductionRecoveryDetailsController::class, 'loadGrades']);
        Route::get('/productionRecoveryDetails/loadFishTypes', [ProductionRecoveryDetailsController::class, 'loadFishTypes']);
        Route::get('/productionRecoveryDetails/loadPresentation', [ProductionRecoveryDetailsController::class, 'loadPresentation']);
        Route::get('/productionRecoveryDetails/loadSize', [ProductionRecoveryDetailsController::class, 'loadSize']);
        Route::get('/productionRecoveryDetails/generateReport', [ProductionRecoveryDetailsController::class, 'generateReport']);
        Route::get('/productionRecoveryDetails/loadGRNnumbers', [ProductionRecoveryDetailsController::class, 'loadGRNnumbers']);

        // Packing Details
        Route::get('/packingDetails', function () {
            return view('mnu::pages.masters.packingDetailsConfigure');
        });
        Route::get('/packingDetailsConfigure/loadWSnumbers', [PackingDetailsController::class, 'loadWSnumbers']);
        Route::get('/packingDetailsConfigure/loadCustomers', [PackingDetailsController::class, 'loadCustomers']);
        Route::get('/packingDetailsConfigure/loadWorkSheets', [PackingDetailsController::class, 'loadWorkSheets']);
        Route::get('/packingDetailsConfigure/loadWorksheetDtls/{mainPlId}', [PackingDetailsController::class, 'loadWorksheetDtls']);
        Route::get('/packingDetailsConfigure/loadNewGenPL', [PackingDetailsController::class, 'loadNewGenPL']);
        Route::post('/packingDetailsConfigure/saveGpl', [PackingDetailsController::class, 'saveGpl']);
        Route::get('/packingDetailsConfigure/loadGpls/{mainPlId}', [PackingDetailsController::class, 'loadGpls']);
        Route::delete('/packingDetailsConfigure/deleteGpl/{id}', [PackingDetailsController::class, 'deleteGpl']);
        Route::get('/packingDetailsConfigure/editGpl/{id}', [PackingDetailsController::class, 'editGpl']);
        Route::post('/packingDetailsConfigure/UpdateGpl/{id}', [PackingDetailsController::class, 'UpdateGpl']);
        Route::get('/packingDetailsConfigure/loadNewExpPL/{mainPlId}', [PackingDetailsController::class, 'loadNewExpPL']);
        Route::get('/packingDetailsConfigure/updateExpPlSummary', [PackingDetailsController::class, 'updateExpPlSummary']);
        Route::get('/packingDetailsConfigure/loadGplSummaryDetails/{mainPlId}', [PackingDetailsController::class, 'loadGplSummaryDetails']);
        Route::get('/packingDetailsConfigure/loadDestinations', [PackingDetailsController::class, 'loadDestinations']);
        Route::get('/packingDetailsConfigure/loadAirlines', [PackingDetailsController::class, 'loadAirlines']);
        Route::get('/packingDetailsConfigure/loadCustomerAddress/{mainPlId}', [PackingDetailsController::class, 'loadCustomerAddress']);
        Route::get('/packingDetailsConfigure/loadCustomerNotify/{mainPlId}', [PackingDetailsController::class, 'loadCustomerNotify']);
        Route::get('/packingDetailsConfigure/loadAddress/{addressId}', [PackingDetailsController::class, 'loadAddress']);
        Route::post('/packingDetailsConfigure/saveExpl', [PackingDetailsController::class, 'saveExpl']);
        Route::get('/packingDetailsConfigure/loadExpls/{mainPlId}', [PackingDetailsController::class, 'loadExpls']);
        Route::delete('/packingDetailsConfigure/deleteExpl/{id}', [PackingDetailsController::class, 'deleteExpl']);
        Route::get('/packingDetailsConfigure/editExpl/{id}', [PackingDetailsController::class, 'editExpl']);
        Route::post('/packingDetailsConfigure/UpdateExpl', [PackingDetailsController::class, 'UpdateExpl']);
        Route::get('/packingDetailsConfigure/LOadPickListBoxes/{pickListNum}', [PackingDetailsController::class, 'LOadPickListBoxes']);


        //Packing Details Reports
        Route::post('/packing-list/download', [PackingListController::class, 'download'])->name('packing-list.download');
        Route::get('/packingDetailsConfigure/getReport/{reportType}/{EplId}', [PackingDetailsReportsController::class, 'getReport']);







    });
});
