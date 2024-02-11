@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
    {{-- searchable select --}}
    <link rel="stylesheet" href="{{ url('vendors/select2/css/select2.min.css') }}" type="text/css">

    <style>
        .dataTables_filter {
            display: none;
        }

        .t-right {
            text-align: right;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('New Sales Invoice') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="\dashbord-Parent">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="\selling">{{ __('Selling') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="\selling\salesinvoice_list">{{ __('Sales Invoice') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('New Sales Invoice') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mb-3 d-flex justify-content-end">
        <div class="col-md-3 mb-2">
            <button id="btnSelectPL" name="btnSelectPL" class="btn btn-primary btn-block">Select PL<i
                    class="ti-arrow-circle-right ml-2"></i></button>
        </div>
        <div class="col-md-3 mb-2">
            <button id="btnSave" class="btn btn-success btn-block" style="float: right" type="button">Save</button>
        </div>
    </div>

    <form id="frmsalesInvoiceHeader" autocomplete="off">

        <div class="row">
            {{-- Invoice Details Column --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('Invoice Number') }}</label>
                                    <input type="text" class="form-control" name="invoice_number" id="invoice_number"
                                        readonly value="New">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('Invoice Date') }}</label>
                                    <input type="date" class="form-control" name="invoice_date" id="invoice_date">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('Due Date') }}</label>
                                    <input type="date" class="form-control" name="due_date" id="due_date">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('Order Number') }}</label>
                                    <input type="text" class="form-control" name="order_number" id="order_number"
                                        readonly>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('PO Number') }}</label>
                                    <input type="text" class="form-control" name="po_number" id="po_number" readonly>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Packing Details Column --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('Packing List No') }}</label>
                                    <input type="text" class="form-control" name="plumberN" id="plumberN" readonly>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('WS No') }}</label>
                                    <input type="text" class="form-control" name="ws_id" id="ws_id" readonly>
                                </div>


                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('AWB No') }}</label>
                                    <input type="text" class="form-control" name="awb_no" id="awb_no" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">{{ __('Flight No') }}</label>
                                    <input type="text" class="form-control" name="flight_no" id="flight_no" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">{{ __('Flight Date') }}</label>
                                    <input type="text" class="form-control" name="flight_date" id="flight_date"
                                        readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">{{ __('Shipment No') }}</label>
                                    <input type="text" class="form-control" name="shipment_no" id="shipment_no"
                                        readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">{{ __('Destination') }}</label>
                                    <input type="text" class="form-control" name="Destinatination_name"
                                        id="Destinatination_name" readonly>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Customer Address Columm --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('Customer') }}</label>
                                    <input type="text" class="form-control" name="Customer" id="Customer" readonly>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('Address Line 1') }}</label>
                                    <input type="text" class="form-control" name="consignee_add1"
                                        id="consignee_add1">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('Address Line 2') }}</label>
                                    <input type="text" class="form-control" name="consignee_add2"
                                        id="consignee_add2">
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="validationCustom01">{{ __('City/Town') }}</label>
                                    <input type="text" class="form-control" name="consignee_city_towm"
                                        id="consignee_city_towm">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">{{ __('Postal') }}</label>
                                    <input type="text" class="form-control" name="consignee_postal_code"
                                        id="consignee_postal_code">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('Country') }}</label>
                                    <input type="text" class="form-control" name="consignee_country"
                                        id="consignee_country">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notify Address Columm --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('Notify Party') }}</label>
                                    <input type="text" class="form-control" name="notify" id="notify" readonly>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('Address Line 1') }}</label>
                                    <input type="text" class="form-control" name="notify_add1" id="notify_add1">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('Address Line 2') }}</label>
                                    <input type="text" class="form-control" name="notify_add2" id="notify_add2">
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="validationCustom01">{{ __('City/Town') }}</label>
                                    <input type="text" class="form-control" name="notify_city_towm"
                                        id="notify_city_towm">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">{{ __('Postal') }}</label>
                                    <input type="text" class="form-control" name="notify_postal_code"
                                        id="notify_postal_code">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom01">{{ __('Country') }}</label>
                                    <input type="text" class="form-control" name="notify_country"
                                        id="notify_country">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="accordion accordion-primary custom-accordion">
                            <div class="accordion-row ">
                                <a href="#" class="accordion-header">
                                    <h6 class="card-title mb-0 mt-1">{{ __('Other Details') }}</h6>
                                    <i class="accordion-status-icon close fa fa-chevron-up"></i>
                                    <i class="accordion-status-icon open fa fa-chevron-down"></i>
                                </a>
                                <div class="accordion-body">
                                    <div class="row">
                                        {{-- Invoice Details Column --}}
                                        <div class="col-md-6">
                                            {{-- <div class="card"> --}}
                                            {{-- <div class="card-body"> --}}
                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="validationCustom01">{{ __('GRN Nos') }}</label>
                                                    <input type="text" class="form-control" name="grn_nos_list"
                                                        id="grn_nos_list" readonly>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="validationCustom01">{{ __('Batch Nos') }}</label>
                                                    <input type="text" class="form-control" name="batch_nos_list"
                                                        id="batch_nos_list" readonly>
                                                </div>
                                            </div>
                                            {{-- </div> --}}
                                            {{-- </div> --}}
                                        </div>
                                        <div class="col-md-3">
                                            {{-- <div class="card"> --}}
                                            {{-- <div class="card-body"> --}}
                                            <div class="form-row">

                                                <div class="col-md-12 w-100 mb-3">
                                                    <label for="validationCustom02">{{ __('Shipping Term') }}</label>
                                                    <select class="form-control" name="shipping_term" id="shipping_term"></select>
                                                </div>
                                                <div class="col-md-12 w-100 mb-3">
                                                    <label for="validationCustom02">{{ __('Currency') }}</label>
                                                    <select class="form-control" name="currency" id="currency"> </select>
                                                </div>
                                            </div>
                                            {{-- </div> --}}
                                            {{-- </div> --}}
                                        </div>
                                        <div class="col-md-3">
                                            {{-- <div class="card"> --}}
                                            {{-- <div class="card-body"> --}}
                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="validationCustom01"><span
                                                            id="currLable"></span>{{ __(' Rate') }}</label>
                                                    <input type="text" class="form-control" name="defaultCurrRate"
                                                        id="defaultCurrRate" readonly>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="validationCustom01"><span
                                                            id="basscurrLable"></span>{{ __(' Rate') }}</label>
                                                    <input type="text" class="form-control" name="baseCurrRate"
                                                        id="baseCurrRate" readonly>
                                                </div>
                                            </div>
                                            {{-- </div> --}}
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- </div>
            </div>
        </div>
    </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body"> --}}
                        <div class="accordion accordion-primary custom-accordion mt-4">
                            <div class="accordion-row">
                                <a href="#" class="accordion-header">
                                    <h6 class="card-title mb-0 mt-1">{{ __('Bank Details') }}</h6>
                                    <i class="accordion-status-icon close fa fa-chevron-up"></i>
                                    <i class="accordion-status-icon open fa fa-chevron-down"></i>
                                </a>
                                <div class="accordion-body">
                                    <div class="row">
                                        {{-- Bank Details Column --}}
                                        <div class="col-md-12">
                                            {{-- <div class="card"> --}}
                                            {{-- <div class="card-body"> --}}
                                            {{-- <h6 class="card-title">{{ __('Bank Details') }}</h6> --}}
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom01">{{ __('Bank Account') }}</label>
                                                    <select class="form-control" name="bank_account"
                                                        id="bank_account"></select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom01">{{ __('Bank Name') }}</label>
                                                    <input type="text" class="form-control" name="bank_name"
                                                        id="bank_name" readonly>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom01">{{ __('Branch Name') }}</label>
                                                    <input type="text" class="form-control" name="branch"
                                                        id="branch" readonly>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom01">{{ __('Account Name') }}</label>
                                                    <input type="text" class="form-control" name="account_name"
                                                        id="account_name" readonly>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom01">{{ __('Account Number') }}</label>
                                                    <input type="text" class="form-control" name="account_number"
                                                        id="account_number" readonly>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom01">{{ __('SWIFT Code') }}</label>
                                                    <input type="text" class="form-control" name="swift_code"
                                                        id="swift_code" readonly>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom01">{{ __('Corresponding Bank') }}</label>
                                                    <select class="form-control" name="bank" id="bank"></select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom01">{{ __('Comments') }}</label>
                                                    <input type="text" class="form-control" name="invoice_number"
                                                        id="invoice_number">
                                                </div>
                                            </div>
                                            {{-- </div> --}}
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{-- Invoice items Section --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-0">{{ __('Invoice Details') }}</h6>
                        <div class="row ">
                            <div class="col-md-12 mb-3">
                                <button class="btn btn-danger " style="float: right" type="button"
                                    id="btnReset">Reset</button>
                            </div>
                        </div>

                        <table id="tblInvoiceItems" class="table table-striped Date display">
                            <thead>
                                <tr>
                                    <th class="thNo">{{ __('No') }}</th>
                                    <th class="thProdCode">{{ __('Product Code') }}</th>
                                    <th class="thproductName">{{ __('Product name') }}</th>
                                    <th class="thBoxesQty">{{ __('Boxes Qty') }}</th>
                                    <th class="thNetWg">{{ __('Net Weight') }}</th>
                                    <th class="thGrossWg">{{ __('Gross Weight') }}</th>
                                    <th class="thRate">{{ __('Rate') }}</th>
                                    <th class="thTotalPrice">{{ __('Total Price') }}</th>
                                    <th class="thAction">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                <td>1</td>
                                <td>TUN-LO-25KG-BOX</td>
                                <td>Tuna Loin 25KG Box Wrapped</td>
                                <td>15</td>
                                <td>372.88 KG</td>
                                <td>$ 25.00</td>
                                <td>$ 9,322.00</td>
                                <td>
                                    <button class="btn btn-primary btn-sm mr-1" id="btnEdit"><i
                                            class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                    <button class="btn btn-danger btn-sm mr-1" onclick="del(' + id + ')"><i
                                            class="fa fa-trash" aria-hidden="true"></i></button>
                                </td>
                            </tr> --}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <h6 class="card-title m-0">Total Box</h6>
                        <div class="d-flex align-items-center mb-0">
                            <p class="m-0 ml-0" id="lbl_totalBoxes">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <h6 class="card-title m-0">Not Priced</h6>
                        <div class="d-flex align-items-center mb-0">
                            <p class="m-0 ml-0" id="lbl_notPricedBoxes">-</p>
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

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label pr-0 ">Gross Weight</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control t-right" id="totGrossWeight" readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 col-form-label pr-0">Net Weight</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control t-right" id="totNetWeight" readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 col-form-label pr-0 ">Total Price</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control t-right" id="totPriice" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">Freight</div>
                            <div class="col-sm-2">
                                <select class="form-control" name="freight_type" id="freight_type">
                                    <option value="1">On Gross Weight</option>
                                    <option value="2">On Net Weight</option>
                                    <option value="3">On Total</option>
                                    <option value="4">On Actual</option>
                                </select>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 col-form-label pr-0">Freight</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="freightVal">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 col-form-label pr-0">Freight Total</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control t-right" name="freightTot" id="freightTot" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">Discount Type</div>
                            <div class="col-sm-2">
                                <select class="form-control" id="discountType">
                                    <option value="1">Percentage Based</option>
                                    <option value="2">Value Based</option>
                                </select>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 col-form-label pr-0">Discount</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="discountVal">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 col-form-label pr-0">Discount Total</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control t-right" id="discountTot" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label pr-0">Payment Terms</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="payment_term"> </select>
                            </div>
                            <label for="grandtotal" class="col-sm-2 col-form-label pr-0">Grand Total</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-lg bg-warning-bright t-right"
                                    id="grandtotal" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleFormControlTextarea1" class="col-sm-2 col-form-label pr-0">Invoice
                                Remarks</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="inv_comment" name="inv_comment" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    {{-- Modals --}}

    {{-- Select Packing List --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalSelectPL">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pending for Invoicing Packing Lists</h5>
                    <div>
                        <button type="button" class="btn btn-primary mr-3" id="btnAddToPl">Add PL</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </button>
                    </div>

                </div>
                <div class="modal-body pt-0">
                    <h6 class="card-title">{{ __('Packing Lists') }}</h6>
                    <table id="tblModalPackingLists" class="table table-striped Date display">
                        <thead>
                            <tr>
                                <th class="thPLNo">{{ __('PL No') }}</th>
                                <th class="thPLDate">{{ __('PL Date') }}</th>
                                <th class="thCustomer">{{ __('Customer') }}</th>
                                <th class="thNotify">{{ __('Notify Party') }}</th>
                                <th class="thOrderNo">{{ __('Order No') }}</th>
                                <th class="thPONo">{{ __('PO No') }}</th>
                                <th class="thAWBNo">{{ __('AWB No') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <hr>
                    <h6 class="card-title">{{ __('Selected Packing List Details') }}</h6>


                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-1 col-form-label pr-0">PL#</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="modalSelectPL_plno" readonly>
                        </div>
                        <label for="inputEmail3" class="col-sm-1 col-form-label pr-0">Date</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="modalSelectPL_pldate" readonly>
                        </div>
                        <label for="inputEmail3" class="col-sm-1 col-form-label pr-0">Order#</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="modalSelectPL_orderNum" readonly>
                        </div>
                        <label for="inputEmail3" class="col-sm-1 col-form-label pr-0">Date</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="modalSelectPL_orderDate" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-1 col-form-label pr-0">Customer</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="modalSelectPL_Customer" readonly>
                        </div>
                        <label for="inputEmail3" class="col-sm-1 col-form-label pr-0">Notify</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="modalSelectPL_Notify" readonly>
                        </div>
                    </div>

                    <table id="tblModalPackingListDetails" class="table table-striped Date display">
                        <thead>
                            <tr>
                                <th class="thProduct">{{ __('Product') }}</th>
                                <th class="thQty">{{ __('Qty') }}</th>
                                <th class="thNetWeight">{{ __('Net Weight') }}</th>
                                <th class="thGrossWeight">{{ __('Gross Weight') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Row --}}
    <div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-hidden="true" id="modalAddNewRow">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <h5 class="modal-title">Add Row</h5>
                    <div>
                        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </button>
                    </div>
                </div>

                <div class="modal-body">
                    <hr class="mt-0">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <h6>Pending Items</h6>
                            <table id="tblModalPendingBoxesSummary" class="table table-striped Date display">
                                <thead class="text-center">
                                    <tr>
                                        <th class="thProductCode">{{ __('Product Code') }}</th>
                                        <th class="thProductName">{{ __('Product Name') }}</th>
                                        <th class="thPendingQty">{{ __('Pending Qty') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td>TUN-LO-25KG-BOX</td>
                                        <td>Tuna Loin 25KG Box Wrapped</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td>TUN-CC-15KG-BOX</td>
                                        <td>Tuna CC 15KG Box Wrapped</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>TUN-WHOLE-25KG-BOX</td>
                                        <td>Tuna Whole 25KG Box Wrapped</td>
                                        <td>1</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <h6>Pending Boxes</h6>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="inputEmail3" class="col-sm-6 col-form-label pr-0">Sel. Qty</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputEmail3" readonly>
                        </div>
                        <div class="col-sm-3">
                            <label for="inputEmail3" class="col-sm-6 col-form-label pr-0">Sel. Wgh</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputEmail3" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="inputEmail3" class="col-sm-6 col-form-label pr-0">Rate</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" id="inputEmail3">
                        </div>
                        <div class="col-sm-3">
                            <label for="inputEmail3" class="col-sm-6 col-form-label pr-0">Total</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputEmail3" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">

                            <table id="tblModalPendingBoxes" class="table table-striped Date display">
                                <thead class="text-center">
                                    <tr>
                                        <th class="thBoxNo">{{ __('Box No') }}</th>
                                        <th class="thNetWeight">{{ __('Net Weight') }}</th>
                                        <th class="thGrossWeight">{{ __('Gross Weight') }}</th>
                                        <th class="thActions">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td>1</td>
                                        <td>623.45 KG</td>
                                        <td>623.45 KG</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck21"
                                                    checked>
                                                <label class="custom-control-label" for="customCheck21"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>623.45 KG</td>
                                        <td>623.45 KG</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck22"
                                                    checked>
                                                <label class="custom-control-label" for="customCheck22"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>623.45 KG</td>
                                        <td>623.45 KG</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck23"
                                                    checked>
                                                <label class="custom-control-label" for="customCheck23"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>623.45 KG</td>
                                        <td>623.45 KG</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck24"
                                                    checked>
                                                <label class="custom-control-label" for="customCheck24"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>623.45 KG</td>
                                        <td>623.45 KG</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck25"
                                                    checked>
                                                <label class="custom-control-label" for="customCheck25"></label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-light" id="btnSelectall1">Select All</button>
                        <button type="button" class="btn btn-primary btn-md ml-3" id="btnAddToTable">Add</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Edit Row --}}
    <div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-hidden="true" id="modalEditRow">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Row | No : 5</h5>
                    <div>

                        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </button>
                    </div>

                </div>

                <div class="modal-body py-4">

                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="inputEmail3" class="col-sm-6 col-form-label pr-0">Item</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="modalEditRow_itemName" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="inputEmail3" class="col-sm-6 col-form-label pr-0">Sel. Qty</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="modalEditRow_selQty" readonly>
                        </div>
                        <div class="col-sm-3">
                            <label for="inputEmail3" class="col-sm-6 col-form-label pr-0">Sel. Net Wgh</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="modalEditRow_selWeight" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="inputEmail3" class="col-sm-6 col-form-label pr-0">Rate</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" id="modalEditRow_Rate">
                        </div>
                        <div class="col-sm-3">
                            <label for="inputEmail3" class="col-sm-6 col-form-label pr-0">Total</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="modalEditRow_tot" readonly>
                        </div>
                    </div>
                    <hr>
                    <h6>Current Boxes</h6>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="tblSelectedBoxDetails" class="table table-striped Date display">
                                <thead class="text-center">
                                    <tr>
                                        <th class="thBoxNo">{{ __('Box No') }}</th>
                                        <th class="thNetWeight">{{ __('Net Weight') }}</th>
                                        <th class="thGrossWeight">{{ __('Gross Weight') }}</th>
                                        <th class="thActions">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    {{-- <tr>
                                            <td>1</td>
                                            <td>623.45 KG</td>
                                            <td>623.45 KG</td>
                                            <td class="text-center">
                                                <button class="btn btn-danger btn-sm"><i class="fa fa-minus "
                                                        aria-hidden="true"></i></button>
                                            </td>
                                        </tr> --}}

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <hr>
                            <h6>Add to New Row</h6>
                        </div>
                        <div class="col-sm-12">
                            <table id="tblDeSelectedBoxDetails" class="table table-striped Date display">
                                <thead class="text-center">
                                    <tr>
                                        <th class="thBoxNo">{{ __('Box No') }}</th>
                                        <th class="thNetWeight">{{ __('Net Weight') }}</th>
                                        <th class="thGrossWeight">{{ __('Gross Weight') }}</th>
                                        <th class="thActions">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    {{-- <tr>
                                            <td>1</td>
                                            <td>623.45 KG</td>
                                            <td>623.45 KG</td>
                                            <td class="text-center">
                                                <button class="btn btn-success btn-sm"><i class="fa fa-plus"
                                                        aria-hidden="true"></i></button>
                                            </td>
                                        </tr> --}}

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-primary btn-md ml-3"
                            id="modalEditRow_btnUpdate">Update</button>
                    </div>
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



    <script src="{{ Module::asset('selling:js/masters/salesInvoiceConfigure.js') }}"></script>
@endsection
