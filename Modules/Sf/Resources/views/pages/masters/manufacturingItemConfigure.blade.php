@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Manufacturing Item" @endphp

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
                        <a href="/sf">{{ __('Sea Food Module') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/sf/manufacturingItem_list">{{ __('Manufacturing Items List') }}</a>
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
                    <h6 class="card-title">{{ __('Manufacturing Item Details') }}</h6>
                    <form id="frmmanufacturingItemConfigure" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">

                            <div class="col-md-1">

                            </div>


                            <div class="col-md-3">
                                <img src="../../assets/media/image/portfolio-six.jpg" id="imageBox" class="img-thumbnail" alt="image">
                                <!-- File input -->
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="file" class="form-control-file mt-3 mb-3" id="image" name="image">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" id="buttonDeleteImage" class="btn btn-danger btn-floating mt-2">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-2">

                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Company') }}</label>
                                <select class="form-control" name="CompanyID" id="CompanyID">
                                    <option value="">-Select-</option>
                                </select>

                                <label for="validationCustom01">{{ __('Product Code*') }}</label>
                                <input type="text" class="form-control" name="Item_Code" id="Item_Code">

                                <label for="validationCustom01">{{ __('Product Name*') }}</label>
                                <input type="text" class="form-control" name="item_name" id="item_name">

                                <label for="validationCustom02">{{ __('Fish Species*') }}</label>
                                <select class="form-control" name="rm_species" id="rm_species">
                                    <option value="">-Select-</option>
                                </select>

                                <label for="validationCustom02">{{ __('Presentation Type*') }}</label>
                                <select class="form-control" name="ProductPresentation" id="ProductPresentation">
                                    <option value="">-Select-</option>
                                </select>

                                <label for="validationCustom02">{{ __('Cutting Types*') }}</label>
                                <select class="form-control" name="ProductCutType" id="ProductCutType">
                                    <option value="">-Select-</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Quality') }}</label>
                                <input type="text" class="form-control" name="ProductQuality" id="ProductQuality">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Specification') }}</label>
                                <input type="text" class="form-control" name="ProductSpec" id="ProductSpec">
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Grade') }}</label>
                                <select class="form-control" name="ReceiveGrade" id="ReceiveGrade">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Unit of Maesure*') }}</label>
                                <select class="form-control" name="stock_uom" id="stock_uom">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Average Weight*') }}</label>
                                <input type="text" class="form-control" name="avg_weight_per_unit"
                                    id="avg_weight_per_unit">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Weight Unit*') }}</label>
                                <select class="form-control" name="weight_uom" id="weight_uom">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Item Group') }}</label>
                                <select class="form-control" name="item_group" id="item_group">
                                    <option value="">-Select-</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Product Description') }}</label>
                                <textarea type="number" class="form-control" name="Item_description" id="Item_description"></textarea>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Process') }}</label>
                                <select class="form-control" name="process" id="process">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Work station') }}</label>
                                <select class="form-control" name="work_station" id="work_station">
                                    <option value="">-Select-</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Index') }}</label>
                                <input type="number" class="form-control" name="list_index" id="list_index"
                                    value="1">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
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
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('sf:js/masters/manufacturingItemConfigure.js') }}"></script>
@endsection
