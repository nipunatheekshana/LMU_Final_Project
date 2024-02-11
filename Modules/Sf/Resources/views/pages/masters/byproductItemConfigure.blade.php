@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Byproduct Item" @endphp

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
                        <a href="/sf/byproductItem_list">{{ __('Byproducts Items List') }}</a>
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
                    <h6 class="card-title">{{ __('Setup New By-Product Item') }}</h6>
                    <form id="frmbyproductItemConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Company') }}</label>
                                <select class="form-control" name="CompanyID" id="CompanyID">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('By-Product Code*') }}</label>
                                <input type="text" class="form-control" name="Item_Code" id="Item_Code">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('By-Product Name*') }}</label>
                                <input type="text" class="form-control" name="item_name" id="item_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Fish Species*') }}</label>
                                <select class="form-control" name="rm_species" id="rm_species">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Item Group') }}</label>
                                <select class="form-control" name="item_group" id="item_group">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Unit of Measure*') }}</label>
                                <select class="form-control" name="stock_uom" id="stock_uom">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Average Weight*') }}</label>
                                <input type="text" class="form-control" name="avg_weight_per_unit"
                                    id="avg_weight_per_unit">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Weight Unit*') }}</label>
                                <select class="form-control" name="weight_uom" id="weight_uom">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Description') }}</label>
                                <textarea type="number" class="form-control" name="Item_description" id="Item_description"></textarea>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Index') }}</label>
                                <input type="number" class="form-control" name="list_index" id="list_index" value="1">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_sales_item"
                                        name="is_sales_item">
                                    <label class="form-check-label" for="exampleCheck1">{{ __('is sales item') }}</label>
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
    <div class="row">
        <div class="col-md-12">
            <button id="btnProcessWorkstation" class="btn btn-primary mb-3" style="float: right" type="button">Add
                Process Workstation</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Process WorkStations') }}</h6>
                    <div class="table-responsive">
                        <table id="tableProcessWorkStations"
                            class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thProcess">{{ __('Process') }}</th>
                                    <th class="thWorkstation">{{ __('WorkStation') }}</th>
                                    <th class="action"> {{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button id="btnPriceList" class="btn btn-primary mb-3" style="float: right" type="button">Add
                Price</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Price') }}</h6>
                    <div class="table-responsive">
                        <table id="tablePrice" class="table table-striped table-bordered dataTable dtr-inline collapsed"
                            role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thUom">{{ __('UOM') }}</th>
                                    <th class="thPriceList">{{ __('Price List') }}</th>
                                    <th class="thPrice">{{ __('Price') }}</th>
                                    <th class="action"> {{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- models --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modelprocessWorkstation">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Process Workstation') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">{{ __('Process Workstation') }}</label>
                            <select class="form-control" id="ProcessWorkstation"></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"
                        id="modelprocessWorkstationbtnAdd">{{ __('Add') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modelPriceList">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Price') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Price List') }}</label>
                            <select class="form-control" id="price_list"></select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Uom') }}</label>
                            <select class="form-control" id="uom"></select>
                        </div>
                        <div class="col-md-12 mb-6">
                            <label for="validationCustom01">{{ __('Price*') }}</label>
                            <input type="text" class="form-control" id="price">
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"
                        id="modelPriceListBtnAdd">{{ __('Add') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('sf:js/masters/byproductItemConfigure.js') }}"></script>
@endsection
