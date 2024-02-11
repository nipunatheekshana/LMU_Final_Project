@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "GRN Details" @endphp

@section('title', $title)

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
    {{-- searchable select --}}
    <link rel="stylesheet" href="{{ url('vendors/select2/css/select2.min.css') }}" type="text/css">

    <style>
        .dataTables_filter {
            display: none;
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
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('GRN History') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-12">
            <button id="btnSubmit" class="btn btn-warning mb-3" style="float: right" type="button">Submit</button>
            <button id="btnDeny" class="btn btn-danger mb-3 mr-2" style="float: right" type="button">Deny</button>
            <button id="btnApprove" class="btn btn-success mb-3 mr-2" style="float: right" type="button">Approve</button>
            <button id="btnSave" class="btn btn-primary mb-3 mr-2" style="float: right" type="button">Save</button>
        </div>
    </div> --}}
    {{-- header --}}

    <div class="container-lg">
        <div class="row justify-content-between">
            <div class="col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-2">{{ __('GRN Details ') }}</h5>

                        <div class="row">
                            <div class="col-md-3">
                                <p class="mb-0">{{ __('GRN #') }}</p>
                                <h5 class="text-muted " id="header_grnNo">-</h5>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-0">{{ __('Boat Reg.') }}</p>
                                <h5 class="text-muted " id="header_BoatReg">-</h5>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-0">{{ __('Supplier No') }}</p>
                                <h5 class="text-muted " id="header_supplier_no">-</h5>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-0">{{ __('Batch No') }}</p>
                                <h5 class="text-muted " id="header_batchNo">-</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <p class="mb-0">{{ __('Date #') }}</p>
                                <h5 class="text-muted " id="header_date">-</h5>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-0">{{ __('Boat Name') }}</p>
                                <h5 class="text-muted " id="header_BoatName">-</h5>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0">{{ __('Supplier') }}</p>
                                <h5 class="text-muted " id="header_Supplier">-</h5>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-xl-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-2">{{ __('GRN Details ') }}</h5>
                        <div class="row">
                            <div class="col-md-4 m-0 p-0">
                                <div class="col-md-12">
                                    <p class="mb-0">{{ __('Fish Qty') }}</p>
                                    <h3 class="text-muted " id="header_FishQty">-</h3>
                                </div>
                                <div class="col-md-12">
                                    <p class="mb-0">{{ __('Fish Wgt') }}</p>
                                    <h3 class="text-muted m-0 p-0" id="header_fishWeight">-</h3>
                                </div>
                            </div>
                            <div class="col-md-4 m-0 p-0">
                                <div class="col-md-12">
                                    <p class="mb-0">{{ __('Proc. Qty') }}</p>
                                    <h3 class="text-muted " id="header_proc_qty">-</h3>
                                </div>
                                <div class="col-md-12">
                                    <p class="mb-0">{{ __('Proc. Wgt') }}</p>
                                    <h3 class="text-muted m-0 p-0" id="header_Proc_Weight">-</h3>
                                </div>
                            </div>
                            <div class="col-md-4 m-0 p-0">
                                <div class="col-md-12">
                                    <p class="mb-0">{{ __('Unpr. Qty') }}</p>
                                    <h3 class="text-muted " id="header_unProcQty">-</h3>
                                </div>
                                <div class="col-md-12">
                                    <p class="mb-0">{{ __('Unpr. Wgt') }}</p>
                                    <h3 class="text-muted m-0 p-0" id="header_unprocWeight">-</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-2">{{ __('Status') }}</h6>
                        <div class="row">
                            <div class="col-md-4 mb-0">
                                <label for="validationCustom01">{{ __('Unloading') }}</label>
                                <span class="badge bg-success-bright text-success">
                                    <h6 class="mt-1">Completed</h6>
                                </span>
                            </div>
                            <div class="col-md-4 mb-0">
                                <label for="validationCustom01">{{ __('Unloading') }}</label>
                                <span class="badge bg-danger-bright text-danger">
                                    <h6 class="mt-1">Closed</h6>
                                </span>
                            </div>
                            <div class="col-md-4 mb-0">
                                <label for="validationCustom01">{{ __('Unloading') }}</label>
                                <span class="badge bg-warning-bright text-warning">
                                    <h6 class="mt-1">Pending</h6>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body ">
                        <h6 class="card-title mb-2">{{ __('Actions') }}</h6>
                        <div class="col-md-12 m-0 p-0 d-flex justify-content-between">
                            <span class="pb-0">{{ __('Select Desired Action') }}</span>
                        </div>
                        <div class="col-md-12 p-0 mt-2">
                            <button type="button" class="btn btn-primary mr-2" id="btnGrnPriceing"> Pricing </button>
                            <button type="button" class="btn btn-primary mr-2" id="btnSizeTable"> Sizing </button>
                            <button type="button" class="btn btn-warning mr-2" id="btnAdminChanges"> Changes </button>
                            <button type="button" class="btn btn-danger mr-2" id="btnStatusSetting"> Status </button>
                            <button type="button" class="btn btn-warning mr-2" id="btnWastage"> Add wastage </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-2">
                <div class="card">
                    <div class="card m-0">
                        <div class="card-body ">
                            <h6 class="card-title mb-3">{{ __('Auto Update') }}</h6>
                            <div class="form-group mb-0">
                                <span class="pb-3">{{ __('Turn on/off') }}</span>
                                <div class="custom-control custom-switch mt-2 mb-0">
                                    <input type="checkbox" class="custom-control-input mb-0" id="customSwitch1" checked>
                                    <label class="custom-control-label mb-0" for="customSwitch1"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-4">{{ __('Reports') }}</h6>
                        <div class="form-row">

                            <div class="col-md-8">
                                <select class="form-control" name="reportSelector" id="reportSelector">
                                    <option value="">-Select-</option>
                                    <option value="1">Fish Details(Excel)</option>
                                    <option value="2">Fish Details(PDF)</option>
                                    <option value="3">Production Sheet(Excel)</option>
                                    <option value="4">Production Sheet(PDF)</option>
                                    <option value="5">Export Summary(Excel)</option>
                                    <option value="6">Export Summary(PDF)</option>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-success btn-sm" id="btnReport">View Report</button>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- order items Section --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row">

                        <div class="col-md-2 mb-3">
                            <label for="validationCustom02">{{ __('Type ') }}</label>
                            <select class="form-control" name="type" id="type">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom02">{{ __('Presentation') }}</label>
                            <select class="form-control" name="presentation" id="presentation">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom02">{{ __('Size ') }}</label>
                            <select class="form-control" name="size" id="size">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-1 mb-3">
                            <label for="validationCustom02">{{ __('Pay Grade') }}</label>
                            <select class="form-control" name="pay_grade" id="pay_grade">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom02">{{ __('Quality Grade') }}</label>
                            <select class="form-control" name="quality_grade" id="quality_grade">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="validationCustom01">{{ __('Search') }}</label>

                            <div class="input-group">
                                <input type="text" class="form-control" id="tableSearch" placeholder="Search here">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            data-feather="search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table id="tableFishDetails" class="table table-striped Date display nowrap">
                        <thead>
                            <tr>
                                <th class="action">{{ __('Action') }}</th>
                                <th class="thFishNo">{{ __('Fish #') }}</th>
                                <th class="thFishBarcode">{{ __('Fish Barcode') }}</th>
                                <th class="thFishType">{{ __('Fish Type') }}</th>
                                <th class="thPresentationType">{{ __('Presentation Type') }}</th>
                                <th class="thPayGrade">{{ __('Pay Grade') }}</th>
                                <th class="thQualityQrade">{{ __('Quality Qrade') }}</th>
                                <th class="thSize">{{ __('Size') }}</th>
                                <th class="thWeight">{{ __('Weight') }}</th>
                                <th class="thStatus">{{ __('Status') }}</th>
                                <th class="thProductionMode">{{ __('Production Mode') }}</th>
                                <th class="thProductionWeight">{{ __('Production Weight') }}</th>
                                <th class="thRecovery">{{ __('Recovery') }}</th>
                                <th class="thExportWeight">{{ __('Export Weight') }}</th>
                                <th class="thDamage">{{ __('Damage') }}</th>
                                <th class="thTemperature">{{ __('Temperature') }}</th>
                                <th class="thFishSelector">{{ __('Fish Selector') }}</th>
                                <th class="thWorkstation">{{ __('Workstation') }}</th>
                                <th class="MobileUser">{{ __('MobileUser') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Footer --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="chartjs_three"></canvas>

                    <div class="table-responsive mt-2">
                        <table id="tableSummaryFishType" class="table table-striped Date display nowrap">
                            <thead>
                                <tr>
                                    <th class="thFishType">{{ __('Fish Type') }}</th>
                                    <th class="thQty">{{ __('Qty') }}</th>
                                    <th class="thWeight">{{ __('Weight') }}</th>
                                    <th class="thProcessedQty">{{ __('Processed Qty') }}</th>
                                    <th class="thProcessedWeight">{{ __('Processed Weight') }}</th>
                                    <th class="thUnprocessedQty">{{ __('Unprocessed Qty') }}</th>
                                    <th class="thUnprocessedWeight">{{ __('Unprocessed Weight') }}</th>
                                    <th class="thTransferQty">{{ __('Transfer Qty') }}</th>
                                    <th class="thTransferWeight">{{ __('Transfer Weight') }}</th>
                                    <th class="thRejecrQty">{{ __('Rejecr Qty') }}</th>
                                    <th class="thRejecrWeight">{{ __('Rejecr Weight') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div id="g1"></div>
                    <div id="g2"></div>

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="height: 40%">
                <div class="card-body">
                    <h5>Quality Details</h5>
                </div>
            </div>
        </div>
    </div>


    {{-- models --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modelAdminChanges">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Admin Changes') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>{{ __('Supplier Details') }}</h5>
                    <form id="FrmModelAdminChanges" autocomplete="off">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Supplier') }}</label>
                                <select class="form-control" name="supplier" id="supplier">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <h5>{{ __('Boat Details') }}</h5>

                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom02">{{ __('Boat') }}</label>
                                <select class="form-control" name="boat" id="boat">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">{{ __('Skipper Name') }}</label>
                                        <input type="text" class="form-control" name="skipper_name"
                                            id="skipper_name">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="validationCustom01">{{ __('Licence No') }}</label>
                                        <input type="text" class="form-control" name="licence_no" id="licence_no">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">{{ __('Signature') }}</label>
                                                <input type="file" class="form-control" name="signature"
                                                    id="signature">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">{{ __('Licence Expiry Date') }}</label>
                                                <input type="date" class="form-control" name="licence_expire_date"
                                                    id="licence_expire_date">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>{{ __('Licence Status') }}</h6>
                                        <span class="badge bg-warning-bright text-warning mb-3 mt-1">
                                            <h6 class="m-1">{{ __('Pending') }}</h6>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-primary" id="btnAddToTable">{{ __('Add') }}</button> --}}
                    <button type="button" class="btn btn-success"
                        id="btnUpdateAdminChanges">{{ __('Update') }}</button>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modelStatusSetting">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Status Setting') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modelStatusSetting_form">
                        <div class="row">
                            <div class="col-md-2">
                                <h6>{{ __('Receving') }}</h6>
                                <span class="badge bg-danger-bright text-danger mb-3 mt-1">
                                    <h6 class="m-1">{{ __('Close') }}</h6>
                                </span>
                            </div>
                            <div class="col-md-7">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="validationCustom01">{{ __('Remark | Hold Reason') }}</label>
                                        <input type="text" class="form-control"
                                            name="modelStatusSetting_receive_reson" id="modelStatusSetting_receive_reson">
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-warning mt-4"
                                    id="modelStatusSetting_Receive_btnHold"
                                    style="float: left">{{ __('Hold') }}</button>
                                <button type="button" class="btn btn-danger mt-4"
                                    id="modelStatusSetting_Receive_btnClose"
                                    style="float: right">{{ __('Close') }}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <h6>{{ __('Finance') }}</h6>
                                <span class="badge bg-success-bright text-success mb-3 mt-1">
                                    <h6 class="m-1">{{ __('Compleated') }}</h6>
                                </span>
                            </div>
                            <div class="col-md-7">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="validationCustom01">{{ __('Remark') }}</label>
                                        <input type="text" class="form-control"
                                            name="modelStatusSetting_finance_remark"
                                            id="modelStatusSetting_finance_remark">
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-danger btn-block mt-4 "
                                    id="modelStatusSetting_Finance_btnClose">{{ __('Close') }}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <h6>{{ __('Voucher') }}</h6>
                                <span class="badge bg-warning-bright text-warning mb-3 mt-1">
                                    <h6 class="m-1">{{ __('Pending') }}</h6>
                                </span>
                            </div>
                            <div class="col-md-7">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="validationCustom01">{{ __('Remark') }}</label>
                                        <input type="text" class="form-control"
                                            name="modelStatusSetting_voucher_remark"
                                            id="modelStatusSetting_voucher_remark">
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-danger btn-block mt-4"
                                    id="modelStatusSetting_Voucher_btnClose">{{ __('Close') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modelFishDetailsUpdate">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Fish Details Update') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmFishDetailUpdate" autocomplete="off">
                        <input type="hidden" id="FishDetailModel_grnNo" name="grnno">
                        <input type="hidden" id="FishDetailModel_fishNo" name="fishNo">

                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-0">{{ __('GRN #') }}</p>
                                <h6 class="text-muted " id="FishDetailModel_grnNoLable">-</h6>
                            </div>
                            <div class="col-md-6">
                                <label for="validationCustom01">{{ __('Fish Type') }}</label>
                                <select class="form-control" name="FishDetailModel_fishtype"
                                    id="FishDetailModel_fishtype">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="validationCustom01">{{ __('Size Code') }}</label>
                                <select class="form-control" name="FishDetailModel_sizeCode"
                                    id="FishDetailModel_sizeCode">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom01">{{ __('Weight') }}</label>
                                        <input type="text" class="form-control" name="FishDetailModel_Weight"
                                            id="FishDetailModel_Weight">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom01">{{ __('Temperature') }}</label>
                                        <input type="text" class="form-control" name="FishDetailModel_temperature"
                                            id="FishDetailModel_temperature">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="validationCustom01">{{ __('Presentation Type') }}</label>
                                <select class="form-control" name="FishDetailModel_presentation_type"
                                    id="FishDetailModel_presentation_type">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom01">{{ __('Pay Grade') }}</label>
                                        <select class="form-control" name="FishDetailModel_pay_grade"
                                            id="FishDetailModel_pay_grade">
                                            <option value="">-Select-</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom01">{{ __('Quality Grade') }}</label>
                                        <select class="form-control" name="FishDetailModel_quality_grade"
                                            id="FishDetailModel_quality_grade">
                                            <option value="">-Select-</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <button type="button" class="btn btn-primary btn-block"
                                    id="btnAddToTable">{{ __('Print Fish Tag') }}</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-success btn-block"
                                    id="btn_FishDetailModel_Update">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </form>


                </div>
                {{-- <div class="modal-footer">

                    <button type="button" class="btn btn-primary"
                        id="btnAddPreviousItems">{{ __('Add') }}</button>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-hidden="true" id="modelFishSizeTable">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Fish Size Table') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modelFishSizeTable_Form">
                        <div class="row">
                            <div class="col-md-9 mb-3">
                                <label for="validationCustom01">{{ __('Fish Species') }}</label>
                                <select class="form-control" name="modelFishSizeTable_FishSpecies"
                                    id="modelFishSizeTable_FishSpecies">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-danger btn-block mt-4"
                                    id="">{{ __('Reset Table') }}</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="validationCustom01">{{ __('Minimum Weight') }}</label>
                                <input type="text" class="form-control" name="modelFishSizeTable_minValue"
                                    id="modelFishSizeTable_minValue" readonly>

                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustom01">{{ __('Maximum Weight') }}</label>
                                <input type="text" class="form-control" name="modelFishSizeTable_maxValue"
                                    id="modelFishSizeTable_maxValue">

                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustom01">{{ __('Discription') }}</label>
                                <input type="text" class="form-control" name="modelFishSizeTable_Discription"
                                    id="modelFishSizeTable_Discription">

                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success btn-block mt-4"
                                    id="modelFishSizeTable_BtnAdd">{{ __('Add') }}</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <table id="tableFishSize" class="table table-striped table-bordered Date display nowrap">
                        <thead>
                            <tr>
                                <th class="thSize">{{ __('Discription') }}</th>
                                <th class="thSizeCode">{{ __('Size Code') }}</th>
                                <th class="action">{{ __('Action') }}</th>

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"
                        id="btnUpdateGrnTableSize">{{ __('Update') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modelProductionDetail">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Production Detail') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-0">{{ __('Fish #') }}</p>
                                    <h6 class="text-muted " id="modelProductionDetail_FishNo">-</h6>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-0">{{ __('GRN #') }}</p>
                                    <h6 class="text-muted " id="modelProductionDetail_GRNNo">-</h6>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-0">{{ __('Fish Type') }}</p>
                                    <h6 class="text-muted " id="modelProductionDetail_FishType">-</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-0">{{ __('Batch #') }}</p>
                                    <h6 class="text-muted " id="modelProductionDetail_BatchNo">-</h6>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-0">{{ __('GRN date') }}</p>
                                    <h6 class="text-muted " id="modelProductionDetail_GRNdate">-</h6>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-0">{{ __('Supplier') }}</p>
                                    <h6 class="text-muted " id="modelProductionDetail_Supplier">-</h6>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="avatar">
                                                <span class="avatar-title bg-primary-bright text-primary rounded-pill">
                                                    <i class="ti-rss-alt"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <p class="mb-0">{{ __('Fish  Weight') }}</p>
                                            <h6 class="text-muted " id="modelProductionDetail_FishWeight">-</h6>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-3">
                                            {{-- <i class="fa fa-balance-scale fa-lg text-danger"></i> --}}
                                            <div class="avatar">
                                                <span class="avatar-title bg-warning-bright text-warning rounded-pill">
                                                    <i class="ti-control-eject"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <p class="mb-0">{{ __('Product Weight') }}</p>
                                            <h6 class="text-muted " id="modelProductionDetail_ProductWeight">-</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="avatar">
                                                <span class="avatar-title bg-success-bright text-success rounded-pill">
                                                    <i class="ti-share-alt"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <p class="mb-0">{{ __('Recovery') }}</p>
                                            <h6 class="text-muted " id="modelProductionDetail_Recovery">-</h6>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <table id="tableProductionDetails" class="table table-striped table-bordered Date display nowrap">
                        <thead>
                            <tr>
                                <th class="thNo">{{ __('#') }}</th>
                                <th class="thPcsId">{{ __('Pcs Id') }}</th>
                                <th class="thItemNmae">{{ __('Item Nmae') }}</th>
                                <th class="thCustomer">{{ __('Customer') }}</th>
                                <th class="thWeight">{{ __('Weight') }}</th>
                                <th class="thOperator">{{ __('Operator') }}</th>
                                <th class="thTimeSupervisor">{{ __('Time Supervisor') }}</th>
                                <th class="thTimmer">{{ __('Timmer') }}</th>
                                <th class="thProductiondateandtime">{{ __('Production date and time') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>
                {{-- <div class="modal-footer">
                </div> --}}
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modelGrnPriceing">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('GRN Pricing') }}<span
                            class="badge bg-warning-bright text-warning ml-2">Pending</span></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row  mb-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-0">{{ __('GRN Date') }}</p>
                                    <h6 class="text-muted " id="modelGrnPriceing_grn_date">-</h6>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-0">{{ __('GRN #') }}</p>
                                    <h6 class="text-muted " id="modelGrnPriceing_grn_no">-</h6>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-0">{{ __('Supplier') }}</p>
                                    <h6 class="text-muted " id="modelGrnPriceing_supplier">-</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <Div class="row d-flex justify-content-center">
                                <button type="button" class="btn btn-primary mr-2"
                                    id="btn_modelGrnPriceing_groupPricing"> {{ __('Group Pricing ') }}
                                </button>
                                <button type="button" class="btn btn-secondary mr-2"> {{ __('Download Report ') }} <br>
                                    (PDF) </button>
                                <button type="button" class="btn btn-secondary mr-2"> {{ __('Download Request') }} <br>
                                    (Excel) </button>

                            </Div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="validationCustom01">{{ __('Pay Currancy') }}</label>
                            <select class="form-control" id="modelGroupPricing_payCurrancy"></select>

                        </div>
                        <div class="col-md-3 mb-3 ml-3">
                            <p class="mb-3">{{ __('Exchange Rate') }}</p>
                            <h4 class="text-success " id="modelGrnPriceing_ExchangeRate">0</h4>
                            <input type="hidden" id="modelGrnPriceing_HiddenExchangeRate">

                        </div>
                    </div>
                    <div class="form-row">

                    </div>

                    <table id="tableGRNPricing" class="table table-striped table-bordered Date display nowrap ">
                        <thead>
                            <tr>
                                <th class="thFishType">{{ __('Fish Type') }}</th>
                                <th class="thPresentation">{{ __('Presentation') }}</th>
                                <th class="thSuppliergrade">{{ __('Supplier grade') }}</th>
                                <th class="thSizeCode">{{ __('Size Code') }}</th>
                                <th class="thQty">{{ __('Qty') }}</th>
                                <th class="thTotalWeight">{{ __('Total Weight') }}</th>
                                <th class="thUnitPrice">{{ __('Unit Price') }}</th>
                                <th class="thTotalPrice">{{ __('Total Price') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div class="accordion accordion-primary custom-accordion mt-3">
                        <div class="accordion-row">
                            <a href="#" class="accordion-header">
                                <span>{{ __('Additional Price Details') }}</span>
                                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                                <i class="accordion-status-icon open fa fa-chevron-down"></i>
                            </a>
                            <div class="accordion-body">

                            </div>
                        </div>
                        <div class="accordion-row open">
                            <a href="#" class="accordion-header">
                                <span>{{ __('Summary') }}</span>
                                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                                <i class="accordion-status-icon open fa fa-chevron-down"></i>
                            </a>
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustom01">{{ __('Pricing Date & time') }}</label>
                                                <input type="text" class="form-control"
                                                    id="modelGrnPriceing_pricingDateAndTime">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustom01">{{ __('Pricing User') }}</label>
                                                <input type="text"
                                                    class="form-control"id="modelGrnPriceing_PricingUser">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustom01">{{ __('Total Fish Weight') }}</label>
                                                <input type="text" class="form-control"
                                                    id="modelGrnPriceing_TotalFishWeight">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-6 text-right">
                                                <p>{{ __('Gross Value') }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control bg-warning-bright text-right"
                                                    id="modelGrnPriceing_grossval">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 text-right">
                                                <p>{{ __('Additional Cost') }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control  bg-info-bright text-right"
                                                    id="modelGrnPriceing_additionalCost">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 text-right ">
                                                <p>{{ __('Net Value') }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control bg-success-bright text-right"
                                                    id="modelGrnPriceing_netVal">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"
                        id="modelGrnPriceing_btnSave">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modelIndividualPricing">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Individual Pricing') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Fish Type') }}</label>
                            <input type="text" class="form-control" id="modelIndividualPricing_fishType">
                            <input type="hidden" id="modelIndividualPricing_hiddenRowId">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Presentation') }}</label>
                            <input type="text" class="form-control" id="modelIndividualPricing_presentation">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Grade') }}</label>
                            <input type="text" class="form-control" id="modelIndividualPricing_grade">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Size') }}</label>
                            <input type="text" class="form-control" id="modelIndividualPricing_size">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('No Of FIsh') }}</label>
                            <input type="text" class="form-control" id="modelIndividualPricing_NoOfFish">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Total Weight') }}</label>
                            <input type="text" class="form-control" id="modelIndividualPricing_TotalWeight">
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">{{ __('Price Per Unit Weight') }}</label>
                            <input type="text" class="form-control bg-warning-bright"
                                id="modelIndividualPricing_Price">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"
                        id="modelIndividualPricing_btnUpdate">{{ __('Update') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modelGroupPricing">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Individual Pricing') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Fish Type') }}</label>
                            <select class="form-control" id="modelGroupPricing_fishType"></select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Presentation') }}</label>
                            <select class="form-control" id="modelGroupPricing_presentation"></select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Grade') }}</label>
                            <select class="form-control" id="modelGroupPricing_grade"></select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Size') }}</label>
                            <select class="form-control" id="modelGroupPricing_size"></select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">{{ __('Price Per Unit Weight') }}</label>
                            <input type="number" class="form-control bg-warning-bright" id="modelGroupPricing_price">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"
                        id="modelGroupPricing_btn_update">{{ __('Update') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modelWastage">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Wastage') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <button id="btAddWastage" class="btn btn-primary mb-3" style="float: right" type="button">Add Wastage</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tableWatage"
                            class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thItemCode">{{ __('Item Code') }}</th>
                                    <th class="thItemName">{{ __('Item Name') }}</th>
                                    <th class="thWarehouse"> {{ __('Warehouse') }}</th>
                                    <th class="thTotalWeight"> {{ __('Total Weight') }}</th>
                                    <th class="thTotalValue"> {{ __('Total Value') }}</th>


                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-success"
                        id="modelAddWastage_btnAdd">{{ __('Add') }}</button>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modelAddWastage">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('Individual Pricing') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Item') }}</label>
                            <select class="form-control" id="Item"></select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Warehouse') }}</label>
                            <select class="form-control" id="Warehouse"></select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">{{ __('Qty') }}</label>
                            <input type="number" class="form-control bg-warning-bright" id="qty">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"
                        id="modelAddWastage_btnAdd">{{ __('Add') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>

    {{-- chart select --}}
    <script src="{{ url('vendors/charts/chartjs/chart.min.js') }}"></script>
    <script src="{{ url('vendors/charts/justgage/raphael-2.1.4.min.js') }}"></script>
    <script src="{{ url('vendors/charts/justgage/justgage.js') }}"></script>

    <script src="{{ Module::asset('buying:js/masters/grnHistoryConfigure.js') }}"></script>
@endsection
