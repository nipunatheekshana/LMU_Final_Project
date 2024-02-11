@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "Customer Item List" @endphp

@section('title',$title)
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __($title) }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/dashbord-Parent">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/mnu">{{ __('Manufacturing Module') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
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
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">{{ __('Customer') }}</label>
                            <select class="form-control" name="customer" id="customer">
                                <option value="null">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="validationCustom02">{{ __('Item Type') }}</label>
                            <select class="form-control" name="itemType" id="itemType">
                                <option value="null">-Select-</option>
                                <option value="Inner_Bom">Inner Bom</option>
                                <option value="Outer_Bom">Outer Bom</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary m-4" id="btnAdd" type="button">Filter</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="tablecustomerItem"
                            class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thcustomer">{{ __('Customer') }}</th>
                                    <th class="thItem">{{ __('Item') }}</th>
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
    <script src="{{ Module::asset('mnu:js/masters/customerItem.js') }}"></script>
@endsection
