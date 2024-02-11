@extends('layouts.app')
{{-- @extends('settings::layouts.settingsModuleLayout') --}}
@section('title', 'New Workstation')
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('New Workstation') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Workstation') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('New Workstation') }}</li>
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
                    <h6 class="card-title">{{ __('Setup New Workstation') }}</h6>
                    <form id="frmworkstationConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Company') }}</label>
                                <select class="form-control" name="CompanyID" id="CompanyID">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Workstation Name') }}</label>
                                <input type="text" class="form-control" name="WorkstationName" id="WorkstationName">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Workstation Description') }}</label>
                                <textarea type="text" class="form-control" name="WorkstationDescription" id="WorkstationDescription"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Default Printer') }}</label>
                                <select class="form-control" name="default_printer" id="default_printer">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Index') }}</label>
                                <input type="number" class="form-control" name="list_index" id="list_index">
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="isInternal" name="isInternal">
                                    <label class="form-check-label" for="exampleCheck1">{{ __('isInternal') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_waste_location" name="is_waste_location">
                                    <label class="form-check-label" for="exampleCheck1">{{ __('is waste location') }}</label>
                                </div>
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
    <script src="{{ Module::asset('settings:js/masters/workstationConfigure.js') }}"></script>
@endsection
