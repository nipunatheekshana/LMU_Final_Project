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
use Modules\Inventory\Http\Controllers\Masters\BrandsController;
use Modules\Inventory\Http\Controllers\Masters\DeliveryTripController;
use Modules\Inventory\Http\Controllers\Masters\HsCodesController;
use Modules\Inventory\Http\Controllers\Masters\ItemAlternativeController;
use Modules\Inventory\Http\Controllers\Masters\ItemController;
use Modules\Inventory\Http\Controllers\Masters\ManufacturersController;
use Modules\Inventory\Http\Controllers\Masters\UOMController;
use Modules\Inventory\Http\Controllers\Masters\UOMConversionFactorsController;
use Modules\Inventory\Http\Controllers\Masters\warehouseController;
use Modules\Inventory\Http\Controllers\Masters\warehouseTypeController;
use Modules\Quality\Http\Controllers\Masters\QualityCheckParamatersController;

Route::prefix('inventory')->group(function () {
    Route::group(['middleware' => ['is.logged']], function () { //logged users route group

        // productGroups list
        Route::get('/productGroups_list', function () {
            return view('inventory::pages.masters.productGroups');
        });
        Route::get('/qualityCheckParameter/loadqualityCheckParameters', [QualityCheckParamatersController::class, 'loadqualityCheckParameters']);

        // uom list
        Route::get('/uom_list', function () {
            return view('inventory::pages.masters.uom');
        });
        Route::get('/uom/loadUOMs', [UOMController::class, 'loadUOMs']);
        Route::delete('/uom/delete/{id}', [UOMController::class, 'delete']);
        Route::get('/uom/view/{id}', [UOMController::class, 'view']);

        // uom configure
        Route::get('/uom_configure', function () {
            return view('inventory::pages.masters.uomConfigure');
        });
        Route::post('/uomConfigure/save', [UOMController::class, 'save']);
        Route::post('/uomConfigure/update', [UOMController::class, 'update']);
        Route::get('/uomConfigure/loadUOM/{id}', [UOMController::class, 'loadUOM']);

        // hsCode list
        Route::get('/hsCode_list', function () {
            return view('inventory::pages.masters.hsCode');
        });
        Route::get('/hsCode/loadHsCodes', [HsCodesController::class, 'loadHsCodes']);
        Route::delete('/hsCode/delete/{id}', [HsCodesController::class, 'delete']);
        Route::get('/hsCode/view/{id}', [HsCodesController::class, 'view']);

        // hsCode configure
        Route::get('/hsCode_configure', function () {
            return view('inventory::pages.masters.hsCodeConfigure');
        });
        Route::post('/hsCodeConfigure/save', [HsCodesController::class, 'save']);
        Route::post('/hsCodeConfigure/update', [HsCodesController::class, 'update']);
        Route::get('/hsCodeConfigure/loadHsCode/{id}', [HsCodesController::class, 'loadHsCode']);
        Route::get('/hsCodeConfigure/LoadCountries', [HsCodesController::class, 'LoadCountries']);


        // manufacturer list
        Route::get('/manufacturer_list', function () {
            return view('inventory::pages.masters.manufacturer');
        });
        Route::get('/manufacturer/loadManufacturers', [ManufacturersController::class, 'loadManufacturers']);
        Route::delete('/manufacturer/delete/{id}', [ManufacturersController::class, 'delete']);

        // manufacturer configure
        Route::get('/manufacturer_configure', function () {
            return view('inventory::pages.masters.manufacturerConfigure');
        });
        Route::post('/manufacturerConfigure/save', [ManufacturersController::class, 'save']);
        Route::post('/manufacturerConfigure/update', [ManufacturersController::class, 'update']);
        Route::get('/manufacturerConfigure/loadManufacturer/{id}', [ManufacturersController::class, 'loadManufacturer']);
        Route::get('/manufacturerConfigure/loadCountries', [ManufacturersController::class, 'loadCountries']);

        // Brand list
        Route::get('/brand_list', function () {
            return view('inventory::pages.masters.brand');
        });
        Route::get('/brand/loadBrands', [BrandsController::class, 'loadBrands']);
        Route::delete('/brand/delete/{id}', [BrandsController::class, 'delete']);

        // Brand configure
        Route::get('/brand_configure', function () {
            return view('inventory::pages.masters.brandConfigure');
        });
        Route::post('/brandConfigure/save', [BrandsController::class, 'save']);
        Route::post('/brandConfigure/update', [BrandsController::class, 'update']);
        Route::get('/brandConfigure/loadBrand/{id}', [BrandsController::class, 'loadBrand']);

        // inventory list
        Route::get('/Item_list', function () {
            return view('inventory::pages.masters.item');
        });
        Route::get('/Item/loadItems', [ItemController::class, 'loadItems']);
        Route::delete('/Item/delete/{id}', [ItemController::class, 'delete']);

        // inventory configure
        Route::get('/Item_configure', function () {
            return view('inventory::pages.masters.itemConfigure');
        });
        Route::post('/ItemConfigure/save', [ItemController::class, 'save']);
        Route::post('/ItemConfigure/update', [ItemController::class, 'update']);
        Route::get('/ItemConfigure/loadItem/{id}', [ItemController::class, 'loadItem']);
        Route::post('/ItemConfigure/saveBarcode', [ItemController::class, 'saveBarcode']);
        Route::get('/ItemConfigure/loadBarcodes/{id}', [ItemController::class, 'loadBarcodes']);
        Route::delete('/ItemConfigure/deleteBarcode/{id}', [ItemController::class, 'deleteBarcode']);
        Route::post('/ItemConfigure/saveSupplier', [ItemController::class, 'saveSupplier']);
        Route::get('/ItemConfigure/loadSuppliersTable/{id}', [ItemController::class, 'loadSuppliersTable']);
        Route::delete('/ItemConfigure/deleteSupplier/{id}', [ItemController::class, 'deleteSupplier']);
        Route::post('/ItemConfigure/saveManufacturer', [ItemController::class, 'saveManufacturer']);
        Route::get('/ItemConfigure/loadManufacturerTable/{id}', [ItemController::class, 'loadManufacturerTable']);
        Route::delete('/ItemConfigure/deleteManufacturer/{id}', [ItemController::class, 'deleteManufacturer']);

        Route::get('/ItemConfigure/loadCompanies', [ItemController::class, 'loadCompanies']);
        Route::get('/ItemConfigure/loadItemGroup', [ItemController::class, 'loadItemGroup']);
        Route::get('/ItemConfigure/loadBrand', [ItemController::class, 'loadBrand']);
        Route::get('/ItemConfigure/loadAssetCatagories', [ItemController::class, 'loadAssetCatagories']);
        Route::get('/ItemConfigure/loadUOM', [ItemController::class, 'loadUOM']);
        Route::get('/ItemConfigure/loadDefaultBuyingPriceList', [ItemController::class, 'loadDefaultBuyingPriceList']);
        Route::get('/ItemConfigure/loadDefaultsellingPriceList', [ItemController::class, 'loadDefaultsellingPriceList']);
        Route::get('/ItemConfigure/loadDefaultManufacture', [ItemController::class, 'loadDefaultManufacture']);
        Route::get('/ItemConfigure/loadHS_code', [ItemController::class, 'loadHS_code']);
        Route::get('/ItemConfigure/loadCurrentItems', [ItemController::class, 'loadCurrentItems']);
        Route::get('/ItemConfigure/loadQualityRules', [ItemController::class, 'loadQualityRules']);
        Route::get('/ItemConfigure/loadBarcodeType', [ItemController::class, 'loadBarcodeType']);
        Route::get('/ItemConfigure/loadSuppliers', [ItemController::class, 'loadSuppliers']);
        Route::get('/ItemConfigure/loadNamingSeris', [ItemController::class, 'loadNamingSeris']);
        Route::get('/ItemConfigure/loadCountries', [ItemController::class, 'loadCountries']);



        // ItemAlternative list
        Route::get('/ItemAlternative_list', function () {
            return view('inventory::pages.masters.ItemAlternative');
        });
        Route::get('/itemAlternative/loadItemAlternatives', [ItemAlternativeController::class, 'loadItemAlternatives']);
        Route::delete('/itemAlternative/delete/{id}', [ItemAlternativeController::class, 'delete']);

        // ItemAlternative configure
        Route::get('/itemAlternative_configure', function () {
            return view('inventory::pages.masters.ItemAlternativeConfigure');
        });
        Route::post('/ItemAlternativeConfigure/save', [ItemAlternativeController::class, 'save']);
        Route::post('/ItemAlternativeConfigure/update', [ItemAlternativeController::class, 'update']);
        Route::get('/ItemAlternativeConfigure/loadItemAlternative/{id}', [ItemAlternativeController::class, 'loadItemAlternative']);
        Route::get('/ItemAlternativeConfigure/loadItems', [ItemAlternativeController::class, 'loadItems']);

        // UOMConversionFactors list
        Route::get('/UOMConversionFactors_list', function () {
            return view('inventory::pages.masters.UOMConversionFactors');
        });
        Route::get('/UOMConversionFactors/loadUOMConversionFactors', [UOMConversionFactorsController::class, 'loadUOMConversionFactors']);
        Route::delete('/UOMConversionFactors/delete/{id}', [UOMConversionFactorsController::class, 'delete']);

        // UOMConversionFactors configure
        Route::get('/UOMConversionFactors_configure', function () {
            return view('inventory::pages.masters.UOMConversionFactorsConfigure');
        });
        Route::post('/UOMConversionFactorsConfigure/save', [UOMConversionFactorsController::class, 'save']);
        Route::post('/UOMConversionFactorsConfigure/update', [UOMConversionFactorsController::class, 'update']);
        Route::get('/UOMConversionFactorsConfigure/loadUOMConversionFactor/{id}', [UOMConversionFactorsController::class, 'loadUOMConversionFactor']);
        Route::get('/UOMConversionFactorsConfigure/loadUOM', [UOMConversionFactorsController::class, 'loadUOM']);


        // deliveryNote list
        Route::get('/delivery_list', function () {
            return view('inventory::pages.masters.deliveryNote');
        });
        Route::get('/deliveryNote/loadDeliveryNotes', [DeliveryTripController::class, 'loadDeliveryNotes']);
        Route::delete('/deliveryNote/delete/{id}', [DeliveryTripController::class, 'delete']);

        // deliveryNote configure
        Route::get('/deliveryNote_configure', function () {
            return view('inventory::pages.masters.deliveryNoteConfigure');
        });
        Route::post('/deliveryNoteConfigure/save', [DeliveryTripController::class, 'save']);
        Route::post('/deliveryNoteConfigure/update', [DeliveryTripController::class, 'update']);
        Route::get('/deliveryNoteConfigure/loadDeliveryNote/{id}', [DeliveryTripController::class, 'loadDeliveryNote']);
        Route::get('/deliveryNoteConfigure/loadDropDownData', [DeliveryTripController::class, 'loadDropDownData']);



        // warehouseType list
        Route::get('/warehouseType_list', function () {
            return view('inventory::pages.masters.warehouseType');
        });
        Route::get('/warehouseType/loadWarehouseTypes', [warehouseTypeController::class, 'loadWarehouseTypes']);
        Route::delete('/warehouseType/delete/{id}', [warehouseTypeController::class, 'delete']);

        // warehouseType configure
        Route::get('/warehouseType_configure', function () {
            return view('inventory::pages.masters.warehouseTypeConfigure');
        });
        Route::post('/warehouseTypeConfigure/save', [warehouseTypeController::class, 'save']);
        Route::post('/warehouseTypeConfigure/update', [warehouseTypeController::class, 'update']);
        Route::get('/warehouseTypeConfigure/loadWarehouseType/{id}', [warehouseTypeController::class, 'loadWarehouseType']);


         // Warehouse list
         Route::get('/warehouse_list', function () {
            return view('inventory::pages.masters.warehouse');
        });
        Route::get('/Warehouse/loadWarehouses', [warehouseController::class, 'loadWarehouses']);
        Route::delete('/warehouse/delete/{id}', [warehouseController::class, 'delete']);

        // Warehouse configure
        Route::get('/warehouse_configure', function () {
            return view('inventory::pages.masters.warehouseConfigure');
        });
        Route::post('/warehouseConfigure/save', [warehouseController::class, 'save']);
        Route::post('/warehouseConfigure/update', [warehouseController::class, 'update']);
        Route::get('/warehouseConfigure/loadWarehouse/{id}', [warehouseController::class, 'loadWarehouse']);
        Route::get('/warehouseConfigure/loadDropDownData', [warehouseController::class, 'loadDropDownData']);

    });
});
