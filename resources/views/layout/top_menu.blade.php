<div class="d-flex d-lg-none align-items-center ms-n3 me-2">
    <!--begin::Aside mobile toggle-->
    <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
        <i class="ki-duotone ki-abstract-14 fs-1 mt-1">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <!--end::Aside mobile toggle-->
    <!--begin::Logo-->
    <a href="{{ url('/')  }}" class="d-flex align-items-center">
        <img alt="Logo" src="{{ asset('assets/media/logos/demo3.svg') }}" class="theme-light-show h-20px"/>
        <img alt="Logo" src="{{ asset('assets/media/logos/demo3-dark.svg') }}" class="theme-dark-show h-20px"/>
    </a>
    <!--end::Logo-->
</div>
<div class="d-flex align-items-center flex-shrink-0 mb-0 mb-lg-0">
    <div
        class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline w-40px h-40px">
        <div>
            <div class="btn btn-sm btn-icon btn-active-color-primary position-relative"
                 data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                 data-kt-menu-overflow="true"
                 data-kt-menu-placement="top-end">
                <i class="ki-duotone ki-setting-2 fs-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
            <div
                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                data-kt-menu="true" style="">
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <div class="menu-content d-flex align-items-center px-3">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-50px me-5">
                            {{--                            <img alt="Logo" src="{{asset('assets/media/avatars/300-1.jpg')}}">--}}
                        </div>
                        <!--end::Avatar-->
                        <!--begin::Username-->
                        <div class="d-flex flex-column">
                            <div
                                class="fw-bold d-flex align-items-center fs-5">{{ $loggedInUser->name }}</div>
                            <a href="#"
                               class="fw-semibold text-muted text-hover-primary fs-7">{{ $loggedInUser->email  }}</a>
                        </div>
                        <!--end::Username-->
                    </div>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu separator-->
                <div class="separator my-2"></div>
                <!--end::Menu separator-->
                <!--begin::Menu item-->
                <div class="menu-item px-5"
                     data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                     data-kt-menu-placement="right-end" data-kt-menu-offset="-15px, 0">
                    <a href="#" class="menu-link px-5">
											<span class="menu-title position-relative">Language
											<span
                                                class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">English
											<img class="w-15px h-15px rounded-1 ms-2"
                                                 src="{{ asset('assets/media/flags/united-states.svg') }}"
                                                 alt=""></span></span>
                    </a>
                    <!--begin::Menu sub-->
                    <div class="menu-sub menu-sub-dropdown w-175px py-4" style="">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{ url('/') }}"
                               class="menu-link d-flex px-5 active">
												<span class="symbol symbol-20px me-4">
													<img class="rounded-1"
                                                         src="{{ asset('assets/media/flags/united-states.svg') }}"
                                                         alt="">
												</span>English</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="{{ url('/') }}"
                               class="menu-link d-flex px-5">
												<span class="symbol symbol-20px me-4">
													<img class="rounded-1"
                                                         src="{{ asset('assets/media/flags/saudi-arabia.svg') }}"
                                                         alt="">
												</span>Arabic</a>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" data-kt-redirect-url="{{ route('login') }}">
                    @csrf
                    <div class="menu-item px-5 logout-btn">
                        <a href="#"
                           class="menu-link px-5">Sign Out</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div
        class="ms-3 btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline w-40px h-40px">
        <div>
            <div class="btn btn-sm btn-icon btn-active-color-primary pulse position-relative"
                 data-bs-toggle="tooltip"
                 title="Amplifier status"
                 data-kt-menu-placement="top-end">

                <a href="{{ route('reports.amplifier_status') }}">
                    <span class="pulse-ring"></span>
                    <i class="ki-duotone ki-notification fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                </a>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center ms-3 ms-lg-3">
        <a href="#"
           class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline w-40px h-40px"
           data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
           data-kt-menu-placement="bottom-end">
            <i class="ki-duotone ki-night-day theme-light-show fs-1">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
                <span class="path5"></span>
                <span class="path6"></span>
                <span class="path7"></span>
                <span class="path8"></span>
                <span class="path9"></span>
                <span class="path10"></span>
            </i>
            <i class="ki-duotone ki-moon theme-dark-show fs-1">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </a>
        <div
            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
            data-kt-menu="true" data-kt-element="theme-mode-menu">
            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                   data-kt-value="light">
    												<span class="menu-icon" data-kt-element="icon">
    													<i class="ki-duotone ki-night-day fs-2">
    														<span class="path1"></span>
    														<span class="path2"></span>
    														<span class="path3"></span>
    														<span class="path4"></span>
    														<span class="path5"></span>
    														<span class="path6"></span>
    														<span class="path7"></span>
    														<span class="path8"></span>
    														<span class="path9"></span>
    														<span class="path10"></span>
    													</i>
    												</span>
                    <span class="menu-title">Light</span>
                </a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                   data-kt-value="dark">
    												<span class="menu-icon" data-kt-element="icon">
    													<i class="ki-duotone ki-moon fs-2">
    														<span class="path1"></span>
    														<span class="path2"></span>
    													</i>
    												</span>
                    <span class="menu-title">Dark</span>
                </a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                   data-kt-value="system">
    												<span class="menu-icon" data-kt-element="icon">
    													<i class="ki-duotone ki-screen fs-2">
    														<span class="path1"></span>
    														<span class="path2"></span>
    														<span class="path3"></span>
    														<span class="path4"></span>
    													</i>
    												</span>
                    <span class="menu-title">System</span>
                </a>
            </div>
            <!--end::Menu item-->
        </div>
    </div>
    <div class="d-flex align-items-center d-xxl-none ms-3 ms-lg-3">
        <div
            class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline w-40px h-40px position-relative"
            id="kt_sidebar_toggler">
            <i class="ki-duotone ki-burger-menu-2 fs-1">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
                <span class="path5"></span>
                <span class="path6"></span>
                <span class="path7"></span>
                <span class="path8"></span>
                <span class="path9"></span>
                <span class="path10"></span>
            </i>
        </div>
    </div>
</div>
