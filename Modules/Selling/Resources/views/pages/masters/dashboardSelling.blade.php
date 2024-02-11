@extends('layouts.app')

@section('title', 'Selling Dashboard')
@section('head')

    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')

    <div class="page-header">
        <div>
            <h3>{{ __('Selling Dashboard') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Selling Dashboard') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
             {{-- Modules --}}
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-2">{{ __('Customer Orders | Last Week') }}</h6>
                    <div class="col">
                        <div class="row">
                            <canvas id="chartjs_one"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Administration Section --}}
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-2">{{ __('Shortcuts') }}</h6>
                    <div class="col">
                        <div class="row">
                            <div class="col pl-1" style="text-align: left;">
                                <a class="btn btn-primary" href="selling/customer_master" type="button"
                                    style="min-width: 220px; width: 250px; max-width: 300px; height: 100px;margin: 20px;text-align: center;font-size: 19px"><i
                                        class="fa fa-user"></i>&nbsp;{{ __('Customers') }}</a>
                                <a class="btn btn-primary" href="selling/customerGroupMaster_list" type="button"
                                    style="min-width: 220px; width: 250px; max-width: 300px; height: 100px;margin: 20px;text-align: center;font-size: 19px"><i
                                        class="fa fa-users"></i>&nbsp;{{ __('Customer Groups') }}</a>
                                <a class="btn btn-primary" href="selling/customerOrder_list" type="button"
                                    style="min-width: 220px; width: 250px; max-width: 300px; height: 100px;margin: 20px;text-align: center;font-size: 19px"><i
                                        class="fa fa-shopping-cart"></i>&nbsp;{{ __('Customer Orders') }}</a>
                                <a class="btn btn-primary" href="selling/notifyparty_list" type="button"
                                    style="min-width: 220px; width: 250px; max-width: 300px; height: 100px;margin: 20px;text-align: center;font-size: 19px"><i
                                        class="fa fa-flag"></i>&nbsp;{{ __('Notify Parties') }}</a>
                                <a class="btn btn-secondary" href="selling/selling_settings" type="button"
                                    style="min-width: 220px; width: 250px; max-width: 300px; height: 100px;margin: 20px;text-align: center;font-size: 19px"><i
                                        class="fa fa-gear"></i>&nbsp;{{ __('Selling Settings') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- New Orders Section --}}
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-2">{{ __('New Orders') }}</h6>
                    <div class="table-responsive">
                        <table id="newOrders" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>Order Date</th>
                                    <th>Customer</th>
                                    <th>Target Date</th>
                                    <th>Total Weight</th>
                                    <th>Total Price</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- New Chnage Requests Section --}}
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-2">{{ __('New Change Requests') }}</h6>
                    <div class="table-responsive">
                        <table id="tablenewChangeRequests" class="table table-striped table-bordered Date display nowrap">
                            <thead>
                                <tr>
                                    <th class="thRequestNo">{{ __('Request No') }}</th>
                                    <th class="thDate&Time">{{ __('Date & Time') }}</th>
                                    <th class="thOrderNumber">{{ __('Order Number') }}</th>
                                    <th class="thCustomer">{{ __('Customer') }}</th>
                                    <th class="thNotifyParty">{{ __('Notify Party') }}</th>
                                    <th class="thItem">{{ __('Item') }}</th>
                                    <th class="thOldQty">{{ __('Old Qty') }}</th>
                                    <th class="thNewQty">{{ __('New Qty') }}</th>
                                    <th class="thOldPrice">{{ __('Old Price') }}</th>
                                    <th class="thNewPrice">{{ __('New Price') }}</th>
                                    <th class="thAction text-right">{{ __('Action') }}</th>

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
    {{-- models --}}
    <div class="modal" tabindex="-1" role="dialog" id="ModelChangeRequestApproval">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="mb-r text-center">Please select the Desired action</h5>
                    <h6 class="text-danger text-center">NOTE: This action cannot be reversed</h6>

                    <h6 class="mt-3"><b>Order Details</b></h6>
                    <div class="row">
                        <div class="col-md-3">Order #</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-8" id="OrderNum"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Customer</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-8" id="Customer"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Notify</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-8" id="Notify"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Item</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-8" id="Item"></div>
                    </div>

                    <h6 class="mt-3"><b>Changes</b></h6>
                    <div class="row">
                        <div class="col-md-3">Old Qty</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-8" id="oldQty"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">New Qty</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-8" id="newQty"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Old Price</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-8" id="oldPrice"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">New Price</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-8" id="newPrice"></div>
                    </div>
                    <form id="frmChangeRequestAction" autocomplete="off">
                        <input type="hidden" id="requestId" name="id">
                        <div class="col-md-12 mt-3">
                            <textarea type="email" class="form-control"id="comment" name="comment" placeholder="Comment"></textarea>
                        </div>
                    </form>
                    <hr>
                    <div class="table-responsive mt-2">
                        <table id="tableChangeRequestApproval"
                            class="table table-striped table-bordered Date display nowrap">
                            <thead>
                                <tr>
                                    <th class="thItem">{{ __('Item') }}</th>
                                    <th class="thTotalPlanedQty">{{ __('Total Planed Qty') }}</th>
                                    <th class="thCompleatedQty">{{ __('Compleated Qty') }}</th>
                                    <th class="thCompleatedWeight">{{ __('Compleated Weight') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnApproveChangeReq">Approve</button>
                    <button type="button" class="btn btn-danger" id="btnRejectChangeReq">Reject</button>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="ModelChangeRequestApproval">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Change Request Approval</h6>

                </div>
                <div class="modal-body">
                    <div class="card mb-1">
                        <div class="card-body">
                            <h6 class="card-title">Item Details</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <p class="mb-0">{{ __('ORder No') }}</p>
                                    <h4 class="text-muted " id="OrderNum">-</h4>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">{{ __('Order Date') }}</p>
                                    <h4 class="text-muted " id="splitModel_productName">-</h4>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">{{ __('Change Type') }}</p>
                                    <h4 class="text-muted " id="Notify">-</h4>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">{{ __('Requirement Id') }}</p>
                                    <h4 class="text-muted " id="splitModel_productName">-</h4>
                                </div>
                                <div class="col-md-12">
                                    <p class="mb-0">{{ __('Customer') }}</p>
                                    <h4 class="text-muted " id="Customer">-</h4>
                                </div>
                                <div class="col-md-12">
                                    <p class="mb-0">{{ __('Notify Party') }}</p>
                                    <h4 class="text-muted " id="Notify">-</h4>
                                </div>
                                <div class="col-md-12">
                                    <p class="mb-0">{{ __('Item') }}</p>
                                    <h4 class="text-muted " id="Item">-</h4>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">{{ __('Old Qty') }}</p>
                                    <h4 class="text-muted " id="oldQty">-</h4>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">{{ __('Old price') }}</p>
                                    <h4 class="text-muted " id="oldPrice">-</h4>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">{{ __('New Qty') }}</p>
                                    <h4 class="text-muted " id="newQty">-</h4>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">{{ __('New price') }}</p>
                                    <h4 class="text-muted " id="newPrice">-</h4>
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive mt-2">
                                <table id="tableChangeRequestApproval"
                                    class="table table-striped table-bordered Date display nowrap">
                                    <thead>
                                        <tr>
                                            <th class="thItem">{{ __('Item') }}</th>
                                            <th class="thTotalPlanedQty">{{ __('Total Planed Qty') }}</th>
                                            <th class="thCompleatedQty">{{ __('Compleated Qty') }}</th>
                                            <th class="thCompleatedWeight">{{ __('Compleated Weight') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div> --}}

@endsection

@section('script')
    <!-- DataTable -->
    <script src="../../vendors/dataTable/datatables.min.js"></script>

    <!-- Chartjs -->
    <script src="../../vendors/charts/chartjs/chart.min.js"></script>

    <!-- Page JS -->
    <script src="{{ Module::asset('selling:js/masters/dashboardSelling.js') }}"></script>

@endsection
