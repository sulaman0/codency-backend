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
                                    <a href="#"
                                       class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1 text-uppercase">{{ $ecgCode->name }}</a>
                                    <a href="{{ route('ecg-codes.edit', $ecgCode->id) }}"><i class="fa-edit"></i></a>
                                </div>
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold">Code</div>
                                    <div class="badge badge-light-primary d-inline">{{ $ecgCode->code }}</div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="pb-5 fs-6">
                                    <div class="text-gray-600 mt-5">Action</div>
                                    <div class="fw-bold">{{ __('common.'.$ecgCode->action) }}</div>
                                    <div class="fw-bold mt-5">Latest Call</div>
                                    <div
                                        class="text-gray-600">{{ empty($lastCall) ? '-' : \App\AppHelper\AppHelper::getAppDateAndTime($lastCall->alarm_triggered_at)  }}</div>

                                    <div class="fw-bold mt-5">Last Amplified</div>
                                    <div
                                        class="text-gray-600">{{ empty($lastCall) || empty($lastCall->played_at_amplifier) ? '-' : \App\AppHelper\AppHelper::getAppDateAndTime($lastCall->played_at_amplifier)  }}</div>

                                    <div class="text-gray-600 mt-5">Notification Tune In English</div>
                                    <div class="text-gray-600 mt-3">
                                        <audio controls autoplay>
                                            <source src="{{ $ecgCode->tune_en }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>

                                    <div class="text-gray-600 mt-5">Notification Tune In Arabic</div>
                                    <div class="text-gray-600 mt-3">
                                        <audio controls autoplay>
                                            <source src="{{ $ecgCode->tune_ar }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>

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
                                                <div>{{ $totalCodePressed }}</div>
                                            </div>
                                            <div class="fs-7 fw-normal text-muted">How many times this code pressed
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
                                            <h2 class="fw-bold text-white">What should do?</h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="fw-bold fs-2">
                                            <div class="fs-7 fw-normal text-white text-active-muted">
                                                {{ $ecgCode->details }}
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
                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                   href="#senders_tab" aria-selected="true" role="tab">Senders</a>
                            </li>
                            <!--end:::Tab item-->
                            <!--begin:::Tab item-->
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                   href="#receiver_tab" aria-selected="false" tabindex="-1" role="tab">Receiver</a>
                            </li>
                        </ul>


                        <div class="tab-content mt-n6">
                            <div class="tab-pane fade active show" id="senders_tab">
                                <div class="card pt-4 mb-6 mt-4 mb-xl-9">
                                    <div class="card-body pt-0 pb-5" id="senders_tab_load"
                                         data-href="{{ route('ecg_code_sender_table', ['id' => $ecgCode->id]) }}">
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
                                         data-href="{{ route('ecg_code_receiver_table', ['id' => $ecgCode->id]) }}">
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
    <script src="{{ asset('assets/js/custom/ecg-codes/details.js?'.time()) }}"></script>
@endsection
