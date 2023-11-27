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

                        <li class="breadcrumb-item text-muted">Staff</li>
                        <li class="breadcrumb-item text-dark">Staff Details</li>
                    </ul>
                </div>
                @include('layout.top_menu')
            </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Container-->
            <div class="container-xxl" id="kt_content_container">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-xl-row">
                    <!--begin::Sidebar-->
                    <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                        <!--begin::Card-->
                        <div class="card mb-5 mb-xl-8">
                            <!--begin::Card body-->
                            <div class="card-body pt-15">
                                <!--begin::Summary-->
                                <div class="d-flex flex-center flex-column mb-5">
                                    <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">Mr.
                                        Abduallah</a>
                                    <!--end::Name-->
                                    <!--begin::Email-->
                                    <a href="#"
                                       class="fs-5 fw-semibold text-muted text-hover-primary mb-6">max@kt.com</a>
                                    <!--end::Email-->
                                </div>
                                <!--end::Summary-->
                                <!--begin::Details toggle-->
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold">Details</div>
                                    <!--begin::Badge-->
                                    <div class="badge badge-light-primary d-inline">Manager</div>
                                    <!--begin::Badge-->
                                </div>
                                <!--end::Details toggle-->
                                <div class="separator separator-dashed my-3"></div>
                                <!--begin::Details content-->
                                <div class="pb-5 fs-6">
                                    <!--begin::Details item-->
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5"> Email</div>
                                    <div class="text-gray-600">
                                        <a href="#" class="text-gray-600 text-hover-primary">info@email.com</a>
                                    </div>
                                    <!--begin::Details item-->
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">Phone</div>
                                    <div class="text-gray-600">0000000000</div>
                                    <!--begin::Details item-->
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">Language</div>
                                    <div class="text-gray-600">English</div>
                                    <!--begin::Details item-->
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">Latest Code Pressed</div>
                                    <div class="text-gray-600">01212</div>

                                    <div class="fw-bold mt-5">Avg Response Time</div>
                                    <div class="text-gray-600">10 sec</div>
                                    <!--begin::Details item-->
                                </div>
                                <!--end::Details content-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Sidebar-->
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid ms-lg-15">
                        <div class="row row-cols-1 row-cols-md-2 mb-6 mb-xl-9">
                            <div class="col">
                                <!--begin::Card-->
                                <div class="card pt-4 h-md-100 mb-6 mb-md-0">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2 class="fw-bold">Emergency Calls</h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <div class="fw-bold fs-2">
                                            <div class="d-flex">
                                                <div>4,571</div>
                                            </div>
                                            <div class="fs-7 fw-normal text-muted">How many times he call for
                                                emergency
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <div class="col">
                                <div class="card pt-4 bg-primary h-md-100 mb-6 mb-md-0">
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2 class="fw-bold text-white">Respond To Calls</h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="fw-bold fs-2">
                                            <div class="d-flex">
                                                <div class="text-white">20</div>
                                            </div>
                                            <div class="fs-7 fw-normal text-white text-active-muted">How many times he
                                                respond to
                                                calls
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                            </div>
                        </div>
                        <!--begin::Card-->
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>ECG Calls</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0 pb-5">
                                <table class="table align-middle table-row-dashed gy-5"
                                       id="kt_table_customers_payment">
                                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                    <tr class="text-start text-muted text-uppercase gs-0">
                                        <th class="min-w-100px">Emergency Code</th>
                                        <th>Respond By</th>
                                        <th class="min-w-100px">Date</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-semibold text-black-600">
                                    <tr>
                                        <td>
                                            <a href="#"
                                               class="text-gray-600 text-hover-primary mb-1">#15692</a>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-success">Mr. Ahmed</span>
                                        </td>
                                        <td>14 Dec 2020, 8:43 pm</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="#"
                                               class="text-gray-600 text-hover-primary mb-1">#15692</a>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-success">Mr. Ahmed</span>
                                        </td>
                                        <td>14 Dec 2020, 8:43 pm</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="#"
                                               class="text-gray-600 text-hover-primary mb-1">#15692</a>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-success">Mr. Ahmed</span>
                                        </td>
                                        <td>14 Dec 2020, 8:43 pm</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="#"
                                               class="text-gray-600 text-hover-primary mb-1">#15692</a>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-success">Mr. Ahmed</span>
                                        </td>
                                        <td>14 Dec 2020, 8:43 pm</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="#"
                                               class="text-gray-600 text-hover-primary mb-1">#15692</a>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-success">Mr. Ahmed</span>
                                        </td>
                                        <td>14 Dec 2020, 8:43 pm</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
