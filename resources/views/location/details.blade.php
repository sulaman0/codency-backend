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
                    <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Hello, Qaiser Khan</h1>
                    <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">

                        <li class="breadcrumb-item text-muted">Code</li>
                        <li class="breadcrumb-item text-dark">Ecg Code Details</li>
                    </ul>
                </div>
                @include('layout.top_menu')
            </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="container-xxl" id="kt_content_container">
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="text" data-kt-customer-table-filter="search"
                                       class="form-control form-control-solid w-250px ps-13 search-location"
                                       placeholder="Search Floor"/>
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <div class="w-150px me-3">
                                    <select class="form-select form-select-solid user-status" data-control="select2"
                                            data-hide-search="true" data-placeholder="Status"
                                            data-kt-ecommerce-order-filter="status">
                                        <option></option>
                                        <option value="all">All</option>
                                        <option selected value="active">Active</option>
                                        <option value="blocked">In-Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-0" id="main-content" data-href="{{ route('location_table') }}">
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
    <script src="{{ asset('assets/js/custom/ecg-codes/details.js?'.time()) }}"></script>
@endsection
