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
                    <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Groups</h1>
                    <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
                        <li class="breadcrumb-item text-muted">App</li>
                        <li class="breadcrumb-item text-muted">Staffs</li>
                        <li class="breadcrumb-item text-muted">Groups</li>
                    </ul>
                </div>
                @include('layout.top_menu')
            </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="container-xxl" id="kt_content_container">
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="text" data-kt-customer-table-filter="search"
                                       class="form-control form-control-solid w-250px ps-13 search-user"
                                       placeholder="Search Group"/>
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_customer">Add Group
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0" id="main-content" data-href="{{ route('group_table') }}">
                        <div class="loading-progress-div">
                            Loading...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="kt_modal_add_customer" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <div class="modal-content">
                            <form class="form" action="#" id="kt_modal_add_customer_form"
                                  data-kt-redirect="{{ route('groups.store') }}">
                                <input type="text" class="d-none" name="id">
                                <div class="modal-header" id="kt_modal_add_customer_header">

                                    <h2 class="fw-bold">Group
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


                                <div class="modal-body py-10 px-lg-17">
                                    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll"
                                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                         data-kt-scroll-max-height="auto"
                                         data-kt-scroll-dependencies="#kt_modal_add_customer_header"
                                         data-kt-scroll-wrappers="#kt_modal_add_customer_scroll"
                                         data-kt-scroll-offset="300px">
                                        <div class="fv-row mb-5">
                                            <label class="required fs-6 fw-semibold mb-2">Name</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   placeholder="" name="name" value=""/>
                                        </div>
                                        <div class="fv-row mb-5">
                                            <label class="fs-6 fw-semibold mb-2">
                                                <span>Description</span>
                                            </label>
                                            <textarea class="form-control form-control-solid"
                                                      name="description"></textarea>
                                        </div>
                                        <div class="fv-row mb-5">
                                            <label class="required fs-6 fw-semibold mb-2">Staffs</label>
                                            <Select class="form-control form-control-solid select2" multiple="multiple"
                                                    data-control="select2"
                                                    name="staff[]">
                                                @foreach($staffs as $staff)
                                                    <option
                                                        value="{{ $staff->id }}">{{ $staff->name }}</option>
                                                @endforeach
                                            </Select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer flex-center">
                                    <button type="reset" id="kt_modal_add_customer_cancel"
                                            class="btn btn-light me-3">Discard
                                    </button>
                                    <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
                                        <span class="indicator-label">Submit</span>
                                        <span class="indicator-progress">
                                            Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
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
    <script src="{{ asset('assets/js/custom/groups/add.js?'.time()) }}"></script>
    <script src="{{ asset('assets/js/custom/groups/listing.js?'.time()) }}"></script>
@endsection
