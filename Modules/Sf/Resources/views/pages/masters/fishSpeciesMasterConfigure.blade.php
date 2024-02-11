@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Fish Species" @endphp

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
                        <a href="/sf/fishSpeciesMaster_list">{{ __('Fish Species List') }}</a>
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Fish Species Image') }}</h6>
                    <input type="hidden" id="hiddenId" name="id">
                    <div class="form-row">
                        <div class="col-md-12" style="padding: 50px;">
                            <img src="../../assets/media/image/portfolio-six.jpg" class="img-thumbnail " id="imageBox"
                                alt="image" style="height : 300px; width:400px">
                            <!-- File input -->
                            <div class="row">
                                <div class="col-md-9">
                                    <input type="file" class="form-control-file mt-3 mb-3" id="img" name="img">
                                </div>
                                <div class="col-md-3">
                                    <button type="button" id="buttonDeleteImage" class="btn btn-danger btn-floating mt-2">
                                        <i class="ti-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Fish Species Details') }}</h6>
                    <form id="frmfishSpeciesMaster" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Fish Code*') }}</label>
                                <input type="text" class="form-control text-uppercase" name="FishCode" id="FishCode">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Short Name') }}</label>
                                <input type="email" class="form-control" name="ShortName" id="ShortName" required="">

                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">{{ __('Scientific Name') }}</label>
                                <input type="text" class="form-control font-italic" name="ScName" id="ScName">

                                <label for="validationCustom02">{{ __('Fish Name*') }}</label>
                                <input type="text" class="form-control" name="FishName" id="FishName" required="">


                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Default Weight Unit*') }}</label>
                                <select class="form-control" name="default_weight_unit" id="default_weight_unit">
                                    <option value="">-Select-</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Average Weight*') }}</label>
                                <input type="number" class="form-control" name="average_weight" id="average_weight">
                            </div>
                            <div class="col-md-6 mb-3">

                                <label for="validationCustom01">{{ __('Quality Risk Level') }}</label>
                                <input type="number" class="form-control" name="QRiskLevel" id="QRiskLevel">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Index') }}</label>
                                <input type="number" class="form-control" name="list_index" id="list_index">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="BulkMode" name="BulkMode">
                                    <label class="form-check-label" for="exampleCheck1">{{ __('Bulk Mode') }}</label>
                                </div>

                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="enabled" name="enabled"
                                        checked>
                                    <label class="form-check-label" for="exampleCheck1">{{ __('Enabled') }}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is_reef_fish" name="is_reef_fish">
                                    <label class="form-check-label" for="exampleCheck1">{{ __('is reef fish') }}</label>
                                </div>
                            </div>
                        </div>
                        {{-- </form> --}}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Fish Receiving Setting') }}</h6>
                    {{-- <form id="frmfishSpeciesMaster" autocomplete="off"> --}}
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">{{ __('Current Fish Serial No*') }}</label>
                            <input type="number" class="form-control text-uppercase" name="currentFishSerialNo"
                                id="currentFishSerialNo">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom02">{{ __('Minimum  Fish Serial No*') }}</label>
                            <input type="number" class="form-control" name="minFishSerialNo" id="minFishSerialNo"
                                required="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom02">{{ __('Maximum  Fish Serial No*') }}</label>
                            <input type="number" class="form-control" name="maxFishSerialNo" id="maxFishSerialNo"
                                required="">
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
    <script src="{{ Module::asset('sf:js/masters/fishSpeciesMasterConfigure.js') }}"></script>
@endsection
