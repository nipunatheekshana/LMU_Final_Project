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
use Modules\HRM\Http\Controllers\DepartmentController;
use Modules\HRM\Http\Controllers\Masters\DesignationsController;
use Modules\HRM\Http\Controllers\Masters\EmployeesController;

Route::prefix('hrm')->group(function() {
    Route::group(['middleware' => ['is.logged']], function () { //logged users route group

        // designation list
        Route::get('/designation_list', function () {
            return view('hrm::pages.masters.designation');
        });
        Route::get('/designation/loadDesignations', [DesignationsController::class, 'loadDesignations']);
        Route::delete('/designation/delete/{id}', [DesignationsController::class, 'delete']);
        Route::get('/designation/view/{id}', [DesignationsController::class, 'view']);

        // designation configure
        Route::get('/designation_configure', function () {
            return view('hrm::pages.masters.designationConfigure');
        });
        Route::post('/designationConfigure/save', [DesignationsController::class, 'save']);
        Route::post('/designationConfigure/update', [DesignationsController::class, 'update']);
        Route::get('/designationConfigure/loadDesignation/{id}', [DesignationsController::class, 'loadDesignation']);

         // employee list
         Route::get('/employee_list', function () {
            return view('hrm::pages.masters.employee');
        });
        Route::get('/employee/loadEmployees', [EmployeesController::class, 'loadEmployees']);
        Route::delete('/employee/delete/{id}', [EmployeesController::class, 'delete']);
        Route::get('/employee/view/{id}', [EmployeesController::class, 'view']);

        // employee configure
        Route::get('/employee_configure', function () {
            return view('hrm::pages.masters.employeeConfigure');
        });
        Route::post('/employeeConfigure/save', [EmployeesController::class, 'save']);
        Route::post('/employeeConfigure/update', [EmployeesController::class, 'update']);
        Route::get('/employeeConfigure/loadEmployee/{id}', [EmployeesController::class, 'loadEmployee']);
        Route::get('/employeeConfigure/loadSalutaions', [EmployeesController::class, 'loadSalutaions']);
        Route::get('/employeeConfigure/loadGenders', [EmployeesController::class, 'loadGenders']);
        Route::get('/employeeConfigure/loadCompanies', [EmployeesController::class, 'loadCompanies']);
        Route::get('/employeeConfigure/loadDesignations', [EmployeesController::class, 'loadDesignations']);
        Route::get('/employeeConfigure/loadDepartments', [EmployeesController::class, 'loadDepartments']);
        Route::get('/employeeConfigure/loadStatus', [EmployeesController::class, 'loadStatus']);

         // Department list
         Route::get('/departments_list', function () {
            return view('hrm::pages.masters.departments');
        });
        Route::get('/departments/loadDepartments', [DepartmentController::class, 'loadDepartments']);
        Route::delete('/departments/delete/{id}', [DepartmentController::class, 'delete']);

        // Department configure
        Route::get('/departments_configure', function () {
            return view('hrm::pages.masters.departmentsConfigure');
        });
        Route::post('/departmentsConfigure/save', [DepartmentController::class, 'save']);
        Route::post('/departmentsConfigure/update', [DepartmentController::class, 'update']);
        Route::get('/departmentsConfigure/loadDepartment/{id}', [DepartmentController::class, 'loadDepartment']);
        Route::get('/departmentsConfigure/loadParentDepartments', [DepartmentController::class, 'loadParentDepartments']);

    });


});
