@extends('layouts.app')
{{-- @extends('settings::layouts.settingsModuleLayout') --}}
@section('title','Create Company Users')

@section('head')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('Create Company Users') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('MISL') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Users') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Create child users') }}</h6>
                    <form class="needs-validation" id="frmCreateMislUsers" autocomplete="off">

                        <input type="hidden" name="hiddnUserId" id="hiddnUserId">

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="txtFullName">Company</label>
                                <select class="form-control" name="company" id="company">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Name') }}</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="@username">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Email') }}</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="example@email.com " required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Password') }}</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('confirm Password') }}</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="password_confirmation" required="">
                            </div>
                        </div>

                        <button id="btnSave" class="btn btn-primary" type="button">Save</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableMISLUsers" class="table table-striped table-bordered dataTable dtr-inline collapsed"
                            role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thName"> {{ __('Name') }}</th>
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
@endsection
@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('settings:js/companySetting/createCompanyUsers.js') }}"></script>
@endsection
