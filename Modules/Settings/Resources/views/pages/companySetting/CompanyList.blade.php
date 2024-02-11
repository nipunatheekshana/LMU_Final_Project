@extends('layouts.app')
{{-- @extends('settings::layouts.settingsModuleLayout') --}}
@section('title', 'Company List')
@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('Company List') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/settings">{{ __('Settings') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Company List') }}</li>
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
                        <table id="tableCompanyList"
                            class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thName"> {{ __('Name') }}</th>
                                    <th class="thAbbr"> {{ __('Abbreviation') }}</th>
                                    <th class="themail">{{ __('email') }}</th>
                                    <th class="actions"> {{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- models --}}
    <div class="modal" tabindex="-1" role="dialog" id="deleteConformationModel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Conformation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Warning! If you delete this company, All related data will become inaccessible. Please Type "DELETE"
                        to delete this Company</p>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">{{ __('Type "DELETE"') }}</label>
                            <input type="text" class="form-control" name="DeleteText" id="DeleteText">
                        </div>
                        <input type="hidden" name="DeleteID" id="DeleteID">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnDelete" class="btn btn-secondary">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('settings:js/companySetting/CompanyList.js') }}"></script>
@endsection
