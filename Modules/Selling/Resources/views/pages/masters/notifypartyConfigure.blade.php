@extends('layouts.app')
{{-- @extends('crm::layouts.CRMModuleLayout') --}}
@section('title', 'New Notify Party')
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('New Notify Party') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/selling">{{ __('Selling') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/selling/notifyparty_list">{{ __('Notify Party List') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('New Notify Party') }}</li>
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
                    <h6 class="card-title">{{ __('Create New Notify Party') }}</h6>
                    <form id="frmaddressConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Notify Party Name') }}</label>
                                <input type="text" class="form-control" name="AddressTitle" id="AddressTitle">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('E-Mail Address') }}</label>
                                <input type="email" class="form-control" name="emailAddress" id="emailAddress"
                                    required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Phone') }}</label>
                                <input type="text" class="form-control" name="Phone" id="Phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Fax') }}</label>
                                <input type="email" class="form-control" name="Fax" id="Fax" required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Longitude') }}</label>
                                <input type="text" class="form-control" name="Longitude" id="Longitude">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Latitude') }}</label>
                                <input type="email" class="form-control" name="Latitude" id="Latitude" required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('GPS Cordinates (Lat,Long)') }}</label>
                                <input type="text" class="form-control" name="LongLat" id="LongLat">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Address Type') }}</label>
                                <select class="form-control" name="AddressType" id="AddressType">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <!--
                                         <div class="col-md-6 mb-3">

                                            <div class="form-group form-check">
                                                <input type="checkbox" class="form-check-input" id="enabled" name="enabled">
                                                <label class="form-check-label" for="exampleCheck1">{{ __('Enabled') }}</label>
                                            </div>
                                        </div> -->

                        </div>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Address Line 1') }}</label>
                                <input type="text" class="form-control" name="Addressline1" id="Addressline1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Address Line 2') }}</label>
                                <input type="text" class="form-control" name="Addressline2" id="Addressline2">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('City/Town') }}</label>
                                <input type="text" class="form-control" name="CityTown" id="CityTown">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Country') }}</label>
                                <select class="form-control" name="Country" id="Country">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Postal Code') }}</label>
                                <input type="text" class="form-control" name="PostalCode" id="PostalCode">
                            </div>
                            <div class="col-md-6 mb-3">

                            </div>



                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Index') }}</label>
                                <input type="number" class="form-control" name="list_index" id="list_index">
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="enabled" name="enabled"
                                        checked>
                                    <label class="form-check-label" for="exampleCheck1">{{ __('Enabled') }}</label>
                                </div>
                            </div>
                        </div>



                        {{-- <button id="btnSave" class="btn btn-primary" type="button">Save</button> --}}
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('selling:js/masters/notifypartyConfigure.js') }}"></script>
@endsection
