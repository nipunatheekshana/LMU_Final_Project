@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Sea Food Raw Material" @endphp

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
                        <a href="/sf">{{ __('Sea Food Module') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/sf/seaFoodRawMaterial_list">{{ __('Sea Food Raw Materials List') }}</a>
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
                    <h6 class="card-title">{{ __('Setup New SeaFood Raw Material') }}</h6>
                    <form id="frmseaFoodRawMaterialConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Company*') }}</label>
                                <select class="form-control" name="CompanyID" id="CompanyID">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Sea Food Raw Material Code*') }}</label>
                                <input type="text" class="form-control" name="Item_Code" id="Item_Code">
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('SeaF ood Raw Material Name*') }}</label>
                                <input type="text" class="form-control" name="item_name" id="item_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Fish Species*') }}</label>
                                <select class="form-control" name="rm_species" id="rm_species">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Receiving Presentation*') }}</label>
                                <select class="form-control" name="ReceivePresentation" id="ReceivePresentation">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Receiving Grade (Q)*') }}</label>
                                <select class="form-control" name="ReceiveGrade" id="ReceiveGrade">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">


                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Item Group*') }}</label>
                                <select class="form-control" name="item_group" id="item_group">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Unit of Measure*') }}</label>
                                <select class="form-control" name="uom" id="uom">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Weight Unit*') }}</label>
                                <select class="form-control" name="weight_uom" id="weight_uom">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Weight per Unit*') }}</label>
                                <input type="number" class="form-control" name="avg_weight_per_unit"
                                    id="avg_weight_per_unit">
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Image') }}</label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Item Description') }}</label>
                                <textarea type="text" class="form-control" name="Item_description" id="Item_description"></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Index') }}</label>
                                <input type="number" class="form-control" name="list_index" id="list_index"
                                    value="1">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">

                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input"
                                        id="is_inspection_required_before_receive"
                                        name="is_inspection_required_before_receive">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Is inspection required before Receive?') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input"
                                        id="is_inspection_required_before_delivery"
                                        name="is_inspection_required_before_delivery">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Is inspection required before Delivery?') }}</label>
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
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('sf:js/masters/seaFoodRawMaterialConfigure.js') }}"></script>
@endsection
