@extends('layouts.app')
{{-- @extends('settings::layouts.settingsModuleLayout') --}}
@section('title', 'New Workstation')
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('New QGRN') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Workstation') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('New Workstation') }}</li>
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
                    <h6 class="card-title">{{ __('Setup New Workstation') }}</h6>
                    <form id="frmQGrnConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('QGRN Date') }}</label>
                                <input type="date" class="form-control" name="qgrn_date" id="qgrn_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('QGRN Type') }}</label>
                                <input type="text" class="form-control" name="qgrn_type" id="qgrn_type">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Batch No') }}</label>
                                <input type="text" class="form-control" name="batch_no" id="batch_no">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Supplier ') }}</label>
                                <select class="form-control" name="supplier_id" id="supplier_id"> </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Supplier Ticket ') }}</label>
                                <select class="form-control" name="supplier_ticket_id" id="supplier_ticket_id"> </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Supplier Vehicle No') }}</label>
                                <input type="text" class="form-control" name="supplier_vehicle_no"
                                    id="supplier_vehicle_no">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Boat ') }}</label>
                                <select class="form-control" name="boat_id" id="boat_id"> </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Boat Registration Number') }}</label>
                                <input type="text" class="form-control" name="boat_registration_number"
                                    id="boat_registration_number">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Boat Licence No') }}</label>
                                <input type="text" class="form-control" name="boat_licence_no" id="boat_licence_no">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Boat Licence Expiry Date') }}</label>
                                <input type="date" class="form-control" name="boat_licence_exp_date"
                                    id="boat_licence_exp_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Boat Skipper Name') }}</label>
                                <input type="text" class="form-control" name="boat_skipper_name" id="boat_skipper_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Boat Number of Crew') }}</label>
                                <input type="number" class="form-control" name="boat_number_of_crew"
                                    id="boat_number_of_crew">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Boat Number of Tanks') }}</label>
                                <input type="number" class="form-control" name="boat_number_of_tanks"
                                    id="boat_number_of_tanks">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Boat Trip Start Date') }}</label>
                                <input type="date" class="form-control" name="boat_trip_start_date"
                                    id="boat_trip_start_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Boat Trip End Date') }}</label>
                                <input type="date" class="form-control" name="boat_trip_end_date"
                                    id="boat_trip_end_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Boat Cooling Method ') }}</label>
                                <select class="form-control" name="boat_cooling_method" id="boat_cooling_method"> </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Boat Fishing Method ID ') }}</label>
                                <select class="form-control" name="boat_fishing_method_id" id="boat_fishing_method_id"> </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Boat Landing Site ID ') }}</label>
                                <select class="form-control" name="boat_landing_site_id" id="boat_landing_site_id"> </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Unload Status') }}</label>
                                <input type="text" class="form-control" name="unload_status" id="unload_status">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Unload Start Time') }}</label>
                                <input type="time" class="form-control" name="unload_start_time"
                                    id="unload_start_time">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Unload End Time') }}</label>
                                <input type="time" class="form-control" name="unload_end_time" id="unload_end_time">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Unload End User ID ') }}</label>
                                <select class="form-control" name="unload_end_user_id" id="unload_end_user_id"> </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Finance Status') }}</label>
                                <input type="text" class="form-control" name="finance_status" id="finance_status">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Voucher Status') }}</label>
                                <input type="text" class="form-control" name="voucher_status" id="voucher_status">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Finance Close Time') }}</label>
                                <input type="time" class="form-control" name="finance_close_time"
                                    id="finance_close_time">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Finance Close User ID ') }}</label>
                                <select class="form-control" name="finance_close_user_id" id="finance_close_user_id"> </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Finance Currency ID Pay ') }}</label>
                                <select class="form-control" name="finance_currency_id_pay" id="finance_currency_id_pay"> </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Finance Gross Value Pay') }}</label>
                                <input type="number" class="form-control" name="finance_gross_value_pay"
                                    id="finance_gross_value_pay">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Finance Currency ID Base ') }}</label>
                                <select class="form-control" name="finance_currency_id_base" id="finance_currency_id_base"> </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Finance Gross Value Base') }}</label>
                                <input type="number" class="form-control" name="finance_gross_value_base"
                                    id="finance_gross_value_base">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Costing Export Income') }}</label>
                                <input type="number" class="form-control" name="costing_export_income"
                                    id="costing_export_income">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Costing Local Sale Income') }}</label>
                                <input type="number" class="form-control" name="costing_localsale_income"
                                    id="costing_localsale_income">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Total Quantity') }}</label>
                                <input type="number" class="form-control" name="total_qty" id="total_qty">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Total Fish Weight') }}</label>
                                <input type="number" class="form-control" name="total_fish_weight"
                                    id="total_fish_weight">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Unprocessed Pieces') }}</label>
                                <input type="number" class="form-control" name="unprocessed_pcs" id="unprocessed_pcs">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Processed Pieces') }}</label>
                                <input type="number" class="form-control" name="processed_pcs" id="processed_pcs">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Transfer Pieces') }}</label>
                                <input type="number" class="form-control" name="transfer_pcs" id="transfer_pcs">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Reject Pieces') }}</label>
                                <input type="number" class="form-control" name="reject_pcs" id="reject_pcs">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Receive Hold Reason') }}</label>
                                <input type="text" class="form-control" name="receive_hold_reason"
                                    id="receive_hold_reason">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Finance Close Reason') }}</label>
                                <input type="text" class="form-control" name="finance_close_reason"
                                    id="finance_close_reason">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Voucher Close Reason') }}</label>
                                <input type="text" class="form-control" name="voucher_close_reason"
                                    id="voucher_close_reason">
                            </div>
                        </div>


                        {{-- <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="isInternal" name="isInternal">
                                    <label class="form-check-label" for="exampleCheck1">{{ __('isInternal') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="enabled" name="enabled" checked>
                                    <label class="form-check-label" for="exampleCheck1">{{ __('Enabled') }}</label>
                                </div>

                            </div>


                        </div> --}}

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('buying:js/masters/QGrnConfigure.js') }}"></script>
@endsection
