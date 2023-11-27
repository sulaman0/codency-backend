<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href=""/>
    <title>Codency - Every emergency has code</title>
    <meta charset="utf-8"/>
    <meta itemprop="name" content="Codency - Every emergency has code">
    <meta name="description" content="Codency - Every emergency has code"/>
    <meta name="keywords" content="Codency, Emergency,Code App"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta itemprop="image" content="{{ asset('assets/media/logos/withoutShadow.png') }}">

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
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset("assets/plugins/global/plugins.bundle.css") }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset("assets/css/style.bundle.css") }}" rel="stylesheet" type="text/css"/>
    <!--end::Global Stylesheets Bundle-->
    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center">
<!--begin::Theme mode setup on page load-->
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
    <style>body {
            background-color: var(--bs-primary)
        }

        [data-bs-theme="dark"] body {
            background-color: var(--bs-primary)
        }</style>
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">

        <div class="d-flex flex-lg-row-fluid">

            <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">

                <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                     src="{{ asset('assets/media/logos/demo3.svg') }}" alt=""/>

                <h1 class="fs-2qx fw-bold text-center mb-7 text-white" style="margin: -150px 0 0 -40px">CODENCY</h1>
            </div>
        </div>
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">

            <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                        <form class="form w-100" id="kt_sign_in_form"
                              method="POST"
                              data-kt-redirect-url="{{ route('login') }}" action="{{ route('login') }}">
                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                                <div class="text-gray-500 fw-semibold fs-6">Every emergency has code</div>
                            </div>
                            <div class="fv-row mb-3">
                                <input id="email" type="email"
                                       class="form-control bg-transparent @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" placeholder="abc@xyz.com" required
                                       autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="fv-row mb-3">
                                <input id="password" type="password"
                                       class="form-control bg-transparent @error('password') is-invalid @enderror"
                                       name="password"
                                       placeholder="******"
                                       required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @if (Route::has('password.request'))
                                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                    <div></div>
                                    <a href="{{ route('password.request') }}"
                                       class="link-primary">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </div>
                            @endif


                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Sign In</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
											<span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="d-flex flex-stack">
                        <div class="me-10">
                            <button
                                class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"
                                data-kt-menu-offset="0px, 0px">
                                <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3"
                                     src="{{ asset('assets/media/flags/united-states.svg') }}" alt=""/>
                                <span data-kt-element="current-lang-name" class="me-1">English</span>
                                <i class="ki-duotone ki-down fs-5 text-muted rotate-180 m-0"></i>
                            </button>
                            <!--end::Toggle-->
                            <!--begin::Menu-->
                            <div
                                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7"
                                data-kt-menu="true" id="kt_auth_lang_menu">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1"
                                                         src="{{ asset('assets/media/flags/united-states.svg') }}"
                                                         alt=""/>
												</span>
                                        <span data-kt-element="lang-name">English</span>
                                    </a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
												<span class="symbol symbol-20px me-4">
													<img data-kt-element="lang-flag" class="rounded-1"
                                                         src="{{ asset('assets/media/flags/saudi-arabia.svg') }}"
                                                         alt=""/>
												</span>
                                        <span data-kt-element="lang-name">Arabic</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>var hostUrl = "assets/";</script>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/authentication/sign-in/general.js?'.time()) }}"></script>
</body>
</html>
