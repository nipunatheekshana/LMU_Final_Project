@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Supplier Group" @endphp

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
                        <a href="/buying">{{ __('Buying Module') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/buying/supplierGroup_list">{{ __('Supplier Groups List') }}</a>
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
                    <h6 class="card-title">{{ __('Setup New Supplier Group') }}</h6>
                    <form id="frmsupplierGroupConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Supplier Group Code') }}</label>
                                <input type="text" class="form-control" name="SupGroupCode" id="SupGroupCode">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Supplier Group Name') }}</label>
                                <input type="text" class="form-control" name="SupGroupName" id="SupGroupName">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Parent Supplier Group') }}</label>
                                {{-- <input type="text" class="form-control" name="domain_id" id="domain_id"> --}}
                                <select class="form-control" name="ParentSupGroupID" id="ParentSupGroupID">
                                    <option value="">-Select-</option>
                                </select>
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
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="isGroup" name="isGroup">
                                    <label class="form-check-label" for="exampleCheck1">{{ __('isGroup') }}</label>
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
    <script src="{{ Module::asset('buying:js/masters/supplierGroupConfigure.js') }}"></script>
@endsection
