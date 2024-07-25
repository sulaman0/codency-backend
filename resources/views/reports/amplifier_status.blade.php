@extends('layout.index')
@section('main-layout')
    <style>
        .wrapper {
            padding-right: unset !important;
        }
    </style>
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <div id="kt_header" class="header mt-0 mt-lg-0 pt-lg-0" data-kt-sticky="true"
             data-kt-sticky-name="header"
             data-kt-sticky-offset="{lg: '300px'}">
            <div class="container d-flex flex-stack flex-wrap gap-4" id="kt_header_container">
                <div
                    class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-10 pb-lg-0"
                    data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                    <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Amplifier Status</h1>
                    <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
                        <li class="breadcrumb-item text-muted">App</li>
                        <li class="breadcrumb-item text-muted">Report</li>
                        <li class="breadcrumb-item text-muted">Amplifier Status</li>
                    </ul>
                </div>
                @include('layout.top_menu')
            </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="container-xxl" id="kt_content_container">
                @include('alert_synced_notification')
                <div class="card">
                    <div class="card-body pt-0" id="main-content"
                         data-href="{{ route('reports.amplifier_status_json') }}">
                        <div class="loading-progress-div">
                            Loading...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_files')
    <script src="{{ asset('assets/js/custom/amplifier-status/listing.js?'.time()) }}"></script>
@endsection
