@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "Monthly Purchase Summary" @endphp

@section('title', $title)

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('vendors/select2/css/select2.min.css') }}" type="text/css">

    <style>
        .dataTables_filter {
            display: none;
        }

        input.larger {
        width: 25px;
        height: 25px;
        }

        tr.group,
        tr.group:hover {
            background-color: rgb(82, 103, 222, 255) !important;
            color: rgb(255, 255, 255) !important;
            font-weight: bold;

        }
    </style>

@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('Monthly Purchase Summary') }}</h3>
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
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-2">{{ __('Filter Criteria') }}</h6>

                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <p class="mb-0">{{ __('Year') }}</p>
                                <select id="year" class="reset" multiple>
                                </select>
                            </div>
                            <div class="col-md-6 mb-1">
                                <p class="mb-0">{{ __('Fish Type') }}</p>
                                <select id="fishType" class="reset" multiple>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-1">
                                <p class="mb-0">{{ __('Supplier') }}</p>
                                <select id="supplier" class="reset" multiple>

                                </select>
                            </div>

                            <div class="col-md-2 mb-1 text-center">
                                <p class="mb-1">{{ __('View') }}</p>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox custom-checkbox-primary">
                                        <input type="checkbox" class="reset custom-control-input" id="cbxSupplier" checked>
                                        <label class="custom-control-label" for="cbxSupplier"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-1">
                                <p class="mb-0">{{ __('Presentation') }}</p>
                                <select id="presentation" class="reset" multiple>

                                </select>
                            </div>

                            <div class="col-md-2 mb-1 text-center">
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
                            <div class="col-md-4 mb-1">
                                <p class="mb-0">{{ __('Grade') }}</p>
                                <select id="grade" class="reset" multiple>

                                </select>
                            </div>

                            <div class="col-md-2 mb-1 text-center">
                                <p class="mb-1">{{ __('View') }}</p>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox custom-checkbox-primary">
                                        <input type="checkbox" class="reset custom-control-input" id="cbxGrade" checked>
                                        <label class="custom-control-label" for="cbxGrade"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-1">
                                <p class="mb-0">{{ __('Size') }}</p>
                                <select id="size" class="reset" multiple>

                                </select>
                            </div>

                            <div class="col-md-2 mb-1 text-center">
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

            <div class="col-xl-3">
                <div class="card" style=" height: 90%;">
                    <div class="card-body">
                        <h6 class="card-title mb-2">{{ __('Type') }}</h6>
                        <div class="row">
                            <div class="col-md-12 mb-0">
                                <div class="form-group">
                                    <div class="row text-left mb-3">
                                        <div class="col-sm-6 col-xs-2">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="reportType" name="reportType"
                                                    class="reset custom-control-input" checked value="supplier">
                                                <label class="custom-control-label" for="reportType">Supplier</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-2">
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

                        <h6 class="card-title mb-2">{{ __('Report') }}</h6>
                        <div class="row mb-4">
                            <div class="col-md-12 mb-6 d-flex justify-content-between">
                                <button type="button" class="btn btn-danger btn-lg btn-block"
                                    id="btnGenerate">Generate</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-6">
                                <h6 class="card-title mb-2">{{ __('Merge Similar') }}</h6>
                                <div class="form-group">
                                    <div class="form-check checkbox-xl pl-4 m-0 pt-0">
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
                    <h6 class="card-title mb-1">{{ __('Monthly Purchase Summary') }}</h6>

                    <table id="tableFishDetails" class="table table-striped table-borderless Date display nowrap">
                        <thead>
                            <tr>
                                {{-- Criterias --}}
                                <th class="thYear">{{ __('Year') }}</th>
                                <th class="thSupplier">{{ __('Supplier') }}</th>
                                <th class="thFishType">{{ __('Fish Type') }}</th>
                                <th class="thPresentation">{{ __('Presentation') }}</th>
                                <th class="thPayGrade">{{ __('Pay Grade') }}</th>
                                <th class="thSize">{{ __('Size') }}</th>

                                {{-- Months --}}
                                <th class="thJan">{{ __('JAN') }}</th>
                                <th class="thFeb">{{ __('FEB') }}</th>
                                <th class="thMar">{{ __('MAR') }}</th>
                                <th class="thApr">{{ __('APR') }}</th>
                                <th class="thMay">{{ __('MAY') }}</th>
                                <th class="thJun">{{ __('JUN') }}</th>
                                <th class="thJul">{{ __('JUL') }}</th>
                                <th class="thAug">{{ __('AUG') }}</th>
                                <th class="thSep">{{ __('SEP') }}</th>
                                <th class="thOct">{{ __('OCT') }}</th>
                                <th class="thNov">{{ __('NOV') }}</th>
                                <th class="thDec">{{ __('DEC') }}</th>
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="chart_fish_type_wise" style="height: 300px"></div>
                </div>
            </div>
        </div>
    </div>


    {{-- Modals --}}

@endsection


@section('script')

    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

    <!-- Charts -->
    {{-- <script src="{{ url('vendors/charts/chartjs/chart.min.js') }}"></script> --}}
    <script src="{{ url('vendors/charts/apex/apexcharts.min.js') }}"></script>



    <!-- Select2 -->
    <script src="{{ url('vendors/select2/js/select2.min.js') }}"></script>



    <!-- Document -->
    <script src="{{ Module::asset('buying:js/masters/monthlyPurchaseSummary.js') }}"></script>

@endsection
