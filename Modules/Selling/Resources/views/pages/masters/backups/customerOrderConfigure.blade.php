@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}

@section('head')
    <!-- DataTable -->
    {{-- <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    {{-- searchable select --}}
    <link rel="stylesheet" href="{{ url('vendors/select2/css/select2.min.css') }}" type="text/css">

    <style>
        .dataTables_filter {
            display: none;
        }

        #btnaddItem {
            float: right
        }

        .text-left {
            text-align: left;
            background-color: #181818;
             !important color: rgb(10, 10, 10);
        }

        tr.group,
        tr.group:hover {
            background-color: rgb(82, 103, 222, 255) !important;
            color: rgb(255, 255, 255) !important;
            font-weight: bold;

        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('New Customer Order') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Customer Order') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('New Customer Order') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button id="btnSubmit" class="btn btn-warning mb-3" style="float: right" type="button">Submit</button>
            <button id="btnDeny" class="btn btn-danger mb-3 mr-2" style="float: right" type="button">Deny</button>
            <button id="btnApprove" class="btn btn-success mb-3 mr-2" style="float: right" type="button">Approve</button>
            <button id="btnSave" class="btn btn-primary mb-3 mr-2" style="float: right" type="button">Save</button>
        </div>
    </div>
    {{-- header --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card" style="height: 95%">
                <div class="card-body">
                    {{-- <h6 class="card-title">{{ __('Setup New Customer Order') }}</h6> --}}
                    <form id="frmcustomerOrderConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Order Number') }}</label>
                                <input type="text" class="form-control" name="order_number" id="order_number" readonly>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Order Date') }}</label>
                                <input type="date" class="form-control" name="order_date" id="order_date" data=>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Target Date') }}</label>
                                <input type="date" class="form-control" name="target_date" id="target_date">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Customer PO Number') }}</label>
                                <input type="text" class="form-control" name="customer_po_no" id="customer_po_no">
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Customer Referance Number') }}</label>
                                <input type="text" class="form-control" name="customer_ref_no" id="customer_ref_no">
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="enabled" name="enabled" checked>
                                    <label class="form-check-label" for="exampleCheck1">{{ __('Enabled') }}</label>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card" style="height: 95%">
                <div class="card-body">
                    {{-- <h6 class="card-title">{{ __('Setup New Customer Order') }}</h6> --}}
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">{{ __('Customer') }}</label>
                            <select class="form-control" name="customer" id="customer">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 ">
                            <label for="validationCustom01">{{ __('Billing Address') }}</label>
                            {{-- <textarea type="text" class="form-control" name="customer_billing_address" id="customer_billing_address"></textarea> --}}
                            <select class="form-control" name="customer_billing_address" id="customer_billing_address">
                                <option value="">-Select-</option>
                            </select>
                        </div>

                    </div>
                    <div id="billingAddressContainer">

                    </div>

                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="validationCustom01">{{ __('Shipping Address') }}</label>
                            {{-- <textarea type="text" class="form-control" name="customer_shipping_address" id="customer_shipping_address"></textarea> --}}
                            <select class="form-control" name="customer_shipping_address" id="customer_shipping_address">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                    </div>
                    <div id="shippingAddressContainer">

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- order items Section --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="tableSearch" placeholder="Search here">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            data-feather="search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button class="btn btn-primary " type="button" id="btnaddItem">Add Item</button>

                        </div>
                    </div>

                    <table id="tableItems" class="table table-striped table-bordered Date display nowrap">
                        <thead>
                            <tr>
                                <th class="thProdId">{{ __('Product Id') }}</th>
                                <th class="thproductName">{{ __('Product name') }}</th>
                                <th class="thAvgWeight">{{ __('Avg. Weight') }}</th>
                                <th class="thQty">{{ __('Qty') }}</th>
                                <th class="thTotNetWeight">{{ __('Total Avg Net weight') }}</th>
                                <th class="thUnitPrice">{{ __('Unit Price') }}</th>
                                <th class="thTotalPrice">{{ __('Total Price') }}</th>
                                <th class="action">{{ __('Action') }}</th>

                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Summary') }}</h6>
                    <hr>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">{{ __('Total Average Net Weight') }}</label>
                            <input type="text" class="form-control" id="total_avg_net_weight"
                                name="total_avg_net_weight" readonly>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">{{ __('Total Average Gross Weight') }}</label>
                            <input type="text" class="form-control" id="total_avg_gross_weight"
                                name="total_avg_gross_weight" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">{{ __('Total Price') }}</label>
                            <input type="currency" class="form-control" id="total_price" name="total_price" readonly>
                        </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion accordion-primary custom-accordion">
        <div class="accordion-row">
            <a href="#" class="accordion-header">
                <span>{{ __('Outter Item Summary') }}</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <table id="tableOuterSummary" class="table table-striped table-bordered Date display nowrap">
                    <thead>
                        <tr>
                            <th class="ProdId">{{ __('Product Id') }}</th>
                            <th class="productName">{{ __('Product name') }}</th>
                            <th class="TotQty">{{ __('TotalQty') }}</th>
                            <th class="TotNetWeight">{{ __('Total Avg Net weight') }}</th>
                            <th class="TotalPrice">{{ __('Total Price') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div class="accordion-row ">
            <a href="#" class="accordion-header">
                <span>{{ __('inner Item Summary') }}</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <table id="tableInnerSummary" class="table table-striped table-bordered Date display nowrap">
                    <thead>
                        <tr>
                            <th class="ProdId">{{ __('Product Id') }}</th>
                            <th class="productName">{{ __('Product name') }}</th>
                            <th class="TotQty">{{ __('TotalQty') }}</th>
                            <th class="TotNetWeight">{{ __('Total Avg Net weight') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- models --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="previousOrderModel">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Previous Orders</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="tablecustomerOrder"
                                            class="table table-striped table-bordered dataTable dtr-inline collapsed"
                                            role="grid" aria-describedby="example1_info">
                                            <thead>
                                                <tr>
                                                    <th class="thId">#</th>
                                                    <th class="thcustomerOrder">{{ __('Customer Order') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">{{ __('Item Details') }}</h6>
                                    <hr>
                                    <div id="PrevNotifyContainer">

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnSelectAll">Select All
                    </button>
                    <button type="button" class="btn btn-primary" id="btnAddPreviousItems">Add</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modelAddItem">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Add Item</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">{{ __('Notify') }}</label>
                            <select class="form-control" name="notify" id="notify">
                                <option value="">-Select-</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">{{ __('Item') }}</label>
                            <select class="form-control" name="item" id="item">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        {{-- <div class="col-md-3 mb-3">
                            <label for="validationCustom01">{{ __('Item Code') }}</label>
                            <input type="text" class="form-control" name="ItemCode" id="ItemCode" readonly>
                        </div> --}}
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="validationCustom01">{{ __('Quantity') }}</label>
                            <input type="text" class="form-control" name="quantity" id="quantity">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="validationCustom01">{{ __('Unit Price') }}</label>
                            <input type="text" class="form-control" name="unitPrice" id="unitPrice">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom02">{{ __('Total Price') }}</label>
                            <input type="email" class="form-control" name="totalPrice" id="totalPrice" readonly>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom02">{{ __('Avg Weight') }}</label>
                            <input type="text" class="form-control" name="AvgWeight" id="AvgWeight" readonly>
                            <input type="hidden" name="AvgGrossWeight" id="AvgGrossWeight" readonly>

                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom02">{{ __('Total Net Weight') }}</label>
                            <input type="test" class="form-control" name="totalNetWeight" id="totalNetWeight"
                                readonly>
                            <input type="hidden" name="totalGrossWeight" id="totalGrossWeight" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnAddToTable">Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    {{-- <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script> --}}
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>
    {{-- searchable select --}}
    <script src="{{ url('vendors/select2/js/select2.min.js') }}"></script>

    <script src="{{ Module::asset('selling:js/masters/customerOrderConfigure.js') }}"></script>
@endsection
