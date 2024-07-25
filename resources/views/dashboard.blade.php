@extends('layout.index')
@section('main-layout')
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <div id="kt_header" class="header mt-0 mt-lg-0 pt-lg-0" data-kt-sticky="true"
             data-kt-sticky-name="header"
             data-kt-sticky-offset="{lg: '300px'}">
            <div class="container d-flex flex-stack flex-wrap gap-4" id="kt_header_container">
                <div
                    class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-10 pb-lg-0"
                    data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                    <h1 class="d-flex flex-column text-dark fw-bold my-0 fs-1">Hello, {{ auth()->user()->name }}
                        <small
                            class="text-muted fs-6 fw-semibold pt-1">{{ \App\AppHelper\AppHelper::getAppDate(now()) }}</small>
                    </h1>
                </div>
                @include('layout.top_menu')
            </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="container-xxl" id="kt_content_container">
                <div class="row gy-5 g-xl-10">
                    @include('alert_synced_notification')
                    <div class="col-xl-6">
                        <div class="card card-xl-stretch mb-xl-10 theme-dark-bg-body"
                             style="background-color: #F7D9E3">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#" class="text-dark text-hover-primary fw-bold fs-3">Emergency
                                        Calls</a>
                                    <div class="mixed-widget-13-chart-custom" style="height: 100px"></div>
                                </div>
                                <div class="pt-5">
                                    <span class="text-dark fw-bold fs-3x me-2 lh-0" id="total_emergency_calls">0</span>
                                    <span class="text-dark fw-bold fs-6 lh-0">Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card card-xxl-stretch mb-xl-10 theme-dark-bg-body"
                             style="background-color: #CBF0F4">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#" class="text-dark text-hover-primary fw-bold fs-3">Announcements</a>
                                    <div class="mixed-widget-14-chart-custom" style="height: 100px"></div>
                                </div>
                                <div class="pt-5">
                                    <span class="text-dark fw-bold fs-3x me-2 lh-0" id="total_played_calls">0</span>
                                    <span class="text-dark fw-bold fs-6 lh-0">Amplified</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="col-xl-6">
                        <div class="card card-flush overflow-hidden h-lg-100">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">Respond Time</span>
                                    <span
                                        class="text-gray-400 mt-1 fw-semibold fs-6">Respond time of Calls</span>
                                </h3>
                                {{--                                <div class="card-toolbar">--}}
                                {{--                                    <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left"--}}
                                {{--                                         data-kt-daterangepicker-range="today"--}}
                                {{--                                         class="btn btn-sm btn-light d-flex align-items-center px-4">--}}
                                {{--                                        <!--begin::Display range-->--}}
                                {{--                                        <div class="text-gray-600 fw-bold">Loading date range...</div>--}}
                                {{--                                        <!--end::Display range-->--}}
                                {{--                                        <i class="ki-duotone ki-calendar-8 fs-1 ms-2 me-0">--}}
                                {{--                                            <span class="path1"></span>--}}
                                {{--                                            <span class="path2"></span>--}}
                                {{--                                            <span class="path3"></span>--}}
                                {{--                                            <span class="path4"></span>--}}
                                {{--                                            <span class="path5"></span>--}}
                                {{--                                            <span class="path6"></span>--}}
                                {{--                                        </i>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            </div>
                            <div class="card-body d-flex align-items-end p-0">
                                <div id="kt_charts_widget_36" class="min-h-auto w-100 ps-4 pe-6"
                                     style="height: 300px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card card-flush overflow-hidden h-lg-100">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">Amplified</span>
                                    <span
                                        class="text-gray-400 mt-1 fw-semibold fs-6">Calls sent to Amplifier</span>
                                </h3>
                                {{--                                <div class="card-toolbar">--}}
                                {{--                                    <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left"--}}
                                {{--                                         data-kt-daterangepicker-range="today"--}}
                                {{--                                         class="btn btn-sm btn-light d-flex align-items-center px-4">--}}
                                {{--                                        <!--begin::Display range-->--}}
                                {{--                                        <div class="text-gray-600 fw-bold">Loading date range...</div>--}}
                                {{--                                        <!--end::Display range-->--}}
                                {{--                                        <i class="ki-duotone ki-calendar-8 fs-1 ms-2 me-0">--}}
                                {{--                                            <span class="path1"></span>--}}
                                {{--                                            <span class="path2"></span>--}}
                                {{--                                            <span class="path3"></span>--}}
                                {{--                                            <span class="path4"></span>--}}
                                {{--                                            <span class="path5"></span>--}}
                                {{--                                            <span class="path6"></span>--}}
                                {{--                                        </i>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            </div>
                            <div class="card-body d-flex align-items-end p-0">
                                <div id="kt_charts_widget_36_b" class="min-h-auto w-100 ps-4 pe-6"
                                     style="height: 300px"></div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
            <div class="container d-flex flex-column flex-md-row flex-stack">
                <div class="text-dark order-2 order-md-1">
                    <span class="text-gray-400 fw-semibold me-1">Created by</span>
                    <a href="https://keenthemes.com" target="_blank"
                       class="text-muted text-hover-primary fw-semibold me-2 fs-6">QM Solutions</a>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_sidebar" class="sidebar" data-kt-drawer="true" data-kt-drawer-name="sidebar"
         data-kt-drawer-activate="{default: true, xxl: false}" data-kt-drawer-overlay="true"
         data-kt-drawer-width="{default:'300px', 'lg': '400px'}" data-kt-drawer-direction="end"
         data-kt-drawer-toggle="#kt_sidebar_toggler">
        <!--begin::Sidebar Content-->
        <div class="d-flex flex-column sidebar-body px-5 py-10" id="kt_sidebar_body">
            <!--begin::Sidebar Nav-->
            <!--end::Sidebar Nav-->
            <!--begin::Sidebar Content-->
            <div id="kt_sidebar_content">
                <div class="hover-scroll-y" data-kt-scroll="true" data-kt-scroll-height="auto"
                     data-kt-scroll-offset="0px" data-kt-scroll-dependencies="#kt_sidebar_tabs"
                     data-kt-scroll-wrappers="#kt_sidebar_content, #kt_sidebar_body">
                    <!--begin::Tab content-->
                    <div class="tab-content px-5 px-xxl-10">
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade" id="kt_sidebar_tab_1" role="tabpanel">
                            <!--begin::Statistics Widget-->
                            <div class="card card-flush card-p-0 shadow-none bg-transparent mb-10">
                                <!--begin::Header-->
                                <div class="card-header align-items-center border-0">
                                    <!--begin::Title-->
                                    <h3 class="card-title fw-bold text-white fs-3">Assigned Tasks</h3>
                                    <!--end::Title-->
                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <button type="button"
                                                class="btn btn-icon btn-icon-white btn-active-color-primary me-n4"
                                                data-kt-menu-trigger="click" data-kt-menu-overflow="true"
                                                data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-category fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </button>
                                        <!--begin::Menu 2-->
                                        <div
                                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                            data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick
                                                    Actions
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator mb-3 opacity-75"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Ticket</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Customer</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                                 data-kt-menu-placement="right-start">
                                                <!--begin::Menu item-->
                                                <a href="#" class="menu-link px-3">
                                                    <span class="menu-title">New Group</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <!--end::Menu item-->
                                                <!--begin::Menu sub-->
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Admin Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Staff Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Member Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu sub-->
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Contact</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator mt-3 opacity-75"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content px-3 py-3">
                                                    <a class="btn btn-primary btn-sm px-4" href="#">Generate
                                                        Reports</a>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 2-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Row-->
                                    <div class="row g-5">
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="100"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">Pending</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="210"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">Completed</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="10"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">On Hold</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="55"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">In Progress</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card Body-->
                            </div>
                            <!--end::Statistics Widget-->
                            <!--begin::Tasks Widget-->
                            <div class="card card-flush card-p-0 shadow-none bg-transparent mb-5">
                                <!--begin::Header-->
                                <div class="card-header align-items-center border-0">
                                    <!--begin::Title-->
                                    <h3 class="card-title fw-bold text-white fs-3">Latest Tasks</h3>
                                    <!--end::Title-->
                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <button type="button"
                                                class="btn btn-icon btn-icon-white btn-active-color-primary me-n4"
                                                data-kt-menu-trigger="click" data-kt-menu-overflow="true"
                                                data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-category fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </button>
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px"
                                             data-kt-menu="true" id="kt_menu_64b77cca6ef73">
                                            <!--begin::Header-->
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Menu separator-->
                                            <div class="separator border-gray-200"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Form-->
                                            <div class="px-7 py-5">
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-semibold">Status:</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div>
                                                        <select class="form-select form-select-solid"
                                                                multiple="multiple" data-kt-select2="true"
                                                                data-close-on-select="false"
                                                                data-placeholder="Select option"
                                                                data-dropdown-parent="#kt_menu_64b77cca6ef73"
                                                                data-allow-clear="true">
                                                            <option></option>
                                                            <option value="1">Approved</option>
                                                            <option value="2">Pending</option>
                                                            <option value="2">In Process</option>
                                                            <option value="2">Rejected</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-semibold">Member Type:</label>
                                                    <!--end::Label-->
                                                    <!--begin::Options-->
                                                    <div class="d-flex">
                                                        <!--begin::Options-->
                                                        <label
                                                            class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input" type="checkbox"
                                                                   value="1"/>
                                                            <span class="form-check-label">Author</span>
                                                        </label>
                                                        <!--end::Options-->
                                                        <!--begin::Options-->
                                                        <label
                                                            class="form-check form-check-sm form-check-custom form-check-solid">
                                                            <input class="form-check-input" type="checkbox"
                                                                   value="2" checked="checked"/>
                                                            <span class="form-check-label">Customer</span>
                                                        </label>
                                                        <!--end::Options-->
                                                    </div>
                                                    <!--end::Options-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-semibold">Notifications:</label>
                                                    <!--end::Label-->
                                                    <!--begin::Switch-->
                                                    <div
                                                        class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               name="notifications" checked="checked"/>
                                                        <label class="form-check-label">Enabled</label>
                                                    </div>
                                                    <!--end::Switch-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Actions-->
                                                <div class="d-flex justify-content-end">
                                                    <button type="reset"
                                                            class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                            data-kt-menu-dismiss="true">Reset
                                                    </button>
                                                    <button type="submit" class="btn btn-sm btn-primary"
                                                            data-kt-menu-dismiss="true">Apply
                                                    </button>
                                                </div>
                                                <!--end::Actions-->
                                            </div>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Menu 1-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body py-0">
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-abstract-26 fs-2x text-success">
																<span class="path1"></span>
																<span class="path2"></span>
															</i>
														</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-white text-hover-primary fs-6 fw-bold">Project
                                                Briefing</a>
                                            <span class="sidebar-text-muted fw-bold">Project Manager</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-pencil fs-2x text-warning">
																<span class="path1"></span>
																<span class="path2"></span>
															</i>
														</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-white text-hover-primary fs-6 fw-bold">Concept
                                                Design</a>
                                            <span class="sidebar-text-muted fw-bold">Art Director</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-message-text-2 fs-2x text-primary">
																<span class="path1"></span>
																<span class="path2"></span>
																<span class="path3"></span>
															</i>
														</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-white text-hover-primary fs-6 fw-bold">Functional
                                                Logics</a>
                                            <span class="sidebar-text-muted fw-bold">Lead Developer</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-disconnect fs-2x text-danger">
																<span class="path1"></span>
																<span class="path2"></span>
																<span class="path3"></span>
																<span class="path4"></span>
																<span class="path5"></span>
															</i>
														</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <a href="#"
                                               class="text-white text-hover-primary fs-6 fw-bold">Development</a>
                                            <span class="sidebar-text-muted fw-bold">DevOps</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-security-user fs-2x text-info">
																<span class="path1"></span>
																<span class="path2"></span>
															</i>
														</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <a href="#"
                                               class="text-white text-hover-primary fs-6 fw-bold">Testing</a>
                                            <span class="sidebar-text-muted fw-bold">QA Managers</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Tasks Widget-->
                        </div>
                        <!--end::Tab pane-->
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade" id="kt_sidebar_tab_2" role="tabpanel">
                            <!--begin::Statistics Widget-->
                            <div class="card card-flush card-p-0 shadow-none bg-transparent mb-10">
                                <!--begin::Header-->
                                <div class="card-header align-items-center border-0">
                                    <!--begin::Title-->
                                    <h3 class="card-title fw-bold text-white fs-3">Customer Orders</h3>
                                    <!--end::Title-->
                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <button type="button"
                                                class="btn btn-icon btn-icon-white btn-active-color-primary me-n4"
                                                data-kt-menu-trigger="click" data-kt-menu-overflow="true"
                                                data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-category fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </button>
                                        <!--begin::Menu 2-->
                                        <div
                                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                            data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick
                                                    Actions
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator mb-3 opacity-75"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Ticket</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Customer</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                                 data-kt-menu-placement="right-start">
                                                <!--begin::Menu item-->
                                                <a href="#" class="menu-link px-3">
                                                    <span class="menu-title">New Group</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <!--end::Menu item-->
                                                <!--begin::Menu sub-->
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Admin Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Staff Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Member Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu sub-->
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Contact</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator mt-3 opacity-75"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content px-3 py-3">
                                                    <a class="btn btn-primary btn-sm px-4" href="#">Generate
                                                        Reports</a>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 2-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Row-->
                                    <div class="row g-5">
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="40"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">In Process</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="110"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">Delivered</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="29"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">On Hold</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="15"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">In Progress</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card Body-->
                            </div>
                            <!--end::Statistics Widget-->
                            <!--begin::Best Sellers Widget-->
                            <div class="card card-flush card-p-0 shadow-none bg-transparent mb-5">
                                <!--begin::Header-->
                                <div class="card-header align-items-center border-0">
                                    <!--begin::Title-->
                                    <h3 class="card-title fw-bold text-white fs-3">Latest Orders</h3>
                                    <!--end::Title-->
                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <button type="button"
                                                class="btn btn-icon btn-icon-white btn-active-color-primary me-n4"
                                                data-kt-menu-trigger="click" data-kt-menu-overflow="true"
                                                data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-category fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </button>
                                        <!--begin::Menu 3-->
                                        <div
                                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                            data-kt-menu="true">
                                            <!--begin::Heading-->
                                            <div class="menu-item px-3">
                                                <div
                                                    class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                                    Payments
                                                </div>
                                            </div>
                                            <!--end::Heading-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">Create Invoice</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link flex-stack px-3">Create Payment
                                                    <span class="ms-2" data-bs-toggle="tooltip"
                                                          title="Specify a target name for future usage and reference">
																<i class="ki-duotone ki-information fs-6">
																	<span class="path1"></span>
																	<span class="path2"></span>
																	<span class="path3"></span>
																</i>
															</span></a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">Generate Bill</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                                 data-kt-menu-placement="right-end">
                                                <a href="#" class="menu-link px-3">
                                                    <span class="menu-title">Subscription</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <!--begin::Menu sub-->
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Plans</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Billing</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Statements</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu separator-->
                                                    <div class="separator my-2"></div>
                                                    <!--end::Menu separator-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="menu-content px-3">
                                                            <!--begin::Switch-->
                                                            <label
                                                                class="form-check form-switch form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input w-30px h-20px"
                                                                       type="checkbox" value="1"
                                                                       checked="checked"
                                                                       name="notifications"/>
                                                                <!--end::Input-->
                                                                <!--end::Label-->
                                                                <span
                                                                    class="form-check-label text-muted fs-6">Recuring</span>
                                                                <!--end::Label-->
                                                            </label>
                                                            <!--end::Switch-->
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu sub-->
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3 my-1">
                                                <a href="#" class="menu-link px-3">Settings</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 3-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body py-0">
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Image-->
                                        <div class="symbol symbol-40px symbol-2by3 me-4">
                                            <img src="assets/media/stock/600x400/img-20.jpg" alt=""
                                                 class="mw-100"/>
                                        </div>
                                        <!--end::Image-->
                                        <!--begin::Title-->
                                        <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pe-3">
                                            <a href="#" class="text-white fw-semibold text-hover-primary fs-6">Premium
                                                Coffee</a>
                                            <span
                                                class="sidebar-text-muted fw-semibold fs-7 my-1">Arabica Specialty Brand</span>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Image-->
                                        <div class="symbol symbol-40px symbol-2by3 me-4">
                                            <img src="assets/media/stock/600x400/img-25.jpg" alt=""
                                                 class="mw-100"/>
                                        </div>
                                        <!--end::Image-->
                                        <!--begin::Title-->
                                        <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pe-3">
                                            <a href="#" class="text-white fw-semibold text-hover-primary fs-6">Light
                                                Sneakers</a>
                                            <span class="sidebar-text-muted fw-semibold fs-7 my-1">The Best Lightweight Sneakers</span>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Image-->
                                        <div class="symbol symbol-40px symbol-2by3 me-4">
                                            <img src="assets/media/stock/600x400/img-24.jpg" alt=""
                                                 class="mw-100"/>
                                        </div>
                                        <!--end::Image-->
                                        <!--begin::Title-->
                                        <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pe-3">
                                            <a href="#" class="text-white fw-semibold text-hover-primary fs-6">Red
                                                Boots</a>
                                            <span
                                                class="sidebar-text-muted fw-semibold fs-7 my-1">All Season Boots</span>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Image-->
                                        <div class="symbol symbol-40px symbol-2by3 me-4">
                                            <img src="assets/media/stock/600x400/img-19.jpg" alt=""
                                                 class="mw-100"/>
                                        </div>
                                        <!--end::Image-->
                                        <!--begin::Title-->
                                        <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pe-3">
                                            <a href="#" class="text-white fw-semibold text-hover-primary fs-6">Wall
                                                Decoration</a>
                                            <span class="sidebar-text-muted fw-semibold fs-7 my-1">Creative & Easy To Install</span>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center">
                                        <!--begin::Image-->
                                        <div class="symbol symbol-40px symbol-2by3 me-4">
                                            <img src="assets/media/stock/600x400/img-27.jpg" alt=""
                                                 class="mw-100"/>
                                        </div>
                                        <!--end::Image-->
                                        <!--begin::Title-->
                                        <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pe-3">
                                            <a href="#" class="text-white fw-semibold text-hover-primary fs-6">Home
                                                Confort</a>
                                            <span
                                                class="sidebar-text-muted fw-semibold fs-7 my-1">Smart Air Purifier</span>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end: Card Body-->
                            </div>
                            <!--end::Best Sellers Widget-->
                        </div>
                        <!--end::Tab pane-->
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade show active" id="kt_sidebar_tab_3" role="tabpanel">
                            <!--begin::Statistics Widget-->
                            <div class="card card-flush card-p-0 shadow-none bg-transparent mb-10">
                                <!--begin::Header-->
                                <div class="card-header align-items-center border-0">
                                    <!--begin::Title-->
                                    <h3 class="card-title text-dark text-hover-primary fw-bold fs-3">Emergency
                                        Codes</h3>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Row-->
                                    <div class="row g-5">
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div
                                                    class="sidebar-text-muted fs-2 fs-xxl-2x fw-bold mb-1 self-generated"
                                                    data-kt-countup="true" data-kt-countup-value=""
                                                    id="ecg_code_receives"
                                                    data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="fs-6 fw-bold">Receives</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div
                                                    class="sidebar-text-muted fs-2 fs-xxl-2x fw-bold mb-1 self-generated"
                                                    data-kt-countup="true" data-kt-countup-value=""
                                                    id="ecg_code_accepted"
                                                    data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="fs-6 fw-bold">Accepted</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div
                                                    class="sidebar-text-muted fs-2 fs-xxl-2x fw-bold mb-1 self-generated"
                                                    data-kt-countup="true" data-kt-countup-value=""
                                                    id="ecg_code_decline"
                                                    data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="fs-6 fw-bold">Declined</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div
                                                    class="sidebar-text-muted fs-2 fs-xxl-2x fw-bold mb-1 self-generated"
                                                    data-kt-countup="true" data-kt-countup-value=""
                                                    id="ecg_code_annoucement"
                                                    data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="fs-6 fw-bold">Announcement
                                                </div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card Body-->
                            </div>
                            <div class="card card-flush card-p-0 shadow-none bg-transparent mb-5">
                                <div class="card-header align-items-center">
                                    <h3 class="card-title text-dark text-hover-primary fw-bold fs-3">
                                        Dail Codes
                                    </h3>
                                </div>
                                <div class="card-body" id="dailCodes"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kt_sidebar_tab_4" role="tabpanel">
                            <!--begin::Statistics Widget-->
                            <div class="card card-flush card-p-0 shadow-none bg-transparent mb-10">
                                <!--begin::Header-->
                                <div class="card-header align-items-center border-0">
                                    <!--begin::Title-->
                                    <h3 class="card-title fw-bold text-white fs-3">Notifcations</h3>
                                    <!--end::Title-->
                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <button type="button"
                                                class="btn btn-icon btn-icon-white btn-active-color-primary me-n4"
                                                data-kt-menu-trigger="click" data-kt-menu-overflow="true"
                                                data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-category fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </button>
                                        <!--begin::Menu 2-->
                                        <div
                                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                            data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick
                                                    Actions
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator mb-3 opacity-75"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Ticket</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Customer</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                                 data-kt-menu-placement="right-start">
                                                <!--begin::Menu item-->
                                                <a href="#" class="menu-link px-3">
                                                    <span class="menu-title">New Group</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <!--end::Menu item-->
                                                <!--begin::Menu sub-->
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Admin Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Staff Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Member Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu sub-->
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Contact</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator mt-3 opacity-75"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content px-3 py-3">
                                                    <a class="btn btn-primary btn-sm px-4" href="#">Generate
                                                        Reports</a>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 2-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Row-->
                                    <div class="row g-5">
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="5"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">System Alert</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="10"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">Server Failure
                                                </div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="40"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">User Feedback</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="3"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">Backup</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card Body-->
                            </div>
                            <!--end::Statistics Widget-->
                            <!--begin::Tasks Widget-->
                            <div class="card card-flush card-p-0 shadow-none bg-transparent mb-5">
                                <!--begin::Header-->
                                <div class="card-header align-items-center border-0">
                                    <!--begin::Title-->
                                    <h3 class="card-title fw-bold text-white fs-3">Latest Tasks</h3>
                                    <!--end::Title-->
                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <button type="button"
                                                class="btn btn-icon btn-icon-white btn-active-color-primary me-n4"
                                                data-kt-menu-trigger="click" data-kt-menu-overflow="true"
                                                data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-category fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </button>
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px"
                                             data-kt-menu="true" id="kt_menu_64b77cca6f103">
                                            <!--begin::Header-->
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Menu separator-->
                                            <div class="separator border-gray-200"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Form-->
                                            <div class="px-7 py-5">
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-semibold">Status:</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div>
                                                        <select class="form-select form-select-solid"
                                                                multiple="multiple" data-kt-select2="true"
                                                                data-close-on-select="false"
                                                                data-placeholder="Select option"
                                                                data-dropdown-parent="#kt_menu_64b77cca6f103"
                                                                data-allow-clear="true">
                                                            <option></option>
                                                            <option value="1">Approved</option>
                                                            <option value="2">Pending</option>
                                                            <option value="2">In Process</option>
                                                            <option value="2">Rejected</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-semibold">Member Type:</label>
                                                    <!--end::Label-->
                                                    <!--begin::Options-->
                                                    <div class="d-flex">
                                                        <!--begin::Options-->
                                                        <label
                                                            class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input" type="checkbox"
                                                                   value="1"/>
                                                            <span class="form-check-label">Author</span>
                                                        </label>
                                                        <!--end::Options-->
                                                        <!--begin::Options-->
                                                        <label
                                                            class="form-check form-check-sm form-check-custom form-check-solid">
                                                            <input class="form-check-input" type="checkbox"
                                                                   value="2" checked="checked"/>
                                                            <span class="form-check-label">Customer</span>
                                                        </label>
                                                        <!--end::Options-->
                                                    </div>
                                                    <!--end::Options-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-semibold">Notifications:</label>
                                                    <!--end::Label-->
                                                    <!--begin::Switch-->
                                                    <div
                                                        class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               name="notifications" checked="checked"/>
                                                        <label class="form-check-label">Enabled</label>
                                                    </div>
                                                    <!--end::Switch-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Actions-->
                                                <div class="d-flex justify-content-end">
                                                    <button type="reset"
                                                            class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                            data-kt-menu-dismiss="true">Reset
                                                    </button>
                                                    <button type="submit" class="btn btn-sm btn-primary"
                                                            data-kt-menu-dismiss="true">Apply
                                                    </button>
                                                </div>
                                                <!--end::Actions-->
                                            </div>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Menu 1-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body py-0">
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-abstract-26 fs-2x text-success">
																<span class="path1"></span>
																<span class="path2"></span>
															</i>
														</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-white text-hover-primary fs-6 fw-bold">Project
                                                Briefing</a>
                                            <span class="sidebar-text-muted fw-bold">Project Manager</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-pencil fs-2x text-warning">
																<span class="path1"></span>
																<span class="path2"></span>
															</i>
														</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-white text-hover-primary fs-6 fw-bold">Concept
                                                Design</a>
                                            <span class="sidebar-text-muted fw-bold">Art Director</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-message-text-2 fs-2x text-primary">
																<span class="path1"></span>
																<span class="path2"></span>
																<span class="path3"></span>
															</i>
														</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-white text-hover-primary fs-6 fw-bold">Functional
                                                Logics</a>
                                            <span class="sidebar-text-muted fw-bold">Lead Developer</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-disconnect fs-2x text-danger">
																<span class="path1"></span>
																<span class="path2"></span>
																<span class="path3"></span>
																<span class="path4"></span>
																<span class="path5"></span>
															</i>
														</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <a href="#"
                                               class="text-white text-hover-primary fs-6 fw-bold">Development</a>
                                            <span class="sidebar-text-muted fw-bold">DevOps</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-security-user fs-2x text-info">
																<span class="path1"></span>
																<span class="path2"></span>
															</i>
														</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <a href="#"
                                               class="text-white text-hover-primary fs-6 fw-bold">Testing</a>
                                            <span class="sidebar-text-muted fw-bold">QA Managers</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Tasks Widget-->
                        </div>
                        <!--end::Tab pane-->
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade" id="kt_sidebar_tab_5" role="tabpanel">
                            <!--begin::Statistics Widget-->
                            <div class="card card-flush card-p-0 shadow-none bg-transparent mb-10">
                                <!--begin::Header-->
                                <div class="card-header align-items-center border-0">
                                    <!--begin::Title-->
                                    <h3 class="card-title fw-bold text-white fs-3">Outgoing Emails</h3>
                                    <!--end::Title-->
                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <button type="button"
                                                class="btn btn-icon btn-icon-white btn-active-color-primary me-n4"
                                                data-kt-menu-trigger="click" data-kt-menu-overflow="true"
                                                data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-category fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </button>
                                        <!--begin::Menu 2-->
                                        <div
                                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                            data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick
                                                    Actions
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator mb-3 opacity-75"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Ticket</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Customer</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                                 data-kt-menu-placement="right-start">
                                                <!--begin::Menu item-->
                                                <a href="#" class="menu-link px-3">
                                                    <span class="menu-title">New Group</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <!--end::Menu item-->
                                                <!--begin::Menu sub-->
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Admin Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Staff Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3">Member Group</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu sub-->
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">New Contact</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator mt-3 opacity-75"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content px-3 py-3">
                                                    <a class="btn btn-primary btn-sm px-4" href="#">Generate
                                                        Reports</a>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 2-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Row-->
                                    <div class="row g-5">
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="160"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">Sending</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="2600"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">Sent</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="2500"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">Delivered</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Item-->
                                            <div
                                                class="sidebar-border-dashed d-flex flex-column justify-content-center rounded p-3 p-xxl-5">
                                                <!--begin::Value-->
                                                <div class="text-white fs-2 fs-xxl-2x fw-bold mb-1"
                                                     data-kt-countup="true" data-kt-countup-value="11"
                                                     data-kt-countup-prefix="">0
                                                </div>
                                                <!--begin::Value-->
                                                <!--begin::Label-->
                                                <div class="sidebar-text-muted fs-6 fw-bold">Failed</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card Body-->
                            </div>
                            <!--end::Statistics Widget-->
                            <!--begin::Tasks Widget-->
                            <div class="card card-flush card-p-0 shadow-none bg-transparent mb-5">
                                <!--begin::Header-->
                                <div class="card-header align-items-center border-0">
                                    <!--begin::Title-->
                                    <h3 class="card-title fw-bold text-white fs-3">Latest Tasks</h3>
                                    <!--end::Title-->
                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <button type="button"
                                                class="btn btn-icon btn-icon-white btn-active-color-primary me-n4"
                                                data-kt-menu-trigger="click" data-kt-menu-overflow="true"
                                                data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-category fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </button>
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px"
                                             data-kt-menu="true" id="kt_menu_64b77cca6f148">
                                            <!--begin::Header-->
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Menu separator-->
                                            <div class="separator border-gray-200"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Form-->
                                            <div class="px-7 py-5">
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-semibold">Status:</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div>
                                                        <select class="form-select form-select-solid"
                                                                multiple="multiple" data-kt-select2="true"
                                                                data-close-on-select="false"
                                                                data-placeholder="Select option"
                                                                data-dropdown-parent="#kt_menu_64b77cca6f148"
                                                                data-allow-clear="true">
                                                            <option></option>
                                                            <option value="1">Approved</option>
                                                            <option value="2">Pending</option>
                                                            <option value="2">In Process</option>
                                                            <option value="2">Rejected</option>
                                                        </select>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-semibold">Member Type:</label>
                                                    <!--end::Label-->
                                                    <!--begin::Options-->
                                                    <div class="d-flex">
                                                        <!--begin::Options-->
                                                        <label
                                                            class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input" type="checkbox"
                                                                   value="1"/>
                                                            <span class="form-check-label">Author</span>
                                                        </label>
                                                        <!--end::Options-->
                                                        <!--begin::Options-->
                                                        <label
                                                            class="form-check form-check-sm form-check-custom form-check-solid">
                                                            <input class="form-check-input" type="checkbox"
                                                                   value="2" checked="checked"/>
                                                            <span class="form-check-label">Customer</span>
                                                        </label>
                                                        <!--end::Options-->
                                                    </div>
                                                    <!--end::Options-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-semibold">Notifications:</label>
                                                    <!--end::Label-->
                                                    <!--begin::Switch-->
                                                    <div
                                                        class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               name="notifications" checked="checked"/>
                                                        <label class="form-check-label">Enabled</label>
                                                    </div>
                                                    <!--end::Switch-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Actions-->
                                                <div class="d-flex justify-content-end">
                                                    <button type="reset"
                                                            class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                            data-kt-menu-dismiss="true">Reset
                                                    </button>
                                                    <button type="submit" class="btn btn-sm btn-primary"
                                                            data-kt-menu-dismiss="true">Apply
                                                    </button>
                                                </div>
                                                <!--end::Actions-->
                                            </div>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Menu 1-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body py-0">
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-abstract-26 fs-2x text-success">
																<span class="path1"></span>
																<span class="path2"></span>
															</i>
														</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-white text-hover-primary fs-6 fw-bold">Project
                                                Briefing</a>
                                            <span class="sidebar-text-muted fw-bold">Project Manager</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-pencil fs-2x text-warning">
																<span class="path1"></span>
																<span class="path2"></span>
															</i>
														</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-white text-hover-primary fs-6 fw-bold">Concept
                                                Design</a>
                                            <span class="sidebar-text-muted fw-bold">Art Director</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-message-text-2 fs-2x text-primary">
																<span class="path1"></span>
																<span class="path2"></span>
																<span class="path3"></span>
															</i>
														</span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-white text-hover-primary fs-6 fw-bold">Functional
                                                Logics</a>
                                            <span class="sidebar-text-muted fw-bold">Lead Developer</span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-nowrap align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-disconnect fs-2x text-danger">
																<span class="path1"></span>
																<span class="path2"></span>
																<span class="path3"></span>
																<span class="path4"></span>
																<span class="path5"></span>
															</i>
														</span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="#"
                                               class="text-white text-hover-primary fs-6 fw-bold">Development</a>
                                            <span class="sidebar-text-muted fw-bold">DevOps</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-nowrap align-items-center">
                                        <div class="symbol symbol-50px me-5">
														<span class="symbol-label sidebar-bg-muted">
															<i class="ki-duotone ki-security-user fs-2x text-info">
																<span class="path1"></span>
																<span class="path2"></span>
															</i>
														</span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="#"
                                               class="text-white text-hover-primary fs-6 fw-bold">Testing</a>
                                            <span class="sidebar-text-muted fw-bold">QA Managers</span>
                                        </div>
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
    <script>
        let dashboardData = "{{ route('load_dashboard_content') }}";
    </script>
    <script src="{{ asset('assets/js/custom/dashboard/details.js?'.time()) }}"></script>
@endsection
