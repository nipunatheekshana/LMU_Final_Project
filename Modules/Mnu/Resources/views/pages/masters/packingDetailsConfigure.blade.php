@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "Packing Details" @endphp

@section('title', $title)
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('vendors/datepicker/daterangepicker.css') }}" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ Module::asset('mnu:css/packingDetailsConfigure.css') }}" type="text/css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ url('vendors/select2/css/select2.min.css') }}" type="text/css">

    <!-- Wizard -->
    <link rel="stylesheet" href="{{ url('vendors/form-wizard/jquery.steps.css') }}" type="text/css">

@endsection

@section('content')
    <div class="row justify-content-between">
        <div class="col-md-7 ">
            <h3>{{ __($title) }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashbord-Parent">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/buying">{{ __('Buying Module') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row ">
        <div class="col-md-7 my-auto">
            <h4 class="card-title">{{ __('Worksheets') }}</h4>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{-- Filters Row --}}
                    <div class="form-row">
                        <div class="col-md-2 mb-1">
                            <label for="select2-customer">Customer</label>
                            <select class="select2-customer" id="customer"></select>
                        </div>
                        <div class="col-md-2 mb-1">
                            <label for="select2-wsno">WS Number</label>
                            <select class="select2-customer" id="wsNumber"></select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom02">Date Range</label>
                            <input type="text" name="daterangepicker" id="daterangepicker" class="form-control">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tableWorksheets" class="table table-striped table-bordered Date display nowrap hover">
                            <thead>
                                <tr>
                                    <th class="thWSNo">{{ __('WS No') }}</th>
                                    <th class="thWSDate">{{ __('WS Date') }}</th>
                                    <th class="thCustomer">{{ __('Customer') }}</th>
                                    <th class="thOrderNo">{{ __('Order No') }}</th>
                                    <th class="thPONo">{{ __('PO No') }}</th>
                                    <th class="thTotQty">{{ __('Total Qty') }}</th>
                                    <th class="thTotWgt">{{ __('Total Wgt') }}</th>
                                    <th class="thPendQty">{{ __('Pending Qty') }}</th>
                                    <th class="thPendWeight">{{ __('Pending Wgt') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td>WS1005</td>
                                    <td>2022-05-03</td>
                                    <td>Comptairs Inc.</td>
                                    <td>CO564564</td>
                                    <td>PO10065</td>
                                    <td>25</td>
                                    <td>426.65 KG</td>
                                    <td>22</td>
                                    <td>402.59 KG</td>
                                </tr>
                                <tr>
                                    <td>WS1005</td>
                                    <td>2022-05-03</td>
                                    <td>Comptairs Inc.</td>
                                    <td>CO564564</td>
                                    <td>PO10065</td>
                                    <td>25</td>
                                    <td>426.65 KG</td>
                                    <td>22</td>
                                    <td>402.59 KG</td>
                                </tr>
                                <tr>
                                    <td>WS1005</td>
                                    <td>2022-05-03</td>
                                    <td>Comptairs Inc.</td>
                                    <td>CO564564</td>
                                    <td>PO10065</td>
                                    <td>25</td>
                                    <td>426.65 KG</td>
                                    <td>22</td>
                                    <td>402.59 KG</td>
                                </tr> --}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-md-7 my-auto">
            <h4 class="card-title">{{ __('Worksheet Details') }}</h4>
        </div>

    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-3">
                    <h6 class="card-title m-0">Worksheet No</h6>
                    <div class="d-flex align-items-center mb-0">
                        <p class="m-0 ml-0" id="lable_wsNum">-</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-3">
                    <h6 class="card-title m-0">Worksheet Date</h6>
                    <div class="d-flex align-items-center mb-0">
                        <p class="m-0 ml-0" id="lable_wsDate">-</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-3">
                    <h6 class="card-title m-0">Order No</h6>
                    <div class="d-flex align-items-center mb-0">
                        <p class="m-0 ml-0" id="lable_orderNum">-</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-3">
                    <h6 class="card-title m-0">Customer</h6>
                    <div class="d-flex align-items-center mb-0">
                        <p class="m-0 ml-0" id="lable_customer">-</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success">
                <div class="card-body p-3">
                    <h6 class="card-title m-0">Total Boxes</h6>
                    <div class="d-flex align-items-center mb-0">
                        <p class="m-0 ml-0" id="lable_TotBoxes">-</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success">
                <div class="card-body p-3">
                    <h6 class="card-title m-0">Total Weight</h6>
                    <div class="d-flex align-items-center mb-0">
                        <p class="m-0 ml-0" id="lable_totWeight">-</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary">
                <div class="card-body p-3">
                    <h6 class="card-title m-0">Pending Boxes</h6>
                    <div class="d-flex align-items-center mb-0">
                        <p class="m-0 ml-0" id="lable_pendingBoxes">-</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary">
                <div class="card-body p-3">
                    <h6 class="card-title m-0">Pending Weight</h6>
                    <div class="d-flex align-items-center mb-0">
                        <p class="m-0 ml-0" id="lable_pendingWeight">-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Work Sheet Details Row  --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableWorksheetDetails" class="table table-striped table-bordered Date display nowrap">
                            <thead>
                                <tr>
                                    <th class="thProduct">{{ __('Product') }}</th>
                                    <th class="thTotalQty">{{ __('Total Qty') }}</th>
                                    <th class="thComplQty">{{ __('Completed Qty') }}</th>
                                    <th class="thPackingStatus">{{ __('Packing Status') }}</th>
                                    <th class="thPendingPL">{{ __('Pending for PL') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Work Sheet Details Row  --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3 text-right" role="tablist">
                        <li class="nav-item">
                            <h6 class="nav-link active" id="genpackinglist-tab" data-toggle="tab" href="#genpackinglist"
                                role="tab" aria-controls="home" aria-selected="true">General Packing Lists</h6>
                        </li>
                        <li class="nav-item">
                            <h6 class="nav-link" id="exppackinglist-tab" data-toggle="tab" href="#exppackinglist"
                                role="tab" aria-controls="profile" aria-selected="false">Export Packing Lists</h6>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="genpackinglist" role="tabpanel"
                            aria-labelledby="genpackinglist-tab">
                            <div class="row">
                                <div class="col-md-12 mt-0 mb-1">
                                    <button id="btnNewGenPL" class="btn btn-primary mb-0 ml-2" style="float: right"
                                        type="button">New PL</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="tableGeneralPackingList" class="table table-striped table-bordered wrap"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th class="thPLNo">{{ __('PL No') }}</th>
                                            <th class="thFrom">{{ __('From') }}</th>
                                            <th class="thTo">{{ __('To') }}</th>
                                            <th class="thQty">{{ __('Qty') }}</th>
                                            <th class="thWeight">{{ __('Weight') }}</th>
                                            <th class="thPLST">{{ __('PLST') }}</th>
                                            <th class="thExpPLNo">{{ __('Exp. PL No') }}</th>
                                            <th class="thActions">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="exppackinglist" role="tabpanel"
                            aria-labelledby="exppackinglist-tab">
                            <div class="row">
                                <div class="col-md-12 mt-0 mb-1">
                                    <button id="btnNewExpPL" class="btn btn-primary mb-0 ml-2" style="float: right"
                                        type="button">New PL</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="tableExportPackingList"
                                    class="table table-striped table-bordered Date display wrap" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="thPLNo">{{ __('PL No') }}</th>
                                            <th class="thPLDate">{{ __('PL Date') }}</th>
                                            <th class="thAWBNo">{{ __('AWB No') }}</th>
                                            <th class="thFlightNo">{{ __('Flight No') }}</th>
                                            <th class="thFlightDate">{{ __('Flight Date') }}</th>
                                            <th class="thInvStatus">{{ __('Invoice Status') }}</th>
                                            <th class="thInvNo">{{ __('Invoice No') }}</th>
                                            <th class="thActions">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
    </div>

    {{-- Modals --}}

    <div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-hidden="true" id="ModalGenPL">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('General Packing List') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="row pb-1">
                        <div class="col-md-4">
                            <h6>{{ __('Worksheeet No') }}</h6>
                            <div class="d-flex align-items-center mb-0">
                                <h4 id="ModalGenPL_mainPlId" class="m-0 ml-0">-</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6>{{ __('Packing List No') }}</h6>
                            <div class="d-flex align-items-center mb-0">
                                <h4 id="ModalGenPL_GplNo" class="m-0 ml-0">New</h4>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h4>{{ __('Add/Remove Boxes') }}</h4>
                    <div class="form-row">
                        <div class="col-md-7 mb-3">

                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="validationCustom01">{{ __('Pick List No.') }}</label>
                            <input type="text" class="form-control" name="pickList_on"
                                id="pickList_on">
                        </div>

                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <h6>{{ __('WS Boxes') }}</h6>

                            <div class="table-responsive">
                                <table id="tableModalGeneralPLWS"
                                    class="table table-striped table-bordered Date display nowrap">
                                    <thead>
                                        <tr>
                                            <th class="thSelect">{{ __('Select') }}</th>
                                            <th class="thBoxNo">{{ __('Box No') }}</th>
                                            <th class="thProduct">{{ __('Product') }}</th>
                                            <th class="thPcs">{{ __('Pcs') }}</th>
                                            <th class="thNetWgt">{{ __('Net Weight') }}</th>
                                            <th class="thGrossWgt">{{ __('Gross Weight') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                </table>
                            </div>
                            <div class="btn-group btn-group-sm pt-2" role="group" aria-label="Small button group">
                                <button type="button" class="btn btn-light" id="btnSelectall1">Select All</button>
                                <div class="form-group m-0">
                                    <div class="custom-control custom-checkbox custom-checkbox-danger ml-4 pt-1">
                                        <input type="checkbox" class="custom-control-input" id="ignore_gross_weight">
                                        <label class="custom-control-label" for="ignore_gross_weight">Ignore Gross
                                            Weight</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-1 text-center my-auto">
                            <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-light" id="buttonToLeft1">
                                    <i class="ti-angle-left"></i>
                                </button>
                                <button type="button" class="btn btn-light" id="buttonToRight1">
                                    <i class="ti-angle-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-5 pb-2">
                            <h6>{{ __('Selected Boxes') }}</h6>
                            <div class="table-responsive">
                                <table id="tableModalGeneralPLSelected"
                                    class="table table-striped table-bordered Date display nowrap">
                                    <thead>
                                        <tr>
                                            <th class="thSelect">{{ __('Select') }}</th>
                                            <th class="thBoxNo">{{ __('Box No') }}</th>
                                            <th class="thProduct">{{ __('Product') }}</th>
                                            <th class="thPcs">{{ __('Pcs') }}</th>
                                            <th class="thNetWgt">{{ __('Net Weight') }}</th>
                                            <th class="thGrossWgt">{{ __('Gross Weight') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                </table>
                            </div>
                            <div class="btn-group btn-group-sm pt-2" role="group" aria-label="Small button group">
                                <button type="button" class="btn btn-light" id="btnSelectall2">Select All</button>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12 pt-1 pb-1">
                            <h4>{{ __('Summary') }}</h4>
                            <div class="table-responsive">
                                <table id="tableModalGeneralPLSummary"
                                    class="table table-striped table-bordered Date display wrap">
                                    <thead>
                                        <tr>
                                            <th class="thProduct">{{ __('Product') }}</th>
                                            <th class="thBoxQty">{{ __('Boxes') }}</th>
                                            <th class="thNetWgt">{{ __('Net Weight') }}</th>
                                            <th class="thGrossWgt">{{ __('Gross Weight') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <div class="row pt-4">

                        <div class="col-md-4">
                            <div class="card bg-primary">
                                <div class="card-body p-3">
                                    <h6 class="card-title m-0">Total Boxes</h6>
                                    <div class="d-flex align-items-center mb-0">
                                        <p class="m-0 ml-0" id="ModalGenPL_totBoxes">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-primary">
                                <div class="card-body p-3">
                                    <h6 class="card-title m-0">Net Weight</h6>
                                    <div class="d-flex align-items-center mb-0">
                                        <p class="m-0 ml-0" id="ModalGenPL_totNetWeight">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-primary">
                                <div class="card-body p-3">
                                    <h6 class="card-title m-0">Gross Weight</h6>
                                    <div class="d-flex align-items-center mb-0">
                                        <p class="m-0 ml-0" id="ModalGenPL_totGrossWeight">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <input type="hidden" id="ModalGenPL_txt_totBoxes">
                    <input type="hidden" id="ModalGenPL_txt_totNetWeight">
                    <input type="hidden" id="ModalGenPL_txt_totGrossWeight">
                    <input type="hidden" id="ModalGenPL_txt_externelPackingId">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="ModalGenPL_btnSave">Save
                    </button>

                </div>
            </div>
        </div>
    </div>


    {{-- Export PL Modal  --}}

    <div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-hidden="true" id="ModalExpPL">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Export Packing List') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="row pb-2">
                        <div class="col-md-4">
                            <h6>{{ __('Worksheeet No') }}</h6>
                            <div class="d-flex align-items-center mb-0">
                                <h4 id="ModalExpPL_mainPlId" class="m-0 ml-0">-</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6>{{ __('Packing List No') }}</h6>
                            <div class="d-flex align-items-center mb-0">
                                <h4 id="ModalExpPL_PlNo" class="m-0 ml-0">New</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <h6>{{ __('WS Boxes') }}</h6>

                            <div class="table-responsive">
                                <table id="tableModalExportPLGeneralPL"
                                    class="table table-striped table-bordered Date display nowrap">
                                    <thead>
                                        <tr>
                                            <th class="thSelect">{{ __('Select') }}</th>
                                            <th class="thGenPLNo">{{ __('Gen. PL No') }}</th>
                                            <th class="thFrom">{{ __('From') }}</th>
                                            <th class="thTo">{{ __('To') }}</th>
                                            <th class="thBoxQty">{{ __('Box Qty') }}</th>
                                            <th class="thBoxWgt">{{ __('Box Weight') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div class="btn-group btn-group-sm pt-2" role="group" aria-label="Small button group">
                                <button type="button" class="btn btn-light" id="btnSelectall3">Select All</button>
                                {{-- <button type="button" class="btn btn-light">Deselct All</button> --}}
                            </div>
                        </div>

                        <div class="col-md-1 text-center my-auto">
                            <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-light" id="buttonToLeft2">
                                    <i class="ti-angle-left"></i>
                                </button>
                                <button type="button" class="btn btn-light" id="buttonToRight2">
                                    <i class="ti-angle-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-5 pb-2">
                            <h6>{{ __('Selected Boxes') }}</h6>
                            <div class="table-responsive">
                                <table id="tableModalExportPLSelected"
                                    class="table table-striped table-bordered Date display nowrap">
                                    <thead>
                                        <tr>
                                            <th class="thSelect">{{ __('Select') }}</th>
                                            <th class="thGenPLNo">{{ __('Gen. PL No') }}</th>
                                            <th class="thFrom">{{ __('From') }}</th>
                                            <th class="thTo">{{ __('To') }}</th>
                                            <th class="thBoxQty">{{ __('Box Qty') }}</th>
                                            <th class="thBoxWgt">{{ __('Box Weight') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div class="btn-group btn-group-sm pt-2" role="group" aria-label="Small button group">
                                <button type="button" class="btn btn-light" id="btnSelectall4">Select All</button>
                                {{-- <button type="button" class="btn btn-light">Deselct All</button> --}}
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 pt-1 pb-1">
                            <h4>{{ __('Summary') }}</h4>
                            <div class="table-responsive">
                                <table id="tableModalExportPLSummary"
                                    class="table table-striped table-bordered Date display nowrap">
                                    <thead>
                                        <tr>
                                            <th class="thBoxNo">{{ __('Box No') }}</th>
                                            <th class="thProduct">{{ __('Product') }}</th>
                                            <th class="thBoxQty">{{ __('Qty') }}</th>
                                            <th class="thNetWgt">{{ __('Net Weight') }}</th>
                                            <th class="thGrossWgt">{{ __('Gross Weight') }}</th>
                                            <th class="thGenPLNo">{{ __('Gen. PL No') }}</th>
                                            <th class="thPackCode">{{ __('kPack Code') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-4 mb-3">

                        <div class="col-md-4">
                            <div class="card bg-primary">
                                <div class="card-body p-3">
                                    <h6 class="card-title m-0">Total Boxes</h6>
                                    <div class="d-flex align-items-center mb-0">
                                        <p id="ModalExpPL_totBoxes" class="m-0 ml-0">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-primary">
                                <div class="card-body p-3">
                                    <h6 class="card-title m-0">Net Weight</h6>
                                    <div class="d-flex align-items-center mb-0">
                                        <p id="ModalExpPL_totNetWeight" class="m-0 ml-0">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-primary">
                                <div class="card-body p-3">
                                    <h6 class="card-title m-0">Gross Weight</h6>
                                    <div class="d-flex align-items-center mb-0">
                                        <p id="ModalExpPL_totGrossWeight" class="m-0 ml-0">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            {{-- <div class="card"> --}}
                            {{-- <div class="card-body p-3"> --}}
                            <h6 class="card-title m-0 pb-2">GRN Nos</h6>
                            <div class="d-flex align-items-center mb-0">
                                <input type="text" class="form-control" id="ModalExpPL_GrnNos"
                                    aria-describedby="emailHelp">
                            </div>
                            {{-- </div> --}}
                            {{-- </div> --}}
                        </div>
                        <div class="col-md-3">
                            {{-- <div class="card bg-primary"> --}}
                            {{-- <div class="card-body p-3"> --}}
                            <h6 class="card-title m-0 pb-2">Batch Nos</h6>
                            <div class="d-flex align-items-center mb-0">
                                <input type="text" class="form-control" id="ModalExpPL_batchNo"
                                    aria-describedby="emailHelp">
                            </div>
                            {{-- </div> --}}
                            {{-- </div> --}}
                        </div>
                        <div class="col-md-3">
                            {{-- <div class="card bg-primary"> --}}
                            {{-- <div class="card-body p-3"> --}}
                            <h6 class="card-title m-0 pb-2">Production Date</h6>
                            <div class="d-flex align-items-center mb-0">
                                <input type="text" class="form-control" id="ModalExpPL_productDate"
                                    aria-describedby="emailHelp">
                            </div>
                            {{-- </div> --}}
                            {{-- </div> --}}
                        </div>
                        <div class="col-md-3">
                            {{-- <div class="card bg-primary"> --}}
                            {{-- <div class="card-body p-3"> --}}
                            <h6 class="card-title m-0 pb-2">Expiry Date</h6>
                            <div class="d-flex align-items-center mb-0">
                                <input type="text" class="form-control" id="ModalExpPL_ExpirDate"
                                    aria-describedby="emailHelp">
                            </div>
                            {{-- </div> --}}
                            {{-- </div> --}}
                        </div>

                    </div>


                    <div class="accordion accordion-primary custom-accordion">
                        <div class="accordion-row open">
                            <a href="#" class="accordion-header">
                                <span>{{ __('PL Information') }}</span>
                                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                                <i class="accordion-status-icon open fa fa-chevron-down"></i>
                            </a>
                            <div class="accordion-body">
                                <form id="frmExportPackingListDetails" autocomplete="off">

                                    <input type="hidden" id="hiddenId" name="id">

                                    <div class="form-row">
                                        <div class="col-md-4 mb-1">
                                            <label for="validationCustom01">{{ __('AWB No') }}</label>
                                            <input type="text" class="form-control" name="awb_no" id="awb_no">
                                        </div>
                                        <div class="col-md-4 mb-1">
                                            <label for="validationCustom01">{{ __('Flight No') }}</label>
                                            <input type="text" class="form-control" name="flight_no" id="flight_no">
                                        </div>
                                        <div class="col-md-4 mb-1">
                                            <label for="validationCustom01">{{ __('Flight Date') }}</label>
                                            <input type="date" class="form-control" name="flight_date"
                                                id="flight_date">
                                        </div>


                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-1">
                                            <label for="validationCustom01">{{ __('Air Line') }}</label>
                                            <select class="form-control" name="air_line" id="air_line"> </select>
                                        </div>
                                        <div class="col-md-4 mb-1">
                                            <label for="validationCustom01">{{ __('Shipment No') }}</label>
                                            <input type="text" class="form-control" name="shipment_no"
                                                id="shipment_no">
                                        </div>
                                        <div class="col-md-4 mb-1">
                                            <label for="validationCustom01">{{ __('PL Date') }}</label>
                                            <input type="date" class="form-control" name="pl_date" id="pl_date">
                                        </div>

                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-4 mb-1">
                                            <label for="validationCustom01">{{ __('Destination') }}</label>
                                            <select class="form-control" name="destination" id="destination"></select>
                                        </div>
                                        <div class="col-md-4 mb-1">
                                            <label for="validationCustom01">{{ __('Remarks') }}</label>
                                            <input type="text" class="form-control" name="remarks" id="remarks">
                                        </div>
                                        <div class="col-md-4 mb-1">
                                            <label for="validationCustom01">{{ __('Export Date') }}</label>
                                            <input type="date" class="form-control" name="export_date"
                                                id="export_date">
                                        </div>
                                    </div>


                                    <h4 class="py-2">{{ __('Address Details') }}</h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-0">
                                            <div class="col-md-12 mb-1 p-0">
                                                <label for="validationCustom02">{{ __('Consignee') }}</label>
                                                <select class="form-control" name="consignee" id="consignee">
                                                    <option value="">-Select-</option>
                                                </select>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-1">
                                                    <label for="validationCustom01">{{ __('Address Line 1') }}</label>
                                                    <input type="text" class="form-control" name="consignee_addr1"
                                                        id="consignee_addr1">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-1">
                                                    <label for="validationCustom01">{{ __('Address Line 2') }}</label>
                                                    <input type="text" class="form-control" name="consignee_addr2"
                                                        id="consignee_addr2">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-7 mb-1">
                                                    <label for="validationCustom01">{{ __('City/Town') }}</label>
                                                    <input type="text" class="form-control" name="consignee_city"
                                                        id="consignee_city">
                                                </div>
                                                <div class="col-md-5 mb-1">
                                                    <label for="validationCustom01">{{ __('Postal Code') }}</label>
                                                    <input type="text" class="form-control"
                                                        name="consignee_postalcode" id="consignee_postalcode">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-1">
                                                    <label for="validationCustom01">{{ __('Country') }}</label>
                                                    <input type="text" class="form-control" name="consignee_country"
                                                        id="consignee_country">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <div class="col-md-12 mb-1 p-0">
                                                <label for="validationCustom02">{{ __('Notify Party') }}</label>
                                                <select class="form-control" name="notify_party" id="notify_party">
                                                    <option value="">-Select-</option>
                                                </select>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-1">
                                                    <label for="validationCustom01">{{ __('Address Line 1') }}</label>
                                                    <input type="text" class="form-control" name="notify_addr1"
                                                        id="notify_addr1">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-1">
                                                    <label for="validationCustom01">{{ __('Address Line 2') }}</label>
                                                    <input type="text" class="form-control" name="notify_addr2"
                                                        id="notify_addr2">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-7 mb-1">
                                                    <label for="validationCustom01">{{ __('City/Town') }}</label>
                                                    <input type="text" class="form-control" name="notify_city"
                                                        id="notify_city">
                                                </div>
                                                <div class="col-md-5 mb-1">
                                                    <label for="validationCustom01">{{ __('Postal Code') }}</label>
                                                    <input type="text" class="form-control" name="notify_postalcode"
                                                        id="notify_postalcode">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-1">
                                                    <label for="validationCustom01">{{ __('Country') }}</label>
                                                    <input type="text" class="form-control" name="notify_country"
                                                        id="notify_country">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <h4 class="py-2">{{ __('Company Related Details') }}</h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-0">
                                            <div class="form-row">
                                                <div class="col-md-12 mb-1">
                                                    <label for="validationCustom01">{{ __('EU Approval No') }}</label>
                                                    <input type="text" class="form-control" name="eu_approval_no"
                                                        id="eu_approval_no">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-1">
                                                    <label
                                                        for="validationCustom01">{{ __('Production Manager') }}</label>
                                                    <input type="text" class="form-control" name="production_manager"
                                                        id="production_manager">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-0">
                                            <div class="form-row">
                                                <div class="col-md-12 mb-1">
                                                    <label for="validationCustom01">{{ __('Packing QC') }}</label>
                                                    <input type="text" class="form-control" name="packing_qc"
                                                        id="packing_qc">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-1">
                                                    <label for="validationCustom01">{{ __('Authorization') }}</label>
                                                    <input type="text" class="form-control" name="authorization"
                                                        id="authorization">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="Explid" name="Explid">
                                </form>
                            </div>
                        </div>
                        <div class="accordion-row ">
                            <a href="#" class="accordion-header">
                                <span>{{ __('Boxes Information') }}</span>
                                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                                <i class="accordion-status-icon open fa fa-chevron-down"></i>
                            </a>
                            <div class="accordion-body">
                                <div class="row pt-4 pb-0">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="tableModalExportPLBoxSummary"
                                                class="table table-striped table-bordered Date display nowrap">
                                                <thead>
                                                    <tr>
                                                        <th class="thProduct">{{ __('Product') }}</th>
                                                        <th class="thWeight">{{ __('Gross Weight') }}</th>
                                                        <th class="thBoxQty">{{ __('Boxes Qty') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-4 pb-0">
                                    <div class="col-md-4">
                                        <div class="card bg-primary">
                                            <div class="card-body p-3">
                                                <h6 class="card-title m-0">Total Boxes</h6>
                                                <div class="d-flex align-items-center mb-0">
                                                    <p id="ModalExpl_totBoxes" class="m-0 ml-0">-</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-primary">
                                            <div class="card-body p-3">
                                                <h6 class="card-title m-0">Total Weight</h6>
                                                <div class="d-flex align-items-center mb-0">
                                                    <p id="ModalExpl_totGrossWeight" class="m-0 ml-0">-</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="ModalExPL_btnSave">Save
                    </button>

                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ url('vendors/datepicker/daterangepicker.js') }}"></script>

    <!-- Select2 JS -->
    <script src="{{ url('vendors/select2/js/select2.min.js') }}"></script>

    <!-- Wizard JS -->
    <script src="{{ url('vendors/form-wizard/jquery.steps.min.js') }}"></script>

    <script src="{{ Module::asset('mnu:js/masters/packingDetailsConfigure.js') }}"></script>
@endsection
