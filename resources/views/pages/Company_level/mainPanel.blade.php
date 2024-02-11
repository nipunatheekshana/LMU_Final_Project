@extends('layouts.app')

@section('head')
<!-- Prism -->
<link rel="stylesheet" href="{{ url('vendors/prism/prism.css') }}" type="text/css">
@endsection

@section('content')

<div class="page-header">
    <div>
        <h3>{{__('Dashboard')}}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">{{__('Home')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{__('dashboard')}}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-body">
                <h6 class="card-title">{{__('Child Company level')}}</h6>

            </div>
        </div>

    </div>
</div>

@endsection
