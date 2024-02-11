@extends('layouts.app')
{{-- @extends('sf::layouts.sfModuleLayout') --}}

{{-- Define Page Title Here --}}
@php $title= "New Requirements" @endphp

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
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <button id="btnSave" class="btn btn-primary mb-3" style="float: right" type="button">Save</button>
            <button id="btnApprove" class="btn btn-success mb-3 mr-2" style="float: right" type="button">Aprove</button>
            <button id="btnCancle" class="btn btn-danger mb-3 mr-2" style="float: right" type="button">Cancle</button>
            <button type="button"style="float: right" class="btn btn-danger btn-floating mr-2">
                <i class="ti-trash"></i>
            </button>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <form id="frmNewRequirements" autocomplete="off">

                                <div class="form-row">

                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom01">{{ __('Date') }}</label>
                                        <input type="date" class="form-control" name="date" id="date" readonly>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom01">{{ __('Required Date') }}</label>
                                        <input type="date" class="form-control" name="rqDate" id="rqDate">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom01">{{ __('Remarks') }}</label>
                                        <input type="text" class="form-control" name="remarks" id="remarks">
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <p class="mb-2">Status</p>
                                <h1 class="text-success">OPEN</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">{{ __('Item Details') }}
                        <button id="btnAddItem" class="btn btn-primary btn-floating ml-2 mb-1" type="button"> <i
                                class="ti-plus"></i></button>
                    </h6>
                    <div class="table-responsive">
                        <table id="tablenewRequirementConfigure"
                            class="table table-striped table-bordered Date display nowrap" style="100%">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thItemCode">{{ __('Item Coce') }}</th>
                                    <th class="thItem">{{ __('Item') }}</th>
                                    <th class="thRequiredQuantity">{{ __('Required Quantity') }}</th>
                                    <th class="thRequiredWeight">{{ __('Required Weight') }}</th>
                                    <th class="action"> {{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- models --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="ItemModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Items</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ti-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="tableItem" class="table table-striped table-bordered Date display nowrap" style="100%">
                            <thead>
                                <tr>
                                    <th class="thId">#</th>
                                    <th class="thItem">{{ __('Item') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary">Add
                    </button>
                    <button type="button" class="btn btn-primary">Add</button> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="QuantityModel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quantity Model</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <input type="hidden" name="itemId" id="itemId">
                <input type="hidden" name="avgWeight" id="avgWeight">

                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom02">{{ __('QUantity') }}</label>
                            <input class="form-control" type="number" name="qty" id="qty">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSaveQuantity" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTable -->
    <script src="{{ url('vendors/dataTable/datatables.min.js') }}"></script>
    {{-- <script src="{{ url('assets/js/custom/Admin_level/configurations/supplierGroup.js') }}"></script> --}}
    <script src="{{ Module::asset('mnu:js/masters/newRequirementConfigure.js') }}"></script>
@endsection
