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
                    <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Emergency Calls</h1>
                    <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
                        <li class="breadcrumb-item text-muted">App</li>
                        <li class="breadcrumb-item text-muted">Report</li>
                        <li class="breadcrumb-item text-muted">ECG Calls</li>
                    </ul>
                </div>
                @include('layout.top_menu')
            </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="container-xxl" id="kt_content_container">
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title"></div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_customer">Filter
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0" id="main-content" data-href="{{ route('reports.code_pressed_table') }}">
                        <div class="loading-progress-div">
                            Loading...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="kt_modal_add_customer" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-650px">

                        <div class="modal-content">
                            <form class="form" action="{{ route('reports.code_pressed_table') }}"
                                  id="kt_modal_add_customer_form">

                                <input type="hidden" name="date_range">
                                <div class="modal-header" id="kt_modal_add_customer_header">
                                    <h2 class="fw-bold">Filter Ecg Alerts
                                        <div class="loading-progress-div d-none">
                                            Loading...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </div>
                                    </h2>
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                         id="kt_modal_add_customer_close">
                                        <i class="ki-duotone ki-cross fs-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                                <div class="modal-body py-10 px-lg-17">
                                    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll"
                                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                         data-kt-scroll-max-height="auto"
                                         data-kt-scroll-dependencies="#kt_modal_add_customer_header"
                                         data-kt-scroll-wrappers="#kt_modal_add_customer_scroll"
                                         data-kt-scroll-offset="300px">

                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-semibold mb-2">
                                                Ecg Codes
                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                      title="Search Codes">
                                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
									            </span>
                                            </label>
                                            <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="Emergency Codes"
                                                    multiple="multiple"
                                                    name="ecg_codes[]">
                                                @foreach($codes as $code)
                                                    <option value="{{ $code->id }}">{{ $code->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-semibold mb-2">
                                                Date Range
                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                      title="Filter when code pressed">
                                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
									            </span>
                                            </label>
                                            <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left"
                                                 data-kt-daterangepicker-range="today"
                                                 class="btn btn-sm btn-light d-flex align-items-center px-4">
                                                <div class="text-gray-600 fw-bold">Loading date range...</div>
                                                <i class="ki-duotone ki-calendar-8 fs-1 ms-2 me-0">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                    <span class="path6"></span>
                                                </i>
                                            </div>
                                        </div>
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-semibold mb-2">
                                                Senders
                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                      title="Those users who has pressed the code">
                                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
									            </span>
                                            </label>
                                            <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="Select Staff"
                                                    multiple="multiple"
                                                    name="senders_list[]">
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-semibold mb-2">
                                                Receivers
                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                      title="Those users who has respond the code">
                                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
									            </span>
                                            </label>
                                            <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="Select Staff"
                                                    multiple="multiple"
                                                    name="receivers_list[]">
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="fv-row mb-7">
                                            <label class="fs-6 fw-semibold mb-2">
                                                Locations
                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                      title="Find Location Where code pressed">
                                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
									            </span>
                                            </label>
                                            <select class="form-select form-select-solid" data-control="select2"
                                                    data-placeholder="Locations"
                                                    multiple="multiple"
                                                    name="locations_list[]">
                                                @foreach($locations as $location)
                                                    <option
                                                        value="{{ $location->id }}">{{ $location->locationName() }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                    </div>
                                </div>
                                <div class="modal-footer flex-center">
                                    <button data-dismiss="modal" class="btn btn-light me-3"
                                            id="kt_modal_add_customer_cancel">Reset
                                    </button>
                                    <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
                                        <span class="indicator-label">Submit</span>
                                        <span class="indicator-progress">Please wait...
													<span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js_files')
    <script src="{{ asset('assets/js/custom/ecg-alerts/listing.js?'.time()) }}"></script>
@endsection
