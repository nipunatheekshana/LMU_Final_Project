@extends('layouts.app')

@section('title', 'Buying Dashboard')
@section('head')

    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')

    <div class="page-header">
        <div>
            <h3>{{ __('Buying Dashboard') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashbord-Parent">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Buying') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Active Suppliers</h6>
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-secondary-bright text-secondary rounded-pill">
                                    <i class="ti-user"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-30 ml-3">48</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Today GRNs</h6>
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-success-bright text-success rounded-pill">
                                    <i class="ti-user"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-30 ml-3">3</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Open GRNs</h6>
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-warning-bright text-warning rounded-pill">
                                    <i class="ti-user"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-30 ml-3">5</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                  <h5 class="card-title mb-4">Purchase Analytics</h5>
                  <a href="/buying/purchaseAnalytics" class="btn btn-primary">View</a>
                </div>
              </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            {{-- Administration Section --}}
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-2">{{ __('Shortcuts') }}</h6>
                    <div class="col">
                        <div class="row">
                            <div class="col pl-1" style="text-align: left;">
                                <a class="btn btn-primary" href="buying/supplier_list" type="button"
                                    style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i
                                        class="fa fa-user"></i>&nbsp;{{ __('Suppliers') }}</a>
                                <a class="btn btn-primary" href="buying/supplierGroup_list" type="button"
                                    style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i
                                        class="fa fa-users"></i>&nbsp;{{ __('Supplier Groups') }}</a>
                                <a class="btn btn-primary" href="buying/supplierHoldTypes_list" type="button"
                                    style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i
                                        class="fa fa-shopping-cart"></i>&nbsp;{{ __('Supplier Hold Types') }}</a>
                                <a class="btn btn-primary" href="buying/grnHistory_list" type="button"
                                    style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i
                                        class="fa fa-flag"></i>&nbsp;{{ __('GRN History') }}</a>
                                <a class="btn btn-secondary" href="buying/settings" type="button"
                                    style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i
                                        class="fa fa-gear"></i>&nbsp;{{ __('Buying Settings') }}</a>
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
        </div>
    </div>
    

@endsection

@section('script')
    <!-- DataTable -->
    <script src="../../vendors/dataTable/datatables.min.js"></script>

    <!-- Chartjs -->
    <script src="../../vendors/charts/chartjs/chart.min.js"></script>

    <!-- Page JS -->
    <script src="{{ Module::asset('selling:js/masters/dashboardBuying.js') }}"></script>

@endsection
