@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "Quality Lab Tests" @endphp

@section('title', $title)

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
    {{-- searchable select --}}
    <link rel="stylesheet" href="{{ url('vendors/select2/css/select2.min.css') }}" type="text/css">

    <!-- Date Range Picker -->
    <link rel="stylesheet" href="{{ url('vendors/datepicker/daterangepicker.css') }}" type="text/css">

    <style>
        .dataTables_filter {
            display: none;
        }

        #btnaddItem {
            float: right
        }

        .text-left {
            text-align: left;
            background-color: #181818;
             !important color: rgb(10, 10, 10);
        }

        tr.group,
        tr.group:hover {
            background-color: rgb(82, 103, 222, 255) !important;
            color: rgb(255, 255, 255) !important;
            font-weight: bold;
        }

        tr {
            height: 10px;
        }


        /* Select2 Related CSS */
        .select2-selection__rendered {
            line-height: 31px !important;
        }

        .select2-container .select2-selection--single {
            height: 35px !important;
        }

        .form-control {
            height: 35px !important;
        }

        .select2-selection__arrow {
            height: 34px !important;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __($title) }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="\dashbord-Parent">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="\quality">{{ __('Quality') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="card-title">Lab Tests</h6>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary mr-1" style="float: right" id="btnNewTest">New Lab Test</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="testTypesSelect">Test Types</label>
                                <select class="form-control select2" id="testTypesSelect" placeholder="Select Test Types"></select>
                            </div>
                            <div class="col-md-2">
                                <label for="testStatusSelect">Status</label>
                                <select class="form-control select2" id="testStatusSelect" placeholder="Select Test Types">
                                    <option value="null">-All-</option>
                                    <option value="0">Pending</option>
                                    <option value="1">In-Progress</option>
                                    <option value="2">Closed</option>
                                    <option value="3">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="dateRangeLabTests">Test Date</label>
                                <input type="text" name="dateRangeLabTests" class="form-control" id="dateRangeLabTests">
                            </div>
                            <div class="col-md-2">
                                <label for="grnNoSelect">GRN No</label>
                                <select class="form-control select2" id="grnNoSelect" placeholder="Select GRNs"></select>
                            </div>

                            <div class="col-md-2">
                                <label for="notify">Search</label>
                                <input type="text" id="searchTblLabTestDetails" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive" tabindex="5" style="overflow: hidden; outline: none;">
                        <div id="orders_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="tblLabTestDetails" class="table table-striped table-bordered"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="thTestNo">Test No</th>
                                                <th class="thTestDate">Date</th>
                                                <th class="thTestStatus">Status</th>
                                                <th class="thTypes</">Test Types</th>
                                                <th class="thRelatedGRN</">Related GRNs</th>
                                                <th class="thActions">Actions</th>
                                            </tr>
                                        </thead>
                                        {{-- <tbody>
                                        </tbody> --}}
                                        <tbody>
                                            <tr role="row">
                                                <td><a href="#labtestdetailssection" type="button"
                                                        class="btn btn-warning btn-sm mb-1">TEST560500</a></td>
                                                <td>2023-01-12</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                                <td>
                                                    <ul>
                                                        <li><a type="button" class="btn btn-success btn-sm mb-1"
                                                                data-toggle="tooltip" data-placement="right"
                                                                data-html="true"
                                                                title="<b>Threshold : Lock(Alert)</b><br>YFT : 45(40)<br>SWD : 13(10)<br>BIG : 55(45)">Mercury
                                                            </a></li>
                                                        <li><a type="button" class="btn btn-success btn-sm mb-1"
                                                                data-toggle="tooltip" data-placement="right"
                                                                data-html="true"
                                                                title="<b>Threshold : Lock(Alert)</b><br>YFT : 45(40)<br>SWD : 13(10)<br>BIG : 55(45)">Histamine
                                                            </a></li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li><a href="/buying/grnHistory_configure?8036" type="button"
                                                                class="btn btn-primary btn-sm mb-1" data-toggle="tooltip"
                                                                data-placement="right" data-html="true"
                                                                title="<b>Status</b><br>RCV : Closed<br>FNC : Pending<br>VOU : Pending">GRN23510041</a>
                                                        </li>
                                                        <li><a href="/buying/grnHistory_configure?8036" type="button"
                                                                class="btn btn-primary btn-sm mb-1" data-toggle="tooltip"
                                                                data-placement="right" data-html="true"
                                                                title="<b>Status</b><br>RCV : Closed<br>FNC : Pending<br>VOU : Pending">GRN23510052</a>
                                                        </li>
                                                        <li><a href="/buying/grnHistory_configure?8036" type="button"
                                                                class="btn btn-primary btn-sm mb-1" data-toggle="tooltip"
                                                                data-placement="right" data-html="true"
                                                                title="<b>Status</b><br>RCV : Closed<br>FNC : Pending<br>VOU : Pending">GRN23515346</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-center">
                                                    <a href="#labtestdetailssection" class="btn btn-primary mr-1">View</a>
                                                    <button class="btn btn-danger mr-1" id="btnLabTestDelete2"><i
                                                            class="fa fa-trash" aria-hidden="true"></i></button>
                                                </td>
                                            </tr>
                                            <tr role="row">
                                                <td><a href="#labtestdetailssection" type="button"
                                                        class="btn btn-warning btn-sm mb-1">TEST560501</a></td>
                                                <td>2023-01-13</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                                <td>
                                                    <ul>
                                                        <li><a type="button" class="btn btn-success btn-sm mb-1"
                                                                data-toggle="tooltip" data-placement="right"
                                                                data-html="true"
                                                                title="<b>Threshold : Lock(Alert)</b><br>YFT : 45(40)<br>SWD : 13(10)<br>BIG : 55(45)">Parasite
                                                            </a></li>
                                                        <li><a type="button" class="btn btn-success btn-sm mb-1"
                                                                data-toggle="tooltip" data-placement="right"
                                                                data-html="true"
                                                                title="<b>Threshold : Lock(Alert)</b><br>YFT : 45(40)<br>SWD : 13(10)<br>BIG : 55(45)">Mercury
                                                            </a></li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li><a href="/buying/grnHistory_configure?8036" type="button"
                                                                class="btn btn-primary btn-sm mb-1" data-toggle="tooltip"
                                                                data-placement="right" data-html="true"
                                                                title="<b>Status</b><br>RCV : Closed<br>FNC : Pending<br>VOU : Pending">GRN23510041</a>
                                                        </li>
                                                        <li><a href="/buying/grnHistory_configure?8036" type="button"
                                                                class="btn btn-primary btn-sm mb-1" data-toggle="tooltip"
                                                                data-placement="right" data-html="true"
                                                                title="<b>Status</b><br>RCV : Closed<br>FNC : Pending<br>VOU : Pending">GRN23510052</a>
                                                        </li>
                                                        <li><a href="/buying/grnHistory_configure?8036" type="button"
                                                                class="btn btn-primary btn-sm mb-1" data-toggle="tooltip"
                                                                data-placement="right" data-html="true"
                                                                title="<b>Status</b><br>RCV : Closed<br>FNC : Pending<br>VOU : Pending">GRN23515346</a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="text-center">
                                                    <a href="#labtestdetailssection" class="btn btn-primary mr-1">View</a>
                                                    <button class="btn btn-danger mr-1"><i class="fa fa-trash"
                                                            aria-hidden="true" id="btnLabTestDelete"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="labtestdetailssection" style="overflow: auto;" hidden>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="card-title">Lab Test Details</h6>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-success" style="float: right" id="btnUpdateDetails">Update
                                Details</button>
                        </div>

                    </div>
                    <form id="frmLabTestDetails" autocomplete="off">
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" id="hiddenId" name="id">
                                <div class="col-md-2">
                                    <label for="testNo">Test No</label>
                                    <input type="text" name="testNo" class="form-control" id="testNo" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label for="labTestDetailsDate">Test Date</label>
                                    <input type="text" name="labTestDetailsDate" class="form-control"
                                        id="labTestDetailsDate">
                                </div>
                                <div class="col-md-2">
                                    <label for="testDetailsStatus">Test Status</label>
                                    <select class="form-control select" id="testDetailsStatus" name="testDetailsStatus" placeholder="Select GRNs">
                                        <option value="0">Pending</option>
                                        <option value="1">In-Progress</option>
                                        <option value="2">Closed</option>
                                        <option value="3">Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="testDescription">Test Description</label>
                                    <input type="text" name="testDescription" class="form-control"
                                        id="testDescription">
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-primary mb-3"
                                id="btnNewTestSample">{{ _('Create Test Sample') }}</button>
                            <table id="tblLabTestDetailsSamples" class="table table-striped table-bordered"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="thSampleNo">{{ _('Sample No') }}</th>
                                        <th class="thFishNo">Fish No(s)</th>
                                        <th class="thActions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr role="row">
                                        <td><button type="button" class="btn btn-warning btn-sm mb-1">SAMP200041</button>
                                        </td>
                                        <td>
                                            <ul>
                                                <li><a href="/buying/grnHistory_configure?8036" type="button"
                                                        class="btn btn-primary btn-sm mb-1">GRN23510041</a>
                                                    ->
                                                    <a type="button" class="btn btn-secondary btn-sm mb-1">F414001</a>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-primary btn-sm mr-1" id="btnEditTestSample"><i
                                                    class="fa fa-pencil" aria-hidden="true"></i></button>
                                            <button class="btn btn-danger btn-sm mr-1"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-primary mb-3" id="btnAddTestType">Add Test Type</button>
                            <table id="tblLabTestDetailsTestTypes" class="table table-striped table-bordered"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="thTestType">Test Type</th>
                                        <th class="thStatus">Status</th>
                                        <th class="thActions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr role="row">
                                        <td><button type="button" class="btn btn-primary btn-sm mb-1">Parasite</button>
                                        </td>
                                        <td><button type="button" class="btn btn-warning btn-sm mb-1">Test
                                                Pending</button></td>
                                        <td class="text-center">
                                            <button class="btn btn-primary btn-sm mr-1" id="btnEditAndResults">Edit &
                                                Results</button>
                                            <button
                                                class="btn
                                                btn-danger btn-sm mr-1"><i
                                                    class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                    </tr> --}}


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Modals --}}

    {{-- New Test Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalNewTest">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Test</h5>
                    <div>
                        <button type="button" class="btn btn-success" id="btnModalSaveNewTest">
                            Save
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </button>
                    </div>

                </div>
                <div class="modal-body pt-0">
                    <form id="frmlabTestTypesConfigure" autocomplete="off">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="newtestNo">Test No</label>
                                    <input type="text" name="newtestNo" class="form-control" id="newtestNo"
                                        value="NEW" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="labTestDate">Test Date</label>
                                    <input type="text" name="labTestDate" class="form-control" id="labTestDate">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label for="newtestDescription">Test Description</label>
                                    <input type="text" name="newtestDescription" class="form-control"
                                        id="newtestDescription">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label for="newTestTestType">Test Types</label>
                                    <select class="form-control select2" id="newTestTestType"
                                        placeholder="Select Test Types" multiple></select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- New Edit Sample Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalNewEditTestSample">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Test Sample</h5>
                    <div>
                        <button type="button" class="btn btn-success" id="sampBtnSave">
                            Save
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </button>
                    </div>

                </div>
                <input type="hidden" name="compositionId" id="compositionId">
                <div class="modal-body pt-0">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="validationCustom02">{{ __('Sample No') }}</label>
                            <input type="text" id="sampleNo" name="sampleNo" class="form-control" value="NEW"
                                readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom02">{{ __('Type') }}</label>
                            <select class="form-control" id="sampType" placeholder="Select Test Types">
                                <option value="1">Single</option>
                                <option value="2">Composition</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="sampFishType">Fish Type</label>
                            <select class="form-control select2" id="sampFishType"
                                placeholder="Select Test Types"></select>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom02">{{ __('Remarks') }}</label>
                            <input type="text" id="sampleRemarks" name="sampleRemarks" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="sampSupplier">Supplier</label>
                            <select class="form-control select2" id="sampSupplier" placeholder="Select Test Types">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="sampGRNNo">GRN No</label>
                            <select class="form-control select2" id="sampGRNNo" placeholder="Select Test Types">
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom02">{{ __('Scan/Enter Fish') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" id="scan" name="scan" class="form-control"
                                    placeholder="Scan/Enter Fish">
                                <div class="input-group-append">
                                    <button class="btn" type="button">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row justify-content-center mt-4">
                        <div class="col-md-5">
                            <h6>GRN Fish</h6>

                            <div class="table-responsive">
                                <table id="tableGrnNotSelected" class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="thGRNNo">GRN</th>
                                            <th class="thFishNo">Fish</th>
                                            <th class="thType">Type</th>
                                            <th class="thNetWgt">Weight</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <tr>
                                            <td>GRN406654</td>
                                            <td>45</td>
                                            <td>YFT</td>
                                            <td>24.650 KG</td>
                                        </tr> --}}

                                    </tbody>
                                </table>
                            </div>
                            <div class="btn-group btn-group-sm pt-2" role="group" aria-label="Small button group">
                                <button type="button" class="btn btn-primary" id="btnSelectall1">Select All</button>
                            </div>

                        </div>

                        <div class="col-md-2 text-center my-auto">
                            <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" id="buttonToLeft1">
                                    <i class="ti-angle-left"></i>
                                </button>
                                <button type="button" class="btn btn-primary" id="buttonToRight1">
                                    <i class="ti-angle-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-5 pb-2">
                            <h6>Selected Fish</h6>
                            <div class="table-responsive">
                                <table id="tableGrnSelected" class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="thGRNNo">GRN</th>
                                            <th class="thFishNo">Fish</th>
                                            <th class="thType">Type</th>
                                            <th class="thNetWgt">Weight</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <tr>
                                            <td>GRN406654</td>
                                            <td>45</td>
                                            <td>YFT</td>
                                            <td>24.650 KG</td>
                                        </tr> --}}

                                    </tbody>
                                </table>
                            </div>
                            <div class="btn-group btn-group-sm pt-2" role="group" aria-label="Small button group">
                                <button type="button" class="btn btn-primary" id="btnSelectall2">Select All</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Test Type Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalAddTestType">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Test Type</h5>
                    <div>
                        <button type="button" class="btn btn-success" id="btnModalSaveAddTestType">
                            Save
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </button>
                    </div>

                </div>
                <div class="modal-body pt-0">
                    <form id="addTestTypeForm">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="labTestTypeDateTime">Test Date & Time</label>
                                    <input type="text" name="labTestTypeDateTime" class="form-control"
                                        id="labTestTypeDateTime">
                                </div>
                                <div class="col-md-6">
                                    <label for="newtestNo">Test Equipment</label>
                                    <input type="text" name="testEqup" class="form-control" id="testEqup">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for="testTypeTestBy">Test By</label>
                                    <select class="form-control select2" id="testTypeTestBy"
                                        placeholder="Select Employee" name="testTypeTestBy">

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="newtestNo">Verify By</label>
                                    <select class="form-control select2" id="testTypeVerifydBy"
                                        placeholder="Select Employee" name="testTypeVerifydBy">

                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label for="selectedTestTypes">Test Types</label>
                                    <select class="form-control select2" id="selectedTestTypes"
                                        placeholder="Select Test Types" name="selectedTestTypes">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit & Results Test Type Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalEditAndResults">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit & Test Results</h5>
                    <div>
                        <button type="button" class="btn btn-success" id="modalEditAndResults_btnSave">Save </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </button>
                    </div>

                </div>
                <div class="modal-body pt-0">
                    <div class="row">
                        <input type="hidden" id="hiddenTestTypeDtlId">
                        <div class="col-md-6">
                            <label for="resultsTestTypes">Test Types</label>
                            {{-- <select class="form-control select2" id="resultsTestTypes" placeholder="Select Test Types">

                            </select> --}}
                            <input type="text" name="resultsEquipment" class="form-control" id="resultsTestTypes">

                        </div>
                        <div class="col-md-6">
                            <label for="resultsStatus">Test Status</label>
                            <select class="form-control select2" id="resultsStatus" placeholder="Select Test Types">
                                <option value="0">Test Pending</option>
                                <option value="1">Test In-Progress</option>
                                <option value="2">Results Pending</option>
                                <option value="3">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="labTestResultsDateTime">Test Date & Time</label>
                            <input type="text" name="labTestResultsDateTime" class="form-control"
                                id="labTestResultsDateTime">
                        </div>
                        <div class="col-md-6">
                            <label for="resultsEquipment">Test Equipment</label>
                            <input type="text" name="resultsEquipment" class="form-control" id="resultsEquipment">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="resultsTestBy">Test By</label>
                            <select class="form-control select2" id="resultsTestBy" placeholder="Select Employee"></select>
                        </div>
                        <div class="col-md-6">
                            <label for="newtestNo">Verify By</label>
                            <select class="form-control select2" id="resultsVerifydBy" placeholder="Select Employee"></select>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h6>Lab Test Results</h6>

                            <div class="table-responsive">
                                <table id="tableLabTestResults" class="table table-striped table-bordered"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="thSampleNo">Sample No</th>
                                            <th class="thResult">Results</th>
                                            <th class="thvalueStatus">Value Status</th>
                                            <th class="thUpdateStatus">Update Status</th>
                                            <th class="thAction">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <tr>
                                            <td><span class="badge badge-warning">SAMP200041</span></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="Results Value" value="" id="inputResultsValue">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="resultUnit">PPM</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a class="badge badge-warning" data-toggle="tooltip"
                                                    data-placement="right" data-html="true"
                                                    title="<b>Threshold : Lock(Alert)</b><br>YFT : 45(40)<br>SWD : 13(10)<br>BIG : 55(45)">ALERT
                                                    LEVEL</a></td>
                                            <td><span class="badge badge-danger">Not Updated</span></td>
                                            <td><button type="button" class="btn btn-primary btn-sm"
                                                    id="btnUpdateResult">Update Result</button></td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge badge-warning">SAMP200042</span></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="Results Value" id="inputResultsValue">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="resultUnit">PPM</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a class="badge badge-danger" data-toggle="tooltip"
                                                    data-placement="right" data-html="true"
                                                    title="<b>Threshold : Lock(Alert)</b><br>YFT : 45(40)<br>SWD : 13(10)<br>BIG : 55(45)">LOCK
                                                    LEVEL</a></td>
                                            <td><span class="badge badge-danger">Not Updated</span></td>
                                            <td><button type="button" class="btn btn-primary btn-sm"
                                                    id="btnUpdateResult">Update Result</button></td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge badge-warning">SAMP200043</span></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="Results Value" id="inputResultsValue">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="resultUnit">PPM</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a class="badge badge-success" data-toggle="tooltip"
                                                    data-placement="right" data-html="true"
                                                    title="<b>Threshold : Lock(Alert)</b><br>YFT : 45(40)<br>SWD : 13(10)<br>BIG : 55(45)">SAFE
                                                    LEVEL</a></td>
                                            <td><span class="badge badge-danger">Not Updated</span></td>
                                            <td><button type="button" class="btn btn-primary btn-sm"
                                                    id="btnUpdateResult">Update Result</button></td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge badge-warning">SAMP200044</span></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="Results Value" id="inputResultsValue">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="resultUnit">PPM</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a class="badge badge-warning" data-toggle="tooltip"
                                                    data-placement="right" data-html="true"
                                                    title="<b>Threshold : Lock(Alert)</b><br>YFT : 45(40)<br>SWD : 13(10)<br>BIG : 55(45)">ALERT
                                                    LEVEL</a></td>
                                            <td><span class="badge badge-danger">Not Updated</span></td>
                                            <td><button type="button" class="btn btn-primary btn-sm"
                                                    id="btnUpdateResult">Update Result</button></td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                            <div class="btn-group btn-group-sm pt-2" role="group" aria-label="Small button group">
                                <button type="button" class="btn btn-primary" id="btnSelectall1">Select All</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>

    {{-- Searchable select --}}
    <script src="{{ url('vendors/select2/js/select2.min.js') }}"></script>

    {{-- Date Range Picker  --}}
    <script src="{{ url('vendors/datepicker/daterangepicker.js') }}"></script>

    {{-- Form Repeater  --}}
    <script src="{{ url('vendors/jquery.repeater.min.js') }}"></script>

    <script src="{{ Module::asset('quality:js/masters/qualityLabTests.js') }}"></script>
@endsection
