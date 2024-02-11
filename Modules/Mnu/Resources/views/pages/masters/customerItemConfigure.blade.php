@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Customer Item" @endphp

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
                        <a href="/mnu/customerItem_list">{{ __('Customer Item List') }}</a>
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
                    <h6 class="card-title">{{ __('Customer Item Details') }}</h6>
                    <form id="frmcustomerItemConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">


                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom02">{{ __('Customer') }} <i
                                        onclick="coppyTOClipBoard('@cusname')" title="@cusname" data-toggle="tooltip"
                                        data-placement="top" data-feather="clipboard"></i></label>
                                <select class="form-control" name="customer" id="customer">
                                    <option value="">-Select-</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="validationCustom02">{{ __('Item type') }}</label>
                                <select class="form-control" name="itemType" id="itemType">
                                    <option value="">-Select-</option>
                                    <option value="Inner_Bom">Inner Bom</option>
                                    <option value="Outer_Bom">Outer Bom</option>
                                </select>
                            </div>
                            <div class="col-md-9 mb-3">
                                <label for="validationCustom02">{{ __('Item') }} <i
                                        onclick="coppyTOClipBoard('@itemcode')" title="@itemcode" data-toggle="tooltip"
                                        data-placement="top" data-feather="clipboard"></i></label>
                                <select class="form-control" name="item" id="item">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_sale_item" name="is_sale_item">
                                    <label class="form-check-label" for="exampleCheck1">{{ __('is sale item ?') }}</label>
                                </div>

                            </div>


                        </div>

                        <h6 class="card-title mt-4">{{ __('Product Names') }}</h6>
                        <hr>
                        <b>For Lables</b>

                        <div class="form-row mt-3">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Product Name 01') }} <i
                                        onclick="coppyTOClipBoard('@prodname1')" title="@prodname1" data-toggle="tooltip"
                                        data-placement="top" data-feather="clipboard"></i></label>
                                <input type="text" class="form-control" name="lbl_prodname1" id="lbl_prodname1">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Product Name 02') }} <i
                                        onclick="coppyTOClipBoard('@prodname2')" title="@prodname2" data-toggle="tooltip"
                                        data-placement="top" data-feather="clipboard"></i></label>
                                <input type="text" class="form-control" name="lbl_prodname2" id="lbl_prodname2">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Product Name 03') }} <i
                                        onclick="coppyTOClipBoard('@prodname3')" title="@prodname3" data-toggle="tooltip"
                                        data-placement="top" data-feather="clipboard"></i></label>
                                <input type="text" class="form-control" name="lbl_prodname3" id="lbl_prodname3">
                            </div>

                        </div>
                        <b>For Packing List</b>

                        <div class="form-row mt-3">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Product Name 01') }}</label>
                                <input type="text" class="form-control" name="pl_prodname1" id="pl_prodname1">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Product Name 02') }}</label>
                                <input type="text" class="form-control" name="pl_prodname2" id="pl_prodname2">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Summary Name ') }}</label>
                                <input type="text" class="form-control" name="pl_summary_name" id="pl_summary_name">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Short Name') }}</label>
                                <input type="text" class="form-control" name="pl_short_name" id="pl_short_name">
                            </div>

                        </div>
                        <b>For Invoice</b>

                        <div class="form-row mt-3">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Product Name 01') }}</label>
                                <input type="text" class="form-control" name="in_prodname1" id="in_prodname1">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Product Name 02') }}</label>
                                <input type="text" class="form-control" name="in_prodname2" id="in_prodname2">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Short Name') }}</label>
                                <input type="text" class="form-control" name="in_short_name" id="in_short_name">
                            </div>

                        </div>
                        <b>Other</b>

                        <div class="form-row mt-3">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Product Name 01') }}</label>
                                <input type="text" class="form-control" name="ot_prodname1" id="ot_prodname1">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Product Name 02') }}</label>
                                <input type="text" class="form-control" name="ot_prodname2" id="ot_prodname2">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Short Name') }}</label>
                                <input type="text" class="form-control" name="ot_short_name" id="ot_short_name">
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
                    <h6 class="card-title">{{ __('Barcode Details') }}</h6>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('GTN Number') }} <i onclick="coppyTOClipBoard('@gtin')"
                                    title="@gtin" data-toggle="tooltip" data-placement="top"
                                    data-feather="clipboard"></i></label>
                            <input type="text" class="form-control" name="gtin_no" id="gtin_no"
                                placeholder="Eg : 10658652686545">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('EAN-13 Number') }} <i
                                    onclick="coppyTOClipBoard('@ean13')" title="@ean13" data-toggle="tooltip"
                                    data-placement="top" data-feather="clipboard"></i></label>
                            <input type="text" class="form-control" name="ean13_no" id="ean13_no"
                                placeholder="Eg : 96538056504893">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Customer Product Code 1') }} <i
                                    onclick="coppyTOClipBoard('@cusprodcode1')" title="@cusprodcode1"
                                    data-toggle="tooltip" data-placement="top" data-feather="clipboard"></i></label>
                            <input type="text" class="form-control" name="cus_prod_code_1" id="cus_prod_code_1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Customer Product Code 2') }} <i
                                    onclick="coppyTOClipBoard('@cusprodcode2')" title="@cusprodcode2"
                                    data-toggle="tooltip" data-placement="top" data-feather="clipboard"></i></label>
                            <input type="text" class="form-control" name="cus_prod_code_2" id="cus_prod_code_2">
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
                    <h6 class="card-title">{{ __('Printing Details') }}</h6>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Number Of Lables') }}</label>
                            <input type="text" class="form-control" name="numOfLables" id="numOfLables">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Upload PRN File') }}</label>
                            <input type="file" class="form-control" name="SupGroupCode" id="SupGroupCode">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Default Printer') }}</label>
                            <select class="form-control" name="default_printer" id="default_printer">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row" id="innerItemList">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Inner Item List') }}</h6>

                    <div class="table-responsive">
                        <table id="tableInnerItemList"
                            class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thcustomerItem">{{ __('Customer Item') }}</th>
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
                    <h6 class="card-title">{{ __('List of Parameters') }}</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <button id="btnResetParameters" onclick="" class="btn btn-primary mb-3"
                                style="float: right" type="button">Reset</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tableParameterList"
                            class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thParameter">{{ __('Parameter') }}</th>
                                    <th class="thDiscription"> {{ __('Discription') }}</th>
                                    <th class="thDataType"> {{ __('Data Type') }}</th>
                                    <th class="thFormat"> {{ __('Format') }}</th>
                                    <th class="thSampledata"> {{ __('Sample ') }}</th>
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
                    <h6 class="card-title">{{ __('Sample Lable Print') }}</h6>
                    <div class="form-row">
                        <div class="col-md-9 mb-3">
                            <label for="validationCustom02">{{ __('Printer') }}</label>
                            <select class="form-control" name="ParentSupGroupID" id="ParentSupGroupID">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary m-4" type="button">Print Sample Lable</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- models --}}
    <div class="modal" tabindex="-1" role="dialog" id="DataTypeFormatModel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Type Format Model</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <input type="hidden" name="paraId" id="paraId">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">{{ __('Format') }}</label>
                            <select class="form-control" name="format" id="format">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSaveDataTypeFormat" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('mnu:js/masters/customerItemConfigure.js') }}"></script>
@endsection
