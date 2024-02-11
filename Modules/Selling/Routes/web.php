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
use Modules\Selling\Http\Controllers\Masters\CustomerGroupMasterController;
use Modules\Selling\Http\Controllers\Masters\CustomerMasterconfigureController;
use Modules\Selling\Http\Controllers\Masters\CustomerOrderController;
use Modules\Selling\Http\Controllers\Masters\NotifyPartyConfigureController;
use Modules\Selling\Http\Controllers\Masters\SellingdashboardController;
use Modules\Selling\Http\Controllers\Masters\SalesInvoicesReportsController;
use Modules\Selling\Http\Controllers\SalesInvoiceController;

Route::prefix('selling')->group(function () {
    Route::group(['middleware' => ['is.logged']], function () { //logged users route group


        // customerGroup list
        Route::get('/customerGroupMaster_list', function () {
            return view('selling::pages.masters.customerGroupMaster');
        });
        Route::get('/customerGroupMaster/loadcustomerGroups', [CustomerGroupMasterController::class, 'loadcustomerGroups']);
        Route::delete('/customerGroupMaster/delete/{id}', [CustomerGroupMasterController::class, 'delete']);

        // customerGroup configure
        Route::get('/customerGroupMaster_configure', function () {
            return view('selling::pages.masters.customerGroupMasterConfigure');
        });
        Route::post('/customerGroupMasterConfigure/save', [CustomerGroupMasterController::class, 'save']);
        Route::post('/customerGroupMasterConfigure/update', [CustomerGroupMasterController::class, 'update']);
        Route::get('/customerGroupMasterConfigure/loadcustomerGroupMaster/{id}', [CustomerGroupMasterController::class, 'loadcustomerGroupMaster']);
        Route::get('/customerGroupMasterConfigure/loadParentGroups', [CustomerGroupMasterController::class, 'loadParentGroups']);

        //customer Master
        Route::get('/customer_master', function () {
            return view('selling::pages.masters.customerMaster');
        });
        Route::get('/customerMaster/loadCustomers', [CustomerMasterconfigureController::class, 'loadCustomers']);
        Route::delete('/customerMaster/delete/{id}', [CustomerMasterconfigureController::class, 'delete']);
        // Route::get('/catchAreaMaster/view/{id}', [CustomerMasterconfigureController::class, 'view']);



        // customer configure
        Route::get('/customer_configure', function () {
            return view('selling::pages.masters.customerMasterconfigure');
        });
        Route::post('/customerMasterconfigure/save', [CustomerMasterconfigureController::class, 'save']);
        Route::post('/customerMasterconfigure/update', [CustomerMasterconfigureController::class, 'update']);
        Route::get('/customerMasterconfigure/loadCustomerTypes', [CustomerMasterconfigureController::class, 'loadCustomerTypes']);
        Route::get('/customerMasterconfigure/loadCustomerGroups', [CustomerMasterconfigureController::class, 'loadCustomerGroups']);
        Route::get('/customerMasterconfigure/loadCountries', [CustomerMasterconfigureController::class, 'loadCountries']);
        Route::get('/customerMasterconfigure/loadCurrency', [CustomerMasterconfigureController::class, 'loadCurrency']);
        Route::get('/customerMasterconfigure/loadPriceList', [CustomerMasterconfigureController::class, 'loadPriceList']);
        Route::get('/customerMasterconfigure/loadLanguage', [CustomerMasterconfigureController::class, 'loadLanguage']);
        Route::get('/customerMasterconfigure/loadContactPerson/{cusId}', [CustomerMasterconfigureController::class, 'loadContactPerson']);
        Route::get('/customerMasterconfigure/loadContactAddress/{cusId}', [CustomerMasterconfigureController::class, 'loadContactAddress']);
        Route::get('/customerMasterconfigure/loadCustomer/{id}', [CustomerMasterconfigureController::class, 'loadCustomer']);
        Route::get('/customerMasterconfigure/loadCustomerAddress/{id}', [CustomerMasterconfigureController::class, 'loadCustomerAddress']);
        Route::get('/customerMasterconfigure/loadCustomerContact/{id}', [CustomerMasterconfigureController::class, 'loadCustomerContact']);
        Route::get('/customerMasterconfigure/SetSessionAndReturnUrl/{id}', [CustomerMasterconfigureController::class, 'SetSessionAndReturnUrl']);
        Route::get('/customerMasterconfigure/loadCustomerNotify/{id}', [CustomerMasterconfigureController::class, 'loadCustomerNotify']);
        Route::get('/customerMasterconfigure/loadAddress', [CustomerMasterconfigureController::class, 'loadAddress']);
        Route::get('/customerMasterconfigure/loadNotify', [CustomerMasterconfigureController::class, 'loadNotify']);
        Route::get('/customerMasterconfigure/loadContacts', [CustomerMasterconfigureController::class, 'loadContacts']);
        Route::post('/customerMasterconfigure/link', [CustomerMasterconfigureController::class, 'link']);


        // customerOrder list
        Route::get('/customerOrder_list', function () {
            return view('selling::pages.masters.customerOrder');
        });
        Route::get('/customerOrder/loadCustomerOrders', [CustomerOrderController::class, 'loadCustomerOrders']);
        Route::delete('/customerOrder/delete/{id}', [CustomerOrderController::class, 'delete']);

        // customerOrder configure
        Route::get('/customerOrder_configure', function () {
            return view('selling::pages.masters.customerOrderConfigure');
        });
        Route::post('/customerOrderConfigure/save', [CustomerOrderController::class, 'save']);
        Route::post('/customerOrderConfigure/update', [CustomerOrderController::class, 'update']);
        Route::get('/customerOrderConfigure/getOrderNumber', [CustomerOrderController::class, 'getOrderNumber']);
        Route::get('/customerOrderConfigure/loadCustomerOrder/{id}', [CustomerOrderController::class, 'loadCustomerOrder']);
        Route::get('/customerOrderConfigure/loadNotifyParties/{cusID}', [CustomerOrderController::class, 'loadNotifyParties']);
        Route::get('/customerOrderConfigure/loadCustomers', [CustomerOrderController::class, 'loadCustomers']);
        Route::get('/customerOrderConfigure/loadItems/{cusID}', [CustomerOrderController::class, 'loadItems']);
        Route::get('/customerOrderConfigure/loadCustomerBillingAddresses/{CusId}', [CustomerOrderController::class, 'loadCustomerBillingAddresses']);
        Route::get('/customerOrderConfigure/loadCustomerShippingAddresses/{CusId}', [CustomerOrderController::class, 'loadCustomerShippingAddresses']);
        Route::get('/customerOrderConfigure/loadAddress/{AddressId}', [CustomerOrderController::class, 'loadAddress']);
        Route::get('/customerOrderConfigure/getItemDetails/{itemId}', [CustomerOrderController::class, 'getItemDetails']);
        Route::post('/customerOrderConfigure/getInnerSummary', [CustomerOrderController::class, 'getInnerSummary']);
        Route::get('/customerOrderConfigure/setOrderStatus/{state}/{id}', [CustomerOrderController::class, 'setOrderStatus']);
        Route::get('/customerOrderConfigure/CheckCustomerType/{CusId}', [CustomerOrderController::class, 'CheckCustomerType']);

        Route::get('/customerOrderConfigure/loadPreviousCustomerOrders/{cusID}', [CustomerOrderController::class, 'loadCustomersPreviousOrders']);
        Route::get('/customerOrderConfigure/loadPreviousOrderDetails/{orderId}', [CustomerOrderController::class, 'loadPreviousOrderDetails']);
        Route::post('/customerOrderConfigure/CreateChangeRequest', [CustomerOrderController::class, 'CreateChangeRequest']);
        Route::post('/customerOrderConfigure/loadChangeRequestsToItem', [CustomerOrderController::class, 'loadChangeRequestsToItem']);



        // Notify Party List6
        Route::get('/notifyparty_list', function () {
            return view('selling::pages.masters.notifyparty');
        });
        Route::get('/notifyparty/loadAddresses', [NotifyPartyConfigureController::class, 'loadAddresses']);
        Route::delete('/notifyparty/delete/{id}', [NotifyPartyConfigureController::class, 'delete']);

        // Notify Party Configure
        Route::get('/notifyparty_configure', function () {
            return view('selling::pages.masters.notifypartyConfigure');
        });
        Route::post('/notifypartyConfigure/save', [NotifyPartyConfigureController::class, 'save']);
        Route::post('/notifypartyConfigure/update', [NotifyPartyConfigureController::class, 'update']);
        Route::get('/notifypartyConfigure/loadCountries', [NotifyPartyConfigureController::class, 'loadCountries']);
        Route::get('/notifypartyConfigure/loadAddressType', [NotifyPartyConfigureController::class, 'loadAddressType']);
        Route::get('/notifypartyConfigure/loadAddress/{id}', [NotifyPartyConfigureController::class, 'loadAddress']);

        // Dashboard
        Route::get('/', function () {
            return view('selling::pages.masters.dashboardSelling');
        });
        Route::get('/dashboardSelling/loadChangeRequests', [SellingdashboardController::class, 'loadChangeRequests']);
        Route::get('/dashboardSelling/loadApproveModel/{reqId}', [SellingdashboardController::class, 'loadApproveModel']);
        Route::post('/dashboardSelling/changeRequestAction', [SellingdashboardController::class, 'changeRequestAction']);
        Route::get('/dashboardSelling/loadChangeRequestRequirements/{orderNum}/{itemId}/{notify}', [SellingdashboardController::class, 'loadChangeRequestRequirements']);

        // Sales Invoice List
        Route::get('/salesinvoice_list', function () {
            return view('selling::pages.masters.salesInvoice');
        });
        Route::get('/salesInvoice/loadInvoices', [SalesInvoiceController::class, 'loadInvoices']);
        Route::delete('/salesInvoice/delete/{id}', [SalesInvoiceController::class, 'delete']);


        // Sales Invoice Configure
        Route::get('/salesinvoice_configure', function () {
            return view('selling::pages.masters.salesInvoiceConfigure');
        });
        Route::get('/salesInvoiceConfigure/loadCurrency', [SalesInvoiceController::class, 'loadCurrency']);
        Route::get('/salesInvoiceConfigure/loadShippingTerms', [SalesInvoiceController::class, 'loadShippingTerms']);
        Route::get('/salesInvoiceConfigure/loadPls', [SalesInvoiceController::class, 'loadPls']);
        Route::get('/salesInvoiceConfigure/loadExplDetails/{id}', [SalesInvoiceController::class, 'loadExplDetails']);
        Route::get('/salesInvoiceConfigure/AddPl/{ExpPlId}', [SalesInvoiceController::class, 'AddPl']);
        Route::get('/salesInvoiceConfigure/loadPaymentTerms', [SalesInvoiceController::class, 'loadPaymentTerms']);
        Route::get('/salesInvoiceConfigure/loadBaseCurrency/{currencyId}', [SalesInvoiceController::class, 'loadBaseCurrency']);
        Route::get('/salesInvoiceConfigure/loadBankAccount', [SalesInvoiceController::class, 'loadBankAccount']);
        Route::get('/salesInvoiceConfigure/loadBankAccountDetails/{AccountId}', [SalesInvoiceController::class, 'loadBankAccountDetails']);
        Route::get('/salesInvoiceConfigure/loadBank', [SalesInvoiceController::class, 'loadBank']);
        Route::post('/salesInvoiceConfigure/save', [SalesInvoiceController::class, 'save']);
        Route::get('/salesInvoiceConfigure/loadInvoice/{id}', [SalesInvoiceController::class, 'loadInvoice']);
        Route::post('/salesInvoiceConfigure/update', [SalesInvoiceController::class, 'update']);

        // Sales Invoice Reports
        Route::get('/salesInvoiceConfigure/getReport/{reportType}/{InvId}', [SalesInvoicesReportsController::class, 'getReport']);
    });
});
