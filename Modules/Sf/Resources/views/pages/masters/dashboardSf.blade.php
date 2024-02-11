@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "Sea Food Module | Dashboard" @endphp

@section('title',$title)
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
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-primary" href="\sf\fishGradesMaster_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Fish Grades</a>
                    <a class="btn btn-primary" href="\sf\presentationTypeMaster_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Presentation Types</a>
                    <a class="btn btn-primary" href="\sf\cuttingtypeMaster_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Cutting Types</a>
                    <a class="btn btn-primary" href="\sf\catchAreaMaster_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Catch Areas</a>
                    <a class="btn btn-primary" href="\sf\catchMethodMaster_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Catch Methods</a>
                    <a class="btn btn-primary" href="\sf\landingsiteMaster_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Landing Sites</a>
                    <a class="btn btn-primary" href="\sf\fishSpeciesMaster_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Fish Species</a>
                    <a class="btn btn-primary" href="\sf\boatCategory_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Boat Categories</a>
                    <a class="btn btn-primary" href="\sf\boat_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Boats</a>
                    <a class="btn btn-primary" href="\sf\fishReceiveParamSettings_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Fish Receiving Settings</a>
                    <a class="btn btn-primary" href="\sf\boatHoldType_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Boat Hold Types</a>
                    <a class="btn btn-primary" href="\sf\companyBoats_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Company Boats</a>
                    <a class="btn btn-primary" href="\sf\fishCoolingMethod_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Fish Cooling Methods</a>
                    <a class="btn btn-primary" href="\sf\fishSize_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Fish Sizes</a>
                    <a class="btn btn-primary" href="\sf\seaFoodRawMaterial_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Sea Food Raw Material</a>
                    <a class="btn btn-primary" href="\sf\productQuality_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Product Qualities</a>
                    <a class="btn btn-primary" href="\sf\manufacturingItem_list" type="button" style="min-width: 220px; width: 250px; max-width: 300px; height: 70px;margin: 20px;text-align: center;font-size: 17px"><i class="fa fa-ship"></i>&nbsp;Manufacturing Items</a>



                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    {{-- <script src="{{ url('assets/js/custom/Admin_level/configurations/supplierGroup.js') }}"></script> --}}
    <script src="{{ Module::asset('sf:js/masters/fishSize.js') }}"></script>
@endsection
