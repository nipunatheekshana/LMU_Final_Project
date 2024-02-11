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
use Modules\Accounting\Http\Controllers\Masters\BankAccountsController;
use Modules\Accounting\Http\Controllers\Masters\BankAccountTypesController;
use Modules\Accounting\Http\Controllers\Masters\BankController;
use Modules\Accounting\Http\Controllers\Masters\ItemPriceController;
use Modules\Accounting\Http\Controllers\Masters\PriceListController;
use Modules\Accounting\Http\Controllers\Masters\ExchangeRateController;

Route::prefix('accounting')->group(function () {
    Route::group(['middleware' => ['is.logged']], function () { //logged users route group

        // PriceList list
        Route::get('/priceList_list', function () {
            return view('accounting::pages.masters.priceList');
        });
        Route::get('/priceList/loadPriceLists', [PriceListController::class, 'loadPriceLists']);
        Route::delete('/priceList/delete/{id}', [PriceListController::class, 'delete']);

        // PriceList configure
        Route::get('/priceList_configure', function () {
            return view('accounting::pages.masters.priceListConfigure');
        });
        Route::post('/priceListConfigure/save', [PriceListController::class, 'save']);
        Route::post('/priceListConfigure/update', [PriceListController::class, 'update']);
        Route::get('/priceListConfigure/loadPriceList/{id}', [PriceListController::class, 'loadPriceList']);
        Route::get('/priceListConfigure/loadCompanies', [PriceListController::class, 'loadCompanies']);
        Route::get('/priceListConfigure/loadCurrencies', [PriceListController::class, 'loadCurrencies']);

        // itemPrice list
        Route::get('/itemPrice_list', function () {
            return view('accounting::pages.masters.itemPrice');
        });
        Route::get('/itemPrice/loadItemPrices', [ItemPriceController::class, 'loadItemPrices']);
        Route::delete('/itemPrice/delete/{id}', [ItemPriceController::class, 'delete']);

        // itemPrice configure
        Route::get('/itemPrice_configure', function () {
            return view('accounting::pages.masters.itemPriceConfigure');
        });
        Route::post('/itemPriceConfigure/save', [ItemPriceController::class, 'save']);
        Route::post('/itemPriceConfigure/update', [ItemPriceController::class, 'update']);
        Route::get('/itemPriceConfigure/loadItemPrice/{id}', [ItemPriceController::class, 'loadItemPrice']);
        Route::get('/itemPriceConfigure/loadItems', [ItemPriceController::class, 'loadItems']);
        Route::get('/itemPriceConfigure/loadPriceLists', [ItemPriceController::class, 'loadPriceLists']);
        Route::get('/itemPriceConfigure/loadUOMs', [ItemPriceController::class, 'loadUOMs']);
        Route::get('/itemPriceConfigure/loadPriceList/{id}', [ItemPriceController::class, 'loadPriceList']);

        // Bank list
        Route::get('/bank_list', function () {
            return view('accounting::pages.masters.bank');
        });
        Route::get('/bank/loadBanks', [BankController::class, 'loadBanks']);
        Route::delete('/bank/delete/{id}', [BankController::class, 'delete']);

        // Bank configure
        Route::get('/bank_configure', function () {
            return view('accounting::pages.masters.bankConfigure');
        });
        Route::post('/bankConfigure/save', [BankController::class, 'save']);
        Route::post('/bankConfigure/update', [BankController::class, 'update']);
        Route::get('/bankConfigure/loadBank/{id}', [BankController::class, 'loadBank']);

        // bankAccountType list
        Route::get('/bankAccountType_list', function () {
            return view('accounting::pages.masters.bankAccountType');
        });
        Route::get('/bankAccountType/loadBankAccountTypes', [BankAccountTypesController::class, 'loadBankAccountTypes']);
        Route::delete('/bankAccountType/delete/{id}', [BankAccountTypesController::class, 'delete']);

        // bankAccountType configure
        Route::get('/bankAccountType_configure', function () {
            return view('accounting::pages.masters.bankAccountTypeConfigure');
        });
        Route::post('/bankAccountTypeConfigure/save', [BankAccountTypesController::class, 'save']);
        Route::post('/bankAccountTypeConfigure/update', [BankAccountTypesController::class, 'update']);
        Route::get('/bankAccountTypeConfigure/loadBankAccountType/{id}', [BankAccountTypesController::class, 'loadBankAccountType']);



        // BankAccounts list
        Route::get('/bankAccount_list', function () {
            return view('accounting::pages.masters.bankAccount');
        });
        Route::get('/bankAccount/loadBankAccounts', [BankAccountsController::class, 'loadBankAccounts']);
        Route::delete('/bankAccount/delete/{id}', [BankAccountsController::class, 'delete']);

        // BankAccounts configure
        Route::get('/bankAccount_configure', function () {
            return view('accounting::pages.masters.bankAccountConfigure');
        });
        Route::post('/bankAccountConfigure/save', [BankAccountsController::class, 'save']);
        Route::post('/bankAccountConfigure/update', [BankAccountsController::class, 'update']);
        Route::get('/bankAccountConfigure/loadBankAccount/{id}', [BankAccountsController::class, 'loadBankAccount']);
        Route::get('/bankAccountConfigure/loadDropDownData', [BankAccountsController::class, 'loadDropDownData']);


        // Exchange Rate list
        Route::get('/exchange_rate_list', function () {
            return view('accounting::pages.masters.exchangeRate');
        });
        Route::get('/exchangeRate/loadExchangeRates', [ExchangeRateController::class, 'loadExchangeRates']);
        Route::delete('/exchangeRate/delete/{id}', [ExchangeRateController::class, 'delete']);




        // Exchange Rate Configure
        Route::get('/exchange_rate_configure', function () {
            return view('accounting::pages.masters.exchangeRateConfigure');
        });
        Route::post('/exchangeRateConfigure/save', [ExchangeRateController::class, 'save']);
        Route::post('/exchangeRateConfigure/update', [ExchangeRateController::class, 'update']);
        Route::get('/exchangeRateConfigure/loadExchangeRate/{id}', [ExchangeRateController::class, 'loadExchangeRate']);
        Route::get('/exchangeRateConfigure/loadCompanies', [ExchangeRateController::class, 'loadCompanies']);
        Route::get('/exchangeRateConfigure/loadAccountTypes', [ExchangeRateController::class, 'loadAccountTypes']);
        Route::get('/exchangeRateConfigure/LoadBank', [ExchangeRateController::class, 'LoadBank']);
        Route::get('/exchangeRateConfigure/LoadCurrency', [ExchangeRateController::class, 'LoadCurrency']);
    });
});
