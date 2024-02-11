@extends('layouts.app')
{{-- @extends('crm::layouts.CRMModuleLayout') --}}

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('New Contact') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Contact') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('New Contact') }}</li>
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
                    <h6 class="card-title">{{ __('Setup New Contact') }}</h6>
                    <form id="frmcontactConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="validationCustom02">{{ __('Salutation') }}</label>
                                <select class="form-control" name="Salutation" id="Salutation">
                                    <option value="">-Select-</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('First Name') }}</label>
                                <input type="text" class="form-control" name="FirstName" id="FirstName">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Middle Name') }}</label>
                                <input type="text" class="form-control" name="MiddleName" id="MiddleName">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Last Name') }}</label>
                                <input type="text" class="form-control" name="LastName" id="LastName">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Designation') }}</label>
                                <input type="text" class="form-control" name="Designation" id="Designation">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Gender') }}</label>
                                <select class="form-control" name="Gender" id="Gender">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('PrimaryAddress') }}</label>
                                <input type="text" class="form-control" name="PrimaryAddress" id="PrimaryAddress">
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

    <div class="accordion accordion-primary custom-accordion">
        <div class="accordion-row open">
            <a href="#" class="accordion-header">
                <span>Phone</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <div class="row">
                    <div class="col-md-12">
                        <button id="btnNewPhone" class="btn btn-primary mb-3" type="button">+</button>
                    </div>
                </div>
                <div class="form-row">
                    <div class="table-responsive">
                        <table id="tableContactPhone"
                            class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thphone">{{ __('Phone No.') }}</th>
                                    <th class="action"> {{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="accordion-row">
            <a href="#" class="accordion-header">
                <span>Email</span>
                <i class="accordion-status-icon close fa fa-chevron-up"></i>
                <i class="accordion-status-icon open fa fa-chevron-down"></i>
            </a>
            <div class="accordion-body">
                <div class="table-responsive">
                    <table id="tableContactEmail"
                        class="table table-striped table-bordered dataTable dtr-inline collapsed" role="grid"
                        aria-describedby="example1_info">
                        <thead>
                            <tr>
                                <th class="thId">#</th>
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
    <div class="modal" tabindex="-1" id="modalPhone" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Phone Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    {{-- <script src="{{ url('assets/js/custom/Admin_level/configurations/contactConfigure.js') }}"></script> --}}
    <script src="{{ Module::asset('crm:js/masters/contactConfigure.js') }}"></script>
@endsection
