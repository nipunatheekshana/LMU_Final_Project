@extends('layouts.app')
{{-- @extends('hrm::layouts.HRMModuleLayout') --}}
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('Employee List') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Employee') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Employee') }}</li>
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
                        <table id="tableemployee" class="table table-striped table-bordered dataTable dtr-inline collapsed"
                            role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="themployee">{{ __('Employee') }}</th>
                                    <th class="thDesignation">{{ __('Designation') }}</th>
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
    <script src="{{ Module::asset('hrm:js/masters/employee.js') }}"></script>
@endsection
