@extends('layouts.app')
{{-- @extends('settings::layouts.settingsModuleLayout') --}}
@section('title', 'Email Settings')
@section('head')
    <!-- Prism -->
    <link rel="stylesheet" href="{{ url('vendors/prism/prism.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('Email Settings') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Settings') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Email Settings') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Setup Email Account') }}</h6>
                    <form id="frmEmailSettings" autocomplete="off">


                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Mail Driver') }}</label>
                                <input type="text" class="form-control" name="mailDriver" id="mailDriver">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('MAIL_HOST') }}</label>
                                <input type="email" class="form-control" name="host" id="host" required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('MAIL_PORT') }}</label>
                                <input type="text" class="form-control" name="port" id="port">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('MAIL_USERNAME') }}</label>
                                <input type="email" class="form-control" name="userName" id="userName" required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('MAIL_PASSWORD') }}</label>
                                <input type="text" class="form-control" name="password" id="password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('MAIL_ENCRYPTION') }}</label>
                                <input type="email" class="form-control" name="encryption" id="encryption" required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('MAIL_FROM_ADDRESS') }}</label>
                                <input type="text" class="form-control" name="mailFromAddress" id="mailFromAddress">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('MAIL_FROM_NAME') }}</label>
                                <input type="email" class="form-control" name="mailFromName" id="mailFromName"
                                    required="">
                            </div>
                        </div>

                        <button id="btnSave" class="btn btn-primary" type="button">Save</button>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modelEmail" type="button">Send
                            test Mail</button>

                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- models --}}
    <div class="modal" id="modelEmail" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Test email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmemail" autocomplete="off">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Email address') }}</label>
                                <input type="email" class="form-control" name="emailAddress" id="emailAddress">
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="col-md-12 mb-3">
                                <label for="validationCustom02">{{ __('Type Something') }}</label>
                                <textarea type="text" class="form-control" name="content" id="content" required=""></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btntest" class="btn btn-primary">Send</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ Module::asset('settings:js/systemSettings/emailsettings.js') }}"></script>
@endsection
