@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Boat Category" @endphp

@section('title', $title)
@section('head')
    <!-- DataTable -->
    {{-- <link rel="stylesheet" href="{{ url('vendors/dataTable/datatables.min.css') }}" type="text/css"> --}}
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
                        <a href="/sf/boatCategory_list">{{ __('Boat Category List') }}</a>
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
                    <h6 class="card-title">{{ __('Setup New Boat Category') }}</h6>
                    <form id="frmboatCategoryConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Boat Category Code') }}</label>
                                <input type="text" class="form-control" name="BoatCategory" id="BoatCategory"
                                    placeholder="Eg : ALL">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Boat Category Name*') }}</label>
                                <input type="text" class="form-control" name="BoatCatName" id="BoatCatName"
                                    placeholder="Eg : Large Vessels">
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Boat Category Description') }}</label>
                                <textarea type="text" class="form-control" name="BoatCateDescription" id="BoatCateDescription"></textarea>
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
                                    <input type="checkbox" class="form-check-input" id="LicenseRequired"
                                        name="LicenseRequired" checked>
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('License Required') }}</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="LogSheetRequired"
                                        name="LogSheetRequired" checked>
                                    <label class="form-check-label"
                                        for="exampleCheck1">{{ __('Log Sheet Required') }}</label>
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
    {{-- <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script> --}}
    <script src="{{ Module::asset('sf:js/masters/boatCategoryConfigure.js') }}"></script>
@endsection
