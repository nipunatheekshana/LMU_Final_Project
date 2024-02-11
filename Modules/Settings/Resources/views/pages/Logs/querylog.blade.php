@extends('layouts.app')

{{-- Define Page Title Here --}}
@php $title= "Application Log" @endphp

@section('title', $title)

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
                        <a href="/settings">{{ __('Settings') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __($title) }}</li>
                </ol>
            </nav>
        </div>
    </div>






    <style>
        #query-log {
            background-color: black;
            color: #00FF00;
            white-space: pre-wrap;
            word-wrap: break-word;
            max-height: 55vh;
            overflow-y: auto;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="card-title">{{ __('Query Log') }}</h6>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-warning ml-3" style="float: right" onclick="clearQueryLog()">Clear</button>
                            <button class="btn btn-primary" onclick="window.location.reload()"
                                style="float: right">Reload</button>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <pre id="query-log" class="p-4">{{ file_get_contents(storage_path('logs/query.log')) }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="card-title">{{ __('App Log') }}</h6>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-warning ml-3" style="float: right" onclick="clearAppLog()">Clear</button>
                            <button class="btn btn-primary" onclick="window.location.reload()"
                                style="float: right">Reload</button>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <pre id="query-log" class="p-4">{{ file_get_contents(storage_path('logs/laravel.log')) }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="card-title">{{ __('API Log') }}</h6>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-warning ml-3" style="float: right" onclick="clearAPILog()">Clear</button>
                            <button class="btn btn-primary" onclick="window.location.reload()"
                                style="float: right">Reload</button>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <pre id="query-log" class="p-4">{{ file_get_contents(storage_path('logs/api.log')) }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function clearQueryLog() {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the cleared logs!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willClear) => {
                if (willClear) {
                    window.location.href = "{{ route('clearQueryLog') }}";
                }
            });
        }

        // Reload the Application Log every 5 seconds
        setInterval(function() {
            $('#query-log').load('{{ route('loadQueryLog') }}');
        }, 1000);

        function clearAppLog() {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the cleared logs!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willClear) => {
                if (willClear) {
                    window.location.href = "{{ route('clearAppLog') }}";
                }
            });
        }

        function clearAPILog() {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the cleared logs!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willClear) => {
                if (willClear) {
                    window.location.href = "{{ route('clearAPILog') }}";
                }
            });
        }
    </script>


@endsection
