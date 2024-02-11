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
use Modules\Settings\Entities\ProcessWorkstation;
use Modules\Settings\Http\Controllers\CompanySetting\CompanyListController;
use Modules\Settings\Http\Controllers\CompanySetting\CreateCompanyController;
use Modules\Settings\Http\Controllers\CompanySetting\CreateCompanyUsersController;
use Modules\Settings\Http\Controllers\Masters\ActivityController;
use Modules\Settings\Http\Controllers\Masters\BarcodeTypesController;
use Modules\Settings\Http\Controllers\Masters\DataTypeController;
use Modules\Settings\Http\Controllers\Masters\DataTypeFormatController;
use Modules\Settings\Http\Controllers\Masters\NamingSeriesController;
use Modules\Settings\Http\Controllers\Masters\PrintersController;
use Modules\Settings\Http\Controllers\Masters\ProcessActEmpFiltersController;
use Modules\Settings\Http\Controllers\Masters\ProcessActivitiesController;
use Modules\Settings\Http\Controllers\Masters\ProcessesController;
use Modules\Settings\Http\Controllers\Masters\ProcessWorkstationsController;
use Modules\Settings\Http\Controllers\Masters\TransportVehicleTypesController;
use Modules\Settings\Http\Controllers\Masters\workstationsController;
use Modules\Settings\Http\Controllers\Masters\ReportsController;
use Modules\Settings\Http\Controllers\SystemSettings\EmailSettingsController;
use Modules\Settings\Http\Controllers\Masters\TermsController;
use Illuminate\Support\Facades\File;
use Modules\Settings\Http\Controllers\Masters\driverController;
use Modules\Settings\Http\Controllers\Masters\vehicleyController;

