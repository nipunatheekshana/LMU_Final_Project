@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "Quality Control" @endphp

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

        .select2-selection__arrow {
            height: 34px !important;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('Quality Control') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="\dashbord-Parent">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="\quality">{{ __('Quality') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Quality Control') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mb-3 d-flex justify-content-end">
        <div class="col-md-3 mb-2">
            <button id="btnSelectGRN" name="btnSelectGRN" class="btn btn-primary btn-block">Select GRN</button>
        </div>
        <div class="col-md-3 mb-2">
            <button id="btnLabTests" class="btn btn-success btn-block" style="float: right"
                onclick="window.location.href='qualitylabtests';" type="button">
                Lab Tests
            </button>
        </div>
    </div>


    <div class="row">
        {{-- Notify Address Columm --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-2">{{ __('GRN Details ') }}</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-0">{{ __('GRN No') }}</p>
                            <h5 id="header_grnNo">-</h5>
                            <p class="mb-0">{{ __('GRN Date') }}</p>
                            <h5 id="header_grnDate">-</h5>
                            <p class="mb-0">{{ __('Supplier') }}</p>
                            <h5 id="header_supplier">-</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-2">{{ __('Status ') }}</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0">{{ __('Total') }}</p>
                            <span class="badge badge-primary mb-2 w-100" id="header_total">-</span>
                            <p class="mb-0">{{ __('Processed') }}</p>
                            <span class="badge badge-primary mb-2 w-100" id="header_processed">-</span>
                            <p class="mb-0">{{ __('Unprocessed') }}</p>
                            <span class="badge badge-primary mb-0 w-100" id="header_unprocessed">-</span>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">{{ __('Receiving') }}</p>
                            <div id="header_receivingStatus"> <span class="badge badge-primary mb-2 w-100">-</span></div>
                            <p class="mb-0">{{ __('Finance') }}</p>
                            <div id="header_financeStatus"><span class="badge badge-primary mb-2 w-100">-</span></div>
                            <p class="mb-0">{{ __('Voucher') }}</p>
                            <div id="header_voucherStatus"><span class="badge badge-primary mb-2 w-100">-</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Notify Address Columm --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    {{-- <h5 class="card-title mb-2">{{ __('GRN Details ') }}</h5> --}}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row mb-0">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-7">
                                    <select class="select2" id="testType" name="testType"></select>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary btn-block"
                                        id="btnThresholds">Thresholds</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    {{-- <h5 class="card-title mb-2">{{ __('Status ') }}</h5> --}}
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary btn-block" id="btnAdminChanges">Admin
                                Changes</button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary btn-block dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Reports
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Histamine Report</a>
                                <a class="dropdown-item" href="#">Mercury Level Report</a>
                                <a class="dropdown-item" href="#">HACCP Report</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Selected Lab Test Report</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Notify Address Columm --}}
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    {{-- <h5 class="card-title mb-2">{{ __('GRN Details ') }}</h5> --}}


                    <h6 class="card-title mb-0">{{ __('Fish Details') }}</h6>

                    <table id="tblFishDetails" class="table table-striped Date display">
                        <thead>
                            <tr>
                                <th class="thNo">{{ __('NO') }}</th>
                                <th class="thFishType">{{ __('Type') }}</th>
                                <th class="thQGrade">{{ __('Grd') }}</th>
                                <th class="thSize">{{ __('Size') }}</th>
                                <th class="thWeight">{{ __('Wgh') }}</th>
                                <th class="thStatus">{{ __('Status') }}</th>
                                <th class="thTestValue">{{ __('Test Value') }}</th>
                                <th class="thQualityStatus">{{ __('Quality Status') }}</th>
                                <th class="thAction">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <tr>
                                <td>1</td>
                                <td>YFT</td>
                                <td>B+</td>
                                <td>SM-2</td>
                                <td>24.65</td>
                                <td><span class="badge badge-success">Processed</span></td>
                                <td>24.36</td>
                                <td><span class="badge badge-danger">Locked</span></td>
                                <td>
                                    <button class="btn btn-success btn-sm mr-1" id="btnUnlock"><i class="fa fa-unlock"
                                            aria-hidden="true"></i></button>
                                    <button class="btn btn-primary btn-sm" id="btnEdit"><i class="fa fa-pencil"
                                            aria-hidden="true"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>YFT</td>
                                <td>B+</td>
                                <td>SM-2</td>
                                <td>24.65</td>
                                <td><span class="badge badge-success">Processed</span></td>
                                <td>24.36</td>
                                <td> </td>
                                <td>
                                    <button class="btn btn-danger btn-sm mr-1" id="btnLockFish"><i class="fa fa-lock"
                                            aria-hidden="true"></i></button>
                                    <button class="btn btn-primary btn-sm mr-1" id="btnEdit"><i class="fa fa-pencil"
                                            aria-hidden="true"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>YFT</td>
                                <td>B+</td>
                                <td>SM-2</td>
                                <td>24.65</td>
                                <td><span class="badge badge-success">Processed</span></td>
                                <td>24.36</td>
                                <td><span class="badge badge-warning">Rejected</span></td>
                                <td>
                                    <button class="btn btn-success btn-sm mr-1" id="btnUnlockFish" disabled><i
                                            class="fa fa-unlock" aria-hidden="true"></i></button>
                                    <button class="btn btn-primary btn-sm" id="btnEdit"><i class="fa fa-pencil"
                                            aria-hidden="true"></i></button>
                            </td> --}}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3 d-flex align-items-stretch">
            <div class="card">
                <div class="card-body">
                    {{-- <h5 class="card-title mb-2">{{ __('Status ') }}</h5> --}}
                    <button type="button" class="btn btn-primary btn-block" id="btnSelectAllFish">
                        <i class="fa fa-plus-circle mr-2"></i>
                        Select All
                    </button>
                    <button type="button" class="btn btn-primary btn-block" id="btnDeSelectAllFish">
                        <i class="fa fa-minus-circle mr-2"></i>
                        Deselect All
                    </button>
                    <button type="button" class="btn btn-danger btn-block" id="btnLockSelectedFish">
                        <i class="fa fa-lock mr-2"></i>
                        Lock Selected
                    </button>
                    <button type="button" class="btn btn-success btn-block" id="btnUnlockSelectedFish">
                        <i class="fa fa-unlock mr-2"></i>
                        Unlock Selected
                    </button>
                    <hr>
                    <strong>
                        <a id="testType"> Histamine </a>
                        <a>Value Update</a>
                    </strong>
                    <div class="form-group row">
                        <div class="col-sm-6 pr-0">
                            <input type="number" class="form-control" id="value" placeholder="Value">
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-danger btn-block" id="btnSetTestValue">Update</button>
                        </div>
                    </div>
                    <hr>
                    <button type="button" class="btn btn-danger btn-block" id="btnRejectGroup">Reject Selected</button>
                    <button type="button" class="btn btn-success btn-block" id="btnAllowGroup">Allow</button>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Notify Address Columm --}}
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    {{-- <h5 class="card-title mb-2">{{ __('GRN Details ') }}</h5> --}}

                    <h6 class="card-title mb-0">{{ __('Pcs Details') }}</h6>

                    <table id="tblPcsDetails" class="table table-striped Date display">
                        <thead>
                            <tr>
                                <th class="thNo">{{ __('No') }}</th>
                                <th class="thPcsCode">{{ __('Pcs Code') }}</th>
                                <th class="thWeight">{{ __('Weight') }}</th>
                                <th class="thStatus">{{ __('Status') }}</th>
                                <th class="thTestValue">{{ __('Test') }}</th>
                                <th class="thQualityStatus">{{ __('Quality') }}</th>
                                <th class="thAction">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <tr>
                                <td>1</td>
                                <td>GB001442</td>
                                <td>2.650</td>
                                <td><span class="badge badge-success">Packed</span></td>
                                <td>25</td>
                                <td><span class="badge badge-danger">Locked</span></td>
                                <td>
                                    <button class="btn btn-success btn-sm mr-1" id="btnUnlockPcs"><i class="fa fa-unlock"
                                            aria-hidden="true"></i></button>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3 d-flex align-items-stretch">
            <div class="card">
                <div class="card-body">
                    {{-- <h5 class="card-title mb-2">{{ __('Status ') }}</h5> --}}
                    <button type="button" class="btn btn-primary btn-block" id="btnSelectAllPcs">
                        <i class="fa fa-plus-circle mr-2"></i>
                        Select All
                    </button>
                    <button type="button" class="btn btn-primary btn-block" id="btnDeSelectAllPcs">
                        <i class="fa fa-minus-circle mr-2"></i>
                        Deselect All
                    </button>
                    <button type="button" class="btn btn-danger btn-block" id="btnLockSelectedPcs">
                        <i class="fa fa-lock mr-2"></i>
                        Lock Selected
                    </button>
                    <button type="button" class="btn btn-success btn-block" id="btnUnlockSelectedPcs">
                        <i class="fa fa-unlock mr-2"></i>
                        Unlock Selected
                    </button>
                    <hr>
                    <button type="button" class="btn btn-danger btn-block" id="btnRejectPce">Reject Selected</button>
                    <button type="button" class="btn btn-success btn-block" id="btnAllowPce">Allow</button>

                </div>
            </div>
        </div>
    </div>


    {{-- Modals --}}

    {{-- Select Packing List --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalSelectGRN">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select GRN</h5>
                    <div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </button>
                    </div>

                </div>
                <div class="modal-body pt-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="col-md-2 mb-3">
                                    <label for="validationCustom02">{{ __('Supplier') }}</label>
                                    <select class="select2" name="supplier" id="supplier">
                                        <option value="">-Select-</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationCustom02">{{ __('Boat') }}</label>
                                    <select class="select2" name="boat" id="boat">
                                        <option value="">-Select-</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationCustom02">{{ __('Type') }}</label>
                                    <select class="select2" name="type" id="type">
                                        <option value="">-Select-</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validationCustom02">{{ __('Date Range') }}</label>
                                    <input type="text" id="daterangepicker" name="daterangepicker"
                                        class="form-control">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="validationCustom01">{{ __('Search') }}</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control" id="tableSearch"
                                            placeholder="Search">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tblGRNDetails" class="table table-striped Date display nowrap">
                                    <thead>
                                        <tr>
                                            <th class="thGrnNo">{{ __('GRN No') }}</th>
                                            <th class="thGRNDate">{{ __('GRN Date') }}</th>
                                            <th class="thType">{{ __('Type') }}</th>
                                            <th class="thSupplier">{{ __('Supplier') }}</th>
                                            <th class="thTotalQty"> {{ __('Total Qty') }}</th>
                                            <th class="thTotalWeight">{{ __('Total Weight') }}</th>
                                            <th class="thUnprocessedPCs">{{ __('Unprocessed PCs') }}</th>
                                            <th class="thProcessedPcs">{{ __('Processed Pcs') }}</th>
                                            <th class="thTransferPcs">{{ __('Transfer Pcs') }}</th>
                                            <th class="thRejectPcs">{{ __('Reject Pcs') }}</th>
                                            <th class="thReceivingStatus">{{ __('Receiving Status') }}</th>
                                            <th class="thFinanceStatus">{{ __('Finance Status') }}</th>
                                            <th class="thVoucherStatus">{{ __('Voucher Status') }}</th>
                                            <th class="thGrnNo2">{{ __('GRN No') }}</th>
                                            <th class="thAction">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tresholds Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalTresholds">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Threshold Values</h5>
                    <div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </button>
                    </div>

                </div>
                <div class="modal-body pt-0">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="card-title mb-0">{{ __('Test Type : Histamine') }}</h6>

                            <table id="tblTresholds" class="table table-striped Date display">
                                <thead>
                                    <tr>
                                        <th class="thFishType">{{ __('Fish Type') }}</th>
                                        <th class="thTresholdAlert">{{ __('Alert Treshold') }}</th>
                                        <th class="thTresholdLock">{{ __('Lock Treshold') }}</th>
                                        <th class="thAutoLock">{{ __('Auto Lock Enabled?') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Yellowfin Tuna</td>
                                        <td>20.0</td>
                                        <td>25.0</td>
                                        <td>
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="customSwitchInline1">
                                                <label class="custom-control-label" for="customSwitchInline1"> </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Swordfish</td>
                                        <td>18.5</td>
                                        <td>20.0</td>
                                        <td>
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="customSwitchInline2" checked>
                                                <label class="custom-control-label" for="customSwitchInline2"> </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bigeye Tuna</td>
                                        <td>23.0</td>
                                        <td>25.0</td>
                                        <td>
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="customSwitchInline3">
                                                <label class="custom-control-label" for="customSwitchInline3"> </label>
                                            </div>
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

    {{-- Change Properties Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalChangeProperties">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Properties</h5>
                    <div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </button>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Fish Type</label>
                                <div class="col-sm-9">
                                    <select class="select2" aria-describedby="passwordHelpBlock">
                                        <option>IMUA-24-25233 | Sahan Putha | 2023-02-05</option>
                                        <option>IMUA-24-46322 | HBS-53 | 2023-02-05</option>
                                        <option>IMUA-24-36243 | Kasun Putha | 2023-02-05</option>
                                        <option>IMUA-24-13242 | Theekshana Putha | 2023-12-05</option>
                                        <option>IMUA-34-25233 | Dilmi Duwa | 2024-02-05</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Landing Site</label>
                                <div class="col-sm-9">
                                    <select class="select2" aria-describedby="passwordHelpBlock">
                                        <option>Galle</option>
                                        <option>Diklanda</option>
                                        <option>Trincomalee</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-success">
                            Update
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Admin Changes Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalAdminChanges">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Admin Changes</h5>
                    <div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </button>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Boat</label>
                                <div class="col-sm-9">
                                    <select class="select2" aria-describedby="passwordHelpBlock" id="boatAdmin"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Landing Site</label>
                                <div class="col-sm-9">
                                    <select class="select2" aria-describedby="passwordHelpBlock" id="landingSites">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-success" id="btnUpdateAdminChanges">Update </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalReject">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject</h5>
                    <div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </button>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row mb-0">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Reject Reason</label>
                                <div class="col-sm-9">
                                    <select class="select2" aria-describedby="passwordHelpBlock" id="rejectReson">
                                        <option value="1">High Histamine</option>
                                        <option value="2">Parasites</option>
                                        <option value="3">Bad Smell</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-danger" id="rejectConfirmBtn">
                            Reject Selected
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Edit Fish Details Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalEditFish">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Fish Details</h5>
                    <div>
                        <button type="button" class="btn btn-success mr-3" id="modalEditFish_btnUpdate">
                            Update
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </button>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0">{{ __('Selectd Fish No') }}</p>
                            <h5 id="EditFish_fishNo">-</h5>
                            <p class="mb-0">{{ __('Fish Type') }}</p>
                            <h5 id="EditFish_fishType">-</h5>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">{{ __('Size') }}</p>
                            <h5 id="EditFish_size">-</h5>
                            <p class="mb-0">{{ __('Weight') }}</p>
                            <h5 id="EditFish_weight">-</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row mb-0">
                                <label for="staticEmail" class="col-sm-6 col-form-label">Quality Grade</label>
                                <div class="col-sm-6">
                                    <input type="hidden" id="EditFish_grnDtlId">
                                    <select class="select2" aria-describedby="passwordHelpBlock"
                                        id="EditFish_grade"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5 class="card-title py-2">{{ __('Quality Status History ') }}</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="timeline" id="timeline">
                                {{-- <div class="timeline-item">
                                    <div>
                                        <figure class="avatar avatar-sm mr-3 bring-forward">
                                            <span class="avatar-title bg-danger-bright text-danger rounded-circle">
                                                <i class="fa fa-lock" aria-hidden="true"></i>
                                            </span>
                                        </figure>
                                    </div>
                                    <div>
                                        <h6 class="d-flex justify-content-between mb-4">
                                            <span>
                                                Fish Status Locked
                                            </span>
                                            <span class="text-muted font-weight-normal">2023-05-01 08:17pm</span>
                                        </h6>
                                    </div>
                                </div> --}}
                                {{-- <div class="timeline-item">
                                    <div>
                                        <figure class="avatar avatar-sm mr-3 bring-forward">
                                            <span class="avatar-title bg-success-bright text-success rounded-circle">
                                                <i class="fa fa-unlock" aria-hidden="true"></i>
                                            </span>
                                        </figure>
                                    </div>
                                    <div>
                                        <h6 class="d-flex justify-content-between mb-4">
                                            <span>
                                                Fish Status Unlock
                                            </span>
                                            <span class="text-muted font-weight-normal">2023-05-01 09:24pm</span>
                                        </h6>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div>
                                        <figure class="avatar avatar-sm mr-3 bring-forward">
                                            <span class="avatar-title bg-info-bright text-info rounded-circle">
                                                <i class="fa fa-flask" aria-hidden="true"></i>
                                            </span>
                                        </figure>
                                    </div>
                                    <div>
                                        <h6 class="d-flex justify-content-between mb-4">
                                            <span>
                                                Histamine Set to PPM 25.00
                                            </span>
                                            <span class="text-muted font-weight-normal">2023-05-01 09:25pm</span>
                                        </h6>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div>
                                        <figure class="avatar avatar-sm mr-3 bring-forward">
                                            <span class="avatar-title bg-warning-bright text-warning rounded-circle">
                                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                                            </span>
                                        </figure>
                                    </div>
                                    <div>
                                        <h6 class="d-flex justify-content-between mb-4">
                                            <span>
                                                Fish Status Rejected
                                            </span>
                                            <span class="text-muted font-weight-normal">2023-05-01 10:27pm</span>
                                        </h6>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div>
                                        <figure class="avatar avatar-sm mr-3 bring-forward">
                                            <span class="avatar-title bg-success-bright text-success rounded-circle">
                                                <i class="fa fa-unlock" aria-hidden="true"></i>
                                            </span>
                                        </figure>
                                    </div>
                                    <div>
                                        <h6 class="d-flex justify-content-between mb-4">
                                            <span>
                                                Fish Status Unlock
                                            </span>
                                            <span class="text-muted font-weight-normal">2023-05-01 09:24pm</span>
                                        </h6>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div>
                                        <figure class="avatar avatar-sm mr-3 bring-forward">
                                            <span class="avatar-title bg-info-bright text-info rounded-circle">
                                                <i class="fa fa-flask" aria-hidden="true"></i>
                                            </span>
                                        </figure>
                                    </div>
                                    <div>
                                        <h6 class="d-flex justify-content-between mb-4">
                                            <span>
                                                Mercury Set to 0.02%
                                            </span>
                                            <span class="text-muted font-weight-normal">2023-05-01 09:25pm</span>
                                        </h6>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div>
                                        <figure class="avatar avatar-sm mr-3 bring-forward">
                                            <span class="avatar-title bg-warning-bright text-warning rounded-circle">
                                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                                            </span>
                                        </figure>
                                    </div>
                                    <div>
                                        <h6 class="d-flex justify-content-between mb-4">
                                            <span>
                                                Fish Status Rejected
                                            </span>
                                            <span class="text-muted font-weight-normal">2023-05-01 10:27pm</span>
                                        </h6>
                                    </div>
                                </div> --}}
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


    <script src="{{ Module::asset('quality:js/masters/qualityControlConfigure.js') }}"></script>
@endsection
