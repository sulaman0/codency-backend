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
                    <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">ECG Codes</h1>
                    <ul class="breadcrumb breadcrumb-dot fw-semibold fs-base my-1">
                        <li class="breadcrumb-item text-muted">App</li>
                        <li class="breadcrumb-item text-muted">ECG Codes</li>
                    </ul>
                </div>
                @include('layout.top_menu')
            </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            <div class="container-xxl" id="kt_content_container">
                <div class="card p-10">
                    <form id="kt_modal_new_target_form" class="form" action="#">
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Add Code</h1>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Code Name</span></span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid"
                                   placeholder="e.g, Fire Alram" name="target_title"/>
                        </div>

                        <div class="row g-9 mb-8">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">Operation</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Select a Team Member"
                                        name="target_assign">
                                    <option value="1">Sent to Amplifier Directly</option>
                                    <option value="2">Managed by Manager</option>
                                </select>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Code</span></span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                       placeholder="e.g, 10" name="target_title"/>
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2">Code Details</label>
                            <textarea class="form-control form-control-solid" rows="3" name="target_details"
                                      placeholder="e.g, What should do?"></textarea>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Sender</span>
                                <span class="ms-1" data-bs-toggle="tooltip"
                                      title="These users can only press this code">
										<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
										</i>
									</span>
                            </label>
                            <input class="form-control form-control-solid" value="All"
                                   name="tags"/>
                        </div>

                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Receiver</span>
                                <span class="ms-1" data-bs-toggle="tooltip"
                                      title="Notify these users only">
										<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
										</i>
									</span>
                            </label>
                            <input class="form-control form-control-solid" value="Mr.Qaiser, Mr.Abdullah"
                                   name="tags_receiver"/>
                        </div>
                        <div class="row g-9 mb-8">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">Image</label>
                                <input type="file" class="form-control form-control-solid"
                                       placeholder="e.g, 10" name="target_title"/>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Notification Tune</span></span>
                                </label>
                                <!--end::Label-->
                                <input type="file" class="form-control form-control-solid"
                                       placeholder="e.g, 10" name="target_title"/>
                            </div>
                            <!--end::Col-->
                        </div>

                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-15 fv-row">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack">
                                <!--begin::Label-->
                                <div class="fw-semibold me-5">
                                    <label class="fs-6">Notifications</label>
                                    <div class="fs-7 text-muted">Allow Notifications by Email</div>
                                </div>
                                <!--end::Label-->
                                <!--begin::Checkboxes-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Checkbox-->
                                    <label class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input h-20px w-20px" type="checkbox"
                                               name="communication[]" value="email" checked="checked"/>
                                        <span class="form-check-label fw-semibold">Email</span>
                                    </label>
                                    <!--end::Checkbox-->
                                    <!--begin::Checkbox-->
                                {{--                                                <label class="form-check form-check-custom form-check-solid">--}}
                                {{--                                                    <input class="form-check-input h-20px w-20px" type="checkbox"--}}
                                {{--                                                           name="communication[]" value="phone"/>--}}
                                {{--                                                    <span class="form-check-label fw-semibold">Phone</span>--}}
                                {{--                                                </label>--}}
                                <!--end::Checkbox-->
                                </div>
                                <!--end::Checkboxes-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3">
                                Cancel
                            </button>
                            <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                </div>
                <div class="modal fade" id="kt_modal_new_target" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <!--begin::Modal content-->
                        <div class="modal-content rounded">
                            <!--begin::Modal header-->
                            <div class="modal-header pb-0 border-0 justify-content-end">
                                <!--begin::Close-->
                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                    <i class="ki-duotone ki-cross fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--begin::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                                <!--begin:Form-->
                                <form id="kt_modal_new_target_form" class="form" action="#">
                                    <!--begin::Heading-->
                                    <div class="mb-13 text-center">
                                        <h1 class="mb-3">Add Code</h1>
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Code Name</span></span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid"
                                               placeholder="e.g, Fire Alram" name="target_title"/>
                                    </div>

                                    <div class="row g-9 mb-8">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <label class="required fs-6 fw-semibold mb-2">Operation</label>
                                            <select class="form-select form-select-solid" data-control="select2"
                                                    data-hide-search="true" data-placeholder="Select a Team Member"
                                                    name="target_assign">
                                                <option value="1">Sent to Amplifier Directly</option>
                                                <option value="2">Managed by Manager</option>
                                            </select>
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span class="required">Code</span></span>
                                            </label>
                                            <!--end::Label-->
                                            <input type="text" class="form-control form-control-solid"
                                                   placeholder="e.g, 10" name="target_title"/>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <div class="d-flex flex-column mb-8">
                                        <label class="fs-6 fw-semibold mb-2">Code Details</label>
                                        <textarea class="form-control form-control-solid" rows="3" name="target_details"
                                                  placeholder="e.g, What should do?"></textarea>
                                    </div>
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Sender</span>
                                            <span class="ms-1" data-bs-toggle="tooltip"
                                                  title="These users can only press this code">
										<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
										</i>
									</span>
                                        </label>
                                        <input class="form-control form-control-solid" value="All"
                                               name="tags"/>
                                    </div>

                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Receiver</span>
                                            <span class="ms-1" data-bs-toggle="tooltip"
                                                  title="Notify these users only">
										<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
										</i>
									</span>
                                        </label>
                                        <input class="form-control form-control-solid" value="Mr.Qaiser, Mr.Abdullah"
                                               name="tags_receiver"/>
                                    </div>
                                    <div class="row g-9 mb-8">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <label class="required fs-6 fw-semibold mb-2">Image</label>
                                            <input type="file" class="form-control form-control-solid"
                                                   placeholder="e.g, 10" name="target_title"/>
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                <span class="required">Notification Tune</span></span>
                                            </label>
                                            <!--end::Label-->
                                            <input type="file" class="form-control form-control-solid"
                                                   placeholder="e.g, 10" name="target_title"/>
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-15 fv-row">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-stack">
                                            <!--begin::Label-->
                                            <div class="fw-semibold me-5">
                                                <label class="fs-6">Notifications</label>
                                                <div class="fs-7 text-muted">Allow Notifications by Email</div>
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Checkboxes-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Checkbox-->
                                                <label class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input h-20px w-20px" type="checkbox"
                                                           name="communication[]" value="email" checked="checked"/>
                                                    <span class="form-check-label fw-semibold">Email</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                            {{--                                                <label class="form-check form-check-custom form-check-solid">--}}
                                            {{--                                                    <input class="form-check-input h-20px w-20px" type="checkbox"--}}
                                            {{--                                                           name="communication[]" value="phone"/>--}}
                                            {{--                                                    <span class="form-check-label fw-semibold">Phone</span>--}}
                                            {{--                                                </label>--}}
                                            <!--end::Checkbox-->
                                            </div>
                                            <!--end::Checkboxes-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="text-center">
                                        <button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3">
                                            Cancel
                                        </button>
                                        <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end:Form-->
                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js_files')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/new-target.js?'.time()) }}"></script>
    <script src="{{ asset('assets/js/custom/ecg-codes/listing.js?'.time()) }}"></script>
@endsection
