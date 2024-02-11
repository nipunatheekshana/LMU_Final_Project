@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Fish Receiving Parameter Settings" @endphp

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
                        <a href="/sf">{{ __('Sea Food Module') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/sf/fishReceiveParamSettings_list">{{ __('Fish Receiving Parameter Settings List') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button id="btnSave" class="btn btn-primary mb-3" style="float: right" type="button">Save</button>
            <button id="btnClear" class="btn btn-secondary mb-3 mr-2" style="float: right" type="button">Clear</button>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Setup New Fish Receive Parameter') }}</h6>
                    <form id="frmfishReceiveParamSettingsConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Parameter Name*') }}</label>
                                <input type="text" class="form-control" name="paramName" id="paramName">
                            </div>


                        </div>
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Company ID*') }}</label>
                                <select class="form-control" name="CompanyID" id="CompanyID">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Quality Check Parameter*') }}</label>
                                <select class="form-control" name="QParamID" id="QParamID">
                                    <option value="">-Select-</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Fish Species*') }}</label>
                                <select class="form-control" name="FishSpeciesID" id="FishSpeciesID">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Fish Prasentation*') }}</label>
                                <select class="form-control" name="FishPrasentationID" id="FishPrasentationID">
                                    <option value="">-Select-</option>
                                </select>
                            </div>

                        </div>

                        <h6 class="card-title mt-3 mb-0">{{ __('Paramente Values') }}</h6>
                        <hr>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Minimum Value*') }}</label>
                                <input type="number" class="form-control" name="MinValue" id="MinValue"
                                    placeholder="Eg: 1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Maximum Value*') }}</label>
                                <input type="number" class="form-control" name="MaxVal" id="MaxVal"
                                    placeholder="Eg : 5">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Default Value*') }}</label>
                                <input type="number" class="form-control" name="DefaultVal" id="DefaultVal"
                                    placeholder="Eg : 3">
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Index') }}</label>
                                <input type="number" class="form-control" name="list_index" id="list_index">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">

                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="enabled" name="enabled"
                                        checked>
                                    <label class="form-check-label" for="exampleCheck1">{{ __('Enabled') }}</label>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Related Paramenters') }}</h6>

                    <div class="table-responsive">
                        <table id="tablefishReceiveParamSettings"
                            class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thfishReceiveParamSettings">{{ __('Fish Receive Parameter') }}</th>
                                    <th class="thQParam">{{ __('Q Parameter') }}</th>

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
    <script src="{{ Module::asset('sf:js/masters/fishReceiveParamSettingsConfigure.js') }}"></script>
@endsection
