@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
    {{-- searchable select --}}
    <link rel="stylesheet" href="{{ url('vendors/select2/css/select2.min.css') }}" type="text/css">
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-2">
                            <h6 class="card-title">{{ __('Item Details') }}</h6>
                        </div>

                        <div class="col-md-7">
                            <button id="btnAddNotifyParty" class="btn btn-primary" style="float: right"
                                type="button">Add Notify Party</button>
                        </div>
                        <div class="col-md-3">
                            <button id="btnPreviousOrders" class="btn btn-secondary" style="float: right"
                                type="button">Add Items From Previous Orders</button>
                        </div>
                    </div>
                    <hr>
                    <div id="notifyContainer">
                    </div>

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
                <div id="OutterSummaryContainer"></div>
            </div>
        </div>
        <div class="accordion-row ">
            <a href="#" class="accordion-header">
                <span>{{ __('inner Item Summary') }}</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <div id="innerSummaryContainer">

                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Outter Item Summary') }}</h6>
                    <hr>
                    <div id="OutterSummaryContainer"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('inner Item Summary') }}</h6>
                    <hr>
                    <div id="innerSummaryContainer">

                    </div>
                </div>
            </div>
        </div>
    </div> --}}
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
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="notifyPartyModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Notify Party</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="tableNotify" class="table table-striped table-bordered dataTable dtr-inline collapsed"
                            role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thnotify">{{ __('Notify') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary">Add
                    </button>
                    <button type="button" class="btn btn-primary">Add</button> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="ItemModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Items</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="tableItem" class="table table-striped table-bordered dataTable dtr-inline collapsed"
                            role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thItem">{{ __('Item') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary">Add
                    </button>
                    <button type="button" class="btn btn-primary">Add</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    {{-- searchable select --}}
    <script src="{{ url('vendors/select2/js/select2.min.js') }}"></script>

    <script src="{{ Module::asset('selling:js/masters/customerOrderConfigure.js') }}"></script>
@endsection
