@extends('layouts.app')
{{-- @extends('settings::layouts.settingsModuleLayout') --}}
@section('title', 'New Vehicle')
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('New Vehicle') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Vehicle') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('New Vehicle') }}</li>
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
                    <h6 class="card-title">{{ __('Setup New Vehicle') }}</h6>
                    <form id="frmvehicleConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('License plate') }}</label>
                                <input type="text" class="form-control" name="license_plate" id="license_plate">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Make') }}</label>
                                <input type="text" class="form-control" name="make" id="make">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Model') }}</label>
                                <input type="text" class="form-control" name="model" id="model">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Engine no') }}</label>
                                <input type="text" class="form-control" name="engine_no" id="engine_no">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Engine no') }}</label>
                                <input type="text" class="form-control" name="engine_no" id="engine_no">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Chassis no') }}</label>
                                <input type="text" class="form-control" name="chassis_no" id="chassis_no">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Fuel type') }}</label>
                                <input type="text" class="form-control" name="fuel_type" id="fuel_type">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Acquisition date') }}</label>
                                <input type="date" class="form-control" name="acquisition_date" id="acquisition_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Acquisition value') }}</label>
                                <input type="number" class="form-control" name="acquisition_value" id="acquisition_value">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Ownership') }}</label>
                                <input type="text" class="form-control" name="ownership" id="ownership">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Type') }}</label>
                                <select class="form-control" name="type" id="type">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Last odometer value') }}</label>
                                <input type="text" class="form-control" name="last_odometer_value" id="last_odometer_value">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Last odometer date time') }}</label>
                                <input type="date" class="form-control" name="last_odometer_date_time" id="last_odometer_date_time">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Location') }}</label>
                                <input type="text" class="form-control" name="location" id="location">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Default driver') }}</label>
                                <select class="form-control" name="default_driver" id="default_driver">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Insuarance policy no') }}</label>
                                <input type="text" class="form-control" name="insuarance_policy_no" id="insuarance_policy_no">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Insuarance company') }}</label>
                                <input type="text" class="form-control" name="insuarance_company" id="insuarance_company">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Insuarance valid till') }}</label>
                                <input type="date" class="form-control" name="insuarance_valid_till" id="insuarance_valid_till">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Revenue licence no') }}</label>
                                <input type="text" class="form-control" name="revenue_licence_no" id="revenue_licence_no">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Revenue licence valid till') }}</label>
                                <input type="date" class="form-control" name="revenue_licence_valid_till" id="revenue_licence_valid_till">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Emission test no') }}</label>
                                <input type="text" class="form-control" name="emission_test_no" id="emission_test_no">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Emission test company') }}</label>
                                <input type="text" class="form-control" name="emission_test_company" id="emission_test_company">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Emission test valid till') }}</label>
                                <input type="date" class="form-control" name="emission_test_valid_till" id="emission_test_valid_till">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Emission test no') }}</label>
                                <input type="text" class="form-control" name="emission_test_no" id="emission_test_no">
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

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('settings:js/masters/vehicleConfigure.js') }}"></script>
@endsection
