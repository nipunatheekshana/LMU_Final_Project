@extends('layouts.app')
{{-- @extends('quality::layouts.qualityModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Quality Rule Parameter" @endphp

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
                        <a href="/quality/qualityRuleParameters_list">{{ __('Quality Rule Parameter List') }}</a>
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
                    <h6 class="card-title">{{ __('Setup New Quality Rule Parameters') }}</h6>
                    <form id="frmqualityRuleParametersConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Quality Checking Rule*') }}</label>
                                <select class="form-control" name="QualityRuleID" id="QualityRuleID">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Quality Checking Parameter') }}</label>
                                <select class="form-control" name="QParameterId" id="QParameterId">
                                    <option value="">-Select-</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Quality Parameter Name*') }}</label>
                                <input type="text" class="form-control" name="QParamName" id="QParamName">
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Quality Parameter Description') }}</label>
                                <textarea type="text" class="form-control" name="QParamDescription" id="QParamDescription"></textarea>
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Status Value Comment') }}</label>
                                <textarea type="text" class="form-control" name="status_value_comment" id="status_value_comment"></textarea>
                            </div>


                        </div>



                        <h6 class="card-title mt-3 mb-0">{{ __('Parameter Values') }}</h6>
                        <hr>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Minimum Value*') }}</label>
                                <input type="number" class="form-control" name="MinValue" id="MinValue" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Maximum Value*') }}</label>
                                <input type="number" class="form-control" name="MaxValue" id="MaxValue" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Default Value*') }}</label>
                                <input type="number" class="form-control" name="DefaultValue" id="DefaultValue">
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Index') }}</label>
                                <input type="number" class="form-control" name="list_index" id="list_index" value="1">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_status_value_required"
                                        name="is_status_value_required">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Is Status Value Required?') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_status_value_number"
                                        name="is_status_value_number">
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Is Status Value Number?') }}</label>
                                </div>
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
                        <table id="tablequalityRuleParameters"
                            class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thqualityRuleParameters">{{ __('Quality Rule Parameters') }}</th>
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
    <script src="{{ Module::asset('quality:js/masters/qualityRuleParametersConfigure.js') }}"></script>
@endsection
