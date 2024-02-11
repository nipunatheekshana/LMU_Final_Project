@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "GRN History" @endphp

@section('title',$title)

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
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
            <h3>{{ __('GRN History List') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashbord-Parent">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/buying">{{ __('Buying') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('GRN History') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('GRN Details ') }}</h6>

                    <div class="form-row">

                        <div class="col-md-2 mb-3">
                            <label for="validationCustom02">{{ __('Supplier') }}</label>
                            <select class="form-control" name="supplier" id="supplier">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom02">{{ __('Boat') }}</label>
                            <select class="form-control" name="boat" id="boat">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom02">{{ __('Type') }}</label>
                            <select class="form-control" name="type" id="type">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="validationCustom02">{{ __('Date Range') }}</label>
                            <input type="text" class="form-control" name="date" id="date">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="validationCustom01">{{ __('Search') }}</label>

                            <div class="input-group">
                                <input type="text" class="form-control" id="tableSearch" placeholder="Search here">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            data-feather="search"></i></span>
                                </div>
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
                    <div class="table-responsive">
                        <table id="tableGrnHistory" class="table table-striped Date display nowrap">
                            <thead>
                                <tr>
                                    <th class="thGrnNo">{{ __('Grn No') }}</th>
                                    <th class="thGRNDate">{{ __('GRN Date') }}</th>
                                    <th class="thType">{{ __('Type') }}</th>
                                    <th class="thSupplier">{{ __('Supplier') }}</th>
                                    <th class="thTotalQty"> {{ __('Total Qty') }}</th>
                                    <th class="thTotalWeight">{{ __('Total Weight') }}</th>
                                    <th class="thUnprocessedPCs">{{ __('Unprocessed PCs') }}</th>
                                    <th class="thProcessedPcs">{{ __('Processed Pcs') }}</th>
                                    <th class="thTransferPcs">{{ __('Transfer Pcs') }}</th>
                                    <th class="thRejectPcs">{{ __('Reject Pcs') }}</th>
                                    <th class="thReceivingStatus">{{ __('Receiving Status') }}</th>
                                    <th class="thFinanceStatus">{{ __('Finance Status') }}</th>
                                    <th class="thVoucherStatus">{{ __('Voucher Status') }}</th>
                                    <th class="thGrnNo2">{{ __('Grn No') }}</th>
                                    <th class="thAction">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ url('vendors/dataTable/FixedColumns-3.3.0/js/fixedColumns.bootstrap4.js') }}"></script>
    <script src="{{ url('vendors/dataTable/FixedColumns-3.3.0/js/dataTables.fixedColumns.min.js') }}"></script>

    {{-- <script src="{{ url('assets/js/custom/Admin_level/configurations/supplierGroup.js') }}"></script> --}}
    <script src="{{ url('vendors/datepicker/daterangepicker.js') }}"></script>

    <script src="{{ Module::asset('buying:js/masters/grnHistory.js') }}"></script>
@endsection
