@extends('layouts.app')

@section('head')
    <!-- Prism -->
    <link rel="stylesheet" href="{{ url('vendors/prism/prism.css') }}" type="text/css">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('Edit Parent Company') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Parent Company') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Edit Parent Company') }}</h6>
                    <form class="needs-validation" id="FrmEditMotherCompany" autocomplete="off">


                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Parent Company Name') }}</label>
                                <input type="hidden" name="userid" id="hiddenuserid">
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ 'E-Mail' }}</label>
                                <input type="email" class="form-control" name="email" id="email" required>

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Address') }}</label>
                                <input type="hidden" name="userid" id="hiddenuserid">
                                <input type="text" class="form-control" name="address" id="address"
                                    placeholder="Address" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Contact Number') }}</label>
                                <input type="text" class="form-control" name="contacts" id="contacts"
                                    placeholder="0772044592" required>
                            </div>
                        </div>

                        <button id="btnSave" class="btn btn-primary" type="button">Save</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script src="{{ url('assets/js/custom/MISL_level/editParentCompany.js') }}"></script>
@endsection
