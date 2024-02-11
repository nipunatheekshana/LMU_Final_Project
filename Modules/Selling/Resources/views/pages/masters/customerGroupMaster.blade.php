@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('Customer Group List') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Customer Group') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Customer Group') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button id="btnCreateNew" class="btn btn-primary mb-3" style="float: right" type="button"></button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablecustomerGroupMaster"
                            class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thCusGroupName"> {{ __('Customer Group') }}</th>
                                    <th class="index"> {{ __('Index') }}</th>
                                    <th class="action"> {{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    {{-- <script src="{{ url('assets/js/custom/Admin_level/configurations/supplierGroup.js') }}"></script> --}}
    <script src="{{ Module::asset('selling:js/masters/customerGroupMaster.js') }}"></script>
@endsection
