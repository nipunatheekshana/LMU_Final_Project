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
use Modules\CRM\Http\Controllers\Masters\AddressConfigureController;
use Modules\CRM\Http\Controllers\Masters\contactConfigureController;

Route::prefix('crm')->group(function () {
    Route::group(['middleware' => ['is.logged']], function () { //logged users route group


        // address list
        Route::get('/address_list', function () {
            return view('crm::pages.masters.addres');
        });
        Route::get('/addres/loadAddresses', [AddressConfigureController::class, 'loadAddresses']);
        Route::delete('/addres/delete/{id}', [AddressConfigureController::class, 'delete']);
        Route::get('/catchAreaMaster/view/{id}', [AddressConfigureController::class, 'view']);



        // addres configure
        Route::get('/addres_configure', function () {
            return view('crm::pages.masters.addresConfigure');
        });
        Route::post('/addressConfigure/save', [AddressConfigureController::class, 'save']);
        Route::post('/addressConfigure/update', [AddressConfigureController::class, 'update']);
        Route::get('/addressConfigure/loadCountries', [AddressConfigureController::class, 'loadCountries']);
        Route::get('/addressConfigure/loadAddressType', [AddressConfigureController::class, 'loadAddressType']);
        Route::get('/addressConfigure/loadAddress/{id}', [AddressConfigureController::class, 'loadAddress']);

        // contact list
        Route::get('/contact_list', function () {
            return view('crm::pages.masters.contact');
        });
        Route::get('/contact/loadcontacts', [contactConfigureController::class, 'loadcontacts']);
        Route::delete('/contact/delete/{id}', [contactConfigureController::class, 'delete']);
        Route::get('/contact/view/{id}', [contactConfigureController::class, 'view']);

        // contact configure
        Route::get('/contact_configure', function () {
            return view('crm::pages.masters.contactConfigure');
        });
        Route::post('/contactConfigure/save', [contactConfigureController::class, 'save']);
        Route::post('/contactConfigure/update', [contactConfigureController::class, 'update']);
        Route::get('/contactConfigure/loadSaluation', [contactConfigureController::class, 'loadSaluation']);
        Route::get('/contactConfigure/loadGender', [contactConfigureController::class, 'loadGender']);

        Route::get('/contactConfigure/loadcontact/{id}', [contactConfigureController::class, 'loadcontact']);
    });
});
