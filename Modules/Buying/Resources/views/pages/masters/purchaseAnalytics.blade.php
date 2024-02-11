@extends('layouts.app')

@section('title', 'Purchase Analytics')
@section('head')

    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">

    <style>
        .card {
            min-height: 450px;
        }
    </style>

@endsection

@section('content')

    <div class="page-header">
        <div class="row d-flex justify-content-between">
            <div class="col-md-6">
                <h3>{{ __('Purchase Analytics') }}</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashbord-Parent">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/buying">{{ __('Buying') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Purchase Analytics') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4">
                <div class="input-group mt-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="fishtype">Fish Type</label>
                    </div>
                    <select class="custom-select form-control" name="fishtype" id="fishtype">
                        <option value="10000">-Select-</option>
                        {{-- <option value="1">Yellowfin Tuna</option>
                        <option value="2">Barramundi</option>
                        <option value="3">Bigeye Tuna</option> --}}
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-6">{{ __('Annual Purchase - Grade Wise Weight') }}</h6>
                    <div class="table-responsive">
                        <table id="tableGradeWisePurchase" class="table table-striped Date display nowrap">
                            <thead>
                                <tr>
                                    <th class="thGrade">{{ __('Grade') }}</th>
                                    <th class="thYear1">{{ __('-') }}</th>
                                    <th class="thYear2">{{ __('-') }}</th>
                                    <th class="thYear3">{{ __('-') }}</th>
                                    <th class="thYear4">{{ __('-') }}</th>
                                    <th class="thYear5">{{ __('-') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-2">{{ __('Annual Purchasing') }}</h6>
                    <div id="annual_purchase_bar" class="p-0 m-0" style="height: 300px"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-2">{{ __('Annual Purchasing Trend') }}</h6>
                    <div id="annual_purchase_line" class="p-0 m-0" style="height: 300px"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-2">{{ __('Grade Wise Purchasing Trend') }}</h6>
                    <div id="annual_purchase_grade_line" class="p-0 m-0" style="height: 300px"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-2">{{ __('Grade Wise Purchasing') }}</h6>
                    <div id="annual_purchase_grade_bar" class="p-0 m-0" style="height: 300px"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-2">{{ __('Grade Wise Purchasing Percentage') }}</h6>
                    <div id="annual_purchase_grade_stack" class="p-0 m-0" style="height: 300px"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-6">{{ __('Annual Purchase - Size Wise Weight') }}</h6>
                    <div class="table-responsive">
                        <table id="tableSizeWisePurchase" class="table table-striped Date display nowrap">
                            <thead>
                                <tr>
                                    <th class="thSize">{{ __('Size') }}</th>
                                    <th class="thYear1">{{ __('-') }}</th>
                                    <th class="thYear2">{{ __('-') }}</th>
                                    <th class="thYear3">{{ __('-') }}</th>
                                    <th class="thYear4">{{ __('-') }}</th>
                                    <th class="thYear5">{{ __('-') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-2">{{ __('Size Wise Purchasing Weight') }}</h6>
                    <div id="annual_purchase_size_line" class="p-0 m-0" style="height: 300px"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-2">{{ __('Size Wise Purchasing Percentage') }}</h6>
                    <div id="annual_purchase_size_stack" class="p-0 m-0" style="height: 300px"></div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h5 class="mt-2 mb-4">{{ __('Price Related Analytics') }}</h5>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-6">{{ __('Grade Wise Average Price (Per Kg)') }}</h6>
                    <div class="table-responsive">
                        <table id="tableGradeWiseAvgPrice" class="table table-striped Date display nowrap">
                            <thead>
                                <tr>
                                    <th class="thGrade">{{ __('Grade') }}</th>
                                    <th class="thYear1">{{ __('-') }}</th>
                                    <th class="thYear2">{{ __('-') }}</th>
                                    <th class="thYear3">{{ __('-') }}</th>
                                    <th class="thYear4">{{ __('-') }}</th>
                                    <th class="thYear5">{{ __('-') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-2">{{ __('Grade Wise Average Price (Per Kg)') }}</h6>
                    <div id="annual_purchase_grade_avg_price_line" class="p-0 m-0" style="height: 300px"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mt-2 mb-2">{{ __('Average Price Variation (Per Kg)') }}</h6>
                    <div id="annual_purchase_avg_price_bar" class="p-0 m-0" style="height: 300px"></div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>

    {{-- <!-- Chartjs -->
    <script src="{{ url('vendors/charts/chartjs/chart.min.js') }}"></script> --}}

    <!-- Apexcharts -->
    <script src="{{ url('vendors/charts/apex/apexcharts.min.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ Module::asset('buying:js/masters/purchaseAnalytics.js') }}"></script>

@endsection
