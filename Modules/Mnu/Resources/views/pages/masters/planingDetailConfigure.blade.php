@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "Planing Detail" @endphp

@section('title', $title)
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('vendors/datepicker/daterangepicker.css') }}" type="text/css">

    {{-- custom css --}}
    <link rel="stylesheet" href="{{ Module::asset('mnu:css/planingDetailConfigure.css') }}" type="text/css">


@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 ">
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
    <div class="row">
        <div class="col-lg-6  d-flex align-items-stretch">
            <div class="card">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="card-title mb-2">{{ __('Plans') }}</h6>
                            </div>
                            <p class="text-muted mb-6">{{ __('Select Process to View the Plans') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">{{ __('Date Range') }}</label>
                            <input type="text" name="daterangepicker" id="daterangepicker" class="form-control">
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom02">{{ __('Status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value="">-Select-</option>
                                <option value="0">Open</option>
                                <option value="1">close</option>
                                <option value="2">Hold</option>


                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom02">{{ __('Process') }}</label>
                            <select class="form-control" name="process" id="process">
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom02">{{ __('Workstation') }}</label>
                            <select class="form-control" name="work_station" id="work_station">
                            </select>
                        </div>

                    </div>

                    <div class="table-responsive mt-2">
                        <table id="tableprocessPlan" class="table table-striped table-bordered Date display nowrap">
                            <thead>
                                <tr>
                                    <th class="status"></th>
                                    <th class="thPlanID">{{ __('Plan ID') }}</th>
                                    <th class="thPlanDate">{{ __('Plan Date') }}</th>
                                    <th class="thItem">{{ __('Item') }}</th>
                                    <th class="thPlannedQty">{{ __('Planned Qty') }}</th>
                                    <th class="thPlannedWeight">{{ __('Planned Weight') }}</th>
                                    <th class="thCompletedQty">{{ __('Completed Qty') }}</th>
                                    <th class="thCompletedWeight">{{ __('Completed Weight') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6  d-flex align-items-stretch">
            <div class="row">
                <div class="col-md-6 ">
                    <div class="card">
                        <div class="card-body">
                            {{-- <h6 class="card-title">{{ __('Completed Quantity') }}</h6> --}}
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <div id="g1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            {{-- <h6 class="card-title">{{ __('Completed Weight') }}</h6> --}}
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <div id="g2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-scroll" style="height: 350px;">
                                <h6 class="card-title">{{ __('Plan Details') }}</h6>
                                <div class="row">
                                    <div class="col-md-4 mb-0">
                                        <p class="mb-0">{{ __('Plan Id') }}</p>
                                        <h5 class="text-muted " id="details_planId">-</h5>
                                    </div>
                                    <div class="col-md-8 mb-0">
                                        <p class="mb-0">{{ __('Product Code') }}</p>
                                        <h5 class="text-muted " id="details_productCode">-</h5>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-0">
                                        <p class="mb-0">{{ __('Product Name') }}</p>
                                        <h5 class="text-muted " id="details_productName">-</h5>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-0">
                                        <p class="mb-0">{{ __('Assigned Workstation') }}</p>
                                        <h5 class="text-muted " id="details_assignedWorkstation">-</h5>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-0">
                                        <p class="mb-0">{{ __('Planned Date') }}</p>
                                        <h5 class="text-muted " id="details_planedDate">-</h5>

                                    </div>
                                    <div class="col-md-4 mb-0">
                                        <p class="mb-0">{{ __('Mnu. Date') }}</p>
                                        <h5 class="text-muted " id="details_mnuDate">-</h5>

                                    </div>
                                    <div class="col-md-4 mb-0">
                                        <p class="mb-0">{{ __('Expiry Date') }}</p>
                                        <h5 class="text-muted " id="details_expireDate">-</h5>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="height: 400px;">
                        <div class="card-body">
                            <h6 class="card-title">
                                <div class="spinner-grow" id="spinner_grow" role="status" style="width: 20px; height: 20px;">
                                </div>
                                <i id="statusText">-</i>
                            </h6>
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <button type="button" class="btn btn-primary btn-block" id="btnSplit">{{ __('Split') }}</button>
                                    <button type="button" class="btn btn-primary  btn-block" id="btnReProcess">{{ __('Reprocess') }}</button>
                                    <button type="button" class="btn btn-secondary  btn-block" id="btnWaste">{{ __('Waste ') }}</button>
                                    <button type="button" class="btn btn-secondary  btn-block" id="btnHold">{{ __('Hold') }}</button>
                                    <button type="button" class="btn btn-danger btn-block" id="btnClose">{{ __('Close') }}</button>
                                    <button type="button" class="btn btn-warning btn-block" id="btnChanges">{{ __('Changes') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card" id="CrdPlanStatus">
                <div class="card-body">
                    <h6 class="card-title mb-4">{{ __('Plan Status & Material Comsumption') }}</h6>
                    <div class="row">
                        <div class="col-md-6 ">
                            <h4>{{ __('Plan Status Timeline') }}</h4>
                        </div>
                        <div class="col-md-6 ">
                            <h4>{{ __('Material Comsumption Details') }}</h4>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="card-title mb-2">{{ __('Last Completed Plans') }}</h6>
                            </div>
                            <p class="text-muted mb-6">{{ __('View Latest Completed Plans') }}</p>
                        </div>
                    </div>

                    <div class="table-responsive mt-2">
                        <table id="tableLastCompleatedPlans"
                            class="table table-striped table-bordered Date display nowrap">
                            <thead>
                                <tr>
                                    <th class="thPlanID">{{ __('Plan ID') }}</th>
                                    <th class="thPlanDate">{{ __('Plan Date') }}</th>
                                    <th class="thItem">{{ __('Item') }}</th>
                                    <th class="thPlannedQty">{{ __('Planned Qty') }}</th>
                                    <th class="thPlannedWeight">{{ __('Planned Weight') }}</th>
                                    <th class="thCompletedQty">{{ __('Completed Qty') }}</th>
                                    <th class="thCompletedWeight">{{ __('Completed Weight') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="card-title mb-2">{{ __('Change Requests') }}</h6>
                            </div>
                            <p class="text-muted mb-6">{{ __('View all change requests') }}</p>
                        </div>
                    </div>

                    <div class="table-responsive mt-2">
                        <table id="tableLastCompleatedPlans"
                            class="table table-striped table-bordered Date display nowrap">
                            <thead>
                                <tr>
                                    <th class="thWSNo">{{ __('WS No') }}</th>
                                    <th class="thDateTime">{{ __('Date & Time') }}</th>
                                    <th class="thWorkstation">{{ __('Workstation') }}</th>
                                    <th class="thItem">{{ __('Item') }}</th>
                                    <th class="thOldQty">{{ __('Old Qty') }}</th>
                                    <th class="thNewQty">{{ __('New Qty') }}</th>
                                    <th class="thStatus">{{ __('Status') }}</th>
                                    <th class="thAction">{{ __('Action') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>PL10054</th>
                                    <th>2022-08-15 04:10 OM</th>
                                    <th>Final Packing Line 01</th>
                                    <th>Tuna Wrapped CC Loin 20 Kg Box</th>
                                    <th>150</th>
                                    <th>100</th>
                                    <th>
                                        <span class="badge bg-warning-bright text-warning"> Request Pending</span>
                                    </th>
                                    <th>
                                        <button type="button" class="btn btn-warning btn-block" id="btnClose">{{ __('Update') }}</button>
                                        <button type="button" class="btn btn-success btn-block" id="btnClose">{{ __('View') }}</button>
                                    </th>
                                </tr>
                                <tr>
                                    <th>PL10054</th>
                                    <th>2022-08-15 04:10 OM</th>
                                    <th>Final Packing Line 01</th>
                                    <th>Tuna Wrapped CC Loin 20 Kg Box</th>
                                    <th>150</th>
                                    <th>100</th>
                                    <th>
                                        <span class="badge bg-success-bright text-success"> Accepted (Modified) </span>
                                    </th>
                                    <th>
                                        <button type="button" class="btn btn-warning btn-block" id="btnClose">{{ __('Update') }}</button>
                                        <button type="button" class="btn btn-success btn-block" id="btnClose">{{ __('View') }}</button>
                                    </th>
                                </tr>
                                <tr>
                                    <th>PL10054</th>
                                    <th>2022-08-15 04:10 OM</th>
                                    <th>Final Packing Line 01</th>
                                    <th>Tuna Wrapped CC Loin 20 Kg Box</th>
                                    <th>150</th>
                                    <th>100</th>
                                    <th>
                                        <span class="badge bg-danger-bright text-danger"> Denied (Resumed) </span>
                                    </th>
                                    <th>
                                        <button type="button" class="btn btn-warning btn-block" id="btnClose">{{ __('Update') }}</button>
                                        <button type="button" class="btn btn-success btn-block" id="btnClose">{{ __('View') }}</button>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- models --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="ModelSplitPlan">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Split Plan</h6>

                    <button type="button" class="btn btn-secondary" id="splitModel_update">Update
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card mb-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-0">{{ __('Product Code') }}</p>
                                    <h4 class="text-muted " id="splitModel_productCode">-</h4>
                                </div>
                                <div class="col-md-8">
                                    <p class="mb-0">{{ __('Product Name') }}</p>
                                    <h4 class="text-muted " id="splitModel_productName">-</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" id="splitModel_weightPerUnit">
                                <div class="col-md-6 border-right">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h5 class="mt-3">{{ __('Planed') }}</h5>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-0">{{ __('Quantity') }}</p>
                                            <h6 class="text-muted " id="splitModel_PlanedQty">-</h6>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-0">{{ __('Weight') }}</p>
                                            <h6 class="text-muted " id="splitModel_planedWeight">-</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 border-left">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h5 class="">{{ __('Remaining In Current Plan') }}</h5>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-0">{{ __('Quantity') }}</p>
                                            <h6 class="text-muted " id="splitModel_remainingQty">-</h6>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-0">{{ __('Weight') }}</p>
                                            <h6 class="text-muted " id="splitModel_remainingWeight">-</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-2">{{ __('New Workstation Assign') }}
                                {{-- <button id="btnAddWorkstation" class="btn btn-primary btn-floating ml-2 mb-1"
                                    type="button"> <i class="ti-plus"></i></button> --}}
                            </h6>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">{{ __('Work station') }}</label>
                                    <select type="text" class="form-control" id="splitModel_Workstation">

                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationCustom01">{{ __('qty') }}</label>
                                    <input type="text" class="form-control" id="splitModel_qty">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="validationCustom01">{{ __('Weight') }}</label>
                                    <input type="text" class="form-control" id="splitModel_weight" readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <button id="btnAddWorkstation" class="btn btn-primary btn-floating mt-4 ml-4" type="button"> <i class="ti-plus"></i></button>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <button id="btnreaetTable" class="btn btn-danger btn-floating mt-4" type="button">  <i class="ti-reload"></i></button>
                                </div>

                            </div>
                            <div class="table-responsive">
                                <table id="tableWorkstations"
                                    class="table table-striped table-bordered Date display nowrap">
                                    <thead>
                                        <tr>
                                            <th class="thWorkstation"> {{ __('Workstation') }}</th>
                                            <th class="thAssignedQuantity"> {{ __('Assigned Quantity') }}</th>
                                            <th class="thAssignedWeight">{{ __('Assigned Weight') }}</th>
                                            {{-- <th class="Action">{{ __('Action') }}</th> --}}

                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
                {{-- <div class="modal-footer">

                <button type="button" class="btn btn-primary" id="btnWizardAddSelected">Add Selected
                </button>
            </div> --}}
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="ModelByProductAndWastage">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Byproducts & Wastage</h6>

                    <button type="button" class="btn btn-secondary" id="btnUpdateValuesBulf">Update
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card mb-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-0">{{ __('Product Code') }}</p>
                                    <h4 class="text-muted ">{{ __('TUN-CC-2KG-WL') }}</h4>
                                </div>
                                <div class="col-md-8">
                                    <p class="mb-0">{{ __('Product Name') }}</p>
                                    <h4 class="text-muted ">{{ __('Tuna Center-cut 2KG Wrapped Loin') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-2">{{ __('By-Products') }}
                                <button id="btnAddOtherItem" class="btn btn-primary btn-floating ml-2 mb-1"
                                    type="button"> <i class="ti-plus"></i></button>
                            </h6>
                            <div class="table-responsive">
                                <table id="tableByProducts"
                                    class="table table-striped table-bordered Date display nowrap">
                                    <thead>
                                        <tr>
                                            <th class="thItem"> {{ __('Item') }}</th>
                                            <th class="thQuantity"> {{ __('Quantity') }}</th>
                                            <th class="thWeight">{{ __('Weight') }}</th>
                                            <th class="AddtoStock">{{ __('Add to Stock') }}</th>
                                            <th class="Action">{{ __('Action') }}</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Production line 1</td>
                                            <td>50</td>
                                            <td>500 </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-floating">
                                                    <i class="ti-check"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-secondary btn-floating">
                                                    <i class="ti-close"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-2">{{ __('Packing Material') }}
                                <button id="btnAddOtherItem" class="btn btn-primary btn-floating ml-2 mb-1"
                                    type="button"> <i class="ti-plus"></i></button>
                            </h6>
                            <div class="table-responsive">
                                <table id="tablePackingMaterial"
                                    class="table table-striped table-bordered Date display nowrap">
                                    <thead>
                                        <tr>
                                            <th class="thItem"> {{ __('Item') }}</th>
                                            <th class="thQuantity"> {{ __('Quantity') }}</th>
                                            <th class="AddtoStock">{{ __('Add to Stock') }}</th>
                                            <th class="Action">{{ __('Action') }}</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Production line 1</td>
                                            <td>50</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-floating">
                                                    <i class="ti-check"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-secondary btn-floating">
                                                    <i class="ti-close"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
                {{-- <div class="modal-footer">

                <button type="button" class="btn btn-primary" id="btnWizardAddSelected">Add Selected
                </button>
            </div> --}}
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="ModelChangeRequests">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Change Requests</h6>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="card mb-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-0">{{ __('Plan ID') }}</p>
                                    <h4 class="text-muted ">{{ __('PL120001') }}</h4>
                                </div>
                                <div class="col-md-8">
                                    <p class="mb-0">{{ __('Product Code') }}</p>
                                    <h4 class="text-muted ">{{ __('TUN-CC-2KG-WL') }}</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="mb-0">{{ __('Product Name') }}</p>
                                    <h4 class="text-muted ">{{ __('Tuna Center-cut 2KG Wrapped Loin') }}</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="mb-0">{{ __('Assigned Workstations') }}</p>
                                    <h4 class="text-muted ">{{ __('Packing Line - 01') }}</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <p class="mb-0">{{ __('Plan Qty') }}</p>
                                    <h4 class="text-muted ">{{ __('150') }}</h4>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">{{ __('Plan Weight') }}</p>
                                    <h4 class="text-muted ">{{ __('325.00') }}</h4>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">{{ __('Completed Qty') }}</p>
                                    <h4 class="text-muted ">{{ __('110') }}</h4>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">{{ __('Completed Weight') }}</p>
                                    <h4 class="text-muted ">{{ __('234.00') }}</h4>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-2">
                                        <table id="tableLastCompleatedPlans"
                                            class="table table-striped table-bordered Date display nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="thDateTime">{{ __('Date & Time') }}</th>
                                                    <th class="thOldQty">{{ __('Old Qty') }}</th>
                                                    <th class="thNewQty">{{ __('New Qty') }}</th>
                                                    <th class="thStatus">{{ __('Status') }}</th>
                                                    <th class="thAction">{{ __('Action') }}</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>2022-08-15 04:10 OM</th>
                                                    <th>150</th>
                                                    <th>100</th>
                                                    <th>
                                                        <span class="badge bg-warning-bright text-warning"> Request Pending</span>
                                                    </th>
                                                    <th>
                                                        <button type="button" class="btn btn-danger btn-block" id="btnClose">{{ __('Update') }}</button>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>2022-08-15 04:10 OM</th>
                                                    <th>150</th>
                                                    <th>100</th>
                                                    <th>
                                                        <span class="badge bg-danger-bright text-danger"> Denied (Resumed) </span>
                                                    </th>
                                                    <th>
                                                        <button type="button" class="btn btn-danger btn-block" id="btnClose">{{ __('Update') }}</button>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>2022-08-15 04:10 OM</th>
                                                    <th>150</th>
                                                    <th>100</th>
                                                    <th>
                                                        <span class="badge bg-success-bright text-success"> Accepted (Modified) </span>
                                                    </th>
                                                    <th>
                                                        <button type="button" class="btn btn-danger btn-block" id="btnClose">{{ __('Update') }}</button>
                                                    </th>
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
    </div>


@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ url('vendors/datepicker/daterangepicker.js') }}"></script>
    <script src="{{ url('vendors/charts/justgage/raphael-2.1.4.min.js') }}"></script>
    <script src="{{ url('vendors/charts/justgage/justgage.js') }}"></script>


    <script src="{{ Module::asset('mnu:js/masters/planingDetailConfigure.js') }}"></script>
@endsection