Route::prefix('settings')->group(function () {
    Route::group(['middleware' => ['is.logged']], function () { //logged users route group

        //email settings
        Route::get('/email_settings', function () {
            return view('settings::pages.system_settings.emailsettings');
        });
        Route::get('/emailsettings/loadCurrentSettings', [EmailSettingsController::class, 'loadCurrentSettings']);
        Route::POST('/emailsettings/SaveNewsettings', [EmailSettingsController::class, 'SaveNewsettings']);
        Route::POST('/emailsettings/testEmail', [EmailSettingsController::class, 'testEmail']);



        // create_Company
        Route::get('/create_Company', function () {
            return view('settings::pages.companySetting.createCompany');
        });
        Route::post('/createCompany/save', [CreateCompanyController::class, 'save']);
        Route::get('/createCompany/loadChildCompany/{id}', [CreateCompanyController::class, 'loadChildCompany']);
        Route::post('/createCompany/update', [CreateCompanyController::class, 'update']);
        Route::get('/createCompany/loadGroupCompanies', [CreateCompanyController::class, 'loadGroupCompanies']);
        Route::get('/createCompany/loadCountries', [CreateCompanyController::class, 'loadCountries']);
        Route::get('/createCompany/loadCurrency', [CreateCompanyController::class, 'loadCurrency']);
        Route::get('/createCompany/loadDomains', [CreateCompanyController::class, 'loadDomains']);


        //  company list
        Route::get('/Company_List', function () {
            return view('settings::pages.companySetting.CompanyList');
        });
        Route::get('/CompanyList/loadCompanies', [CompanyListController::class, 'loadCompanies']);
        Route::delete('/CompanyList/delete/{id}', [CompanyListController::class, 'delete']);

        // createCompanyUsers
        Route::get('/createCompanyUsers', function () {
            return view('settings::pages.companySetting.createCompanyUsers');
        });
        Route::get('/createCompanyUsers/loadCompany', [CreateCompanyUsersController::class, 'loadCompany']);
        Route::post('/createCompanyUsers/save', [CreateCompanyUsersController::class, 'save']);
        Route::post('/createCompanyUsers/update', [CreateCompanyUsersController::class, 'update']);
        Route::get('/createCompanyUsers/loadUsers', [CreateCompanyUsersController::class, 'loadUsers']);
        Route::get('/createCompanyUsers/loadUser/{id}', [CreateCompanyUsersController::class, 'loadUser']);
        Route::delete('/createCompanyUsers/delete/{id}', [CreateCompanyUsersController::class, 'delete']);

        // activity list
        Route::get('/activity_list', function () {
            return view('settings::pages.masters.activity');
        });
        Route::get('/activity/loadActivities', [ActivityController::class, 'loadActivities']);
        Route::delete('/activity/delete/{id}', [ActivityController::class, 'delete']);
        Route::get('/activity/view/{id}', [ActivityController::class, 'view']);

        // activity configure
        Route::get('/activity_configure', function () {
            return view('settings::pages.masters.activityConfigure');
        });
        Route::post('/activityConfigure/save', [ActivityController::class, 'save']);
        Route::post('/activityConfigure/update', [ActivityController::class, 'update']);
        Route::get('/activityConfigure/loadCompanies', [ActivityController::class, 'loadCompanies']);
        Route::get('/activityConfigure/loadActivity/{id}', [ActivityController::class, 'loadActivity']);

        // Process list
        Route::get('/Process_list', function () {
            return view('settings::pages.masters.process');
        });
        Route::get('/process/loadprocesses', [ProcessesController::class, 'loadprocesses']);
        Route::delete('/process/delete/{id}', [ProcessesController::class, 'delete']);
        Route::get('/process/view/{id}', [ProcessesController::class, 'view']);

        // Process configure
        Route::get('/Process_configure', function () {
            return view('settings::pages.masters.processConfigure');
        });
        Route::post('/processConfigure/save', [ProcessesController::class, 'save']);
        Route::post('/processConfigure/update', [ProcessesController::class, 'update']);
        Route::get('/processConfigure/loadCompany', [ProcessesController::class, 'loadCompany']);
        Route::get('/processConfigure/loadProcess/{id}', [ProcessesController::class, 'loadProcess']);

        // processActivity list
        Route::get('/processActivity_list', function () {
            return view('settings::pages.masters.processActivity');
        });
        Route::get('/processActivity/loadProcessActivities', [ProcessActivitiesController::class, 'loadProcessActivities']);
        Route::delete('/processActivity/delete/{id}', [ProcessActivitiesController::class, 'delete']);
        Route::get('/processActivity/view/{id}', [ProcessActivitiesController::class, 'view']);

        // processActivity configure
        Route::get('/processActivity_configure', function () {
            return view('settings::pages.masters.processActivityConfigure');
        });
        Route::post('/processActivityConfigure/save', [ProcessActivitiesController::class, 'save']);
        Route::post('/processActivityConfigure/update', [ProcessActivitiesController::class, 'update']);
        Route::get('/processActivityConfigure/loadProcessActivity/{id}', [ProcessActivitiesController::class, 'loadProcessActivity']);
        Route::get('/processActivityConfigure/loadActivities', [ProcessActivitiesController::class, 'loadActivities']);
        Route::get('/processActivityConfigure/loadProcesses', [ProcessActivitiesController::class, 'loadProcesses']);


        // workstations list
        Route::get('/workstation_list', function () {
            return view('settings::pages.masters.workstation');
        });
        Route::get('/workstation/loadWorkstations', [workstationsController::class, 'loadWorkstations']);
        Route::delete('/workstation/delete/{id}', [workstationsController::class, 'delete']);
        Route::get('/workstation/view/{id}', [workstationsController::class, 'view']);

        // workstations configure
        Route::get('/workstation_configure', function () {
            return view('settings::pages.masters.workstationConfigure');
        });
        Route::post('/workstationConfigure/save', [workstationsController::class, 'save']);
        Route::post('/workstationConfigure/update', [workstationsController::class, 'update']);
        Route::get('/workstationConfigure/loadWorkstation/{id}', [workstationsController::class, 'loadWorkstation']);
        Route::get('/workstationConfigure/loadDropDownData', [workstationsController::class, 'loadDropDownData']);

        // ProcessWorkstation list
        Route::get('/processWorkstation_list', function () {
            return view('settings::pages.masters.processWorkstation');
        });
        Route::get('/processWorkstation/loadProcessWorkstations', [ProcessWorkstationsController::class, 'loadProcessWorkstations']);
        Route::delete('/processWorkstation/delete/{id}', [ProcessWorkstationsController::class, 'delete']);
        Route::get('/processWorkstation/view/{id}', [ProcessWorkstationsController::class, 'view']);

        // ProcessWorkstation configure
        Route::get('/processWorkstation_configure', function () {
            return view('settings::pages.masters.processWorkstationConfigure');
        });
        Route::post('/processWorkstationConfigure/save', [ProcessWorkstationsController::class, 'save']);
        Route::post('/processWorkstationConfigure/update', [ProcessWorkstationsController::class, 'update']);
        Route::get('/processWorkstationConfigure/loadProcessWorkstation/{id}', [ProcessWorkstationsController::class, 'loadProcessWorkstation']);
        Route::get('/processWorkstationConfigure/loadProcesses', [ProcessWorkstationsController::class, 'loadProcesses']);
        Route::get('/processWorkstationConfigure/loadWorkstations', [ProcessWorkstationsController::class, 'loadWorkstations']);



        // processActivityEmployeeFilters list
        Route::get('/processActivityEmployeeFilters_list', function () {
            return view('settings::pages.masters.processActivityEmployeeFilters');
        });
        Route::get('/processActivityEmployeeFilters/loadProcessActivityEmployeeFilters', [ProcessActEmpFiltersController::class, 'loadProcessActivityEmployeeFilters']);
        Route::delete('/processActivityEmployeeFilters/delete/{id}', [ProcessActEmpFiltersController::class, 'delete']);
        Route::get('/processActivityEmployeeFilters/view/{id}', [ProcessActEmpFiltersController::class, 'view']);

        // supplierGroup configure
        Route::get('/processActivityEmployeeFilters_configure', function () {
            return view('settings::pages.masters.processActivityEmployeeFiltersConfigure');
        });
        Route::post('/processActivityEmployeeFiltersConfigure/save', [ProcessActEmpFiltersController::class, 'save']);
        Route::post('/processActivityEmployeeFiltersConfigure/update', [ProcessActEmpFiltersController::class, 'update']);
        Route::get('/processActivityEmployeeFiltersConfigure/loadProcessActivityEmployeeFilter/{id}', [ProcessActEmpFiltersController::class, 'loadProcessActivityEmployeeFilter']);
        Route::get('/processActivityEmployeeFiltersConfigure/loadActivities', [ProcessActEmpFiltersController::class, 'loadActivities']);
        Route::get('/processActivityEmployeeFiltersConfigure/loadEmployees', [ProcessActEmpFiltersController::class, 'loadEmployees']);
        Route::get('/processActivityEmployeeFiltersConfigure/loadCompanies', [ProcessActEmpFiltersController::class, 'loadCompanies']);


        // transportVehicleTypes list
        Route::get('/transportVehicleTypes_list', function () {
            return view('settings::pages.masters.transportVehicleTypes');
        });
        Route::get('/transportVehicleTypes/loadTransportVehicleTypes', [TransportVehicleTypesController::class, 'loadTransportVehicleTypes']);
        Route::delete('/transportVehicleTypes/delete/{id}', [TransportVehicleTypesController::class, 'delete']);
        Route::get('/transportVehicleTypes/view/{id}', [TransportVehicleTypesController::class, 'view']);

        // transportVehicleTypes configure
        Route::get('/transportVehicleTypes_configure', function () {
            return view('settings::pages.masters.transportVehicleTypesConfigure');
        });
        Route::post('/transportVehicleTypesConfigure/save', [TransportVehicleTypesController::class, 'save']);
        Route::post('/transportVehicleTypesConfigure/update', [TransportVehicleTypesController::class, 'update']);
        Route::get('/transportVehicleTypesConfigure/loadTransportVehicleType/{id}', [TransportVehicleTypesController::class, 'loadTransportVehicleType']);
        Route::get('/transportVehicleTypesConfigure/loadTransportMode', [TransportVehicleTypesController::class, 'loadTransportMode']);



        // namingSeries list
        Route::get('/namingSeries_list', function () {
            return view('settings::pages.masters.namingSeries');
        });
        Route::get('/namingSeries/loadNamingSerieses', [NamingSeriesController::class, 'loadNamingSerieses']);
        Route::delete('/namingSeries/delete/{id}', [NamingSeriesController::class, 'delete']);

        // namingSeries configure
        Route::get('/namingSeries_configure', function () {
            return view('settings::pages.masters.namingSeriesConfigure');
        });
        Route::post('/namingSeriesConfigure/save', [NamingSeriesController::class, 'save']);
        Route::post('/namingSeriesConfigure/update', [NamingSeriesController::class, 'update']);
        Route::get('/namingSeriesConfigure/loadNamingSeries/{id}', [NamingSeriesController::class, 'loadNamingSeries']);


        // barcodeTypes list
        Route::get('/barcodeTypes_list', function () {
            return view('settings::pages.masters.barcodeTypes');
        });
        Route::get('/barcodeTypes/loadBarcodeTypes', [BarcodeTypesController::class, 'loadBarcodeTypes']);
        Route::delete('/barcodeTypes/delete/{id}', [BarcodeTypesController::class, 'delete']);

        // barcodeTypes configure
        Route::get('/barcodeTypes_configure', function () {
            return view('settings::pages.masters.barcodeTypesConfigure');
        });
        Route::post('/barcodeTypesConfigure/save', [BarcodeTypesController::class, 'save']);
        Route::post('/barcodeTypesConfigure/update', [BarcodeTypesController::class, 'update']);
        Route::get('/barcodeTypesConfigure/loadBarcodeType/{id}', [BarcodeTypesController::class, 'loadBarcodeType']);


        // DataType list
        Route::get('/dataType_list', function () {
            return view('settings::pages.masters.dataType');
        });
        Route::get('/dataType/loadDataTypes', [DataTypeController::class, 'loadDataTypes']);
        Route::delete('/dataType/delete/{id}', [DataTypeController::class, 'delete']);

        // DataType configure
        Route::get('/dataType_configure', function () {
            return view('settings::pages.masters.dataTypeConfigure');
        });
        Route::post('/dataTypeConfigure/save', [DataTypeController::class, 'save']);
        Route::post('/dataTypeConfigure/update', [DataTypeController::class, 'update']);
        Route::get('/dataTypeConfigure/loadDataType/{id}', [DataTypeController::class, 'loadDataType']);

        // dataTypeFormats list
        Route::get('/dataTypeFormat_list', function () {
            return view('settings::pages.masters.dataTypeFormat');
        });
        Route::get('/dataTypeFormat/loadDataTypeFormats', [DataTypeFormatController::class, 'loadDataTypeFormats']);
        Route::delete('/dataTypeFormat/delete/{id}', [DataTypeFormatController::class, 'delete']);

        // dataTypeFormats configure
        Route::get('/dataTypeFormat_configure', function () {
            return view('settings::pages.masters.dataTypeFormatConfigure');
        });
        Route::post('/dataTypeFormatConfigure/save', [DataTypeFormatController::class, 'save']);
        Route::post('/dataTypeFormatConfigure/update', [DataTypeFormatController::class, 'update']);
        Route::get('/dataTypeFormatConfigure/loadDataTypeFormat/{id}', [DataTypeFormatController::class, 'loadDataTypeFormat']);
        Route::get('/dataTypeFormatConfigure/loadDataTypes', [DataTypeFormatController::class, 'loadDataTypes']);

        // Printer list
        Route::get('/printer_list', function () {
            return view('settings::pages.masters.printer');
        });
        Route::get('/printer/loadPrinters', [PrintersController::class, 'loadPrinters']);
        Route::delete('/printer/delete/{id}', [PrintersController::class, 'delete']);

        // Printer configure
        Route::get('/printer_configure', function () {
            return view('settings::pages.masters.printerConfigure');
        });
        Route::post('/printerConfigure/save', [PrintersController::class, 'save']);
        Route::post('/printerConfigure/update', [PrintersController::class, 'update']);
        Route::get('/printerConfigure/loadPrinter/{id}', [PrintersController::class, 'loadPrinter']);
        Route::get('/printerConfigure/loadWorkstations', [PrintersController::class, 'loadWorkstations']);


        // Report list
        Route::get('/report_list', function () {
            return view('settings::pages.masters.report');
        });
        Route::get('/report/loadReports', [ReportsController::class, 'loadReports']);
        Route::delete('/report/delete/{id}', [ReportsController::class, 'delete']);

        // Report configure
        Route::get('/report_configure', function () {
            return view('settings::pages.masters.reportConfigure');
        });
        Route::post('/reportConfigure/save', [ReportsController::class, 'save']);
        Route::post('/reportConfigure/update', [ReportsController::class, 'update']);
        Route::get('/reportConfigure/loadReport/{id}', [ReportsController::class, 'loadReport']);
        Route::get('/reportConfigure/loadCompany', [ReportsController::class, 'loadCompany']);


        // Term list
        Route::get('/term_list', function () {
            return view('settings::pages.masters.term');
        });
        Route::get('/term/loadTerms', [TermsController::class, 'loadTerms']);
        Route::delete('/term/delete/{id}', [TermsController::class, 'delete']);

        // Term configure
        Route::get('/term_configure', function () {
            return view('settings::pages.masters.termConfigure');
        });
        Route::post('/termConfigure/save', [TermsController::class, 'save']);
        Route::post('/termConfigure/update', [TermsController::class, 'update']);
        Route::get('/termConfigure/loadTerm/{id}', [TermsController::class, 'loadTerm']);

        //Application Log
        Route::get('/querylog', function () {
            return view('settings::pages.Logs.querylog');
        });

        Route::get('/clear-query-log', function () {
            File::put(storage_path('logs/query.log'), '');
            return redirect()->back();
        })->name('clearQueryLog');

        Route::get('/clear-app-log', function () {
            File::put(storage_path('logs/laravel.log'), '');
            return redirect()->back();
        })->name('clearAppLog');

        Route::get('/clear-api-log', function () {
            File::put(storage_path('logs/api.log'), '');
            return redirect()->back();
        })->name('clearAPILog');


    });
    Route::get('/load-query-log', function () {
        return file_get_contents(storage_path('logs/query.log'));
    })->name('loadQueryLog');


     // vehicle list
     Route::get('/vehicle_list', function () {
        return view('settings::pages.masters.vehicle');
    });
    Route::get('/vehicle/loadVehicles', [vehicleyController::class, 'loadVehicles']);
    Route::delete('/vehicle/delete/{id}', [vehicleyController::class, 'delete']);
    Route::get('/vehicle/view/{id}', [vehicleyController::class, 'view']);

    // vehicle configure
    Route::get('/vehicle_configure', function () {
        return view('settings::pages.masters.vehicleConfigure');
    });
    Route::post('/vehicleConfigure/save', [vehicleyController::class, 'save']);
    Route::post('/vehicleConfigure/update', [vehicleyController::class, 'update']);
    Route::get('/vehicleConfigure/loadVehicle/{id}', [vehicleyController::class, 'loadVehicle']);
    Route::get('/vehicleConfigure/loadDropdownData', [vehicleyController::class, 'loadDropdownData']);

      // driver list
      Route::get('/driver_list', function () {
        return view('settings::pages.masters.driver');
    });
    Route::get('/driver/loadDrivers', [driverController::class, 'loadDrivers']);
    Route::delete('/driver/delete/{id}', [driverController::class, 'delete']);

    // driver configure
    Route::get('/driver_configure', function () {
        return view('settings::pages.masters.driverConfigure');
    });
    Route::post('/driverConfigure/save', [driverController::class, 'save']);
    Route::post('/driverConfigure/update', [vehicdriverControllerleyController::class, 'update']);
    Route::get('/driverConfigure/loadDriver/{id}', [driverController::class, 'loadDriver']);
    Route::get('/driverConfigure/loadDropdownData', [driverController::class, 'loadDropdownData']);

});
