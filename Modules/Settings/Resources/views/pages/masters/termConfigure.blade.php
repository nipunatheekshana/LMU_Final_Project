@extends('layouts.app')
{{-- @extends('buying::layouts.buyingModuleLayout') --}}
@section('title','Terms')
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('New Term') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="\dashbord-Parent">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="\settings">{{ __('Settings') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="\settings\term_list">{{ __('Terms List') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('New Term') }}</li>
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
                    <h6 class="card-title">{{ __('Setup New Term') }}</h6>
                    <form id="frmtermConfigure" autocomplete="off">

                        <input type="hidden" id="id" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Term Title') }}</label>
                                <input type="text" class="form-control" name="title" id="title">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Term Type') }}</label>
                                <input type="text" class="form-control" name="type" id="type">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Term Description') }}</label>
                                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Type terms and condtions that related to invoicing, shipping, purchasing, selling, etc.
                                  </small>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_financial" name="is_financial" checked>
                                    <label class="form-check-label" for="exampleCheck1">{{ __('Financial Related') }}</label>
                                </div>
                            </div>
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
    <script src="{{ Module::asset('settings:js/masters/termConfigure.js') }}"></script>
@endsection
