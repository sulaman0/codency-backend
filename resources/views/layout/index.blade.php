<!DOCTYPE html>
<html lang="en">
<head>
    <base href=""/>
    <title>Codency - Every emergency has code</title>
    <meta charset="utf-8"/>
    <meta itemprop="name" content="Codency - Every emergency has code">
    <meta name="description" content="Codency - Every emergency has code"/>
    <meta name="keywords" content="Codency, Emergency,Code App"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta itemprop="image" content="{{ asset('assets/media/logos/withoutShadow.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Codency - Every emergency has code"/>
    <meta property="og:url" content="{{ url('/') }}"/>
    <meta property="og:site_name" content="Codency | Every emergency has code"/>
    <meta property="og:title" content="Codency - Every emergency has code">
    <meta property="og:description" content="Codency - Every emergency has code">
    <meta property="og:image" content="{{ asset('assets/media/logos/withoutShadow.png') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Codency - Every emergency has code">
    <meta name="twitter:description" content="Codency - Every emergency has code">
    <meta name="twitter:image" content="{{ asset('assets/media/logos/withoutShadow.png') }}">

    <link rel="canonical" href="{{ url('/') }}"/>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset("assets/plugins/global/plugins.bundle.css") }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/style.bundle.css?'.time()) }}" rel="stylesheet" type="text/css"/>
    @yield('css_files')
</head>
<body id="kt_body" class="header-fixed sidebar-enabled">
<script>var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }</script>

<div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
        <div id="kt_aside" class="aside py-9" data-kt-drawer="true" data-kt-drawer-name="aside"
             data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
             data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
             data-kt-drawer-toggle="#kt_aside_toggle">
            <div class="aside-logo flex-column-auto px-9 mb-9" id="kt_aside_logo">
                <a href="{{ url('/') }}">
                    <img alt="Logo" src="{{ asset('assets/media/logos/demo3.svg') }}"
                         class="h-150px logo theme-light-show"/>
                    {{--                    <img alt="Logo" src="{{ asset('assets/media/logos/demo3-dark.svg') }}"--}}
                    {{--                         class="h-150px logo theme-dark-show"/>--}}
                </a>
            </div>
            <div class="aside-menu flex-column-fluid ps-5 pe-3 mb-9" id="kt_aside_menu">
                <!--begin::Aside Menu-->
                <div class="w-100 hover-scroll-overlay-y d-flex pe-3" id="kt_aside_menu_wrapper"
                     data-kt-scroll="true"
                     data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
                     data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
                     data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu, #kt_aside_menu_wrapper"
                     data-kt-scroll-offset="100">
                    <!--begin::Menu-->
                    <div class="menu menu-column menu-rounded menu-sub-indention menu-active-bg fw-semibold my-auto"
                         id="#kt_aside_menu" data-kt-menu="true">

                        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                            <a class="menu-parent-link" href="{{ route('dashboard.index') }}">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-black-right fs-2"></i>
                                        </span>
                                        <span class="menu-title">
                                            Dashboard
                                        </span>
                                    </span>
                            </a>
                        </div>

                        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                            <a class="menu-parent-link" href="{{ route('locations.index') }}">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-black-right fs-2"></i>
                                        </span>
                                        <span class="menu-title">
                                            Locations
                                        </span>
                                    </span>
                            </a>
                        </div>
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <span class="menu-link">
										<span class="menu-icon">
											<i class="ki-duotone ki-black-right fs-2"></i>
										</span>
										<span class="menu-title">Staff</span>
										<span class="menu-arrow"></span>
									</span>
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link"
                                       href="{{ route('groups.index') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                        <span class="menu-title">Groups</span>
                                    </a>
                                    <a class="menu-link"
                                       href="{{ route('staff.index') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                        <span class="menu-title">Staff</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                            <a class="menu-parent-link" href="{{ route('ecg-codes.index') }}">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-black-right fs-2"></i>
                                        </span>
                                        <span class="menu-title">
                                            ECG Codes
                                        </span>
                                    </span>
                            </a>
                        </div>
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <span class="menu-link">
										<span class="menu-icon">
											<i class="ki-duotone ki-black-right fs-2"></i>
										</span>
										<span class="menu-title">Reports</span>
										<span class="menu-arrow"></span>
									</span>
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link"
                                       href="{{ route('reports.code_pressed') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                        <span class="menu-title">Code Pressed</span>
                                    </a>
                                    <a class="menu-link"
                                       href="{{ route('reports.amplifier_status') }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                        <span class="menu-title">Amplifier Status</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @yield('main-layout')
    </div>
</div>
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-duotone ki-arrow-up">
        <span class="path1"></span>
        <span class="path2"></span>
    </i>
</div>

<script>var hostUrl = "assets/";</script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script type="module">
    // Import the functions you need from the SDKs you need
    import {initializeApp} from "https://www.gstatic.com/firebasejs/9.6.10/firebase-app.js";
    import {getAnalytics} from "https://www.gstatic.com/firebasejs/9.6.10/firebase-analytics.js";

    const firebaseConfig = {
        apiKey: "AIzaSyCCOy_SWpB3H0XYFbt35ACFxoDSLawffoc",
        authDomain: "codency-a6782.firebaseapp.com",
        projectId: "codency-a6782",
        storageBucket: "codency-a6782.appspot.com",
        messagingSenderId: "884169670185",
        appId: "1:884169670185:web:5e50eeddeecd99dae36638",
        measurementId: "G-LCCC0GVH6G"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function startFCM() {
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route("store.token") }}',
                    type: 'POST',
                    data: {
                        token: response
                    },
                    dataType: 'JSON',
                    success: function (response) {
                    },
                    error: function (error) {
                    },
                });
            }).catch(function (error) {

        });
    }

    messaging.onMessage(function (payload) {
        {{--let audio = new Audio("{{url('/')}}/assets/media/sounds/notification.mp3");--}}
        {{--audio.play();--}}
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: "{{ asset('assets/media/logos/withoutShadow.png') }}",
            data: {
                url: payload.data.web_url,
            }
        };
        let NotificationLocal = new Notification(title, options);
        NotificationLocal.onclick = function (event) {
            if (event.currentTarget.data.url) {
                window.location.href = '{{ route('reports.code_pressed') }}';
            }
        }
    });
    startFCM();
</script>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('src/js/components/app.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
{{--<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>--}}
{{--<script src="{{ asset('assets/js/custom/widgets.js?'.time()) }}"></script>--}}
<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
<script src="{{ asset('assets/js/custom/common.js?'.time()) }}"></script>
@yield('js_files')
</body>
</html>
