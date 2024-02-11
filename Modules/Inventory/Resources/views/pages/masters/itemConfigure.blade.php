@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Item" @endphp

@section('title', $title)
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">

    <!-- select2 -->
    <link rel="stylesheet" href="{{ url('vendors/select2/css/select2.min.css') }}" type="text/css">

@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __($title) }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashbord-Parent">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/inventory">{{ __('Inventory Module') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/inventory/Item_list">{{ __('Items List') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button id="btnSave" class="btn btn-primary mb-3" style="float: right" type="button">Save</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Item Details') }}</h6>
                    <form id="frmItemConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Company*') }}</label>
                                <select class="form-control" name="CompanyID" id="CompanyID">
                                    <option value="">-Select-</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Item Code*') }}</label>
                                <input type="text" class="form-control" name="Item_Code" id="Item_Code"
                                    placeholder="Eg : POL-WRAP-SM">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Item Name*') }}</label>
                                <input type="text" class="form-control" name="item_name" id="item_name"
                                    placeholder="Eg : Polythene Wraps - Small">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Description') }}</label>
                                <textarea type="text" class="form-control" name="Item_description" id="Item_description"></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Item Group') }}</label>
                                <select class="form-control" name="item_group" id="item_group">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Brand') }}</label>
                                <select class="form-control" name="BrandID" id="BrandID">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Image') }}</label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div>


                        </div>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Index') }}</label>
                                <input type="number" class="form-control" name="list_index" id="list_index" value="1">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">

                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="allow_alternative_item"
                                        name="allow_alternative_item">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Allow Alternative item?') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_sales_item"
                                        name="is_sales_item">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Is Sales item?') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_purchase_item"
                                        name="is_purchase_item">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Is Purchase item?') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_stock_item"
                                        name="is_stock_item">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Is Stock item?') }}</label>
                                </div>
                                {{-- <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_manufacturing_item"
                                        name="is_manufacturing_item">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Is Manufacturing item?') }}</label>
                                </div> --}}

                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_seafood_item"
                                        name="is_seafood_item">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Is Sea Food item?') }}</label>
                                </div>
                                {{-- <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_by_product"
                                        name="is_by_product">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Is by product?') }}</label>
                                </div> --}}
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_fixed_asset"
                                        name="is_fixed_asset">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Is Fixed Asset?') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="enabled" name="enabled"
                                        checked>
                                    <label class="form-check-label" for="exampleCheck1">{{ __('Enabled') }}</label>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion accordion-primary custom-accordion">
        <div class="accordion-row" id="barcodeAcordinationRaw">
            <a href="#" class="accordion-header">
                <span>Barcord</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <div class="col-md-12">
                    <button id="btnBarcodeModel" class="btn btn-primary mb-3" type="button"> <i
                            class="ti-plus"></i></button>
                </div>
                <div class="table-responsive">
                    <table id="tableBarcodes" class="table table-striped table-bordered dataTable dtr-inline collapsed"
                        role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr>
                                <th class="thId">#</th>
                                <th class="thBarcode">{{ __('Barcode') }}</th>
                                <th class="thBarcodeType">{{ __('Barcode Type') }}</th>
                                <th class="action"> {{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="accordion-row " id="assetAcordinationRaw">
            <a href="#" class="accordion-header">
                <span>Asset Item Details</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">{{ __('Asset Category') }}</label>
                        <select class="form-control" name="asset_category" id="asset_category">
                            <option value="">-Select-</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Asset Item Short Code') }}</label>
                        <input type="text" class="form-control" name="asset_item_short_code"
                            id="asset_item_short_code" placeholder="Eg : FUR">
                    </div>
                </div>
                <div class="form-row">

                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Asset Naming Series') }}</label>

                        <select class="form-control" name="asset_naming_series" id="asset_naming_series">
                            <option value="">-Select-</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_auto_create_assets"
                                name="is_auto_create_assets">
                            <label class="form-check-label" for="exampleCheck1">{{ __('Auto create assets?') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-row   ">
            <a href="#" class="accordion-header">
                <span>Inventory</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Opening Stock') }}</label>
                        <input type="number" class="form-control" name="opening_stock" id="opening_stock">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Valuation Rate') }}</label>
                        <input type="number" class="form-control" name="valuation_rate" id="valuation_rate">
                    </div>

                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Standard Rate') }}</label>
                        <input type="number" class="form-control" name="standard_rate" id="standard_rate">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Average Weight per Unit') }}</label>
                        <input type="number" class="form-control" name="avg_weight_per_unit" id="avg_weight_per_unit">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('End of Life (EOL)') }}</label>
                        <input type="date" class="form-control" name="end_of_life" id="end_of_life">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Default Warranty Period (Days)') }}</label>
                        <input type="number" class="form-control" name="default_warranty_period_days"
                            id="default_warranty_period_days">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">{{ __('Default Material Request Type') }}</label>
                        <select class="form-control" name="default_material_request_type"
                            id="default_material_request_type">
                            <option value="">-Select-</option>
                            <option value="Purchase">Purchase</option>
                            <option value="Material Transfer">Material Transfer</option>
                            <option value="Material Issue">Material Issue</option>
                            <option value="Manufacture">Manufacture</option>
                            <option value="Customer Provided">Customer Provided</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Over Purchase Receipt Allowance (%)') }}</label>
                        <input type="number" class="form-control" name="over_purchase_receipt_allowance"
                            id="over_purchase_receipt_allowance">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">{{ __('Stock UOM') }}</label>
                        <select class="form-control" name="stock_uom" id="stock_uom">
                            <option value="">-Select-</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">{{ __('Valuation Method') }}</label>
                        <select class="form-control" name="valuation_method" id="valuation_method">
                            <option value="">-Select-</option>
                            <option value="FIFO">FIFO</option>
                            <option value="Moving">Moving</option>
                            <option value="Average">Average</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">{{ __('Weight UOM') }}</label>
                        <select class="form-control" name="weight_uom" id="weight_uom">
                            <option value="">-Select-</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Over Billing Allowance (%)') }}</label>
                        <input type="number" class="form-control" name="over_billing_allowance"
                            id="over_billing_allowance">
                    </div>

                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Over Delivery Receipt Allowance (%)') }}</label>
                        <input type="number" class="form-control" name="over_delivery_receipt_allowance"
                            id="over_delivery_receipt_allowance">
                    </div>

                </div>

            </div>
        </div>
        <div class="accordion-row \">
            <a href="#" class="accordion-header">
            <span>Batch & Serial</span>
            <i class="accordion-status-icon close fa fa-chevron-up"></i>
            <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <div class="form-row">
                    <div class="col-md-6 mb-3" id="BatchNumberSeriesRow">
                        <label for="validationCustom01">{{ __('Batch Number Series') }}</label>
                        <input type="text" class="form-control" name="batch_number_series" id="batch_number_series">
                    </div>
                    <div class="col-md-6 mb-3" id="shelfLifeInDaysRow">
                        <label for="validationCustom01">{{ __('Shelf life (Days)') }}</label>
                        <input type="number" class="form-control" name="shelf_life_in_days" id="shelf_life_in_days">
                    </div>
                    <div class="col-md-6 mb-3" id="SerialNumberSeriesRow">
                        <label for="validationCustom01">{{ __('Serial Number Series') }}</label>
                        <input type="text" class="form-control" name="serial_no_series" id="serial_no_series">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="has_batch_no" name="has_batch_no">
                            <label class="form-check-label" for="exampleCheck1">{{ __('Has Batch Number?') }}</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="has_expiry_date" name="has_expiry_date">
                            <label class="form-check-label" for="exampleCheck1">{{ __('Has Expiry Date?') }}</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="has_serial_no" name="has_serial_no">
                            <label class="form-check-label" for="exampleCheck1">{{ __('Has Serial Number?') }}</label>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="accordion-row ">
            <a href="#" class="accordion-header">
                <span>Variants</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Variant Based on') }}</label>
                        <input type="number" class="form-control" name="variant_based_on" id="variant_based_on">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">{{ __('Variant of') }}</label>
                        <select class="form-control" name="variant_of" id="variant_of">
                            <option value="">-Select-</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="has_variants" name="has_variants">
                            <label class="form-check-label" for="exampleCheck1">{{ __('Has Variants?') }}</label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="accordion-row ">
            <a href="#" class="accordion-header">
                <span>Purchase & Replenishment</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Min Order Quantity') }}</label>
                        <input type="number" class="form-control" name="min_order_qty" id="min_order_qty">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Lead Time (Days)') }}</label>
                        <input type="number" class="form-control" name="lead_time_days" id="lead_time_days">
                    </div>

                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">{{ __('Default Buying Price List') }}</label>
                        <select class="form-control" name="default_buying_pricelist" id="default_buying_pricelist">
                            <option value="">-Select-</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Safety Stock') }}</label>
                        <input type="number" class="form-control" name="safety_stock" id="safety_stock">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Last Purchase Rate') }}</label>
                        <input type="number" class="form-control" name="last_purchase_rate" id="last_purchase_rate">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">{{ __('Inspection Before Receive Rule') }}</label>
                        <select class="form-control" name="inspection_before_receive_rule"
                            id="inspection_before_receive_rule">
                            <option value="">-Select-</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_inspection_required_before_receive"
                                name="is_inspection_required_before_receive">
                            <label class="form-check-label"
                                for="exampleCheck1">{{ __('Is inspection required before Receive?') }}</label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="accordion-row ">
            <a href="#" class="accordion-header">
                <span>Sales and Delivery</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Max Discount (%)') }}</label>
                        <input type="number" class="form-control" name="max_discount" id="max_discount">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">{{ __('Default Selling Price List') }}</label>
                        <select class="form-control" name="default_selling_pricelist" id="default_selling_pricelist">
                            <option value="">-Select-</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">{{ __('Inspection before delivery rule') }}</label>
                        <select class="form-control" name="inspection_before_delivery_rule"
                            id="inspection_before_delivery_rule">
                            <option value="">-Select-</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="delivered_by_supplier"
                                name="delivered_by_supplier">
                            <label class="form-check-label" for="exampleCheck1">{{ __('Delivered by supplier') }}</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_inspection_required_before_delivery"
                                name="is_inspection_required_before_delivery">
                            <label class="form-check-label"
                                for="exampleCheck1">{{ __('Is inspection required before delivery?') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-row ">
            <a href="#" class="accordion-header">
                <span>Manufacturing & Other</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">{{ __('Default BOM') }}</label>
                        <select class="form-control" name="default_bom" id="default_bom">
                            <option value="">-Select-</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_customer_provided_item"
                                name="is_customer_provided_item">
                            <label class="form-check-label"
                                for="exampleCheck1">{{ __('Is customer provided item?') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-row "id="SupplierAndManueAcordinationRaw">
            <a href="#" class="accordion-header">
                <span>Suppliers and Manufacturers</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <div class="col-md-12">
                    <button id="btnSupplierModel" class="btn btn-primary mb-3" type="button"> <i
                            class="ti-plus"></i></button>
                </div>
                <div class="table-responsive">
                    <table id="tableSuppliers" class="table table-striped table-bordered dataTable dtr-inline collapsed"
                        role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr>
                                <th class="thId">#</th>
                                <th class="thsupplier">{{ __('Supplier') }}</th>
                                <th class="action"> {{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Default Supplier') }}</label>
                        <input type="number" class="form-control" name="default_supplier" id="default_supplier">
                    </div>

                </div>
                <div class="col-md-12">
                    <button id="btnManufacturer" class="btn btn-primary mb-3" type="button"> <i
                            class="ti-plus"></i></button>
                </div>
                <div class="table-responsive">
                    <table id="tablemanufacturer"
                        class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                        aria-describedby="example1_info">
                        <thead>
                            <tr>
                                <th class="thId">#</th>
                                <th class="thmanufacturer">{{ __('Item') }}</th>
                                <th class="action"> {{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">{{ __('Default Item Manufacturer') }}</label>
                        <select class="form-control" name="default_item_manufacturer" id="default_item_manufacturer">
                            <option value="">-Select-</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Default Manufacturer Part Number') }}</label>
                        <input type="number" class="form-control" name="default_manufacturer_part_no"
                            id="default_manufacturer_part_no">
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-row ">
            <a href="#" class="accordion-header">
                <span>Foreign Trade</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom02">{{ __('Customs Tariff Number') }}</label>
                        <select class="form-control" name="customs_tariff_number" id="customs_tariff_number">
                            <option value="">-Select-</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Country of Origin') }}</label>
                        <select class="form-control" name="country_of_origin" id="country_of_origin">
                            <option value="">-Select-</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-row ">
            <a href="#" class="accordion-header">
                <span>Website</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <div class="form-row">
                    <div class="col-md-6 mb-3">

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="show_in_website" name="show_in_website">
                            <label class="form-check-label" for="exampleCheck1">{{ __('Show in Website') }}</label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">{{ __('Website Image') }}</label>
                        <input type="file" class="form-control" name="website_image" id="website_image">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">{{ __('Web Description') }}</label>
                        <textarea type="number" class="form-control" name="web_description" id="web_description"></textarea>
                    </div>
                </div>

            </div>
        </div>
        </form>
    </div>
    {{-- models --}}
    {{-- barcode model --}}
    <div class="modal" tabindex="-1" role="dialog" id="BarcodeMOdel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Barcode Model</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmBarcode" autocomplete="off">
                        <input type="hidden" class="form-control" name="ItemIdForBarcode" id="ItemIdForBarcode">

                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Barcode') }}</label>
                                <input type="text" class="form-control" name="barcode" id="barcode">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom02">{{ __('Barcode Type') }}</label>
                                <select class="form-control" name="barcode_type" id="barcode_type">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSaveBarcode" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Supplier model --}}
    <div class="modal" tabindex="-1" role="dialog" id="SupplierModel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Supplier Model</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmSupplier" autocomplete="off">
                        <input type="hidden" class="form-control" name="ItemIdForSupplier" id="ItemIdForSupplier">

                        <div class="form-row">

                            <div class="col-md-12 mb-3">
                                <label for="validationCustom02">{{ __('Supplier') }}</label>
                                <select class="form-control" name="supplier" id="supplier">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Supplier Part Number') }}</label>
                                <input type="text" class="form-control" name="supplier_part_no"
                                    id="supplier_part_no">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSaveSupplier" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Manufacturer model --}}
    <div class="modal" tabindex="-1" role="dialog" id="ManufacturerModel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manufacturer Model</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmManufacturer" autocomplete="off">
                        <input type="hidden" class="form-control" name="ItemIdForManufacturer"
                            id="ItemIdForManufacturer">

                        <div class="form-row">

                            <div class="col-md-12 mb-3">
                                <label for="validationCustom02">{{ __('Manufacturer') }}</label>
                                <select class="form-control" name="manufacturer" id="manufacturer">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Manufacturer Part No') }}</label>
                                <input type="text" class="form-control" name="manufacturer_part_no"
                                    id="manufacturer_part_no">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSaveManufacturer" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ url('vendors/select2/js/select2.min.js') }}"></script>

    <script src="{{ Module::asset('inventory:js/masters/itemConfigure.js') }}"></script>
@endsection
