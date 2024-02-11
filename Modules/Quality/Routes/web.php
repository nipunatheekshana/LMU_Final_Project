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
use Modules\Quality\Http\Controllers\Masters\QualityCheckingRulesController;
use Modules\Quality\Http\Controllers\Masters\QualityCheckParamatersController;
use Modules\Quality\Http\Controllers\Masters\QualityRuleParametersController;
use Modules\Quality\Http\Controllers\QualityControleController;
use Modules\Quality\Http\Controllers\QualityController;
use Modules\Quality\Http\Controllers\Masters\LabTestTypesController;
use Modules\Quality\Http\Controllers\QualityLabTestController;
use Modules\Buying\Http\Controllers\Masters\grnHistoryController;

Route::prefix('quality')->group(function () {
    Route::group(['middleware' => ['is.logged']], function () { //logged users route group

        // qualityCheckParameters list
        Route::get('/qualityCheckParameter_list', function () {
            return view('quality::pages.masters.qualityCheckParameters');
        });
        Route::get('/qualityCheckParameter/loadqualityCheckParameters', [QualityCheckParamatersController::class, 'loadqualityCheckParameters']);
        Route::delete('/qualityCheckParameter/delete/{id}', [QualityCheckParamatersController::class, 'delete']);
        Route::get('/qualityCheckParameter/view/{id}', [QualityCheckParamatersController::class, 'view']);

        // qualityCheckParameters configure
        Route::get('/qualityCheckParameter_configure', function () {
            return view('quality::pages.masters.qualityCheckParametersConfigure');
        });
        Route::post('/qualityCheckParametersConfigure/save', [QualityCheckParamatersController::class, 'save']);
        Route::post('/qualityCheckParametersConfigure/update', [QualityCheckParamatersController::class, 'update']);
        Route::get('/qualityCheckParametersConfigure/loadQualityCheckParameter/{id}', [QualityCheckParamatersController::class, 'loadQualityCheckParameter']);

        // qualityCheckingRules list
        Route::get('/qualityCheckingRules_list', function () {
            return view('quality::pages.masters.qualityCheckingRules');
        });
        Route::get('/qualityCheckingRules/loadQualityCheckingRules', [QualityCheckingRulesController::class, 'loadQualityCheckingRules']);
        Route::delete('/qualityCheckingRules/delete/{id}', [QualityCheckingRulesController::class, 'delete']);
        Route::get('/qualityCheckingRules/view/{id}', [QualityCheckingRulesController::class, 'view']);

        // Quality Checking Rules configure
        Route::get('/qualityCheckingRules_configure', function () {
            return view('quality::pages.masters.qualityCheckingRulesConfigure');
        });
        Route::post('/qualityCheckingRulesConfigure/save', [QualityCheckingRulesController::class, 'save']);
        Route::post('/qualityCheckingRulesConfigure/update', [QualityCheckingRulesController::class, 'update']);
        Route::get('/qualityCheckingRulesConfigure/loadQualityCheckingRule/{id}', [QualityCheckingRulesController::class, 'loadQualityCheckingRule']);
        Route::get('/qualityCheckingRulesConfigure/loadCompanies', [QualityCheckingRulesController::class, 'loadCompanies']);


        // qualityRuleParameters list
        Route::get('/qualityRuleParameters_list', function () {
            return view('quality::pages.masters.qualityRuleParameters');
        });
        Route::get('/qualityRuleParameters/loadQualityRuleParameters', [QualityRuleParametersController::class, 'loadQualityRuleParameters']);
        Route::delete('/qualityRuleParameters/delete/{id}', [QualityRuleParametersController::class, 'delete']);
        Route::get('/qualityRuleParameters/view/{id}', [QualityRuleParametersController::class, 'view']);

        // qualityRuleParameters configure
        Route::get('/qualityRuleParameters_configure', function () {
            return view('quality::pages.masters.qualityRuleParametersConfigure');
        });
        Route::post('/qualityRuleParametersConfigure/save', [QualityRuleParametersController::class, 'save']);
        Route::post('/qualityRuleParametersConfigure/update', [QualityRuleParametersController::class, 'update']);
        Route::get('/qualityRuleParametersConfigure/loadQualityRuleParameter/{id}', [QualityRuleParametersController::class, 'loadQualityRuleParameter']);

        Route::get('/qualityRuleParametersConfigure/loadQParameterId', [QualityRuleParametersController::class, 'loadQParameterId']);
        Route::get('/qualityRuleParametersConfigure/loadQualityRuleID', [QualityRuleParametersController::class, 'loadQualityRuleID']);

        Route::get('/qualityRuleParametersConfigure/loadMinMaxValue/{id}', [QualityRuleParametersController::class, 'loadMinMaxValue']);
        Route::post('/qualityRuleParametersConfigure/loadRelatedParam', [QualityRuleParametersController::class, 'loadRelatedParam']);

        // Quality Control Configure
        Route::get('/qualityControl_configure', function () {
            return view('quality::pages.masters.qualityControlConfigure');
        });
        Route::get('/qualityControlConfigure/loadGrns', [QualityControleController::class, 'loadGrns']);
        Route::get('/qualityControlConfigure/addGrn/{GrnId}/{testType}', [QualityControleController::class, 'addGrn']);
        Route::get('/qualityControlConfigure/loadPcsDetails/{grnDtlId}/{testType}', [QualityControleController::class, 'loadPcsDetails']);
        Route::get('/qualityControlConfigure/loadTestTypes', [QualityControleController::class, 'loadTestTypes']);
        Route::get('/qualityControlConfigure/locuUnlockgrnDetails/{GrnDtlId}/{status}', [QualityControleController::class, 'locuUnlockgrnDetails']);
        Route::get('/qualityControlConfigure/lockUnlockPcs/{pcsId}/{status}', [QualityControleController::class, 'lockUnlockPcs']);
        Route::get('/qualityControlConfigure/bulkLockUnlockFish/{status}', [QualityControleController::class, 'bulkLockUnlockFish']);
        Route::get('/qualityControlConfigure/bulkLockUnlockPcs/{status}', [QualityControleController::class, 'bulkLockUnlockPcs']);
        Route::get('/qualityControlConfigure/updateTestValues', [QualityControleController::class, 'updateTestValues']);
        Route::get('/qualityControlConfigure/rejectAllowFish/{status}', [QualityControleController::class, 'rejectAllowFish']);
        Route::get('/qualityControlConfigure/rejectAllowPcs/{status}', [QualityControleController::class, 'rejectAllowPcs']);
        Route::get('/qualityControlConfigure/loadBoatsAndLandingSites', [QualityControleController::class, 'loadBoatsAndLandingSites']);
        Route::get('/qualityControlConfigure/updateAdminChanges/{GrnId}', [QualityControleController::class, 'updateAdminChanges']);
        Route::get('/qualityControlConfigure/edit/{GrnDtlId}', [QualityControleController::class, 'edit']);
        Route::get('/qualityControlConfigure/UpdateFish/{quality_grade}/{grnDtlId}', [QualityControleController::class, 'UpdateFish']);

        // Lab Test Types List
        Route::get('/labTestTypes_list', function () {
            return view('quality::pages.masters.labTestTypes');
        });
        Route::get('/labTestTypes/loadLabTestTypes', [LabTestTypesController::class, 'loadLabTestTypes']);
        Route::delete('/labTestTypes/delete/{id}', [LabTestTypesController::class, 'delete']);
        Route::get('/labTestTypes/view/{id}', [LabTestTypesController::class, 'view']);

        // Lab Test Types Configure
        Route::get('/labTestTypes_configure', function () {
            return view('quality::pages.masters.labTestTypesConfigure');
        });
        Route::post('/labTestTypesConfigure/save', [LabTestTypesController::class, 'save']);
        Route::post('/labTestTypesConfigure/update', [LabTestTypesController::class, 'update']);
        Route::get('/labTestTypesConfigure/loadLabTestType/{id}', [LabTestTypesController::class, 'loadLabTestType']);
        Route::get('/labTestTypesConfigure/loadCompanies', [LabTestTypesController::class, 'loadCompanies']);
        Route::get('/labTestTypesConfigure/loadCurrencies', [LabTestTypesController::class, 'loadCurrencies']);

         // Quality Lab Configure
        Route::get('/qualitylabtests', function () {
            return view('quality::pages.masters.qualityLabTests');
        });
        Route::get('/qualitylabtests/loadqualitylabtests', [QualityLabTestController::class, 'loadqualitylabtests']);
        Route::delete('/qualitylabtests/delete/{id}', [QualityLabTestController::class, 'deleteQualityLabTest']);
        Route::get('/qualitylabtests/view/{id}', [QualityLabTestController::class, 'view']);
        Route::get('/qualitylabtests/loadDropdownData', [QualityLabTestController::class, 'loadDropdownData']);
        Route::post('/qualitylabtests/newTestSave', [QualityLabTestController::class, 'newTestSave']);
        Route::get('/qualitylabtests/loadQualityLabTest/{id}', [QualityLabTestController::class, 'loadQualityLabTest']);
        Route::post('/qualitylabtests/update', [QualityLabTestController::class, 'update']);
        Route::get('/qualitylabtests/loadGrns', [QualityLabTestController::class, 'loadGrns']);
        Route::get('/qualitylabtests/loadTestSampleRequiredData', [QualityLabTestController::class, 'loadTestSampleRequiredData']);
        Route::post('/qualitylabtests/saveSample', [QualityLabTestController::class, 'saveSample']);
        Route::get('/qualitylabtests/loadTestSamplesTable/{labTestHdId}', [QualityLabTestController::class, 'loadTestSamplesTable']);
        Route::delete('/qualitylabtests/deleteSample/{id}', [QualityLabTestController::class, 'deleteSample']);
        Route::get('/qualitylabtests/editSample/{id}', [QualityLabTestController::class, 'editSample']);
        Route::post('/qualitylabtests/updateSample', [QualityLabTestController::class, 'updateSample']);
        Route::get('/qualitylabtests/loadTestType/{labTestHdId}', [QualityLabTestController::class, 'loadTestType']);
        Route::delete('/qualitylabtests/deleteTestType/{id}', [QualityLabTestController::class, 'deleteTestType']);
        Route::post('/qualitylabtests/addTestType', [QualityLabTestController::class, 'addTestType']);
        Route::get('/qualitylabtests/loadRequiredDataAddTestTypeModel', [QualityLabTestController::class, 'loadRequiredDataAddTestTypeModel']);
        Route::get('/qualitylabtests/editAndTestResults/{LbtestDtLTypeId}/{labTestHdId}', [QualityLabTestController::class, 'editAndTestResults']);
        Route::post('/qualitylabtests/UpdatTestType', [QualityLabTestController::class, 'UpdatTestType']);
        Route::post('/qualitylabtests/UpdateResulValue', [QualityLabTestController::class, 'UpdateResulValue']);
        Route::post('/qualitylabtests/UpdateResult', [QualityLabTestController::class, 'UpdateResult']);
        Route::get('/qualitylabtests/scanToAdd/{barcode}', [QualityLabTestController::class, 'scanToAdd']);









    });
});
