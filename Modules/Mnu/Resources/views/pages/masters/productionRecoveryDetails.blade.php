@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "Production Recovery Details" @endphp

@section('title', $title)

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('vendors/select2/css/select2.min.css') }}" type="text/css">

    <!-- Date Range Picker -->
    <link rel="stylesheet" href="{{ url('vendors/datepicker/daterangepicker.css') }}" type="text/css">

    <style>
        .dataTables_filter {
            display: none;
        }

        input.larger {
            width: 25px;
            height: 25px;
        }
    </style>

@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('Production Recovery Details') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashbord-Parent">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/buying">{{ __('Buying') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/buying/reports">{{ __('Reports') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
                </ol>
            </nav>
        </div>
    </div>


        <div class="row">
            <div class="col-xl-9 py-2">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 mb-1">
                                <h6 class="card-title mb-2">{{ __('Filter Criterias') }}</h6>
                                <p class="card-title mb-2">{{ __('Select desired criterias to filter the report') }}</p>
                            </div>
                            <div class="col-sm-4 mb-1">
                                <p class="mb-0">{{ __('GRN No') }}</p>
                                <select id="grn_no" class="reset" multiple>

                                </select>
                            </div>

                            <div class="col-sm-2 mb-1 text-center">
                                <p class="mb-1">{{ __('View') }}</p>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox custom-checkbox-primary">
                                        <input type="checkbox" class="reset custom-control-input" id="cbxGRNno" checked>
                                        <label class="custom-control-label" for="cbxGRNno"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 mb-1">
                                <p class="mb-0">{{ __('Date Range') }}</p>
                                <input type="text" id="datefilter" class="form-control">
                            </div>
                            <div class="col-sm-4 mb-1">
                                <p class="mb-0">{{ __('Grade') }}</p>
                                <select id="grade" class="reset" multiple>

                                </select>
                            </div>

                            <div class="col-sm-2 mb-1 text-center">
                                <p class="mb-1">{{ __('View') }}</p>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox custom-checkbox-primary">
                                        <input type="checkbox" class="reset custom-control-input" id="cbxGrade" checked>
                                        <label class="custom-control-label" for="cbxGrade"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 mb-1">
                                <p class="mb-0">{{ __('Supplier') }}</p>
                                <select id="supplier" class="reset" multiple>

                                </select>
                            </div>

                            <div class="col-sm-4 mb-1">
                                <p class="mb-0">{{ __('Presentation') }}</p>
                                <select id="presentation" class="reset" multiple>

                                </select>
                            </div>

                            <div class="col-sm-2 mb-1 text-center">
                                <p class="mb-1">{{ __('View') }}</p>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox custom-checkbox-primary">
                                        <input type="checkbox" class="reset custom-control-input" id="cbxPresentation"
                                            checked>
                                        <label class="custom-control-label" for="cbxPresentation"></label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-1">
                                <p class="mb-0">{{ __('Fish Type') }}</p>
                                <select id="fishType" class="reset fishType" multiple>

                                </select>
                            </div>


                            <div class="col-sm-4 mb-1">
                                <p class="mb-0">{{ __('Size') }}</p>
                                <select id="size" class="reset" multiple>

                                </select>
                            </div>

                            <div class="col-sm-2 mb-1 text-center">
                                <p class="mb-1">{{ __('View') }}</p>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox custom-checkbox-primary">
                                        <input type="checkbox" class="reset custom-control-input" id="cbxSize" checked>
                                        <label class="custom-control-label" for="cbxSize"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 py-2">
                <div class="card h-100">
                    <div class="card-body">
                        {{-- <h6 class="card-title mb-2">{{ __('Type') }}</h6>
                        <div class="row">
                            <div class="col-md-12 mb-0">
                                <div class="form-group">
                                    <div class="row text-left mb-3">
                                        <div class="col-sm-6 col-xs-2">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="reportType" name="reportType"
                                                    class="reset custom-control-input" checked value="GRN_wice">
                                                <label class="custom-control-label" for="reportType">GRN Wise</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-2">
                                            <div class="custom-control custom-radio custom-checkbox-secondary">
                                                <input type="radio" id="reportType1" name="reportType"
                                                    class="reset custom-control-input" value="Suplier_wice">
                                                <label class="custom-control-label" for="reportType1">Sup. Wise</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <h6 class="card-title mb-4 mt-4">{{ __('Generate Report') }}</h6>
                        <div class="row mb-4">
                            <div class="col-md-12 mb-6 d-flex justify-content-between">
                                <button type="button" class="btn btn-danger btn-lg btn-block"
                                    id="btnGenerate">Generate</button>
                            </div>
                        </div>

                        <div class="row">
                            {{-- <div class="col-md-6 mb-6">
                                <p class="card-title mb-1">{{ __('Download') }}</p>
                                <button type="button" class="btn btn-primary">PDF</button>
                            </div> --}}
                            <div class="col-md-12 mb-6">
                                <h6 class="card-title mb-1">{{ __('Merge Similar') }}</h6>
                                <div class="form-group">
                                    <div class="form-check checkbox-xl pl-4 m-0 pt-1">
                                        <input class="form-check-input larger reset" type="checkbox" value=""
                                            id="cbxSimilar" checked />
                                        <label class="form-check-label" for="cbxSimilar"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    {{-- Report --}}
    <div class="row">
        <div class="col-md-12 py-2">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-1">{{ __('Production Recovery Details') }}</h6>

                    <table id="tableFishDetails" class="table table-striped table-borderless Date display nowrap">
                        <thead>
                            <tr>

                                <th class="thGRNNo">{{ __('GRN No') }}</th>
                                <th class="thGRNDate">{{ __('GRN Date') }}</th>
                                <th class="thSupplier">{{ __('Supplier') }}</th>
                                <th class="thFishType">{{ __('Fish Type') }}</th>
                                <th class="thPresentation">{{ __('Presentation') }}</th>
                                <th class="thQualityGrade">{{ __('Quality Grade') }}</th>
                                <th class="thSize">{{ __('Size') }}</th>
                                <th class="thPcs">{{ __('Pcs') }}</th>
                                <th class="thWeight">{{ __('Weight') }}</th>
                                <th class="thTotalProcessedPcs">{{ __('Total Processed Pcs') }}</th>
                                <th class="thTotalProcessedWeight">{{ __('Total Processed Weight') }}</th>
                                <th class="thProcessedMode">{{ __('Processed Mode') }}</th>
                                <th class="thProcessedPcs">{{ __('Processed Pcs') }}</th>
                                <th class="thProcessedWeight">{{ __('Processed Weight') }}</th>
                                <th class="thGrossProdWg">{{ __('Gross Prod Wg') }}</th>
                                <th class="thGrossProdYield">{{ __('Gross Prod Yield') }}</th>
                                <th class="thNetProdWg">{{ __('Net Prod Wg') }}</th>
                                <th class="thNetProdYield">{{ __('Net Prod Yield') }}</th>
                                <th class="thExWg">{{ __('Ex Wg') }}</th>
                                <th class="thExYield">{{ __('Ex Yield') }}</th>

                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <h5>{{ __('Overview') }}</h5>
    </div>

    {{-- Footer --}}
    <div class="row mt-3">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Total Received Weight</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-warning-bright text-warning rounded-pill">
                                    <i class="ti-dashboard"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-30 ml-3" id="resiveWeight">-</div>
                    </div>
                    <p class="mb-0">Overall Recovery of Selected Date Range</p>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Total Production Weight</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-success-bright text-success rounded-pill">
                                    <i class="ti-dashboard"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-30 ml-3"  id="productionWeight">-</div>
                    </div>
                    <p class="mb-0">Overall Recovery of Selected Date Range</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <h5>{{ __('Fish Type Wise Overview') }}</h5>
        <div class="col-md-3 p-0 m-0">
            <select class="custom-select custom-select-lg fishType" id="fishTypeAvgSelector">
                {{-- <option value="1">Yellowfin Tuna</option>
                <option value="2">Bigeye Tuna</option>
                <option value="3">Baramundi</option> --}}
            </select>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Average Gross Recovery - Whole</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-secondary-bright text-secondary rounded-pill">
                                    <i class="ti-layout-grid2-alt"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-30 ml-3" id="avgWhRecGross">-</div>
                    </div>
                    <p class="mb-0">Overall Recovery of Selected Date Range</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Average Net Recovery - Whole</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-secondary-bright text-secondary rounded-pill">
                                    <i class="ti-layout-grid2-alt"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-30 ml-3" id="avgWhRecNet">-</div>
                    </div>
                    <p class="mb-0">Overall Recovery of Selected Date Range</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Average Export Recovery - Whole</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-secondary-bright text-secondary rounded-pill">
                                    <i class="ti-layout-grid2-alt"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-30 ml-3" id="avgWhRecEx">-</div>
                    </div>
                    <p class="mb-0">Overall Recovery of Selected Date Range</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Average Gross Recovery - Loin</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-info-bright text-info rounded-pill">
                                    <i class="ti-layout-grid4-alt"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-30 ml-3" id="avgLnRecGross">-</div>
                    </div>
                    <p class="mb-0">Overall Recovery of Selected Date Range</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Average Net Recovery - Loin</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-info-bright text-info rounded-pill">
                                    <i class="ti-layout-grid4-alt"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-30 ml-3" id="avgLnRecNet">-</div>
                    </div>
                    <p class="mb-0">Overall Recovery of Selected Date Range</p>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Average Export Recovery - Loin</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-info-bright text-info rounded-pill">
                                    <i class="ti-layout-grid4-alt"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-30 ml-3" id="avgLnRecEx">-</div>
                    </div>
                    <p class="mb-0">Overall Recovery of Selected Date Range</p>
                </div>
            </div>
        </div>
        {{-- <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Highest Recovery GRNs</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-success-bright text-success rounded-pill">
                                    <i class="ti-thumb-up"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-20 ml-3">2258</div>
                        <div class="font-weight-bold ml-1 font-size-20 ml-3"> | </div>
                        <div class="font-weight-bold ml-1 font-size-20 ml-3">2134</div>
                        <div class="font-weight-bold ml-1 font-size-20 ml-3"> | </div>
                        <div class="font-weight-bold ml-1 font-size-20 ml-3">4564</div>
                    </div>
                    <p class="mb-0">Top 3 GRNs with Highest Recovery Rate</p>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Lowest Recovery GRNs</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-danger-bright text-danger rounded-pill">
                                    <i class="ti-thumb-down"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-20 ml-3">2258</div>
                        <div class="font-weight-bold ml-1 font-size-20 ml-3"> | </div>
                        <div class="font-weight-bold ml-1 font-size-20 ml-3">2134</div>
                        <div class="font-weight-bold ml-1 font-size-20 ml-3"> | </div>
                        <div class="font-weight-bold ml-1 font-size-20 ml-3">4564</div>
                    </div>
                    <p class="mb-0">Lowest 3 GRNs with Lowest Recovery Rate</p>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Highest Recovery Suppliers</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-success-bright text-success rounded-pill">
                                    <i class="ti-thumb-up"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-15 ml-3">Kasun Silva</div>
                        <div class="font-weight-bold ml-1 font-size-15 ml-3"> | </div>
                        <div class="font-weight-bold ml-1 font-size-15 ml-3">Fresh Fisheries</div>
                        <div class="font-weight-bold ml-1 font-size-15 ml-3"> | </div>
                        <div class="font-weight-bold ml-1 font-size-15 ml-3">Anoj Suppliers</div>
                    </div>
                    <p class="mb-0">Top 3 GRNs with Highest Recovery Rate</p>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Lowest Recovery Suppliers</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <div class="avatar">
                                <span class="avatar-title bg-danger-bright text-danger rounded-pill">
                                    <i class="ti-thumb-down"></i>
                                </span>
                            </div>
                        </div>
                        <div class="font-weight-bold ml-1 font-size-15 ml-3">Kasun Silva</div>
                        <div class="font-weight-bold ml-1 font-size-15 ml-3"> | </div>
                        <div class="font-weight-bold ml-1 font-size-15 ml-3">Fresh Fisheries</div>
                        <div class="font-weight-bold ml-1 font-size-15 ml-3"> | </div>
                        <div class="font-weight-bold ml-1 font-size-15 ml-3">Anoj Suppliers</div>
                    </div>
                    <p class="mb-0">Lowest 3 Suppliers with Lowest Recovery Rate</p>
                </div>
            </div>
        </div> --}}
    </div>


    {{-- Modals --}}

@endsection


@section('script')

    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>

    <!-- Charts -->
    <script src="{{ url('vendors/charts/chartjs/chart.min.js') }}"></script>
    <script src="{{ url('vendors/charts/justgage/raphael-2.1.4.min.js') }}"></script>
    <script src="{{ url('vendors/charts/justgage/justgage.js') }}"></script>
    <script src="{{ url('vendors/charts/apex/apexcharts.min.js') }}"></script>



    <!-- Select2 -->
    <script src="{{ url('vendors/select2/js/select2.min.js') }}"></script>

    <!-- Date Range Picker -->
    <script src="{{ url('vendors/datepicker/daterangepicker.js') }}"></script>

    <!-- Document -->
    <script src="{{ Module::asset('mnu:js/masters/productionRecoveryDetails.js') }}"></script>


@endsection
