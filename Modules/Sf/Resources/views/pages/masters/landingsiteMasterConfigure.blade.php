@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Landing Site" @endphp

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
                        <a href="/sf/landingsiteMaster_list">{{ __('Landing Sites List') }}</a>
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
                    <h6 class="card-title">{{ __('Setup New Landing Site') }}</h6>

                    <a class="image-popup" href="f" id="landingSiteImageLarge">
                        <img src="" alt="image" id="landingSiteImageSmall" class="mb-3" height="200"
                            alt="image">

                    </a>
                    <button class="btn btn-danger mr-1" id="btnDeleteImage"><i class="fa fa-trash"
                            aria-hidden="true"></i></button>


                    <form id="frmlandingsiteMaster" autocomplete="off">

                        <input type="hidden" id="hiddenId" name="id">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Landing Site Name*') }}</label>
                                <input type="text" class="form-control" name="LandingSiteName" id="LandingSiteName"
                                    placeholder="Eg : Trincomalee Harbour">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Latitude*') }}</label>
                                <input type="text" class="form-control" name="Latitude" id="Latitude"
                                    placeholder="Eg : 7.6458">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Longitude*') }}</label>
                                <input type="email" class="form-control" name="Longitude" id="Longitude" required=""
                                    placeholder="Eg : 80.6458">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Latitude + Longitude') }}</label>
                                <input type="email" class="form-control" name="LongLat" id="LongLat" required=""
                                    placeholder="Eg : 7.6458,80.6458">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">{{ __('Landing Site Image') }}</label>
                                <input type="file" class="form-control" name="LandingSiteImage" id="LandingSiteImage">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">{{ __('Country*') }}</label>
                                <select class="form-control" name="countryCode" id="countryCode">
                                    <option value="">-Select-</option>
                                </select>
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
    <!-- Javascript -->
    <script src="{{ url('vendors/lightbox/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ Module::asset('sf:js/masters/landingsiteMasterConfigure.js') }}"></script>
@endsection
