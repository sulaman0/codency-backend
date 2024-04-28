@extends('layout.index')
@section('main-layout')
    <style>
        .wrapper {
            padding-right: unset !important;
        }

        .column-separator {
            position: relative;
            padding-right: 10px; /* Adjust spacing on the right */
        }

        .column-separator:after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 1px; /* Line thickness */
            background-color: #f1f1f2;
            background-position: right;
            background-size: 1px 10px; /* Line thickness and spacing between dots */
            background-repeat: repeat-y;
        }

        /* Adjustments for the last column to prevent the line */
        .col-md-4:last-child:after {
            display: none;
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
                    <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Locations</h1>
                    <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
                        <li class="breadcrumb-item text-muted">App</li>
                        <li class="breadcrumb-item text-muted">Building Location</li>
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
                                       placeholder="Search"/>
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <div class="w-150px me-3">
                                    <select class="form-select form-select-solid location-type" data-control="select2"
                                            data-hide-search="true"
                                            data-kt-ecommerce-order-filter="status">
                                        <option selected value="buildings">Building</option>
                                            <option value="floors">Floor</option>
                                        <option value="rooms">Room</option>
                                    </select>
                                </div>
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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_customer">Add Location
                                </button>
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
                <div class="modal fade" id="kt_modal_add_customer" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-950px">

                        <div class="modal-content">
                            <div class="modal-header" id="kt_modal_add_customer_header">
                                <h2 class="fw-bold">Location
                                    <div class="loading-progress-div d-none">
                                        Loading...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </div>
                                </h2>
                                <div id="kt_modal_add_customer_close"
                                     class="btn btn-icon btn-sm btn-active-icon-primary">
                                    <i class="ki-duotone ki-cross fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                            </div>
                            <div class="modal-body py-10 px-lg-8">
                                <!--begin::Scroll-->
                                <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll"
                                     data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                     data-kt-scroll-max-height="auto"
                                     data-kt-scroll-dependencies="#kt_modal_add_customer_header"
                                     data-kt-scroll-wrappers="#kt_modal_add_customer_scroll"
                                     data-kt-scroll-offset="300px">

                                    <div class="row">
                                        <div class="col-md-4 column-separator">
                                            <form class="form" action="#" id="kt_modal_add_customer_form"
                                                  data-kt-redirect="{{ route('locations.store') }}">
                                                <div class="fv-row mb-7">
                                                    <label class="required fs-6 fw-semibold mb-2">Building</label>
                                                    <input type="text" class="form-control form-control-solid"
                                                           placeholder="" name="building_name" value=""/>
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" id="kt_modal_add_customer_submit"
                                                            class="btn btn-primary btn-sm">
                                                        <span class="indicator-label">Save</span>
                                                        <span class="indicator-progress">Please wait...
													<span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-4 column-separator">
                                            <form class="form" action="#" id="kt_modal_add_customer_form_floor"
                                                  data-kt-redirect="{{ route('locations.store') }}">
                                                <input type="hidden" name="step" value="2">
                                                <div class="fv-row mb-7">
                                                    <label class="fs-6 fw-semibold mb-2">Building</label>
                                                    <div class="building-select">
                                                        <select name="building" class="form-control form-control-solid">
                                                            @foreach($buildings as $building)
                                                                <option
                                                                    value="{{ $building->id }}">{{$building->building_nme}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="fv-row mb-7">
                                                    <label class="fs-6 fw-semibold mb-2">Floor</label>
                                                    <input type="text" class="form-control form-control-solid"
                                                           placeholder="" name="floor_name" value=""/>
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" id="kt_modal_add_customer_submit_floor"
                                                            class="btn btn-primary btn-sm">
                                                        <span class="indicator-label">Save</span>
                                                        <span class="indicator-progress">Please wait...
													<span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-4">
                                            <form class="form" action="#" id="kt_modal_add_customer_form_room"
                                                  data-kt-redirect="{{ route('locations.store') }}">
                                                <input type="hidden" name="step" value="3">
                                                <div class="fv-row mb-7">
                                                    <label class="fs-6 fw-semibold mb-2">Building</label>
                                                    <div class="building-select">
                                                        <select name="building" class="form-control form-control-solid">
                                                            @foreach($buildings as $building)
                                                                <option
                                                                    value="{{ $building->id }}">{{$building->building_nme}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="fv-row mb-7">
                                                    <label class="fs-6 fw-semibold mb-2">Floor</label>
                                                    <div class="floor-select">
                                                        <select name="floor" class="form-control form-control-solid">
                                                            @foreach($floors as $floor)
                                                                <option
                                                                    value="{{ $floor->id }}">{{$floor->floor_nme}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="fv-row mb-7">
                                                    <label class="fs-6 fw-semibold mb-2">Room</label>
                                                    <input type="text" class="form-control form-control-solid"
                                                           placeholder="" name="room_name" value=""/>
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" id="kt_modal_add_customer_form_room_submit"
                                                            class="btn btn-primary btn-sm">
                                                        <span class="indicator-label">Save</span>
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
                </div>
                <div class="modal fade" id="kt_modal_edit_location" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-400px">

                        <div class="modal-content">
                            <div class="modal-header" id="kt_modal_add_customer_header">
                                <h2 class="fw-bold">Location
                                    <div class="loading-progress-div d-none">
                                        Loading...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </div>
                                </h2>
                                <div id="edit_modal_close"
                                     class="btn btn-icon btn-sm btn-active-icon-primary">
                                    <i class="ki-duotone ki-cross fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                            </div>
                            <div class="modal-body py-10 px-lg-8">
                                <!--begin::Scroll-->
                                <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll"
                                     data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                     data-kt-scroll-max-height="auto"
                                     data-kt-scroll-dependencies="#kt_modal_add_customer_header"
                                     data-kt-scroll-wrappers="#kt_modal_add_customer_scroll"
                                     data-kt-scroll-offset="300px">

                                    <div class="row">
                                        <form class="form" id="kt_modal_edit_location_form"
                                              action="{{ route('update_location') }}">
                                            <div class="fv-row mb-7">
                                                <label class="fs-6 fw-semibold mb-2">Name</label>
                                                <input type="hidden" name="loc_type">
                                                <input type="hidden" name="id">
                                                <input type="text" class="form-control form-control-solid"
                                                       placeholder="" name="name" value=""/>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" id="kt_modal_edit_location_form_submit"
                                                        class="btn btn-primary btn-sm">
                                                    <span class="indicator-label">Save</span>
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
            </div>
        </div>
    </div>
@endsection
@section('js_files')
    <script src="{{ asset('assets/js/custom/ecg-locations/add.js') }}"></script>
    <script src="{{ asset('assets/js/custom/ecg-locations/listing.js?'.time()) }}"></script>
@endsection
