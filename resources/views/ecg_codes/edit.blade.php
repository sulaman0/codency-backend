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
                    <form id="kt_modal_new_target_form" class="form"
                          data-kt-redirect="{{ route('ecg-codes.show', [$ecgCode->id]) }}"
                          action="{{ route('update_ecg_code', ['id' => $ecgCode->id]) }}">

                        <div class="d-flex justify-content-between">
                            <div class="mb-13 text-left">
                                <h1 class="mb-3">Add Code</h1>
                            </div>
                            <div class="text-right">
                                <button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3">
                                    Cancel
                                </button>
                                <button type="button" id="kt_modal_new_target_submit" class="btn btn-primary">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </div>

                        <div class="row g-9 mb-8">
                            <div class="col-md-6 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Code Name</span></span>
                                </label>
                                <input type="text" class="form-control form-control-solid"
                                       placeholder="e.g, Fire Alarm" name="code_nme" value="{{ $ecgCode->name }}"/>
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">How many times you want to play</label>
                                <input type="text" class="form-control form-control-solid"
                                       placeholder="e.g, 3" name="times_to_play"
                                       value="value="{{ $ecgCode->no_of_times_play }}""/>
                            </div>

                        </div>

                        <div class="row g-9 mb-8">
                            {{--                            <div class="col-md-6 fv-row">--}}
                            {{--                                <label class="required fs-6 fw-semibold mb-2">Operation</label>--}}
                            {{--                                <select class="form-select form-select-solid" data-control="select2"--}}
                            {{--                                        data-hide-search="true" data-placeholder="Select a Team Member"--}}
                            {{--                                        name="action">--}}
                            {{--                                    <option--}}
                            {{--                                        {{ $ecgCode->action == "sent_to_amplifier_directly" ? 'selected': '' }} value="sent_to_amplifier_directly">--}}
                            {{--                                        Sent to Amplifier Directly--}}
                            {{--                                    </option>--}}
                            {{--                                    <option--}}
                            {{--                                        {{ $ecgCode->action == "sent_to_manager" ? 'selected': '' }} value="sent_to_manager">--}}
                            {{--                                        Managed by Manager--}}
                            {{--                                    </option>--}}
                            {{--                                </select>--}}
                            {{--                            </div>--}}
                            <div class="col-md-12 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Code</span></span>
                                </label>
                                <input type="text" class="form-control form-control-solid"
                                       placeholder="e.g, 10" name="code" value="{{ $ecgCode->code }}"/>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-semibold mb-2">Code Details</label>
                            <textarea class="form-control form-control-solid" rows="3" name="details"
                                      placeholder="e.g, What should do?">{{ $ecgCode->details }}</textarea>
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
                            <select class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select a Team Member"
                                    multiple="multiple"
                                    name="senders_list[]">
                                @foreach($groups as $group)
                                    <option
                                        {{ in_array($group->id, $codesToUsers) ? 'selected=selected' : '' }} value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
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
                            <select class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select a Team Member"
                                    multiple="multiple"
                                    name="receivers_list[]">
                                @foreach($groups as $group)
                                    <option
                                        {{ in_array($group->id, $alertsToUsers) ? 'selected=selected' : '' }}
                                        value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-9 mb-8">
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">Color Code</label>
                                <input type="color" class="form-control form-control-solid"
                                       style="height: 43px"
                                       placeholder="e.g, 10" name="color_code" value="{{ $ecgCode->color_code }}"/>
                            </div>
                            {{--                            <div class="col-md-6 fv-row">--}}
                            {{--                                <label class="required fs-6 fw-semibold mb-2">Preferred Language</label>--}}
                            {{--                                <select class="form-select form-select-solid"--}}
                            {{--                                        data-control="select2"--}}
                            {{--                                        data-hide-search="true"--}}
                            {{--                                        data-placeholder="Select Preferred Language for Notification"--}}
                            {{--                                        name="lang">--}}
                            {{--                                    <option {{ $ecgCode->preferred_lang == 'en' ? 'selected' :'' }} value="en">English--}}
                            {{--                                    </option>--}}
                            {{--                                    <option {{ $ecgCode->preferred_lang == 'ar' ? 'selected' :'' }} value="ar">Arabic--}}
                            {{--                                    </option>--}}
                            {{--                                </select>--}}
                            {{--                            </div>--}}
                        </div>
                        {{--                        <div class="row g-9 mb-8">--}}
                        {{--                            <div class="col-md-6 fv-row">--}}
                        {{--                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">--}}
                        {{--                                    <span class="required">Notification Tune English</span></span>--}}
                        {{--                                </label>--}}
                        {{--                                <!--end::Label-->--}}
                        {{--                                <input type="file" class="form-control form-control-solid mb-5"--}}
                        {{--                                       accept=".mp3,audio/*"--}}
                        {{--                                       placeholder="e.g, 10" name="tune_en"/>--}}

                        {{--                                <audio controls>--}}
                        {{--                                    <source src="{{ $ecgCode->tune_en }}" type="audio/mpeg">--}}
                        {{--                                    Your browser does not support the audio element.--}}
                        {{--                                </audio>--}}

                        {{--                            </div>--}}
                        {{--                            <div class="col-md-6 fv-row">--}}
                        {{--                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">--}}
                        {{--                                    <span class="required">Notification Tune Arabic</span></span>--}}
                        {{--                                </label>--}}
                        {{--                                <!--end::Label-->--}}
                        {{--                                <input type="file" class="form-control form-control-solid mb-5"--}}
                        {{--                                       accept=".mp3,audio/*"--}}
                        {{--                                       placeholder="e.g, 10" name="tune_ar"/>--}}

                        {{--                                <audio controls>--}}
                        {{--                                    <source src="{{ $ecgCode->tune_ar }}" type="audio/mpeg">--}}
                        {{--                                    Your browser does not support the audio element.--}}
                        {{--                                </audio>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js_files')
    <script src="{{ asset('assets/js/custom/utilities/modals/new-target.js?'.time()) }}"></script>
@endsection
