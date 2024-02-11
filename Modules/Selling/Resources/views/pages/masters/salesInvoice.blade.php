@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "Sales Invoice List" @endphp

@section('title', $title)

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('vendors/select2/css/select2.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('vendors/datepicker/daterangepicker.css') }}" type="text/css">

    <style>
        .dataTables_filter {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('Sales Invoice List') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="\dashbord-Parent">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="\selling">{{ __('Selling') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Sales Invoice') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button id="btnCreateNew" class="btn btn-primary mb-3" style="float: right" type="button"></button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">All Sale Invoices</h6>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="daterange">Date Range</label>
                                <input type="text" name="datefilter" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="customer">Customer</label>
                                <select class="form-control select2" id="customer">
                                    <option value="">-Select-</option>
                                    <option value="7 Seas Fish Inc.">7 Seas Fish Inc.</option>
                                    <option value="Wallmart Inc.">Wallmart Inc.</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="notify">Notify Party</label>
                                <select class="form-control select2" id="notify">
                                    <option value="">-Select-</option>
                                    <option value="Wallmart Inc.">Wallmart Inc.</option>
                                    <option value="7 Seas Fish Inc.">7 Seas Fish Inc.</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="process_status">Process Status</label>
                                <select class="form-control select2" id="process_status">
                                    <option value="">-Select-</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Set">Set</option>
                                    <option value="Done">Done</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="notify">Search</label>
                                <input type="text" id="myInputTextField" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive" tabindex="5" style="overflow: hidden; outline: none;">
                        <div id="orders_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="sales_invoices" class="table table-striped" role="grid"
                                        aria-describedby="orders_info">
                                        <thead>
                                            <tr>
                                                <th class="thInvNo">Inv No</th>
                                                <th class="thInvDate">Inv Date</th>
                                                <th class="thCustomer</">Customer</th>
                                                <th class="thNotify</">Notify</th>
                                                <th class="thPLNo">PL No</th>
                                                <th class="thShipmentNo">Shipment No</th>
                                                <th class="thCusOrdNo">Cus Ord No</th>
                                                <th class="thAWBNo">AWB No</th>
                                                <th class="thFlightNo">Flight No</th>
                                                <th class="thGrossValue">Gross Value</th>
                                                <th class="thFreight">Freight</th>
                                                <th class="thDiscount">Discount</th>
                                                <th class="thNetValue">Net Value</th>
                                                <th class="thProcessStatus">Process Status</th>
                                                <th class="thPMChargesStatus">PM Charges Status</th>
                                                <th class="thOtherCharges">Other Charges Status</th>
                                                <th class="thDisbursementStatus">Disbursement Status</th>
                                                <th class="Actions">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- <tr role="row" class="odd">
                                                <td><a href="/selling/salesinvoice_configure?3013">3013</a></td>
                                                <td><a>2023-01-12</a></td>
                                                <td><a href="/selling/customer_configure?1">7 Seas Fish Inc.</a></td>
                                                <td><a>Wallmart Inc.</a></td>
                                                <td><a href="/mnu/packingDetails">PL54257</a></td>
                                                <td><a>1056</a></td>
                                                <td><a>CO221230545</a></td>
                                                <td><a>AWB6075886</a></td>
                                                <td><a>EK999</a></td>
                                                <td><a>$ 1,054.24</a></td>
                                                <td><a>$ 24.00</a></td>
                                                <td><a>$ 0.00</a></td>
                                                <td><a>$ 1,078.24</a></td>
                                                <td><span class="badge bg-warning-bright text-warning">Pending</span></td>
                                                <td><span class="badge bg-success-bright text-success">Set</span></td>
                                                <td><span class="badge bg-warning-bright text-warning">Pending</span></td>
                                                <td><span class="badge bg-success-bright text-success">Done</span></td>
                                                <td class="text-center">
                                                    <button class="btn btn-primary mr-1" onclick="edit(' + id + ')"><i
                                                            class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                    <button class="btn btn-danger mr-1" onclick="_delete(' + id + ')"><i
                                                            class="fa fa-trash" aria-hidden="true"></i></button>
                                                </td>
                                            </tr> --}}

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    {{-- <script src="{{ url('assets/js/custom/Admin_level/configurations/supplierGroup.js') }}"></script> --}}
    <script src="{{ Module::asset('selling:js/masters/salesInvoice.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ url('vendors/select2/js/select2.min.js') }}"></script>
    <!-- Date Range Picker -->
    <script src="{{ url('vendors/datepicker/daterangepicker.js') }}"></script>
@endsection
