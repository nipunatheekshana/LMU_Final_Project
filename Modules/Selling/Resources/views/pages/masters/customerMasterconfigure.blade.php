@extends('layouts.app')
{{-- @extends('selling::layouts.SellingModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "Customer" @endphp

@section('title', $title)

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('Customer') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/selling">{{ __('Selling') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/selling/customer_master">{{ __('Customers List') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Customer') }}</li>
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
                    <h6 class="card-title">{{ __('Customer Details') }}</h6>
                    <form id="frmcustomerMasterconfigure" autocomplete="off">
                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Customer Code') }}</label>
                                <input type="text" class="form-control" name="CusCode" id="CusCode">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Customer Name') }}</label>
                                <input type="text" class="form-control" name="CusName" id="CusName">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Customer Registration Number') }}</label>
                                <input type="text" class="form-control" name="CusRegNo" id="CusRegNo">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Customer Type') }}</label>
                                <select class="form-control" name="CusType" id="CusType">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Customer Group') }}</label>
                                <select class="form-control" name="CusGroup" id="CusGroup">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Country') }}</label>
                                <select class="form-control" name="CusCountry" id="CusCountry">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Default Billing Currency') }}</label>
                                <select class="form-control" name="BillingCurrency" id="BillingCurrency">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Default Language') }}</label>
                                <select class="form-control" name="DefltLanguage" id="DefltLanguage">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Primary Contact Person') }}</label>
                                <select class="form-control" name="PrimaryContactPerson" id="PrimaryContactPerson">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Primary Contact Address') }}</label>
                                <select class="form-control" name="PrimaryContactAddress" id="PrimaryContactAddress">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Mobile Number') }}</label>
                                <input type="number" class="form-control" name="MobileNo" id="MobileNo">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('E-Mail Address') }}</label>
                                <input type="email" class="form-control" name="emailAddress" id="emailAddress">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Licence Number') }}</label>
                                <input type="text" class="form-control" name="LicenceNo" id="LicenceNo">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Price List') }}</label>
                                <select class="form-control" name="PriceList" id="PriceList">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Primary Bank Account') }}</label>
                                <input type="text" class="form-control" name="PrimaryBankAccount"
                                    id="PrimaryBankAccount">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Logo') }}</label>
                                <input type="file" class="form-control" name="logo" id="logo">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Max Fish Age (Days)') }}</label>
                                <input type="number" class="form-control" name="max_fish_age" id="max_fish_age">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Index') }}</label>
                                <input type="number" class="form-control" name="list_index" id="list_index">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_internal_customer"
                                        name="is_internal_customer">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Is Internal Customer?') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="enabled" name="enabled"
                                        checked>
                                    <label class="form-check-label" for="exampleCheck1">{{ __('Enabled?') }}</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Addresses & Contacts') }}</h6>
                    <div class="accordion accordion-primary custom-accordion" id="addressAndContactContainer">
                        <div class="accordion-row">
                            <a href="#" class="accordion-header">
                                <span><strong>Address</strong></span>
                                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                                <i class="accordion-status-icon open fa fa-chevron-down"></i>
                            </a>
                            <div class="accordion-body">
                                {{-- id="addressContainer" --}}
                                <div class="row" id="addressContainer">


                                </div>
                                <button type="button" id="btnNewAddress" class="btn btn-dark btn-sm m-2">New
                                    Address</button>
                                <button type="button" id="btnExistingAddress" class="btn btn-dark btn-sm m-2">Link
                                    Address</button>
                            </div>
                        </div>
                        <div class="accordion-row">
                            <a href="#" class="accordion-header">
                                <span><strong>Notify Parties</strong></span>
                                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                                <i class="accordion-status-icon open fa fa-chevron-down"></i>
                            </a>
                            <div class="accordion-body">
                                <div class="row" id="NotifyPartyContainer">
                                </div>
                                <button type="button" id="btnNewNotify" class="btn btn-dark btn-sm m-2">New
                                    Notify</button>
                                <button type="button" id="btnExistingNotify" class="btn btn-dark btn-sm m-2">Link
                                    Notify</button>

                            </div>
                        </div>
                        <div class="accordion-row">
                            <a href="#" class="accordion-header">
                                <span><strong>Contacts</strong></span>
                                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                                <i class="accordion-status-icon open fa fa-chevron-down"></i>
                            </a>
                            <div class="accordion-body">
                                {{-- id="contactsContainer" --}}
                                <div class="row" id="contactsContainer">


                                </div>
                                <button type="button" id="btnNewContact" class="btn btn-dark btn-sm m-2">New
                                    Contact</button>
                                <button type="button" id="btnExistingContact" class="btn btn-dark btn-sm m-2">Link
                                    Contact</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="ModelLink">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Link <span id="linkAttrir"></span></h6>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">{{ __('Select') }}</label>
                            <input type="hidden" name="linkType" id="linkType">
                            <select class="form-control" name="linkInput" id="linkInput">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"
                        id="ModelLink_btn_update">{{ __('Update') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('selling:js/masters/customerMasterconfigure.js') }}"></script>
@endsection
