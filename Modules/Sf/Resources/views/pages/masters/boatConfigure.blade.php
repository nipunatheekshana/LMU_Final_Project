@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Boat" @endphp

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
                        <a href="/sf/boat_list">{{ __('Boat List') }}</a>
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
                    <h6 class="card-title">{{ __('Boat Related Images') }}</h6>
                    <form id="frmboatConfigure" autocomplete="off">

                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="validationCustom01">{{ __('Boat Image') }}</label>
                                <img src="../../assets/media/image/portfolio-six.jpg" id="boatImgBox" class="img-thumbnail" alt="image">
                                <!-- File input -->
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="file" class="form-control-file mt-3 mb-3" id="boatImg"
                                            name="boatImg">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" id="buttonDeleteBoatImage"
                                            class="btn btn-danger btn-floating mt-2">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustom01">{{ __('Skipper Signature') }}</label>
                                <img src="../../assets/media/image/portfolio-six.jpg" id="skipperSignBox"  class="img-thumbnail" alt="image">
                                <!-- File input -->
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="file" class="form-control-file mt-3 mb-3" id="skipperSign"
                                            name="skipperSign">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" id="buttonDeleteSkipperImage"
                                            class="btn btn-danger btn-floating mt-2">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustom01">{{ __('Boat Licence') }}</label>
                                <img src="../../assets/media/image/portfolio-six.jpg" id="licenceImageBox" class="img-thumbnail" alt="image">
                                <!-- File input -->
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="file" class="form-control-file mt-3 mb-3" id="licenceImage"
                                            name="licenceImage">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" id="buttonDeleteLicenceImage"
                                            class="btn btn-danger btn-floating mt-2">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Setup New Boat') }}</h6>



                    <input type="hidden" id="hiddenId" name="id">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Boat ID') }}</label>
                            <input type="text" class="form-control" name="BoatID" id="BoatID"
                                placeholder="Eg : 1065">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Boat Registration Number') }}</label>
                            <input type="text" class="form-control" name="BoatRegNo" id="BoatRegNo"
                                placeholder="Eg : IMUL-A-06585ABR">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Boat Code') }}</label>
                            <input type="text" class="form-control" name="BoatCode" id="BoatCode"
                                placeholder="Eg : SH1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Registration Country') }}</label>
                            <select class="form-control" name="RegCountry" id="RegCountry">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Boat Name*') }}</label>
                            <input type="text" class="form-control" name="BoatName" id="BoatName"
                                placeholder="Eg : SEA HUNT 1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Boat Short Name') }}</label>
                            <input type="text" class="form-control" name="BoatShortName" id="BoatShortName"
                                placeholder="Eg : SEA HUNT 1">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Call Sign') }}</label>
                            <input type="text" class="form-control" name="Call_Sign" id="Call_Sign"
                                placeholder="Eg : SEA HUNT 1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Boat Category') }}</label>
                            <select class="form-control" name="BoatCategory" id="BoatCategory">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Boat Length') }}</label>
                            <input type="number" class="form-control" name="BoatLength" id="BoatLength"
                                placeholder="Eg : 3.58m">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Engine Capacity') }}</label>
                            <input type="text" class="form-control" name="EngineCapacity" id="EngineCapacity"
                                placeholder="Eg : 1000CC">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Boat Weight') }}</label>
                            <input type="number" class="form-control" name="BoatWeight" id="BoatWeight"
                                placeholder="Eg : 890 KG">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('License No') }}</label>
                            <input type="text" class="form-control" name="LicenseNo" id="LicenseNo"
                                placeholder="Eg : BO6566882TR">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('License Expiry Date') }}</label>
                            <input type="date" class="form-control" name="LicenseExpDate" id="LicenseExpDate">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Owner Name') }}</label>
                            <input type="text" class="form-control" name="OwnerName" id="OwnerName"
                                placeholder="Eg : Kushan De Silva">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Skipper Name') }}</label>
                            <input type="text" class="form-control" name="SkipperName" id="SkipperName"
                                placeholder="Eg : Sunil Ferdinandez">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Number of Tanks') }}</label>
                            <input type="number" class="form-control" name="NoofTanks" id="NoofTanks"
                                placeholder="Eg : 4">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">{{ __('Number of Crew') }}</label>
                            <input type="text" class="form-control" name="NoofCrew" id="NoofCrew"
                                placeholder="Eg : 8">
                        </div>
                        <div class="col-md-6 mb-3" id="holdReasonContainer">
                            <label for="validationCustom01">{{ __('Hold Reason') }}</label>
                            <select class="form-control" name="HoldReason" id="HoldReason">
                                <option value="null">-Select-</option>
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
                                <input type="checkbox" class="form-check-input" id="LicenseRequired"
                                    name="LicenseRequired">
                                <label class="form-check-label" for="exampleCheck1">{{ __('License Required') }}</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="LogSheetRequired"
                                    name="LogSheetRequired">
                                <label class="form-check-label"
                                    for="exampleCheck1">{{ __('Log Sheet Required') }}</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="BoatHold" name="BoatHold">
                                <label class="form-check-label" for="exampleCheck1">{{ __('Hold') }}</label>
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
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    <script src="{{ Module::asset('sf:js/masters/boatConfigure.js') }}"></script>
@endsection
