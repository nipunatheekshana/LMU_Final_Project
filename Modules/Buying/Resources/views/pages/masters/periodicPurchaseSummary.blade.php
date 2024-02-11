@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "Periodic Purchase Summary" @endphp

@section('title', $title)

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('vendors/select2/css/select2.min.css') }}" type="text/css">

    <!-- Date Range Picker -->
    <link rel="stylesheet" href="{{ url('vendors/datepicker/daterangepicker.css') }}" type="text/css">

    <style>
        .dataTables_filter {display: none;}
        input.larger {
        width: 25px;
        height: 25px;
        }
    </style>

@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('Periodic Purchase Summary') }}</h3>
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

    <div class="container-lg">
        <div class="row justify-content-between">
            <div class="col-md-7">

                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-2">{{ __('Filter Criterias') }}</h6>

                        <div class="row">
                            <div class="col-md-5 mb-0">
                                <p class="mb-0">{{ __('Date Range') }}</p>
                                <input type="text" id="datefilter" class="form-control">
                            </div>

                            <div class="col-md-1 mb-0">
                            </div>

                            <div class="col-md-5 mb-1">
                                <p class="mb-0">{{ __('Fish Type') }}</p>
                                <select id="fishType" class="reset" multiple>
                                </select>
                            </div>
                            <div class="col-md-1 mb-0">
                                {{-- <p class="mb-1">{{ __('View') }}</p>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox custom-checkbox-primary">
                                        <input type="checkbox" class="custom-control-input" id="cbxFishtype" checked>
                                        <label class="custom-control-label" for="cbxFishtype"></label>
                                    </div>
                                </div> --}}
                            </div>


                        </div>

                        <div class="row">


                            <div class="col-md-5 mb-1">
                                <p class="mb-0">{{ __('Supplier') }}</p>
                                <select id="supplier" class="reset" multiple>

                                </select>
                            </div>

                            <div class="col-md-1 mb-1 text-center">
                                <p class="mb-1">{{ __('View') }}</p>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox custom-checkbox-primary">
                                        <input type="checkbox" class="reset custom-control-input" id="cbxSupplier" checked>
                                        <label class="custom-control-label" for="cbxSupplier"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 mb-1">
                                <p class="mb-0">{{ __('Presentation') }}</p>
                                <select id="presentation" class="reset" multiple>

                                </select>
                            </div>

                            <div class="col-md-1 mb-1 text-center">
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
                            <div class="col-md-5 mb-1">
                                <p class="mb-0">{{ __('Grade') }}</p>
                                <select id="grade" class="reset" multiple>

                                </select>
                            </div>

                            <div class="col-md-1 mb-1 text-center">
                                <p class="mb-1">{{ __('View') }}</p>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox custom-checkbox-primary">
                                        <input type="checkbox" class="reset custom-control-input" id="cbxGrade" checked>
                                        <label class="custom-control-label" for="cbxGrade"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 mb-1">
                                <p class="mb-0">{{ __('Size') }}</p>
                                <select id="size" class="reset" multiple>

                                </select>
                            </div>

                            <div class="col-md-1 mb-1 text-center">
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

            <div class="col-md-2">
                <div class="card" style=" height: 90%;">
                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h6 class="card-title mb-2">{{ __('Financial') }}</h6>
                            </div>
                            <div class="col-md-12 text-center">
                                <p class="mb-0">{{ __('Local Currency') }}</p>
                            </div>
                            <div class="col-md-12 mb-2 text-center">
                                <span class="badge bg-danger-bright text-danger"><h3 class="p-0 m-0">LKR</h3></span>
                            </div>
                            <div class="col-md-12 text-center">
                                <p class="mb-0">{{ __('Base Currency') }}</p>
                            </div>
                            <div class="col-md-12 mb-2 text-center">
                                <span class="badge bg-warning-bright text-warning"><h3 class="p-0 m-0">USD</h3></span>
                            </div>
                            <div class="col-md-12 text-center">
                                <p class="mb-0">{{ __('Show Values') }}</p>
                            </div>
                            <div class="col-md-12 mb-2 text-center">
                                <div class="form-check checkbox-xl pl-3 m-0 text-center">
                                    <input class="form-check-input larger" type="checkbox" value="" id="checkboxShowValues" checked/>
                                    <label class="form-check-label" for="checkboxShowValues"></label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card" style=" height: 90%;">
                    <div class="card-body">
                        <h6 class="card-title mb-2">{{ __('Report Type') }}</h6>

                        <div class="row">
                            <div class="col-md-12 mb-0">
                                <div class="form-group">
                                    <div class="row text-left mb-3">
                                        <div class="col-md-6">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="reportType" name="reportType"
                                                    class="reset custom-control-input" checked value="supplier">
                                                <label class="custom-control-label" for="reportType">Supplier</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom-control custom-radio custom-checkbox-secondary">
                                                <input type="radio" id="reportType1" name="reportType"
                                                    class="reset custom-control-input" value="fishType">
                                                <label class="custom-control-label" for="reportType1">Fish Type</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title mb-2">{{ __('Generate Report') }}</h6>
                        <div class="row mb-4">
                            <div class="col-md-12 mb-6 d-flex justify-content-between">
                                <button type="button" class="btn btn-danger btn-lg btn-block" id="btnGenerate">Generate</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <p class="card-title mb-1">{{ __('Download') }}</p>
                                <button type="button" class="btn btn-primary">PDF</button>
                            </div>
                            <div class="col-md-6 mb-6">
                                <p class="card-title mb-1">{{ __('Merge Similar') }}</p>
                                <div class="form-group">
                                    <div class="form-check checkbox-xl pl-4 m-0 pt-1">
                                        <input class="form-check-input larger reset" type="checkbox" value="" id="cbxSimilar" checked/>
                                        <label class="form-check-label" for="cbxSimilar"></label>
                                    </div>
                                </div>
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
                    <h6 class="card-title mb-1">{{ __('Periodic Purchase Summary') }}</h6>

                    <table id="tableFishDetails" class="table table-striped table-borderless Date display nowrap">



                        <thead>
                            <tr>
                                {{-- Criterias --}}
                                <th class="thSupplier">{{ __('Supplier') }}</th>
                                <th class="thFishType">{{ __('Fish Type') }}</th>
                                <th class="thPresentation">{{ __('Presentation') }}</th>
                                <th class="thPayGrade">{{ __('Pay Grade') }}</th>
                                <th class="thSize">{{ __('Size') }}</th>

                                {{-- Months --}}
                                <th class="thPcs">{{ __('Pcs') }}</th>
                                <th class="thNetWeight">{{ __('Net Weight') }}</th>
                                <th class="thAvgUnitWeightPriceLC">{{ __('Avg Unit Weight Price (LC)') }}</th>
                                <th class="thTotalValueLC">{{ __('Total Value (LC)') }}</th>
                                <th class="thAvgUnitWeightPriceBC">{{ __('Avg Unit Weight Price (BC)') }}</th>
                                <th class="thTotalValueBC">{{ __('Total Value (BC)') }}</th>
                                <th class="thPresentage">{{ __('Pecentage') }}</th>

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
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-2">{{ __('Fish Type Wise Weight') }}</h6>
                    <p class="card-title mb-2">{{ __('View Fish Type wise weight details of selected filter criterias') }}</p>
                    <div id="weightSummary" style="height: 100px"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row ml-1 mr-1">
                        <h6 class="card-title mb-2">{{ __('Grade Wise Weight') }}</h6>
                        <select class="form-control fishType" id="fishTypeGradeWise">
                            <option>Default select</option>
                        </select>
                    </div>
                    <div id="gradeSummary" class="mb-0" style="height: 30px"></div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row ml-1 mr-1">
                        <h6 class="card-title mb-2">{{ __('Presentation Wise Weight') }}</h6>
                        <select class="form-control fishType" id="fishTypePresentationWise">
                            <option>Default select</option>
                        </select>
                    </div>
                    <div id="presentationSummary" class="mb-0" style="height: 100px"></div>
                </div>
            </div>
        </div>
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
    <script src="{{ Module::asset('buying:js/masters/periodicPurchaseSummary.js') }}"></script>


@endsection
