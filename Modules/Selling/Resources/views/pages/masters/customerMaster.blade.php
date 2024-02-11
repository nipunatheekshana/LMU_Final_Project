@extends('layouts.app')
{{-- @extends('selling::layouts.SellingModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "Customers List" @endphp

@section('title', $title)

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('Customers List') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/selling">{{ __('Selling') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Customer List') }}</li>
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
                        <table id="tablecustomerMaster"
                            class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thcustomerMasters">{{ __('Name') }}</th>
                                    <th class="thCountry">{{ __('Country') }}</th>
                                    <th class="thEmail">{{ __('Email') }}</th>
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
    <script src="{{ Module::asset('selling:js/masters/customerMaster.js') }}"></script>
@endsection
