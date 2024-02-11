@extends('layouts.app')
{{-- @extends('inventory::layouts.inventoryModuleLayout') --}}

@section('head')
    <link rel="stylesheet" href="{{ Module::asset('inventory:js/jstree/themes/default/style.min.css') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h3>{{ __('New Product Groups') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ __('Product Groups') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Product Groups') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="jstree_demo_div"></div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script src="{{ Module::asset('inventory:js/jstree/jstree.min.js') }}"></script>

    <script src="{{ Module::asset('inventory:js/masters/productGroups.js') }}"></script>
@endsection
