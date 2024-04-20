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
                        <div class="card mb-5 mb-xl-8">
                            <div class="card-body pt-15">
                                <div class="d-flex flex-center flex-column mb-5">
                                    <a href="#"
                                       class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">{{ $user->name }}</a>
                                    <a href="#"
                                       class="fs-5 fw-semibold text-muted text-hover-primary mb-6">{{ $user->email }}</a>
                                </div>
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold">Designation</div>
                                    <div class="badge badge-light-primary d-inline">{{ $user->designation }}</div>
                                </div>
                                <!--end::Details toggle-->
                                <div class="separator separator-dashed my-3"></div>
                                <!--begin::Details content-->
                                <div class="pb-5 fs-6">
                                    <div class="fw-bold mt-5"> Email</div>
                                    <div class="text-gray-600">
                                        <a href="#" class="text-gray-600 text-hover-primary">{{ $user->email }}</a>
                                    </div>
                                    <div class="fw-bold mt-5">Phone</div>
                                    <div class="text-gray-600">{{ $user->phone }}</div>
                                    <div class="fw-bold mt-5">Group</div>
                                    @foreach($user->groups as $group)
                                        <div class="text-gray-600">{{ $group->name }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-lg-row-fluid ms-lg-15">
                        <div class="row row-cols-1 row-cols-md-2 mb-6 mb-xl-9">
                            <div class="col">
                                <!--begin::Card-->
                                <div class="card pt-4 h-md-100 mb-6 mb-md-0">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <div class="card-title">
                                            <h2 class="fw-bold">Emergency Calls</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="fw-bold fs-2">
                                            <div class="d-flex">
                                                <div>{{ $user->alertPressedCount() }}</div>
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
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="fw-bold fs-2">
                                            <div class="d-flex">
                                                <div class="text-white">{{ $user->alertRespondCount() }}</div>
                                            </div>
                                            <div class="fs-7 fw-normal text-white text-active-muted">How many times he
                                                responds to calls
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8"
                            role="tablist">
                            <!--begin:::Tab item-->
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-active-primary active" data-bs-toggle="tab"
                                   href="#senders_tab" aria-selected="true" role="tab">Ecg Calls</a>
                            </li>
                            <!--end:::Tab item-->
                            <!--begin:::Tab item-->
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-active-primary" data-bs-toggle="tab"
                                   href="#receiver_tab" aria-selected="false" tabindex="-1" role="tab">Locations</a>
                            </li>
                        </ul>


                        <div class="tab-content mt-n6">
                            <div class="tab-pane fade active show" id="senders_tab">
                                <div class="card pt-4 mb-6 mt-4 mb-xl-9">
                                    <div class="card-body pt-0 pb-5" id="senders_tab_load"
                                         data-href="{{ route('ecg_code_interaction_table', ['userId' => $user->id]) }}">
                                        <div class="loading-progress-div">
                                            Loading...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="receiver_tab">
                                <div class="card pt-4 mb-6 mt-4 mb-xl-9">
                                    <div class="card-body pt-0 pb-5" id="receiver_tab_load"
                                         data-href="{{ route('user_location_assigned_table', ['userId' => $user->id]) }}">
                                        <div class="loading-progress-div">
                                            Loading...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
    <script src="{{ asset('assets/js/custom/staffs/details.js?'.time()) }}"></script>
@endsection
