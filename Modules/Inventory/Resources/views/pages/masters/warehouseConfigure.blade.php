@extends('layouts.app')
{{-- @extends('settings::layouts.settingsModuleLayout') --}}
@section('title', 'New Warehouse')
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('New Warehouse') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Warehouse') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('New Warehouse') }}</li>
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
                    <h6 class="card-title">{{ __('Setup New Warehouse') }}</h6>
                    <form id="frmwarehouseConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Warehouse Name') }}</label>
                                <input type="text" class="form-control" name="warehouse_name"
                                    id="warehouse_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Warehouse type') }}</label>
                                <select class="form-control" name="warehouse_type" id="warehouse_type">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Parent warehouse') }}</label>
                                <select class="form-control" name="parent_warehouse" id="parent_warehouse">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Warehouse address 1') }}</label>
                                <input type="text" class="form-control" name="warehouse_address_1"
                                    id="warehouse_address_1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Warehouse address 2') }}</label>
                                <input type="text" class="form-control" name="warehouse_address_2"
                                    id="warehouse_address_2">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Warehouse city') }}</label>
                                <input type="text" class="form-control" name="warehouse_city" id="warehouse_city">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Warehouse state') }}</label>
                                <input type="text" class="form-control" name="warehouse_state" id="warehouse_state">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Warehouse country') }}</label>
                                <select class="form-control" name="warehouse_country" id="warehouse_country">
                                    <option value="">-Select-</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Warehouse email') }}</label>
                                <input type="text" class="form-control" name="warehouse_email" id="warehouse_email">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('warehouse phone') }}</label>
                                <input type="text" class="form-control" name="warehouse_phone" id="warehouse_phone">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Default intransit warehouse') }}</label>
                                <select class="form-control" name="default_intransit_warehouse" id="default_intransit_warehouse">
                                    <option value="">-Select-</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Default account') }}</label>
                                <input type="text" class="form-control" name="default_account" id="default_account">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_group" name="is_group">
                                    <label class="form-check-label" for="exampleCheck1">{{ __('is_group') }}</label>
                                </div>
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
    <script src="{{ Module::asset('inventory:js/masters/warehouseConfigure.js') }}"></script>
@endsection
