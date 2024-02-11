@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}
@section('title', 'New Naming Series')
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('New Naming Series') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Naming Series') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('New Naming Series') }}</li>
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
                    <h6 class="card-title">{{ __('Setup New Naming Series') }}</h6>
                    <form id="frmnamingSeriesConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Function') }}</label>
                                <input type="text" class="form-control" name="function" id="function" readonly>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('NamingFormat') }}</label>
                                <input type="text" class="form-control" name="namingFormat" id="namingFormat">
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('CurrentValue') }}</label>
                                <input type="text" class="form-control" name="currentValue" id="currentValue">
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
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('settings:js/masters/namingSeriesConfigure.js') }}"></script>
@endsection
