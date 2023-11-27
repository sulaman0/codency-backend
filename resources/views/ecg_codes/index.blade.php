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
            <!--begin::Container-->
            <div class="container-xxl" id="kt_content_container">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
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
                                       class="form-control form-control-solid w-250px ps-13"
                                       placeholder="Search Codes"/>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <div class="w-150px me-3">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" data-control="select2"
                                            data-hide-search="true" data-placeholder="Status"
                                            data-kt-ecommerce-order-filter="status">
                                        <option></option>
                                        <option value="all">All</option>
                                        <option value="active">Active</option>
                                        <option value="locked">Locked</option>
                                    </select>
                                    <!--end::Select2-->
                                </div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_new_target">Add Code
                                </button>
                            </div>
                            <!--end::Toolbar-->
                            <!--begin::Group actions-->
                            <div class="d-flex justify-content-end align-items-center d-none"
                                 data-kt-customer-table-toolbar="selected">
                                <div class="fw-bold me-5">
                                    <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected
                                </div>
                                <button type="button" class="btn btn-danger"
                                        data-kt-customer-table-select="delete_selected">Delete Selected
                                </button>
                            </div>
                            <!--end::Group actions-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5 td-black-color"
                               id="kt_customers_table">
                            <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Code</th>
                                <th class="min-w-125px">Name</th>
                                <th class="min-w-125px">Status</th>
                                <th class="min-w-125px">Operation</th>
                                <th class="min-w-125px">Notify By</th>
                                <th class="min-w-125px">Sent To</th>
                                <th class="text-end min-w-70px">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-black-600">
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <!--begin::Thumbnail-->
                                        <a href="#" class="symbol symbol-50px">
                                            <span class="symbol-label"
                                                  style="background-image:url(assets/media//stock/ecommerce/.png);"></span>
                                        </a>
                                        <!--end::Thumbnail-->
                                        <div class="ms-5">
                                            <!--begin::Title-->
                                            <a href="{{ route('ecg-codes.show', 1) }}"
                                               class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                               data-kt-ecommerce-product-filter="product_name">01</a>
                                            <!--end::Title-->
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    Fire Alram
                                </td>
                                <td>
                                    <div class="badge badge-light-danger">Disabled</div>
                                </td>
                                <td>
                                    Sent to Amplifier
                                </td>
                                <td>Email</td>
                                <td>
                                    <div class="symbol-group symbol-hover mb-3">
                                        <!--begin::User-->
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                             data-bs-original-title="Alan Warden" data-kt-initialized="1">
                                            <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                                        </div>
                                        <!--end::User-->
                                        <!--begin::User-->
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                             aria-label="Michael Eberon" data-bs-original-title="Michael Eberon"
                                             data-kt-initialized="1">
                                            <img alt="Pic" src="assets/media/avatars/300-11.jpg">
                                        </div>
                                        <!--end::User-->
                                        <!--begin::User-->
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                             aria-label="Michelle Swanston" data-bs-original-title="Michelle Swanston"
                                             data-kt-initialized="1">
                                            <img alt="Pic" src="assets/media/avatars/300-7.jpg">
                                        </div>
                                        <!--end::User-->
                                        <!--begin::User-->
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                             aria-label="Francis Mitcham" data-bs-original-title="Francis Mitcham"
                                             data-kt-initialized="1">
                                            <img alt="Pic" src="assets/media/avatars/300-20.jpg">
                                        </div>
                                        <!--end::User-->
                                        <!--begin::User-->
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                             data-bs-original-title="Susan Redwood" data-kt-initialized="1">
                                            <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                                        </div>
                                        <!--end::User-->
                                        <!--begin::User-->
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                             aria-label="Melody Macy" data-bs-original-title="Melody Macy"
                                             data-kt-initialized="1">
                                            <img alt="Pic" src="assets/media/avatars/300-2.jpg">
                                        </div>
                                        <!--end::User-->
                                        <!--begin::User-->
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                             data-bs-original-title="Perry Matthew" data-kt-initialized="1">
                                            <span class="symbol-label bg-info text-inverse-info fw-bold">P</span>
                                        </div>
                                        <!--end::User-->
                                        <!--begin::User-->
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                             aria-label="Barry Walter" data-bs-original-title="Barry Walter"
                                             data-kt-initialized="1">
                                            <img alt="Pic" src="assets/media/avatars/300-12.jpg">
                                        </div>
                                        <!--end::User-->
                                        <!--begin::All users-->
                                        <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal"
                                           data-bs-target="#kt_modal_view_users">
                                            <span class="symbol-label bg-dark text-inverse-dark fs-8 fw-bold"
                                                  data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                  data-bs-original-title="View more users"
                                                  data-kt-initialized="1">+42</span>
                                        </a>
                                        <!--end::All users-->
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="#"
                                       class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <!--begin::Menu-->
                                    <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="../../demo3/dist/apps/customers/view.html"
                                               class="menu-link px-3">View</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3"
                                               data-kt-customer-table-filter="delete_row">Edit</a>
                                        </div>
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3"
                                               data-kt-customer-table-filter="delete_row">Delete</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <!--begin::Thumbnail-->
                                        <a href="#" class="symbol symbol-50px">
                                            <span class="symbol-label"
                                                  style="background-image:url(assets/media//stock/ecommerce/.png);"></span>
                                        </a>
                                        <!--end::Thumbnail-->
                                        <div class="ms-5">
                                            <!--begin::Title-->
                                            <a href="{{ route('ecg-codes.show', 1) }}"
                                               class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                               data-kt-ecommerce-product-filter="product_name">10</a>
                                            <!--end::Title-->
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    Fire Alram
                                </td>
                                <td>
                                    <div class="badge badge-light-danger">Disabled</div>
                                </td>
                                <td>
                                    Sent to Amplifier
                                </td>
                                <td>Email</td>
                                <td>
                                    <div class="symbol-group symbol-hover mb-3">
                                        <!--begin::User-->
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                             data-bs-original-title="Alan Warden" data-kt-initialized="1">
                                            <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                                        </div>
                                        <!--end::User-->
                                        <!--begin::User-->
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                             aria-label="Michael Eberon" data-bs-original-title="Michael Eberon"
                                             data-kt-initialized="1">
                                            <img alt="Pic" src="{{ asset('assets/media/avatars/300-11.jpg') }}">
                                        </div>
                                        <!--end::User-->
                                        <!--begin::All users-->
                                        <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal"
                                           data-bs-target="#kt_modal_view_users">
                                            <span class="symbol-label bg-dark text-inverse-dark fs-8 fw-bold"
                                                  data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                  data-bs-original-title="View more users"
                                                  data-kt-initialized="1">+42</span>
                                        </a>
                                        <!--end::All users-->
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="#"
                                       class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <!--begin::Menu-->
                                    <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="../../demo3/dist/apps/customers/view.html"
                                               class="menu-link px-3">View</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3"
                                               data-kt-customer-table-filter="delete_row">Edit</a>
                                        </div>
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3"
                                               data-kt-customer-table-filter="delete_row">Delete</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </td>
                            </tr>
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <div class="modal fade" id="kt_modal_new_target" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    {{--                    <div class="modal-dialog modal-dialog-centered mw-650px">--}}
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
                    <!--end::Modal dialog-->
                </div>

            </div>
            <!--end::Container-->
        </div>
    </div>
@endsection
@section('js_files')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/new-target.js?'.time()) }}"></script>
@endsection
