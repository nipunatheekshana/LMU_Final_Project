@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Supplier" @endphp

@section('title', $title)
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __($title) }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashbord-Parent">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/buying">{{ __('Buying Module') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/buying/supplier_list">{{ __('Suppliers List') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
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
                    <h6 class="card-title">{{ __('Setup New Supplier ') }}</h6>
                    <form id="frmsupplierConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Supplier  name') }}</label>
                                <input type="text" class="form-control" name="supplier_name" id="supplier_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Country ') }}</label>
                                <select class="form-control" name="country" id="country">
                                    <option value="">-Select-</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Default bank account') }}</label>
                                <input type="text" class="form-control" name="default_bank_account"
                                    id="default_bank_account">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Tax id') }}</label>
                                <input type="text" class="form-control" name="tax_id" id="tax_id">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Tax category ') }}</label>
                                <select class="form-control" name="tax_category" id="tax_category">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Tax with holding category ') }}</label>
                                <select class="form-control" name="tax_withholding_category" id="tax_withholding_category">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Represents company') }}</label>
                                <input type="text" class="form-control" name="represents_company"
                                    id="represents_company">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Image') }}</label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Supplier group ') }}</label>
                                <select class="form-control" name="supplier_group" id="supplier_group">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Supplier type ') }}</label>
                                <select class="form-control" name="supplier_type" id="supplier_type">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Pan') }}</label>
                                <input type="text" class="form-control" name="pan" id="pan">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('language ') }}</label>
                                <select class="form-control" name="language" id="language">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Default currency ') }}</label>
                                <select class="form-control" name="default_currency" id="default_currency">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Default price list ') }}</label>
                                <select class="form-control" name="default_price_list" id="default_price_list">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Payment terms ') }}</label>
                                <select class="form-control" name="payment_terms" id="payment_terms">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Hold type ') }}</label>
                                <select class="form-control" name="hold_type" id="hold_type">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Release date') }}</label>
                                <input type="date" class="form-control" name="release_date" id="release_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Website') }}</label>
                                <input type="text" class="form-control" name="website" id="website">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Supplier details') }}</label>
                                <textarea type="date" class="form-control" name="supplier_details" id="supplier_details"></textarea>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Comments') }}</label>
                                <textarea type="date" class="form-control" name="_comments" id="_comments"></textarea>
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
                                    <input type="checkbox" class="form-check-input" id="is_transporter"
                                        name="is_transporter">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('is transporter') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_internal_supplier"
                                        name="is_internal_supplier">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('is internal supplier') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input"
                                        id="allow_purchase_invoice_creation_without_purchase_order"
                                        name="allow_purchase_invoice_creation_without_purchase_order">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Allow purchase invoice creation without purchase order') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input"
                                        id="allow_purchase_invoice_creation_without_purchase_receipt"
                                        name="allow_purchase_invoice_creation_without_purchase_receipt">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Allow purchase invoice creation without purchase receipt') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="on_hold" name="on_hold">
                                    <label class="form-check-label" for="exampleCheck1">{{ __('Hold') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="enabled" name="enabled"
                                        checked>
                                    <label class="form-check-label" for="exampleCheck1">{{ __('Enabled') }}</label>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="accordion accordion-primary custom-accordion" id="addressAndContactContainer">
        <div class="accordion-row open">
            <a href="#" class="accordion-header">
                <span>Address</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                {{-- id="addressContainer" --}}
                <div class="row" id="addressContainer">


                </div>
                <button type="button" id="btnNewAddress" class="btn btn-dark btn-sm m-2">New Address</button>
                <button type="button" id="btnExistingAddress" class="btn btn-dark btn-sm m-2">Link  Address</button>

            </div>
        </div>
        <div class="accordion-row ">
            <a href="#" class="accordion-header">
                <span>Contacts</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                {{-- id="contactsContainer" --}}
                <div class="row" id="contactsContainer">


                </div>
                <button type="button" id="btnNewContact" class="btn btn-dark btn-sm m-2">New Contact</button>
                <button type="button" id="btnExistingContact" class="btn btn-dark btn-sm m-2">Link  Contact</button>

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
    <script src="{{ Module::asset('buying:js/masters/supplierConfigure.js') }}"></script>
@endsection
