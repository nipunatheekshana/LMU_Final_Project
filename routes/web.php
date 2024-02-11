<?php

use App\Http\Controllers\activityLogController;
use App\Http\Controllers\LogInController;
use App\Http\Controllers\MISL_level\createMislUsersController;
use App\Http\Controllers\MISL_level\createParentCompanyUserController;
use App\Http\Controllers\MISL_level\editParentCompanyController;
use App\Http\Controllers\StorageFileControlle;
use App\Http\Controllers\UserCustomizeController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('pages.login');
});

//login
Route::post('/login', [LogInController::class, 'login']);

//logout
Route::get('/logout', [LogInController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['is.logged']], function () { //logged users route group

    //misl user dashboard
    Route::get('/dashbord-Misl', function () {
        return view('pages.MISL_level.dashboard');
    });


    //editParentCompany
    Route::get('/edit_parent-company', function () {
        return view('pages.MISL_level.editParentCompany');
    });
    Route::get('/editParentCompany/loadMotherCompanyData', [editParentCompanyController::class, 'loadMotherCompanyData']);
    Route::post('/editParentCompany/save', [editParentCompanyController::class, 'save']);

    // createMislUsers
    Route::get('/create_Misl-Users', function () {
        return view('pages.MISL_level.createMislUsers');
    });
    Route::post('/createMislUsers/save', [createMislUsersController::class, 'save']);
    Route::post('/createMislUsers/update', [createMislUsersController::class, 'update']);
    Route::get('/createMislUsers/loadUsers', [createMislUsersController::class, 'loadUsers']);
    Route::get('/createMislUsers/loadUser/{id}', [createMislUsersController::class, 'loadUser']);
    Route::delete('/createMislUsers/delete/{id}', [createMislUsersController::class, 'delete']);

    // createParentCompanyUser
    Route::get('/createParentCompanyUser', function () {
        return view('pages.MISL_level.createParentCompanyUser');
    });
    Route::post('/createParentCompanyUser/save', [createParentCompanyUserController::class, 'save']);
    Route::post('/createParentCompanyUser/update', [createParentCompanyUserController::class, 'update']);
    Route::get('/createParentCompanyUser/loadUsers', [createParentCompanyUserController::class, 'loadUsers']);
    Route::get('/createParentCompanyUser/loadUser/{id}', [createParentCompanyUserController::class, 'loadUser']);
    Route::delete('/createParentCompanyUser/delete/{id}', [createParentCompanyUserController::class, 'delete']);

    // Parent User dashboard
    Route::get('/dashbord-Parent', function () {
        return view('pages.Admin_level.dashboard');
    });



    // company dashboard
    Route::get('/main_panel-Child', function () {
        return view('pages.Company_level.mainPanel');
    });


    // loadActivityLog
    Route::get('/loadActivityLog', [activityLogController::class, 'loadActivityLog']);


    //get Storage Files
    Route::get('/storage/{filename}', [StorageFileControlle::class, 'returnImage']);

    //theamSettings
    Route::post('/SaveTheme', [UserCustomizeController::class, 'SaveTheme']);

});
