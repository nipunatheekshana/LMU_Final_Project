@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "Exchange Rate Configure" @endphp

@section('title', $title)

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
    <!-- Date Range Picker -->
    <link rel="stylesheet" href="{{ url('vendors/datepicker/daterangepicker.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('New Exchange Rate') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a
                            href="\">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                            <a href="\accounting">{{ __('Accounting') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="\accounting\exchange_rate_list">{{ __('Exchange Rate') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('New Exchange Rate') }}</li>
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
                    <h6 class="card-title">{{ __('New Exchange Rate') }}</h6>
                    <form id="frmexchangeRateConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Company') }}</label>
                                <input type="text" class="form-control" name="company_id" id="company_id">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Date') }}</label>
                                <input type="text" class="form-control" name="date" id="date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Currency') }}</label>
                                <input type="text" class="form-control" name="currency" id="currency">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Exchange Rate') }}</label>
                                <input type="text" class="form-control" name="exchange_rate" id="exchange_rate">
                            </div>

                        </div>



                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="for_buying" name="for_buying" checked>
                                    <label class="form-check-label" for="exampleCheck1">{{ __('For Buying') }}</label>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="for_selling" name="for_selling" checked>
                                    <label class="form-check-label" for="exampleCheck1">{{ __('For Selling') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-4 mb-3">
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
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('accounting:js/masters/exchangeRateConfigure.js') }}"></script>

    {{-- Date Range Picker  --}}
    <script src="{{ url('vendors/datepicker/daterangepicker.js') }}"></script>
@endsection
