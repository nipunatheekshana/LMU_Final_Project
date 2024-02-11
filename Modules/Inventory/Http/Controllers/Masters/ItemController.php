<?php

namespace Modules\Inventory\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\PriceList;
use Modules\Assets\Entities\AssetCategory;
use Modules\Buying\Entities\Supplier;
use Modules\Inventory\Entities\Brand;
use Modules\Inventory\Entities\HsCode;
use Modules\Inventory\Entities\Item;
use Modules\Inventory\Entities\ItemBarcode;
use Modules\Inventory\Entities\ItemGroup;
use Modules\Inventory\Entities\ItemManufacturer;
use Modules\Inventory\Entities\ItemSupplier;
use Modules\Inventory\Entities\Manufacturer;
use Modules\Inventory\Entities\UOM;
use Modules\Quality\Entities\QualityCheckingRule;
use Modules\Settings\Entities\BarcodeType;
use Modules\Settings\Entities\Company;
use Modules\Settings\Entities\Country;
use Modules\Settings\Entities\NamingSeries;

class ItemController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            // 'CompanyID' => ['required'],
            'Item_Code' => ['required'],
            'item_name' => ['required'],
            'item_group' => ['required'],
        ]);
        if($request->CompanyID==''){
            $this->validationError('CompanyID','Company Field Is Required');
        }
        try {
            $Item = new Item();
            $Item->CompanyID = $request->CompanyID;
            $Item->Inventory_code = 111; //check this#################################3

            $Item->Item_Code = $request->Item_Code;
            $Item->item_name = $request->item_name;
            $Item->Item_description = $request->Item_description;
            $Item->item_group = $request->item_group;
            $Item->BrandID = $request->BrandID;
            $Item->allow_alternative_item = $request->has('allow_alternative_item');
            $Item->is_sales_item = $request->has('is_sales_item');
            $Item->is_purchase_item = $request->has('is_purchase_item');
            $Item->is_stock_item = $request->has('is_stock_item');
            $Item->is_manufacturing_item = $request->has('is_manufacturing_item');
            $Item->is_seafood_item = $request->has('is_seafood_item');
            $Item->is_by_product = $request->has('is_by_product');
            $Item->is_fixed_asset = $request->has('is_fixed_asset');
            $Item->is_auto_create_assets = $request->has('is_auto_create_assets');
            if($request->has('is_fixed_asset')){
                $Item->asset_category = $request->asset_category;
                $Item->asset_item_short_code = $request->asset_item_short_code;
                $Item->asset_naming_series = $request->asset_naming_series;
            }
            $Item->opening_stock = $request->opening_stock;
            $Item->stock_uom = $request->stock_uom;
            $Item->valuation_rate = $request->valuation_rate;
            $Item->valuation_method = $request->valuation_method;
            $Item->standard_rate = $request->standard_rate;
            $Item->avg_weight_per_unit = $request->avg_weight_per_unit;
            $Item->weight_uom = $request->weight_uom;
            // $Item->end_of_life = $request->end_of_life;
            $Item->default_warranty_period_days = $request->default_warranty_period_days;
            $Item->default_material_request_type = $request->default_material_request_type;
            $Item->over_billing_allowance = $request->over_billing_allowance;
            $Item->over_purchase_receipt_allowance = $request->over_purchase_receipt_allowance;
            // $Item->over_delivery_receipt_allowance = $request->over_delivery_receipt_allowance;
            $Item->has_batch_no = $request->has('has_batch_no');
            if($request->has('has_batch_no')){
                $Item->batch_number_series = $request->batch_number_series;
            }
            // $Item->has_expiry_date = $request->has('has_expiry_date');
            if($request->has('has_expiry_date')){
                $Item->shelf_life_in_days = $request->shelf_life_in_days;
            }
            $Item->has_serial_no = $request->has('has_serial_no');
            if($request->has('has_serial_no')){
            // $Item->serial_no_series = $request->serial_no_series;
            }
            $Item->has_variants = $request->has('has_variants');
            // $Item->variant_based_on = $request->variant_based_on;
            $Item->min_order_qty = $request->min_order_qty;
            $Item->lead_time_days = $request->lead_time_days;
            $Item->is_inspection_required_before_receive = $request->has('is_inspection_required_before_receive');
            // $Item->default_buying_pricelist = $request->default_buying_pricelist;
            $Item->safety_stock = $request->safety_stock;
            $Item->last_purchase_rate = $request->last_purchase_rate;
            // $Item->inspection_before_receive_rule = $request->inspection_before_receive_rule;
            // $Item->max_discount = $request->max_discount;
            // $Item->delivered_by_supplier = $request->has('delivered_by_supplier');
            $Item->is_inspection_required_before_delivery = $request->has('is_inspection_required_before_delivery');
            // $Item->default_selling_pricelist = $request->default_selling_pricelist;
            // $Item->inspection_before_delivery_rule = $request->has('inspection_before_delivery_rule');
            $Item->default_bom = $request->default_bom;
            $Item->is_customer_provided_item = $request->has('is_customer_provided_item');
            // $Item->default_supplier = $request->default_supplier;
            $Item->default_item_manufacturer = $request->default_item_manufacturer;
            $Item->default_manufacturer_part_no = $request->default_manufacturer_part_no;
            // $Item->customs_tariff_number = $request->customs_tariff_number;
            // $Item->country_of_origin = $request->country_of_origin;
            $Item->show_in_website = $request->has('show_in_website');
            // $Item->web_description = $request->web_description;
            $Item->list_index = $request->list_index;
            $Item->enabled = $request->has('enabled');
            $Item->created_by = Auth::user()->id;
            $save = $Item->save();


            if ($request->has('image') && $save) {

                $const = '-item_image';
                $imagename = $Item->id . $const; //new image name
                $guessExtension = $request->file('image')->guessExtension(); //file extention
                $file = $request->file('image')->storeAs('item_images/' . $Item->id, $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/item_images/' . $Item->id . '/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = Item::find($Item->id);
                $image->image = $url;
                $image->save();
            }
            if ($request->has('website_image') && $save) {

                $const = '-item_image';
                $imagename = $Item->id . $const; //new image name
                $guessExtension = $request->file('website_image')->guessExtension(); //file extention
                $file = $request->file('website_image')->storeAs('item_images/website_images/' . $Item->id, $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/item_images/website_images/' . $Item->id . '/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = Item::find($Item->id);
                $image->website_image = $url;
                $image->save();
            }
            if ($save) {
                return $this->responseBody(true, "save", "Item saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            // 'CompanyID' => ['required'],
            'Item_Code' => ['required'],
            'item_name' => ['required'],
            'item_group' => ['required'],
        ]);
        if($request->CompanyID==''){
            $this->validationError('CompanyID','Company Field Is Required');
        }
        try {
            $Item = Item::find($request->id);
            $Item->CompanyID = $request->CompanyID;
            $Item->Inventory_code = 111; //check this#################################3

            $Item->Item_Code = $request->Item_Code;
            $Item->item_name = $request->item_name;
            $Item->Item_description = $request->Item_description;
            $Item->item_group = $request->item_group;
            $Item->BrandID = $request->BrandID;
            $Item->allow_alternative_item = $request->has('allow_alternative_item');
            $Item->is_sales_item = $request->has('is_sales_item');
            $Item->is_purchase_item = $request->has('is_purchase_item');
            $Item->is_stock_item = $request->has('is_stock_item');
            $Item->is_manufacturing_item = $request->has('is_manufacturing_item');
            $Item->is_seafood_item = $request->has('is_seafood_item');
            $Item->is_by_product = $request->has('is_by_product');
            $Item->is_fixed_asset = $request->has('is_fixed_asset');
            $Item->is_auto_create_assets = $request->has('is_auto_create_assets');
            if($request->has('is_fixed_asset')){
                $Item->asset_category = $request->asset_category;
                $Item->asset_item_short_code = $request->asset_item_short_code;
                $Item->asset_naming_series = $request->asset_naming_series;
            }
            $Item->opening_stock = $request->opening_stock;
            $Item->stock_uom = $request->stock_uom;
            $Item->valuation_rate = $request->valuation_rate;
            $Item->valuation_method = $request->valuation_method;
            $Item->standard_rate = $request->standard_rate;
            $Item->avg_weight_per_unit = $request->avg_weight_per_unit;
            $Item->weight_uom = $request->weight_uom;
            // $Item->end_of_life = $request->end_of_life;
            $Item->default_warranty_period_days = $request->default_warranty_period_days;
            $Item->default_material_request_type = $request->default_material_request_type;
            $Item->over_billing_allowance = $request->over_billing_allowance;
            $Item->over_purchase_receipt_allowance = $request->over_purchase_receipt_allowance;
            // $Item->over_delivery_receipt_allowance = $request->over_delivery_receipt_allowance;
            $Item->has_batch_no = $request->has('has_batch_no');
            if($request->has('has_batch_no')){
                $Item->batch_number_series = $request->batch_number_series;
            }
            // $Item->has_expiry_date = $request->has('has_expiry_date');
            if($request->has('has_expiry_date')){
                $Item->shelf_life_in_days = $request->shelf_life_in_days;
            }
            $Item->has_serial_no = $request->has('has_serial_no');
            if($request->has('has_serial_no')){
            // $Item->serial_no_series = $request->serial_no_series;
            }
            $Item->has_variants = $request->has('has_variants');
            // $Item->variant_based_on = $request->variant_based_on;
            $Item->min_order_qty = $request->min_order_qty;
            $Item->lead_time_days = $request->lead_time_days;
            $Item->is_inspection_required_before_receive = $request->has('is_inspection_required_before_receive');
            // $Item->default_buying_pricelist = $request->default_buying_pricelist;
            $Item->safety_stock = $request->safety_stock;
            $Item->last_purchase_rate = $request->last_purchase_rate;
            // $Item->inspection_before_receive_rule = $request->inspection_before_receive_rule;
            // $Item->max_discount = $request->max_discount;
            // $Item->delivered_by_supplier = $request->has('delivered_by_supplier');
            $Item->is_inspection_required_before_delivery = $request->has('is_inspection_required_before_delivery');
            // $Item->default_selling_pricelist = $request->default_selling_pricelist;
            // $Item->inspection_before_delivery_rule = $request->has('inspection_before_delivery_rule');
            $Item->default_bom = $request->default_bom;
            $Item->is_customer_provided_item = $request->has('is_customer_provided_item');
            // $Item->default_supplier = $request->default_supplier;
            $Item->default_item_manufacturer = $request->default_item_manufacturer;
            $Item->default_manufacturer_part_no = $request->default_manufacturer_part_no;
            // $Item->customs_tariff_number = $request->customs_tariff_number;
            // $Item->country_of_origin = $request->country_of_origin;
            $Item->show_in_website = $request->has('show_in_website');
            // $Item->web_description = $request->web_description;
            $Item->list_index = $request->list_index;
            $Item->enabled = $request->has('enabled');
            $Item->modified_by = Auth::user()->id;
            $save = $Item->save();


            if ($request->has('image') && $save) {

                $const = '-item_image';
                $imagename = $Item->id . $const; //new image name
                $guessExtension = $request->file('image')->guessExtension(); //file extention
                $file = $request->file('image')->storeAs('item_images/' . $Item->id, $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/item_images/' . $Item->id . '/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = Item::find($Item->id);
                $image->image = $url;
                $image->save();
            }
            if ($request->has('website_image') && $save) {

                $const = '-item_image';
                $imagename = $Item->id . $const; //new image name
                $guessExtension = $request->file('website_image')->guessExtension(); //file extention
                $file = $request->file('website_image')->storeAs('item_images/website_images/' . $Item->id, $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/item_images/website_images/' . $Item->id . '/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = Item::find($Item->id);
                $image->website_image = $url;
                $image->save();
            }
            if ($save) {
                return $this->responseBody(true, "save", "Item saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadItems()
    {
        try {
            $Item = DB::table('inventory_items')
                ->leftJoin('inventory_item_groups', 'inventory_item_groups.id', '=', 'inventory_items.item_group')
                ->select('inventory_items.id', 'inventory_items.Item_Code', 'inventory_items.item_name', 'inventory_item_groups.GroupName')
                ->orwhere('is_fixed_asset', FALSE)
                ->orwhere('is_fixed_asset', TRUE)
                ->orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadItems", "found", $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItems", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $image = Item::where('id', $id)->first()->image;
            if (file_exists($image)) {
                unlink($image);
            }
            $Item = Item::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Item Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadItem($id)
    {
        try {
            $Item = Item::where('id', $id)->first();
            return $this->responseBody(true, "loadItem", "found", $Item);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadItem", "error", $exception->getMessage());
        }
    }
    public function loadCompanies()
    {
        try {
            $Company = Company::where('enabled', true)->get();

            return $this->responseBody(true, "loadCompanies", '', $Company);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCompanies", '', $ex->getMessage());
        }
    }
    public function loadItemGroup()
    {
        try {
            $ItemGroup = ItemGroup::where('enabled', true)->get();

            return $this->responseBody(true, "loadItemGroup", '', $ItemGroup);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItemGroup", '', $ex->getMessage());
        }
    }
    public function loadBrand()
    {
        try {
            $Brand = Brand::where('enabled', true)->get();

            return $this->responseBody(true, "loadBrand", '', $Brand);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBrand", '', $ex->getMessage());
        }
    }
    public function loadAssetCatagories()
    {
        try {
            $AssetCategory = AssetCategory::where('enabled', true)->get();

            return $this->responseBody(true, "loadAssetCatagories", '', $AssetCategory);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadAssetCatagories", '', $ex->getMessage());
        }
    }
    public function loadUOM()
    {
        try {
            $UOM = UOM::where('enabled', true)->get();

            return $this->responseBody(true, "loadUOM", '', $UOM);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadUOM", '', $ex->getMessage());
        }
    }
    public function loadDefaultBuyingPriceList()
    {
        try {
            $PriceList = PriceList::where('enabled', true)->where('buying', true)->get();

            return $this->responseBody(true, "loadDefaultBuyingPriceList", '', $PriceList);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDefaultBuyingPriceList", '', $ex->getMessage());
        }
    }
    public function loadDefaultsellingPriceList()
    {
        try {
            $PriceList = PriceList::where('enabled', true)->where('selling', true)->get();

            return $this->responseBody(true, "loadDefaultBuyingPriceList", '', $PriceList);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDefaultBuyingPriceList", '', $ex->getMessage());
        }
    }
    public function loadDefaultManufacture()
    {
        try {
            $Manufacturer = Manufacturer::where('enabled', true)->get();

            return $this->responseBody(true, "loadDefaultManufacture", '', $Manufacturer);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDefaultManufacture", '', $ex->getMessage());
        }
    }
    public function loadHS_code()
    {
        try {
            $HsCode = HsCode::where('enabled', true)->get();

            return $this->responseBody(true, "loadHS_code", '', $HsCode);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadHS_code", '', $ex->getMessage());
        }
    }
    public function loadCurrentItems()
    {
        try {
            $Item = Item::where('enabled', true)->get();

            return $this->responseBody(true, "loadCurrentItems", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCurrentItems", '', $ex->getMessage());
        }
    }
    public function loadQualityRules()
    {
        try {
            $QualityCheckingRule = QualityCheckingRule::where('enabled', true)->get();

            return $this->responseBody(true, "loadQualityRules", '', $QualityCheckingRule);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadQualityRules", '', $ex->getMessage());
        }
    }
    public function loadBarcodeType()
    {
        try {
            $BarcodeType = BarcodeType::where('enabled', true)->get();

            return $this->responseBody(true, "loadBarcodeType", '', $BarcodeType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBarcodeType", '', $ex->getMessage());
        }
    }

    public function saveBarcode(Request $request)
    {
        $validatedData = $request->validate([
            'barcode' => ['required'],
            'barcode_type' => ['required'],
        ]);
        if (ItemBarcode::where('barcode', $request->barcode)->exists()) {
            $this->validationError('barcode', 'Barcode Exists');
        }
        try {
            $BarcodeType = new ItemBarcode();
            $BarcodeType->item = $request->ItemIdForBarcode;
            $BarcodeType->barcode = $request->barcode;
            $BarcodeType->barcode_type = $request->barcode_type;
            $BarcodeType->created_by = Auth::user()->id;
            $save = $BarcodeType->save();

            if ($save) {
                return $this->responseBody(true, "save", "BarcodeType saved", $request->ItemIdForBarcode);
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadBarcodes($id)
    {
        try {
            // $ItemBarcode = ItemBarcode::where('item',$id)->get();
            $ItemBarcode = DB::table('inventory_item_barcodes')
                ->leftJoin('settings_barcode_types', 'settings_barcode_types.id', '=', 'inventory_item_barcodes.barcode_type')
                ->where('inventory_item_barcodes.item', $id)
                ->select('inventory_item_barcodes.*','settings_barcode_types.barcodeType')
                ->get();


            return $this->responseBody(true, "loadBarcodes", '', $ItemBarcode);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBarcodes", '', $ex->getMessage());
        }
    }

    public function deleteBarcode($id)
    {
        try {

            $ItemBarcode = ItemBarcode::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Item Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadSuppliers()
    {
        try {
            $Supplier = Supplier::where('enabled', true)->get();

            return $this->responseBody(true, "loadSuppliers", '', $Supplier);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSuppliers", '', $ex->getMessage());
        }
    }
    public function saveSupplier(Request $request)
    {
        $validatedData = $request->validate([
            'supplier' => ['required'],
            'supplier_part_no' => ['required'],
        ]);
        if (ItemSupplier::where('item', $request->ItemIdForSupplier)->where('supplier', $request->supplier)->exists()) {
            $this->validationError('supplier', 'Supplier Exists');
        }
        if (ItemSupplier::where('supplier_part_no', $request->supplier_part_no)->exists()) {
            $this->validationError('supplier_part_no', 'supplier part no Exists');
        }
        try {
            $ItemSupplier = new ItemSupplier();
            $ItemSupplier->item = $request->ItemIdForSupplier;
            $ItemSupplier->supplier = $request->supplier;
            $ItemSupplier->supplier_part_no = $request->supplier_part_no;
            $ItemSupplier->created_by = Auth::user()->id;
            $save = $ItemSupplier->save();

            if ($save) {
                return $this->responseBody(true, "save", "ItemSupplier saved", $request->ItemIdForSupplier);
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadSuppliersTable($id)
    {
        try {
            // $ItemSupplier = ItemSupplier::where('item',$id)->get();
            $ItemSupplier = DB::table('inventory_item_suppliers')
                ->leftJoin('buying_suppliers', 'inventory_item_suppliers.supplier', '=', 'buying_suppliers.id')
                ->where('inventory_item_suppliers.item', $id)
                ->select('buying_suppliers.supplier_name as supplier', 'inventory_item_suppliers.id')
                ->get();


            return $this->responseBody(true, "loadSuppliersTable", '', $ItemSupplier);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSuppliersTable", '', $ex->getMessage());
        }
    }
    public function deleteSupplier($id)
    {
        try {

            $ItemSupplier = ItemSupplier::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Supplier Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function saveManufacturer(Request $request)
    {
        $validatedData = $request->validate([
            'manufacturer' => ['required'],
            'manufacturer_part_no' => ['required'],
        ]);
        if (ItemManufacturer::where('item', $request->ItemIdForManufacturer)->where('manufacturer', $request->manufacturer)->exists()) {
            $this->validationError('manufacturer', 'Manufacturer Exists');
        }
        if (ItemManufacturer::where('manufacturer_part_no', $request->manufacturer_part_no)->exists()) {
            $this->validationError('manufacturer_part_no', 'Manufacturer part no Exists');
        }
        try {
            $ItemManufacturer = new ItemManufacturer();
            $ItemManufacturer->item = $request->ItemIdForManufacturer;
            $ItemManufacturer->manufacturer = $request->manufacturer;
            $ItemManufacturer->manufacturer_part_no = $request->manufacturer_part_no;
            $ItemManufacturer->created_by = Auth::user()->id;
            $save = $ItemManufacturer->save();

            if ($save) {
                return $this->responseBody(true, "save", "ItemManufacturer saved", $request->ItemIdForManufacturer);
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadManufacturerTable($id)
    {
        try {
            $ItemManufacturer = DB::table('inventory_item_manufacturers')
                ->leftJoin('inventory_manufacturers', 'inventory_item_manufacturers.manufacturer', '=', 'inventory_manufacturers.id')
                ->where('inventory_item_manufacturers.item', $id)
                ->select('inventory_manufacturers.name', 'inventory_item_manufacturers.id')
                ->get();


            return $this->responseBody(true, "loadManufacturerTable", '', $ItemManufacturer);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadManufacturerTable", '', $ex->getMessage());
        }
    }
    public function deleteManufacturer($id)
    {
        try {

            $ItemManufacturer = ItemManufacturer::where('id', $id)->delete();
            return $this->responseBody(true, "User", "manufacturer Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadNamingSeris()
    {
        try {
            $NamingSeries = NamingSeries::where('enabled', true)->get();

            return $this->responseBody(true, "loadNamingSeris", '', $NamingSeries);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadNamingSeris", '', $ex->getMessage());
        }
    }
    public function loadCountries()
    {
        try {
            $Country = Country::where('enabled', true)->get();

            return $this->responseBody(true, "loadCountries", '', $Country);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCountries", '', $ex->getMessage());
        }
    }
}
