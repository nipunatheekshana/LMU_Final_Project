@extends('layouts.app')

@section('title', 'Dashboard')
@section('head')
    <!-- Prism -->
    <link rel="stylesheet" href="{{ url('vendors/prism/prism.css') }}" type="text/css">
@endsection

@section('content')

    <div class="page-header">
        <div>
            <h3>{{ __('Dashboard') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard | Parent Company Level') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            {{-- Shortcuts --}}
            <div class="col-lg-6 d-flex pl-0">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h6 class="card-title mt-2 mb-2">{{ __('Shortcuts') }}</h6>
                        <div class="col">
                            <div class="row">
                                <div class="col pl-1" style="text-align: left;">
                                    <a class="btn btn-secondary font-weight-bold" href="\hrm\employee_list" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 60px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-user"></i>&nbsp;Employees</a>
                                    <a class="btn btn-secondary" href="\inventory\Item_list" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 60px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-archive"></i>&nbsp;Items</a>
                                    <a class="btn btn-secondary" href="\selling\customerOrder_list" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 60px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-first-order"></i>&nbsp;Customer Orders</a>
                                    <a class="btn btn-secondary" href="/buying/grnHistory_list" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 60px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-truck"></i>&nbsp;GRN History</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-lg-6"> --}}
            {{-- <div class="row" > --}}
            <div class="col-sm-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3 fs-1">Employees</h6>
                        <div class="d-flex align-items-center mb-5">
                            <div>
                                <div class="avatar" style="width: 40px; height: 40px;">
                                    <span class="avatar-title bg-success-bright text-success rounded-pill">
                                        <i class="ti-user"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="font-weight-bold ml-1 font-size-22 ml-2">45</div>
                        </div>

                        <h6 class="mb-3 fs-1">Customers</h6>
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <div class="avatar" style="width: 40px; height: 40px;">
                                    <span class="avatar-title bg-secondary-bright text-secondary rounded-pill">
                                        <i class="ti-link"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="font-weight-bold ml-1 font-size-22 ml-2">5</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="card">
                    <div class="card-body">

                        <h6 class="mb-3 fs-1">Orders</h6>
                        <div class="d-flex align-items-center mb-5">
                            <div>
                                <div class="avatar" style="width: 40px; height: 40px;">
                                    <span class="avatar-title bg-warning-bright text-warning rounded-pill">
                                        <i class="ti-shopping-cart"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="font-weight-bold ml-1 font-size-22 ml-2">6</div>
                        </div>

                        <h6 class="mb-3 fs-1">Ch. Requests</h6>
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <div class="avatar" style="width: 40px; height: 40px;">
                                    <span class="avatar-title bg-danger-bright text-danger rounded-pill">
                                        <i class="ti-exchange-vertical"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="font-weight-bold ml-1 font-size-22 ml-2">0</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="card">
                    <div class="card-body">

                        <h6 class="mb-3 fs-1">Pending PLN</h6>
                        <div class="d-flex align-items-center mb-5">
                            <div>
                                <div class="avatar" style="width: 40px; height: 40px;">
                                    <span class="avatar-title bg-warning-bright text-warning rounded-pill">
                                        <i class="ti-ticket"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="font-weight-bold ml-1 font-size-22 ml-2">2</div>
                        </div>

                        <h6 class="mb-3 fs-1">Pending GRN</h6>
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <div class="avatar" style="width: 40px; height: 40px;">
                                    <span class="avatar-title bg-info-bright text-info rounded-pill">
                                        <i class="ti-truck"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="font-weight-bold ml-1 font-size-22 ml-2">4</div>
                        </div>

                    </div>
                </div>
            </div>
            {{-- </div> --}}
            {{-- </div> --}}
        </div>
    </div>

    <div class="container-fluid content-row p-0">
        <div class="row">
            {{-- Modules --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mt-2 mb-2">{{ __('Modules') }}</h6>
                        <div class="col">
                            <div class="row">
                                <div class="col pl-1" style="text-align: left;">
                                    <a class="btn btn-primary" href="\sf" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 70px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-ship"></i>&nbsp;Sea Food</a>
                                    <a class="btn btn-primary" href="\quality" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 70px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-check"></i>&nbsp;Quality</a>
                                    <a class="btn btn-primary" href="\inventory" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 70px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-institution"></i>&nbsp;Inventory</a>
                                    <a class="btn btn-primary" href="\buying" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 70px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-chevron-circle-down"></i>&nbsp;Buying</a>
                                    <a class="btn btn-primary" href="\crm" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 70px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-envelope"></i>&nbsp;CRM</a>
                                    <a class="btn btn-primary" href="\hrm" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 70px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-user"></i>&nbsp;HRM</a>
                                    <a class="btn btn-primary" href="\selling" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 70px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-chevron-circle-up"></i>&nbsp;Selling</a>
                                    <a class="btn btn-primary" href="\asset" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 70px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-home"></i>&nbsp;Assets</a>
                                    <a class="btn btn-primary" href="\accounting" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 70px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-dollar"></i>&nbsp;Accounting</a>
                                    <a class="btn btn-primary" href="\mnu" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 70px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-briefcase"></i>&nbsp;Manufacturing</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Administration Section --}}
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mt-2 mb-2">{{ __('Administration') }}</h6>
                        <div class="col">
                            <div class="row">
                                <div class="col pl-1" style="text-align: left;">
                                    <a class="btn bg-primary-bright" href="\tools" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 70px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-gear"></i>&nbsp;Tools</a>
                                    <a class="btn bg-primary-bright" href="\settings\createCompanyUsers" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 70px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-gear"></i>&nbsp;Users</a>
                                    <a class="btn bg-primary-bright" href="\settings" type="button"
                                        style="min-width: 200px; width: 200px; max-width: 230px; height: 70px;margin: 10px;text-align: center;font-size: 15px"><i
                                            class="fa fa-gear"></i>&nbsp;Settings</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Administration Section --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mt-2 mb-3">{{ __('Version') }}</h6>
                        <p class="text-muted mb-2">Developed By : MISL Holdings (Pvt) Ltd</p>
                        <p class="text-muted">www.mislholdings.com</p>
                        <div class="text-muted font-size-13">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <span class="badge badge-secondary">v0.1Beta</span>
                                </li>
                                <li class="list-inline-item">14-12-2022</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection
