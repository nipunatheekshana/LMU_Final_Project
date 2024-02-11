@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}
@section('title', 'New Barcode Type')
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('New Barcode Type') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Barcode Type') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('New Barcode Type') }}</li>
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
                    <h6 class="card-title">{{ __('Setup New Barcode Type') }}</h6>
                    <form id="frmbarcodeTypesConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Barcode Type') }}</label>
                                <input type="text" class="form-control" name="barcodeType" id="barcodeType">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Category') }}</label>
                                <select class="form-control" name="category" id="category">
                                    <option value="">-Select-</option>
                                    <option value="2-D">2-D</option>
                                    <option value="Linear">Linear</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Sample Barcode Image') }}</label>
                                <input type="file" class="form-control" name="sampleImage" id="sampleImage">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Character Set') }}</label>
                                <input type="text" class="form-control" name="characterSet" id="characterSet">
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Length') }}</label>
                                <input type="text" class="form-control" name="length" id="length">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Check sum') }}</label>
                                <input type="text" class="form-control" name="checksum" id="checksum">
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Notes') }}</label>
                                <textarea type="text" class="form-control" name="notes" id="notes"></textarea>
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
    <script src="{{ Module::asset('settings:js/masters/barcodeTypesConfigure.js') }}"></script>
@endsection
