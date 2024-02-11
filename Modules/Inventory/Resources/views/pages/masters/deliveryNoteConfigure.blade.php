@extends('layouts.app')
{{-- @extends('settings::layouts.settingsModuleLayout') --}}
@section('title', 'New Delivery Note')
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('New Delivery Note') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Delivery Note') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('New Delivery Note') }}</li>
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
                    <h6 class="card-title">{{ __('Setup New Delivery Note') }}</h6>
                    <form id="frmdeliveryNoteConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                        
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Delivery Note No') }}</label>
                                <input type="text" class="form-control" name="delivery_note_no" id="Delivery">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Delivery Trip') }}</label>
                                <select class="form-control" name="delivery_trip_id" id="delivery_trip_id">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Customer') }}</label>
                                <select class="form-control" name="customer" id="customer">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Date') }}</label>
                                <input type="date" class="form-control" name="date" id="date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Total Qty') }}</label>
                                <input type="number" class="form-control" name="total_qty" id="total_qty">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Total Gross Weight') }}</label>
                                <input type="number" class="form-control" name="total_gross_weight" id="total_gross_weight">
                            </div>
                        </div>
{{--
                        <div class="form-row">
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
    <script src="{{ Module::asset('inventory:js/masters/deliveryNoteConfigure.js') }}"></script>
@endsection
