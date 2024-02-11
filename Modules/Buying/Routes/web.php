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
use Modules\Buying\Http\Controllers\Masters\CompanySuppliersController;
use Modules\Buying\Http\Controllers\Masters\grnHistoryController;
use Modules\Buying\Http\Controllers\Masters\grnHistoryReportsController;
use Modules\Buying\Http\Controllers\Masters\monthlyPurchaseSummaryController;
use Modules\Buying\Http\Controllers\Masters\periodicPurchaseSummaryController;
use Modules\Buying\Http\Controllers\Masters\supplierConfigureController;
use Modules\Buying\Http\Controllers\Masters\SupplierGroupConfigureController;
use Modules\Buying\Http\Controllers\Masters\SupplierHoldTypesController;
use Modules\Buying\Http\Controllers\Masters\purchaseAnalyticsController;
use Modules\Buying\Http\Controllers\Masters\QGrnController;

Route::prefix('buying')->group(function () {
    Route::group(['middleware' => ['is.logged']], function () { //logged users route group

        // supplierGroup list
        Route::get('/supplierGroup_list', function () {
            return view('buying::pages.masters.supplierGroup');
        });
        Route::get('/supplierGroup/loadsupplierGroups', [SupplierGroupConfigureController::class, 'loadsupplierGroups']);
        Route::delete('/supplierGroup/delete/{id}', [SupplierGroupConfigureController::class, 'delete']);

        // supplierGroup configure
        Route::get('/supplierGroup_configure', function () {
            return view('buying::pages.masters.supplierGroupConfigure');
        });
        Route::post('/supplierGroupConfigure/save', [SupplierGroupConfigureController::class, 'save']);
        Route::post('/supplierGroupConfigure/update', [SupplierGroupConfigureController::class, 'update']);
        Route::get('/supplierGroupConfigure/loadParentGroups', [SupplierGroupConfigureController::class, 'loadParentGroups']);
        Route::get('/supplierGroupConfigure/loadSupplierGroup/{id}', [SupplierGroupConfigureController::class, 'loadSupplierGroup']);

        // supplier list
        Route::get('/supplier_list', function () {
            return view('buying::pages.masters.supplier');
        });
        Route::get('/supplier/loadsuppliers', [supplierConfigureController::class, 'loadsuppliers']);
        Route::delete('/supplier/delete/{id}', [supplierConfigureController::class, 'delete']);
        Route::get('/supplier/view/{id}', [supplierConfigureController::class, 'view']);

        // supplier configure
        Route::get('/supplier_configure', function () {
            return view('buying::pages.masters.supplierConfigure');
        });
        Route::post('/supplierConfigure/save', [supplierConfigureController::class, 'save']);
        Route::post('/supplierConfigure/update', [supplierConfigureController::class, 'update']);
        Route::get('/supplierConfigure/loadSupplier/{id}', [supplierConfigureController::class, 'loadSupplier']);
        Route::get('/supplierConfigure/loadCountries', [supplierConfigureController::class, 'loadCountries']);
        Route::get('/supplierConfigure/loadSupplierGroup', [supplierConfigureController::class, 'loadSupplierGroup']);
        Route::get('/supplierConfigure/loadCurrencies', [supplierConfigureController::class, 'loadCurrencies']);
        Route::get('/supplierConfigure/SetSessionAndReturnUrl/{id}', [supplierConfigureController::class, 'SetSessionAndReturnUrl']);
        Route::get('/supplierConfigure/loadSupplierAddress/{id}', [supplierConfigureController::class, 'loadSupplierAddress']);
        Route::get('/supplierConfigure/loadSupplierContact/{id}', [supplierConfigureController::class, 'loadSupplierContact']);
        Route::get('/supplierConfigure/loadAddress', [supplierConfigureController::class, 'loadAddress']);
        Route::get('/supplierConfigure/loadNotify', [supplierConfigureController::class, 'loadNotify']);
        Route::get('/supplierConfigure/loadContacts', [supplierConfigureController::class, 'loadContacts']);
        Route::post('/supplierConfigure/link', [supplierConfigureController::class, 'link']);

        //SupplierHoldTypes list
        Route::get('/supplierHoldTypes_list', function () {
            return view('buying::pages.masters.supplierHoldTypes');
        });
        Route::get('/supplierHoldTypes/loadSupplierHoldTypes', [SupplierHoldTypesController::class, 'loadSupplierHoldTypes']);
        Route::delete('/supplierHoldTypes/delete/{id}', [SupplierHoldTypesController::class, 'delete']);
        Route::get('/supplierHoldTypes/view/{id}', [SupplierHoldTypesController::class, 'view']);

        // SupplierHoldTypes configure
        Route::get('/supplierHoldTypes_configure', function () {
            return view('buying::pages.masters.supplierHoldTypesConfigure');
        });
        Route::post('/supplierHoldTypesConfigure/save', [SupplierHoldTypesController::class, 'save']);
        Route::post('/supplierHoldTypesConfigure/update', [SupplierHoldTypesController::class, 'update']);
        Route::get('/supplierHoldTypesConfigure/loadSupplierHoldType/{id}', [SupplierHoldTypesController::class, 'loadSupplierHoldType']);


        // companySupplier list
        Route::get('/companySupplier_list', function () {
            return view('buying::pages.masters.companySupplier');
        });
        Route::get('/companySupplier/loadCompanySuppliers', [CompanySuppliersController::class, 'loadCompanySuppliers']);
        Route::delete('/companySupplier/delete/{id}', [CompanySuppliersController::class, 'delete']);
        Route::get('/companySupplier/view/{id}', [CompanySuppliersController::class, 'view']);

        // companySupplier configure
        Route::get('/companySupplier_configure', function () {
            return view('buying::pages.masters.companySupplierConfigure');
        });
        Route::post('/companySupplierConfigure/save', [CompanySuppliersController::class, 'save']);
        Route::post('/companySupplierConfigure/update', [CompanySuppliersController::class, 'update']);
        Route::get('/companySupplierConfigure/loadCompanySupplier/{id}', [CompanySuppliersController::class, 'loadCompanySupplier']);
        Route::get('/companySupplierConfigure/loadCompanies', [CompanySuppliersController::class, 'loadCompanies']);
        Route::get('/companySupplierConfigure/loadSuppliers', [CompanySuppliersController::class, 'loadSuppliers']);
        Route::get('/companySupplierConfigure/loadHoldTypes', [CompanySuppliersController::class, 'loadHoldTypes']);

        // GrnHistory list
        Route::get('/grnHistory_list', function () {
            return view('buying::pages.masters.grnHistory');
        });
        Route::post('/grnHistory/loadGrnHistory', [grnHistoryController::class, 'loadGrnHistory']);
        Route::delete('/grnHistory/delete/{id}', [grnHistoryController::class, 'delete']);
        Route::get('/grnHistory/loadSuppliers', [grnHistoryController::class, 'loadSuppliers']);
        Route::get('/grnHistory/loadBoats', [grnHistoryController::class, 'loadBoats']);



        // GrnHistory configure
        Route::get('/grnHistory_configure', function () {
            return view('buying::pages.masters.grnHistoryConfigure');
        });
        Route::post('/grnHistoryConfigure/save', [grnHistoryController::class, 'save']);
        Route::get('/grnHistoryConfigure/loadGrnDetails/{id}', [grnHistoryController::class, 'loadGrnDetails']);
        Route::post('/grnHistoryConfigure/loadFishDetailsTable', [grnHistoryController::class, 'loadFishDetailsTable']);
        Route::get('/grnHistoryConfigure/loadTypesInTable/{GRNno}', [grnHistoryController::class, 'loadTypesInTable']);
        Route::get('/grnHistoryConfigure/loadPresentation', [grnHistoryController::class, 'loadPresentation']);
        Route::get('/grnHistoryConfigure/loadSize/{GRNno}', [grnHistoryController::class, 'loadSize']);
        Route::get('/grnHistoryConfigure/loadFishGrade', [grnHistoryController::class, 'loadFishGrade']);
        Route::post('/grnHistoryConfigure/loadFishDetailSummary', [grnHistoryController::class, 'loadFishDetailSummary']);
        Route::get('/grnHistoryConfigure/loadFishGradeData/{GRNNo}/{fishCode}', [grnHistoryController::class, 'loadFishGradeData']);
        Route::get('/grnHistoryConfigure/loadSuppliers', [grnHistoryController::class, 'loadSuppliers']);
        Route::get('/grnHistoryConfigure/loadBoats', [grnHistoryController::class, 'loadBoats']);
        Route::get('/grnHistoryConfigure/loadBoatDetails/{boatId}', [grnHistoryController::class, 'loadBoatDetails']);
        Route::post('/grnHistoryConfigure/UpdateBoatDetails', [grnHistoryController::class, 'UpdateBoatDetails']);
        Route::get('/grnHistoryConfigure/loadAdminDetails/{GRNno}', [grnHistoryController::class, 'loadAdminDetails']);
        Route::get('/grnHistoryConfigure/LoadFishDetails/{grnno}/{fishNo}', [grnHistoryController::class, 'LoadFishDetails']);
        Route::post('/grnHistoryConfigure/UpdateFishDetails', [grnHistoryController::class, 'UpdateFishDetails']);
        Route::get('/grnHistoryConfigure/LoadProductionDetail/{fishNo}/{GRNno}', [grnHistoryController::class, 'LoadProductionDetail']);
        Route::get('/grnHistoryConfigure/loadFishSizeTOFIsh/{GRNno}/{FishCode}', [grnHistoryController::class, 'loadFishSizeTOFIsh']);
        Route::get('/grnHistoryConfigure/loadFishSpecies', [grnHistoryController::class, 'loadFishSpecies']);
        Route::get('/grnHistoryConfigure/loadResiverdFishSpecies/{GRNno}', [grnHistoryController::class, 'loadResiverdFishSpecies']);
        Route::get('/grnHistoryConfigure/LoadSizeTable/{GRNno}/{fishId}', [grnHistoryController::class, 'LoadSizeTable']);
        Route::delete('/grnHistoryConfigure/deleteSize/{id}', [grnHistoryController::class, 'deleteSize']);
        Route::get('/grnHistoryConfigure/getNewMinValue/{GRNno}/{fishId}', [grnHistoryController::class, 'getNewMinValue']);
        Route::post('/grnHistoryConfigure/saveSize/{GRNno}', [grnHistoryController::class, 'saveSize']);
        Route::post('/grnHistoryConfigure/SetStatus/{GRNno}', [grnHistoryController::class, 'SetStatus']);
        Route::get('/grnHistoryConfigure/loadStatus/{GRNno}', [grnHistoryController::class, 'loadStatus']);
        Route::get('/grnHistoryConfigure/loadGrnPricingTable/{GRNno}', [grnHistoryController::class, 'loadGrnPricingTable']);
        Route::get('/grnHistoryConfigure/loadCurrancy', [grnHistoryController::class, 'loadCurrancy']);
        Route::get('/grnHistoryConfigure/getExchangeRateToDate/{currancyId}/{GRNno}', [grnHistoryController::class, 'getExchangeRateToDate']);
        Route::post('/grnHistoryConfigure/saveGRNPricing', [grnHistoryController::class, 'saveGRNPricing']);
        Route::get('/grnHistoryConfigure/getReport/{reportId}/{GRNno}', [grnHistoryReportsController::class, 'getReport']);
        Route::get('/grnHistoryConfigure/loadAddWastageModleData', [grnHistoryController::class, 'loadAddWastageModleData']);
        Route::Post('/grnHistoryConfigure/saveWastage', [grnHistoryController::class, 'saveWastage']);
        Route::get('/grnHistoryConfigure/loadWastageModleData/{GRNno}', [grnHistoryController::class, 'loadWastageModleData']);


        // Monthly Purchase Summary
        Route::get('/monthlyPurchaseSummary', function () {
            return view('buying::pages.masters.monthlyPurchaseSummary');
        });
        Route::get('/monthlyPurchaseSummary/loadYears', [monthlyPurchaseSummaryController::class, 'loadYears']);
        Route::get('/monthlyPurchaseSummary/loadSuppliers', [monthlyPurchaseSummaryController::class, 'loadSuppliers']);
        Route::get('/monthlyPurchaseSummary/loadGrades', [monthlyPurchaseSummaryController::class, 'loadGrades']);
        Route::get('/monthlyPurchaseSummary/loadFishTypes', [monthlyPurchaseSummaryController::class, 'loadFishTypes']);
        Route::get('/monthlyPurchaseSummary/loadPresentation', [monthlyPurchaseSummaryController::class, 'loadPresentation']);
        Route::get('/monthlyPurchaseSummary/loadSize', [monthlyPurchaseSummaryController::class, 'loadSize']);
        Route::get('/monthlyPurchaseSummary/generateReport', [monthlyPurchaseSummaryController::class, 'generateReport']);

        // Periodic Purchase Summary
        Route::get('/periodicPurchaseSummary', function () {
            return view('buying::pages.masters.periodicPurchaseSummary');
        });
        Route::get('/periodicPurchaseSummary/loadSuppliers', [periodicPurchaseSummaryController::class, 'loadSuppliers']);
        Route::get('/periodicPurchaseSummary/loadGrades', [periodicPurchaseSummaryController::class, 'loadGrades']);
        Route::get('/periodicPurchaseSummary/loadFishTypes', [periodicPurchaseSummaryController::class, 'loadFishTypes']);
        Route::get('/periodicPurchaseSummary/loadPresentation', [periodicPurchaseSummaryController::class, 'loadPresentation']);
        Route::get('/periodicPurchaseSummary/loadSize', [periodicPurchaseSummaryController::class, 'loadSize']);
        Route::get('/periodicPurchaseSummary/generateReport', [periodicPurchaseSummaryController::class, 'generateReport']);
        Route::get('/periodicPurchaseSummary/getGradeWiseChartData', [periodicPurchaseSummaryController::class, 'GradeSummaryChart']);
        Route::get('/periodicPurchaseSummary/getPresentationWiseChartData', [periodicPurchaseSummaryController::class, 'PresentationSummaryChart']);

        // Dashboard
        Route::get('/', function () {
            return view('buying::pages.masters.dashboardBuying');
        });

        // Purchase Analytics
        Route::get('/purchaseAnalytics', function () {
            return view('buying::pages.masters.purchaseAnalytics');
        });
        Route::get('/purchaseAnalytics/loadFishSpecies', [purchaseAnalyticsController::class, 'loadFishSpecies']);
        Route::get('/purchaseAnalytics/loadAnnualPurchaseGradeWeight', [purchaseAnalyticsController::class, 'loadAnnualPurchaseGradeWeight']);
        Route::get('/purchaseAnalytics/loadAnnualPurchaseSizeWeight', [purchaseAnalyticsController::class, 'loadAnnualPurchaseSizeWeight']);
        Route::get('/purchaseAnalytics/loadAnnualPurchaseGradePrice', [purchaseAnalyticsController::class, 'loadAnnualPurchaseGradePrice']);
        Route::get('/purchaseAnalytics/updateAnnualPurchaseSumCharts', [purchaseAnalyticsController::class, 'updateAnnualPurchaseSumCharts']);
        Route::get('/purchaseAnalytics/updateAnnualAvaragePriceCharts', [purchaseAnalyticsController::class, 'updateAnnualAvaragePriceCharts']);
        Route::post('/purchaseAnalytics/saveSelection', [purchaseAnalyticsController::class, 'saveSelection']);
        Route::get('/purchaseAnalytics/loadPreviousFishData', [purchaseAnalyticsController::class, 'loadPreviousFishData']);


         // QGrn list
         Route::get('/QGrn_list', function () {
            return view('buying::pages.masters.QGrn');
        });
        Route::get('/QGrn/loadQGrns', [QGrnController::class, 'loadQGrns']);
        Route::delete('/QGrn/delete/{id}', [QGrnController::class, 'delete']);

        // QGrn configure
        Route::get('/QGrn_configure', function () {
            return view('buying::pages.masters.QGrnConfigure');
        });
        Route::post('/QGrnConfigure/save', [QGrnController::class, 'save']);
        Route::post('/QGrnConfigure/update', [QGrnController::class, 'update']);
        Route::get('/QGrnConfigure/loadQGrn/{id}', [QGrnController::class, 'loadQGrn']);
        Route::get('/QGrnConfigure/loadDropDownData', [QGrnController::class, 'loadDropDownData']);

    });
});
