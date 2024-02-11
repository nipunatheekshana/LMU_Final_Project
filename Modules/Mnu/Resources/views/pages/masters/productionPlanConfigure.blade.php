@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "Production Plan" @endphp

@section('title', $title)
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('vendors/datepicker/daterangepicker.css') }}" type="text/css">

    {{-- custom css --}}
    <link rel="stylesheet" href="{{ Module::asset('mnu:css/productionPlanConfigure.css') }}" type="text/css">


@endsection

@section('content')
    <div class="row justify-content-between">
        <div class="col-md-6 ">
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

        <div class="col-md-2 ">
            <div class="card">
                <div class="card-body p-3">
                    <p class="card-title m-0">Today New Requirements</p>
                    <div class="d-flex align-items-center mb-0">
                        <div class="avatar">
                            <span class="avatar-title bg-success-bright text-success rounded-pill">
                                <i class="ti-calendar"></i>
                            </span>
                        </div>
                        <h1 id="Todayrequirements" class="m-0 ml-2">-</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 ">
            <div class="card">
                <div class="card-body p-3">
                    <p class="card-title m-0">Total Pending Requirements</p>
                    <div class="d-flex align-items-center mb-0">
                        <div class="avatar">
                            <span class="avatar-title bg-warning-bright text-warning rounded-pill">
                                <i class="ti-package"></i>
                            </span>
                        </div>
                        <h1 id="requirements" class="m-0 ml-2">-</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 ">
            <div class="card">
                <div class="card-body p-3">
                    <p class="card-title m-0">New Change Requests</p>
                    <div class="d-flex align-items-center mb-0">
                        <div class="avatar">
                            <span class="avatar-title bg-danger-bright text-danger rounded-pill">
                                <i class="ti-exchange-vertical"></i>
                            </span>
                        </div>
                        <h1 id="ChangeReq" class="m-0 ml-2">-</h1>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Pending to Plan Requirements') }}</h6>

                    {{-- Filters Row --}}
                    <div class="form-row">
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom02">Process</label>
                            <select class="form-control" name="process" id="process">
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom02">Workstation</label>
                            <select class="form-control" name="work_station" id="work_station">
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationCustom02">Date Range</label>
                            <input type="text" name="daterangepicker" id="daterangepicker" class="form-control">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tableproductionPlan" class="table table-striped table-bordered Date display nowrap">
                            <thead>
                                <tr>
                                    <th class="action"> {{ __('') }}</th>
                                    <th class="thId">#</th>
                                    <th class="thRequiredDate">{{ __('Required Date') }}</th>
                                    <th class="thItem">{{ __('Item') }}</th>
                                    <th class="thRemainingQty">{{ __('Remaining Qty') }}</th>
                                    <th class="thRemainingWeight">{{ __('Remaining Weight') }}</th>
                                    <th class="thPlaningQty">{{ __('Planing Qty') }}</th>
                                    <th class="thPlaningWeight">{{ __('Planing Weight') }}</th>
                                    <th class="thPlaningDate">{{ __('Planing date') }}</th>
                                    <th class="thCustomer">{{ __('Customer') }}</th>
                                    <th class="thNotifyParty">{{ __('Notify Party') }}</th>
                                    <th class="thRefNumber">{{ __('Ref Number') }}</th>
                                    <th class="thProcess">{{ __('Process') }}</th>
                                    <th class="thWorkstation">{{ __('Workstation') }}</th>
                                    <th class="thProductionDate">{{ __('Production Date') }}</th>
                                    <th class="thExpiryDate">{{ __('Expiry Date') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <button id="btnASelectAll" class="btn btn-primary mb-0 ml-2" style="float: right"
                                type="button">Select All</button>
                            <button id="btnSetValues" class="btn btn-success mb-0 ml-2" style="float: right"
                                type="button">Set Values</button>
                            <button id="btnSave" class="btn btn-danger mb-0 ml-2" style="float: right"
                                type="button">Save</button>
                            {{-- <div class="form-group form-check mt-3" style="float: right">
                                <input type="checkbox" onchange="" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Ignor Order Number</label>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            {{-- Today Plans --}}
            <div class="card">
                <div class="card-body">
                    <div class="card-scroll" style="height: 650px;">
                        <h6 class="card-title">{{ __('Plans') }}</h6>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="col-md-12 mb-2">
                                            <label for="validationCustom02">Date</label>
                                            <input type="date" class="form-control" id="plansFilter_date">

                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="col-md-12 mb-2">
                                            <label for="validationCustom02">Process</label>
                                            <select class="form-control" name="process2" id="process2">

                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="validationCustom02">Workstation</label>
                                            <select class="form-control" name="work_station2" id="work_station2">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="g1" style="height: 200px"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive mt-2">
                                    <table id="tableTodayPlan"
                                        class="table table-striped table-bordered Date display nowrap">
                                        <thead>
                                            <tr>
                                                <th class="thId">{{ __('ID') }}</th>
                                                <th class="thItem">{{ __('Item') }}</th>
                                                <th class="thPlannedQty">{{ __('Planned Qty') }}</th>
                                                <th class="thPlannedweight">{{ __('Planned Weight') }}</th>
                                                <th class="thCompletedQty">{{ __('Completed Qty') }}</th>
                                                <th class="thCompletedWeight">{{ __('Completed Weight') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-scroll" style="height: 350px;">
                        <h6 class="card-title">{{ __('Change Requests') }} <div id="ChangeRequestSpiner"
                                class="spinner-grow text-danger" role="status"></div>
                        </h6>

                        <div class="container">
                            <div class="row">
                                <div class="table-responsive mt-2">
                                    <table id="tableChangeRequest"
                                        class="table table-striped table-bordered Date display nowrap">
                                        <thead>
                                            <tr>
                                                <th class="thCustomer">{{ __('Customer') }}</th>
                                                <th class="thOrderNo">{{ __('Order No') }}</th>
                                                <th class="thItem">{{ __('Item') }}</th>
                                                <th class="thPreviousQty">{{ __('Previous Qty') }}</th>
                                                <th class="thNewQty">{{ __('New Qty') }}</th>
                                                <th class="thActions">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-body">
                    <div class="card-scroll" style="height: 500px;">
                        <div class="d-flex justify-content-between">
                            <h6 class="card-title mb-2">{{ __('Item Requirement') }}</h6>
                            <a id="btnLoadItemRequirements" class="btn btn-floating">
                                <i class="ti-reload"></i>
                            </a>
                        </div>
                        <div class="table-responsive mt-2">
                            <table id="tableItemRequirement"
                                class="table table-striped table-bordered Date display nowrap">
                                <thead>
                                    <tr>
                                        <th class="thitem">{{ __('Item') }}</th>
                                        <th class="thRequiredQty">{{ __('Required Qty') }}</th>
                                        <th class="thStockQty">{{ __('Stock Qty') }}</th>
                                        {{-- <th class="thAlreadyPlanedQty">{{ __('Already Planed Qty') }}</th> --}}
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-scroll" style="height: 500px;">
                        <div class="d-flex justify-content-between">
                            <h6 class="card-title">{{ __('Packing Material Requirement') }}</h6>
                            <a id="btnLoadPackingRequirements" class="btn btn-floating">
                                <i class="ti-reload"></i>
                            </a>
                        </div>
                        <div class="table-responsive mt-2">
                            <table id="tablePackingMaterialReq"
                                class="table table-striped table-bordered Date display nowrap">
                                <thead>
                                    <tr>
                                        <th class="thitem">{{ __('Item') }}</th>
                                        <th class="thRequiredQty">{{ __('Required Qty') }}</th>
                                        <th class="thStockQty">{{ __('Stock Qty') }}</th>
                                        {{-- <th class="thAlreadyPlanedQty">{{ __('Already Planed Qty') }}</th> --}}
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- models --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="ModelBulkPlaning">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Set Values | Bulk</h6>

                    <button type="button" class="btn btn-secondary" id="btnUpdateValuesBulf">Update
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">{{ __('Planing Date') }}</label>
                            <input type="date" id="Bulk_Planing_Date" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Lable Manufacture Date') }}</label>
                            <input type="date" id="Bulk_Lable_Manufacture_Date" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Lable Expiry Date') }}</label>
                            <input type="date" id="Bulk_Lable_Expiry_Date" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="ModelIndividualPlanning">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Set Values | Selected Requirement</h6>

                    <button type="button" class="btn btn-secondary" id="btnUpdateIndividual">Update
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="g2" style="height: 200px"></div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>{{ __('Requirement ID') }}</label><br>
                            <label>{{ __('Required Date') }}</label><br>
                            <label>{{ __('Item') }}</label><br>
                            <label>{{ __('Ref No') }}</label><br>
                            <label>{{ __('Customer') }}</label><br>
                            <label>{{ __('Notify') }}</label>
                        </div>
                        <div class="col-md-8">
                            <label id="individual_RequirementID"></label><br>
                            <label id="individual_RequiredDate"></label><br>
                            <label id="individual_Item"></label><br>
                            <label id="individual_RefNo"></label><br>
                            <label id="individual_Customer"></label><br>
                            <label id="individual_Notify"></label><br>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="individualTxtBx_RemainingQty">
                            <input type="hidden" id="individualTxtBx_UnitWeight">
                            <input type="hidden" id="individualTxtBx_RowIndex">

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">{{ __('Workstation') }}</label>
                                    <select class="form-control" name="work_station3" id="work_station3">
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">{{ __('Planing Quantity') }}</label>
                                    <input type="number" class="form-control" id="individualTxtBx_PlaningQuantity">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">{{ __('Planing Weight') }}</label>
                                    <input type="text" class="form-control" id="individualTxtBx_PlaningWeight"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">{{ __('Plan Date') }}</label>
                                    <input type="date" class="form-control" id="individualTxtBx_PlanDate">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">{{ __('Manufacturing Date') }}</label>
                                    <input type="date" class="form-control" id="individualTxtBx_ManufacturingDate">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">{{ __('Expire Date') }}</label>
                                    <input type="date" class="form-control" id="individualTxtBx_ExpireDate">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true"
        id="ModelChangeRequests">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Change Requests</h6>

                    <button type="button" class="btn btn-secondary" id="btnUpdateChangeReqWS">Update
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <p class="mb-0">{{ __('New Plan') }}</p>
                            <h4 class="text-warning " id="newPlan">-</h4>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-0">{{ __('Plans Adjusted') }}</p>
                            <h4 class="text-muted " id="Plans_Adjusted">-</h4>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-0">{{ __('Remain to plan') }}</p>
                            <h4 class="text-danger " id="Remain_to_plan">-</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">{{ __('Requirement Id') }}</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-8" id="RequirementId"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">{{ __('Required Date') }}</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-8" id="RequiredDate"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">{{ __('Item') }}</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-8" id="Item"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">{{ __('Ref No') }}</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-8" id="RefNo"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">{{ __('Customer') }}</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-8" id="Customer"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">{{ __('Notify') }}</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-8" id="Notify"></div>
                    </div>

                    <form id="changeReqWSHidden">
                        <input type="hidden" name="hidden_RequirementId" id="hidden_RequirementId">
                        <input type="hidden" name="hidden_Item" id="hidden_Item">
                        <input type="hidden" name="hidden_ItemCode" id="hidden_ItemCode">
                        <input type="hidden" name="hidden_ItemName" id="hidden_ItemName">
                        <input type="hidden" name="hidden_RefNo" id="hidden_RefNo">
                        <input type="hidden" name="hidden_Customer" id="hidden_Customer">
                        <input type="hidden" name="hidden_Notify" id="hidden_Notify">
                        <input type="hidden" name="WsChangeReqId" id="WsChangeReqId">

                    </form>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <button id="btnResetpln" class="btn btn-danger mr-2" style="float: right"
                                type="button">Reset</button>
                            <button id="btnNewPlan" class="btn btn-success mr-2" style="float: right" type="button">New
                                Plan</button>
                        </div>

                    </div>

                    <div class="table-responsive mt-2">
                        <table id="tableChangeRequestWorkSheets"
                            class="table table-striped table-bordered Date display nowrap">
                            <thead>
                                <tr>
                                    <th class="thWorkstation">{{ __('Workstation') }}</th>
                                    <th class="thStatus">{{ __('Status') }}</th>
                                    <th class="thPlanQty">{{ __('Plan Qty') }}</th>
                                    <th class="thCompleatedQty">{{ __('Compleated Qty') }}</th>
                                    <th class="thBalance">{{ __('Balance') }}</th>
                                    <th class="action">{{ __('Action') }}</th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- <div class="modal-footer">

                </div> --}}
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="ModelEdiWSValueEdit">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="validationCustom01">{{ __('Quantity') }}</label>
                            <input type="number" class="form-control" id="ModelEdiWSValueEdit_Quantity">
                            <input type="hidden" id="ModelEdiWSValueEdit_rowID">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="ModelEdiWSValueEdit_UpdateIndividual">Update
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="ModelAddNewWS">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="validationCustom01">{{ __('Workstation') }}</label>
                            <select class="form-control" id="work_station4"></select>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom01">{{ __('Quantity') }}</label>
                            <input type="number" class="form-control" id="ModelAddNewWS_Quantity">
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom01">{{ __('Manufacture Date') }}</label>
                            <input type="date" class="form-control mb-3" id="ModelAddNewWS_Manufacture_Date">
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom01">{{ __('Expire Date') }}</label>
                            <input type="date" class="form-control mb-3" id="ModelAddNewWS_Expire_Date">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnAddNewWsRow">Update
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
    <script src="{{ url('vendors/charts/justgage/raphael-2.1.4.min.js') }}"></script>
    <script src="{{ url('vendors/charts/justgage/justgage.js') }}"></script>

    <script src="{{ Module::asset('mnu:js/masters/productionPlanConfigure.js') }}"></script>
@endsection
