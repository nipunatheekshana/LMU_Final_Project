@extends('layouts.app')
{{-- @extends('settings::layouts.settingsModuleLayout') --}}
@section('title', 'Company')

@section('head')
    <!-- Prism -->
    <link rel="stylesheet" href="{{ url('vendors/prism/prism.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('Company') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/settings">{{ __('Settings') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/settings/Company_List">{{ __('Company List') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Company') }}</li>
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
                    <h6 class="card-title">{{ __('Company Information') }}</h6>
                    <form class="needs-validation" id="frmChildCompany" autocomplete="off">
                    <input type="hidden" name="companyid" id="hiddencompanyid">

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Company Name') }}</label>
                            <input type="text" class="form-control" name="companyName" id="companyName">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Abbr') }}</label>
                            <input type="text" class="form-control" name="abbr" id="abbr">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">{{ __('Domain') }}</label>
                            <select class="form-control" name="domain_id" id="domain_id">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom02">{{ __('Parent Company') }}</label>
                            <select class="form-control" name="group_company_id" id="group_company_id">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="is_group" name="is_group">
                                <label class="form-check-label" for="exampleCheck1">{{ __('is Group') }}</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="enabled" name="enabled" checked>
                                <label class="form-check-label" for="exampleCheck1">{{ __('Enabled') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">{{ __('Company Details') }}</h6>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationCustom01">{{ __('Country') }}</label>
                    <select class="form-control" name="country_id" id="country_id">
                        <option value="">-Select-</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationCustom01">{{ __('Company Logo') }}</label>
                    <input type="file" class="form-control" name="company_logo" id="company_logo">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationCustom01">{{ __('Default Currency') }}</label>
                    <select class="form-control" name="currency_id" id="currency_id">
                        <option value="">-Select-</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationCustom01">{{ __('Local Currency') }}</label>
                    <select class="form-control" name="local_currency_id" id="local_currency_id">
                        <option value="">-Select-</option>
                    </select>
                </div>

            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationCustom01">{{ __('Date of Incorporation') }}</label>
                    <input type="date" class="form-control" name="date_of_incorporation" id="date_of_incorporation">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationCustom01">{{ __('Date of Commencement') }}</label>
                    <input type="date" class="form-control" name="date_of_commencement" id="date_of_commencement">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationCustom01">{{ __('Registration No') }}</label>
                    <input type="text" class="form-control" name="registration_No" id="registration_No">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationCustom01">{{ __('Index') }}</label>
                    <input type="number" class="form-control" name="list_index" id="list_index">
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="validationCustom01">{{ __('Registration Details') }}</label>
                    <textarea type="text" class="form-control" name="registration_details" id="registration_details"></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="validationCustom01">{{ __('Company Description') }}</label>
                    <textarea type="text" class="form-control" name="company_description" id="company_description"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">{{ __('Contact Information') }}</h6>

            <div class="form-row">

                <div class="col-md-6 mb-3">
                    <label for="validationCustom01">{{ __('Phone no') }}</label>
                    <input type="text" class="form-control" name="phone_no" id="phone_no">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationCustom01">{{ __('Fax') }}</label>
                    <input type="text" class="form-control" name="fax" id="fax">
                </div>

            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationCustom01">{{ __('E-Mail') }}</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationCustom01">{{ __('Website') }}</label>
                    <input type="text" class="form-control" name="website" id="website">
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h6 class="card-title">{{ __('Fish Receiving Setting') }}</h6>
            {{-- <form id="frmfishSpeciesMaster" autocomplete="off"> --}}
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationCustom01">{{ __('Current Fish Serial No*') }}</label>
                    <input type="number" class="form-control text-uppercase" name="currentFishSerialNo"
                        id="currentFishSerialNo" value=1>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom02">{{ __('Minimum  Fish Serial No*') }}</label>
                    <input type="number" class="form-control" name="minFishSerialNo" id="minFishSerialNo"
                        required="" value=1>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom02">{{ __('Maximum  Fish Serial No*') }}</label>
                    <input type="number" class="form-control" name="maxFishSerialNo" id="maxFishSerialNo"
                        required="" value=999999>
                </div>
            </div>
        </div>
    </div>
    </form>

    </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Activity log') }}</h6>
                    <ul class="list-unstyled">
                        <li>
                            <ul id="activityLog">

                            </ul>
                        </li>


                    </ul>
                </div>
            </div>

        </div>
    </div> --}}
@endsection
@section('script')
    <script src="{{ Module::asset('settings:js/companySetting/createCompany.js') }}"></script>
@endsection
