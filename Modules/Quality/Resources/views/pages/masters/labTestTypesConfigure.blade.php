@extends('layouts.app')
{{-- @extends('quality::layouts.qualityModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Lab Test Type" @endphp

@section('title', $title)
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
                        <a href="/quality">{{ __('Quality Module') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/quality/labTestTypes_list">{{ __('Lab Test Types List') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button id="btnSave" class="btn btn-primary mb-3" style="float: right" type="button">Save</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Setup New Lab Test Type') }}</h6>
                    <form id="frmlabTestTypesConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Company*') }}</label>
                                <select class="form-control" name="CompanyID" id="CompanyID">
                                    <option value="">-Select-</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Lab Test Type Code*') }}</label>
                                <input type="text" class="form-control" name="LabTestTypeCode" id="LabTestTypeCode"
                                    placeholder="Eg : HIST">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Lab Test Type Name*') }}</label>
                                <input type="text" class="form-control" name="LabTestTypeName" id="LabTestTypeName"
                                    placeholder="Eg : Histamine">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom02">{{ __('Quality Rule Description') }}</label>
                                <textarea type="text" class="form-control" name="LabTestTypeDescription" id="LabTestTypeDescription"></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Common Range - Low') }}</label>
                                <input type="number" class="form-control" name="commonRangeLow" id="commonRangeLow"
                                    placeholder="Eg : 12.09">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Common Range - High') }}</label>
                                <input type="number" class="form-control" name="commonRangeHigh" id="commonRangeHigh"
                                    placeholder="Eg : 45.65">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Test Cost') }}</label>
                                <input type="number" class="form-control" name="testCost" id="testCost"
                                    placeholder="Eg : 450.00">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Currency') }}</label>
                                <select class="form-control" name="testCostCurrencyID" id="testCostCurrencyID">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="enabled" name="enabled" checked>
                                    <label class="form-check-label" for="exampleCheck1">{{ __('Enabled') }}</label>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script type="application/javascript" src="browser-polyfill.js"></script>
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('quality:js/masters/labTestTypesConfigure.js') }}"></script>
@endsection
