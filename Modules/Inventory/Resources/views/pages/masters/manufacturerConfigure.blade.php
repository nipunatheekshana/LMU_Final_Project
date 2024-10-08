@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Manufacturer" @endphp

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
                        <a href="/inventory">{{ __('Inventory Module') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/inventory/manufacturer_list">{{ __('Manufacturers List') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
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
                    <h6 class="card-title">{{ __('Setup New Manufacturer') }}</h6>
                    <form id="frmmanufacturerConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Manufacturer Name*') }}</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Eg : Samsung Electronics Co., Ltd">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Manufacturer Short Name') }}</label>
                                <input type="text" class="form-control" name="short_name" id="short_name"
                                    placeholder="Eg : Samsung">
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Website') }}</label>
                                <input type="text" class="form-control" name="website" id="website"
                                    placeholder="eg : www.samsung.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Country') }}</label>
                                <select class="form-control" name="country" id="country">
                                    <option value="">-Select-</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Logo') }}</label>
                                <input type="file" class="form-control" name="logo" id="logo">
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom02">{{ __('Notes') }}</label>
                                <textarea type="text" class="form-control" name="notes" id="notes"></textarea>
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
    <script src="{{ Module::asset('inventory:js/masters/manufacturerConfigure.js') }}"></script>
@endsection
