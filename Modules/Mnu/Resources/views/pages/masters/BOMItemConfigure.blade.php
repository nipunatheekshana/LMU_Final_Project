@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New BOM Item" @endphp

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
                        <a href="/mnu">{{ __('Manufacturing Module') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/mnu/BOMItem_list">{{ __('Boat Category List') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button id="btnSave" class="btn btn-primary sticky-top mb-3" style="float: right" type="button">Save</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Setup New BOM Item') }}</h6>
                    <form id="frmBOMItemConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('BOM Item Type') }}</label>
                                <select class="form-control" name="BOM_itemType" id="BOM_itemType">
                                    <option value="Inner_Bom">Inner Bom</option>
                                    <option value="Outer_Bom">Outer Bom</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Item Code') }}</label>
                                <input type="text" class="form-control" name="Item_Code" id="Item_Code">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Item Name') }}</label>
                                <input type="text" class="form-control" name="item_name" id="item_name">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Description') }}</label>
                                <textarea type="text" class="form-control" name="Item_description" id="Item_description"></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Process') }}</label>
                                <select class="form-control" name="process" id="process">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Work station') }}</label>
                                <select class="form-control" name="work_station" id="work_station">
                                    <option value="">-Select-</option>
                                </select>
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
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('BOM Details') }}</h6>
                    <div id="OuterBomMainItem">
                        <hr>
                        <h6 class="card-title mb-2">{{ __('Main Items') }}
                            <button id="btnAddMainItem" class="btn btn-primary btn-floating ml-2 mb-1" type="button"> <i
                                    class="ti-plus"></i></button>
                        </h6>

                        <div id="mainItemContainer">
                            <input type="hidden" name="MainItemCount" id="MainItemCount">

                        </div>
                        {{-- <div class="form-row">
                            <div class="col-md-8 mb-3">
                                <label for="validationCustom02">{{ __('Main item') }}</label>
                                <select class="form-control" name="mainItem_name" id="mainItem_name">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustom01">{{ __('Total Weight') }}</label>
                                <input type="text" class="form-control" name="mainItem_weight" id="mainItem_weight"
                                    >
                            </div>
                            <div class="col-md-1 mb-3">
                                <button type="button" class="btn btn-secondary btn-floating mt-4 ml-2" onclick="removeMainItem(`+ otherItemId + `)">
                                    <i class="ti-trash"></i>
                                </button>
                            </div>
                        </div> --}}

                    </div>
                    <div id="InnerBomMainItem">
                        <hr>
                        <h6 class="card-title mb-3">{{ __('Main Item') }}</h6>
                        <div class="form-row">
                            <div class="col-md-9 mb-3">
                                <label for="validationCustom02">{{ __('Item') }}</label>
                                <select class="form-control" name="mainItem_name" id="mainItem_name">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="validationCustom01">{{ __('Total Weight') }}</label>
                                <input type="number" class="form-control" name="mainItem_weight" id="mainItem_weight"
                                    readonly>
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="validationCustom01">{{ __('Reprocess') }}</label>
                                <input type="checkbox" class="ml-3" name="mainItem_reprocess" id="mainItem_reprocess">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h6 class="card-title mb-3">{{ __('Container Item') }}</h6>
                    <div class="form-row">
                        <div class="col-md-9 mb-3">
                            <label for="validationCustom02">{{ __('Item') }}</label>
                            <select class="form-control" name="ContainerItem_name" id="ContainerItem_name">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom01">{{ __('Total Weight') }}</label>
                            <input type="number" class="form-control" name="conteinerItem_weight"
                                id="conteinerItem_weight" readonly>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom01">{{ __('Reprocess') }}</label>
                            <input type="checkbox" class="ml-3" name="conteinerItem_reprocess"
                                id="conteinerItem_reprocess">
                        </div>
                    </div>
                    <hr>
                    <h6 class="card-title mb-3">{{ __('Lable Item') }}</h6>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">{{ __('Item') }}</label>
                            <select class="form-control" name="lableItemName" id="lableItemName">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom01">{{ __('Quantity') }}</label>
                            <input type="number" class="form-control" onchange="calLableItemTotalWeight()"
                                name="lableItem_Qty" id="lableItem_Qty">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom01">{{ __('Unit Weight') }}</label>
                            <input type="number" class="form-control" name="lableItemWeight" id="lableItemWeight"
                                readonly>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom01">{{ __('Total Weight') }}</label>
                            <input type="number" class="form-control" name="lableItem_totalWeight"
                                id="lableItem_totalWeight" readonly>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom01">{{ __('Reprocess') }}</label>
                            <input type="checkbox" class="ml-3" name="lableItem_reprocess" id="lableItem_reprocess">
                        </div>
                    </div>
                    <hr>
                    <h6 class="card-title mb-2">{{ __('Other Items') }}
                        <button id="btnAddOtherItem" class="btn btn-primary btn-floating ml-2 mb-1" type="button"> <i
                                class="ti-plus"></i></button>
                    </h6>



                    <div id="otherItemContainer">
                        {{-- <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Item') }}</label>
                                <select class="form-control"  name="BOM_itemType" id="BOM_itemType">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="validationCustom01">{{ __('Quantity') }}</label>
                                <input type="text" class="form-control" name="item_name" id="item_name" >
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="validationCustom01">{{ __('Unit Weight') }}</label>
                                <input type="text" class="form-control" name="item_name" id="item_name" >
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="validationCustom01">{{ __('Total Weight') }}</label>
                                <input type="text" class="form-control" name="item_name" id="item_name" >
                            </div>
                            <div class="col-md-1 mb-3">
                                <button type="button" class="btn btn-secondary btn-floating mt-4 ml-2" onclick="removeOtherItem()">
                                    <i class="ti-trash"></i>
                                  </button>
                            </div>

                        </div> --}}
                    </div>
                    <input type="hidden" name="otherItemCount" id="otherItemCount">
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Weight Details') }}</h6>

                    <div class="form-row">

                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Average Net Weight') }}</label>
                            <input type="text" class="form-control" name="averageNet_weight" id="averageNet_weight"
                                readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Average Gross Weight') }}</label>
                            <input type="text" class="form-control" name="averageGross_weight"
                                id="averageGross_weight" readonly>
                        </div>

                    </div>
                    </form>



                </div>
            </div>

        </div>
    </div>
    <div class="row" id="RelatedItemRaw">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Other Related BOM Items') }}</h6>

                    <div class="table-responsive">
                        <table id="tableRelatedOuterBOMItem"
                            class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thItemCode">{{ __('Item code') }}</th>
                                    <th class="thItemName">{{ __('Item Name') }}</th>
                                    <th class="thNetWeight">{{ __('Net weight') }}</th>
                                    <th class="thGrossWeight">{{ __('Gross Weight') }}</th>
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
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Assigned Customers') }}</h6>

                    <div class="table-responsive">
                        <table id="tableAssignedCustomers"
                            class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thName">{{ __('Customer Name') }}</th>
                                    <th class="thLableName">{{ __('Customer Item Lable Name') }}</th>
                                    <th class="thBarcode">{{ __('Barcode') }}</th>
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
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('mnu:js/masters/BOMItemConfigure.js') }}"></script>
@endsection
