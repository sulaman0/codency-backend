$(function () {
    getPageData(dashboardData, '', function (res) {
        if (res.status) {
            $('#ecg_code_receives').attr('data-kt-countup-value', res.payload.em_codes.receive);
            $('#total_emergency_calls').text(res.payload.em_codes.receive);
            $('#ecg_code_accepted').attr('data-kt-countup-value', res.payload.em_codes.accept);
            $('#ecg_code_decline').attr('data-kt-countup-value', res.payload.em_codes.decline);
            $('#ecg_code_annoucement').attr('data-kt-countup-value', res.payload.em_codes.announcement);
            $('#total_played_calls').text(res.payload.em_codes.announcement);
            CreateCountAppTwo();


            // Parse Code
            parseDailCodes(res.payload.dail_codes);
            // Init Emergency Calls
            initEmergencyCalls(res.payload.emergency_calls_graph.yAxios, res.payload.emergency_calls_graph.xAxios);
            // Init Amplifier
            initAmplifiedCalls(res.payload.amplifier_calls_graph.yAxios, res.payload.amplifier_calls_graph.xAxios);
        } else {
            Swal.fire({
                text: "Sorry, looks like there are some errors detected, please try again.",
                icon: "error",
                buttonsStyling: !1,
                confirmButtonText: "Ok, got it!",
                customClass: {confirmButton: "btn btn-primary"}
            })
        }
    }, 'GET', false);


    initRespondTimeGraph();
    initAmplifiedTimeGraph();
});


function CreateCountAppTwo() {
    var elements = [].slice.call(document.querySelectorAll('.self-generated'));
    elements.map(function (element) {
        var options = {};
        var value = element.getAttribute('data-kt-countup-value');
        value = parseFloat(value.replace(/,/g, ""));

        if (element.hasAttribute('data-kt-countup-start-val')) {
            options.startVal = parseFloat(element.getAttribute('data-kt-countup-start-val'));
        }

        if (element.hasAttribute('data-kt-countup-duration')) {
            options.duration = parseInt(element.getAttribute('data-kt-countup-duration'));
        }

        if (element.hasAttribute('data-kt-countup-decimal-places')) {
            options.decimalPlaces = parseInt(element.getAttribute('data-kt-countup-decimal-places'));
        }

        if (element.hasAttribute('data-kt-countup-prefix')) {
            options.prefix = element.getAttribute('data-kt-countup-prefix');
        }

        if (element.hasAttribute('data-kt-countup-separator')) {
            options.separator = element.getAttribute('data-kt-countup-separator');
        }

        if (element.hasAttribute('data-kt-countup-suffix')) {
            options.suffix = element.getAttribute('data-kt-countup-suffix');
        }

        var count = new countUp.CountUp(element, value, options);

        count.start();

        element.classList.add('counted');

        element.setAttribute("data-kt-initialized", "1");

    });
}

function initEmergencyCalls(callsCount, periodName) {
    var e, t = document.querySelectorAll(".mixed-widget-13-chart-custom");
    [].slice.call(t).map((function (t) {
        if (e = parseInt(KTUtil.css(t, "height")), t) {
            var a = KTUtil.getCssVariableValue("--bs-gray-800"),
                o = KTUtil.getCssVariableValue("--bs-gray-300");
            new ApexCharts(t, {
                series: [{name: "Calls", data: callsCount}],
                grid: {show: !1, padding: {top: 0, bottom: 0, left: 0, right: 0}},
                chart: {
                    fontFamily: "inherit",
                    type: "area",
                    height: e,
                    toolbar: {show: !1},
                    zoom: {enabled: !1},
                    sparkline: {enabled: !0}
                },
                plotOptions: {},
                legend: {show: !1},
                dataLabels: {enabled: !1},
                fill: {type: "gradient", gradient: {opacityFrom: .4, opacityTo: 0, stops: [20, 120, 120, 120]}},
                stroke: {curve: "smooth", show: !0, width: 3, colors: ["#FFFFFF"]},
                xaxis: {
                    categories: periodName,
                    axisBorder: {show: !1},
                    axisTicks: {show: !1},
                    labels: {show: !1, style: {colors: a, fontSize: "12px"}},
                    crosshairs: {show: !1, position: "front", stroke: {color: o, width: 1, dashArray: 3}},
                    tooltip: {enabled: !0, formatter: void 0, offsetY: 0, style: {fontSize: "12px"}}
                },
                yaxis: {min: 0, max: 60, labels: {show: !1, style: {colors: a, fontSize: "12px"}}},
                states: {
                    normal: {filter: {type: "none", value: 0}},
                    hover: {filter: {type: "none", value: 0}},
                    active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
                },
                tooltip: {
                    style: {fontSize: "12px"}, y: {
                        formatter: function (e) {
                            return "" + e + ""
                        }
                    }
                },
                colors: ["#ffffff"],
                markers: {colors: [a], strokeColor: [o], strokeWidth: 3}
            }).render()
        }
    }))
}

function initAmplifiedCalls(callsCount, periodName) {
    var e, t = document.querySelectorAll(".mixed-widget-14-chart-custom");
    [].slice.call(t).map((function (t) {
        e = parseInt(KTUtil.css(t, "height"));
        var a = KTUtil.getCssVariableValue("--bs-gray-800");
        new ApexCharts(t, {
            series: [{
                name: "Amplified",
                data: callsCount
            }],
            chart: {fontFamily: "inherit", height: e, type: "bar", toolbar: {show: !1}},
            grid: {show: !1, padding: {top: 0, bottom: 0, left: 0, right: 0}},
            colors: ["#ffffff"],
            plotOptions: {bar: {borderRadius: 2.5, dataLabels: {position: "top"}, columnWidth: "20%"}},
            dataLabels: {
                enabled: !1, formatter: function (e) {
                    return e + "%"
                }, offsetY: -20, style: {fontSize: "12px", colors: ["#304758"]}
            },
            xaxis: {
                labels: {show: !1},
                categories: periodName,
                position: "top",
                axisBorder: {show: !1},
                axisTicks: {show: !1},
                crosshairs: {show: !1},
                tooltip: {enabled: !1}
            },
            yaxis: {
                show: !1,
                axisBorder: {show: !1},
                axisTicks: {show: !1, background: a},
                labels: {
                    show: !1, formatter: function (e) {
                        return e - 1;
                    }
                }
            }
        }).render()
    }))
}

function initRespondTimeGraph() {
    KTChartsWidget36_.init();
}

function initAmplifiedTimeGraph() {
    KTChartsWidget36B_.init();
}

var KTChartsWidget36B_ = function () {
    var e = {self: null, rendered: !1}, t = function (e) {
        var t = document.getElementById("kt_charts_widget_36_b");
        if (t) {
            var a = parseInt(KTUtil.css(t, "height")), l = KTUtil.getCssVariableValue("--bs-gray-500"),
                r = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                o = KTUtil.getCssVariableValue("--bs-primary"), i = KTUtil.getCssVariableValue("--bs-primary"),
                s = KTUtil.getCssVariableValue("--bs-gray-500"), n = {
                    series: [{
                        name: "Emergency Call",
                        data: [65, 80, 80, 60, 60, 45, 45, 80, 80, 70, 70, 90, 90, 80, 80, 80, 60, 60, 50]
                    }, {
                        name: "Announcement",
                        data: [90, 110, 110, 95, 95, 85, 85, 95, 95, 115, 115, 100, 100, 115, 115, 95, 95, 85, 85]
                    }],
                    chart: {fontFamily: "inherit", type: "area", height: a, toolbar: {show: !1}},
                    plotOptions: {},
                    legend: {show: !1},
                    dataLabels: {enabled: !1},
                    fill: {
                        type: "gradient",
                        gradient: {shadeIntensity: 1, opacityFrom: .4, opacityTo: .2, stops: [15, 120, 100]}
                    },
                    stroke: {curve: "smooth", show: !0, width: 3, colors: [o, s]},
                    xaxis: {
                        categories: ["", "8 AM", "81 AM", "9 AM", "10 AM", "11 AM", "12 PM", "13 PM", "14 PM", "15 PM", "16 PM", "17 PM", "18 PM", "18:20 PM", "18:20 PM", "19 PM", "20 PM", "21 PM", ""],
                        axisBorder: {show: !1},
                        axisTicks: {show: !1},
                        tickAmount: 6,
                        labels: {rotate: 0, rotateAlways: !0, style: {colors: l, fontSize: "12px"}},
                        crosshairs: {position: "front", stroke: {color: [o, s], width: 1, dashArray: 3}},
                        tooltip: {enabled: !0, formatter: void 0, offsetY: 0, style: {fontSize: "12px"}}
                    },
                    yaxis: {max: 120, min: 30, tickAmount: 6, labels: {style: {colors: l, fontSize: "12px"}}},
                    states: {
                        normal: {filter: {type: "none", value: 0}},
                        hover: {filter: {type: "none", value: 0}},
                        active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
                    },
                    tooltip: {style: {fontSize: "12px"}},
                    colors: [i, KTUtil.getCssVariableValue("--bs-gray-500")],
                    grid: {borderColor: r, strokeDashArray: 4, yaxis: {lines: {show: !0}}},
                    markers: {strokeColor: [o, s], strokeWidth: 3}
                };
            e.self = new ApexCharts(t, n), setTimeout((function () {
                e.self.render(), e.rendered = !0
            }), 200)
        }
    };
    return {
        init: function () {
            t(e), KTThemeMode.on("kt.thememode.change", (function () {
                e.rendered && e.self.destroy(), t(e)
            }))
        }
    }
}();
var KTChartsWidget36_ = function () {
    var e = {self: null, rendered: !1}, t = function (e) {
        var t = document.getElementById("kt_charts_widget_36");
        if (t) {
            var a = parseInt(KTUtil.css(t, "height")), l = KTUtil.getCssVariableValue("--bs-gray-500"),
                r = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                o = KTUtil.getCssVariableValue("--bs-primary"), i = KTUtil.getCssVariableValue("--bs-primary"),
                s = KTUtil.getCssVariableValue("--bs-gray-500"), n = {
                    series: [{
                        name: "Emergency Call",
                        data: [65, 80, 80, 60, 60, 45, 45, 80, 80, 70, 70, 90, 90, 80, 80, 80, 60, 60, 50]
                    }, {
                        name: "Announcement",
                        data: [90, 110, 110, 95, 95, 85, 85, 95, 95, 115, 115, 100, 100, 115, 115, 95, 95, 85, 85]
                    }],
                    chart: {fontFamily: "inherit", type: "area", height: a, toolbar: {show: !1}},
                    plotOptions: {},
                    legend: {show: !1},
                    dataLabels: {enabled: !1},
                    fill: {
                        type: "gradient",
                        gradient: {shadeIntensity: 1, opacityFrom: .4, opacityTo: .2, stops: [15, 120, 100]}
                    },
                    stroke: {curve: "smooth", show: !0, width: 3, colors: [o, s]},
                    xaxis: {
                        categories: ["", "8 AM", "81 AM", "9 AM", "10 AM", "11 AM", "12 PM", "13 PM", "14 PM", "15 PM", "16 PM", "17 PM", "18 PM", "18:20 PM", "18:20 PM", "19 PM", "20 PM", "21 PM", ""],
                        axisBorder: {show: !1},
                        axisTicks: {show: !1},
                        tickAmount: 6,
                        labels: {rotate: 0, rotateAlways: !0, style: {colors: l, fontSize: "12px"}},
                        crosshairs: {position: "front", stroke: {color: [o, s], width: 1, dashArray: 3}},
                        tooltip: {enabled: !0, formatter: void 0, offsetY: 0, style: {fontSize: "12px"}}
                    },
                    yaxis: {max: 120, min: 30, tickAmount: 6, labels: {style: {colors: l, fontSize: "12px"}}},
                    states: {
                        normal: {filter: {type: "none", value: 0}},
                        hover: {filter: {type: "none", value: 0}},
                        active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
                    },
                    tooltip: {style: {fontSize: "12px"}},
                    colors: [i, KTUtil.getCssVariableValue("--bs-gray-500")],
                    grid: {borderColor: r, strokeDashArray: 4, yaxis: {lines: {show: !0}}},
                    markers: {strokeColor: [o, s], strokeWidth: 3}
                };
            e.self = new ApexCharts(t, n), setTimeout((function () {
                e.self.render(), e.rendered = !0
            }), 200)
        }
    };
    return {
        init: function () {
            t(e), KTThemeMode.on("kt.thememode.change", (function () {
                e.rendered && e.self.destroy(), t(e)
            }))
        }
    }
}();

let parseDailCodes = (dailCodes) => {
    let html = '';
    dailCodes.map(function (key, index) {
        html += `
                <div class="d-flex flex-nowrap align-items-center mb-7">
                    <div class="symbol symbol-40px symbol-2by3 me-4">
                        <span class="badge badge-primary" style="background-color: ${key.color_code}; width: 50px; height: 30px">&nbsp;</span>
                    </div>
                    <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pe-3">
                        <a href="#"
                           class="text-white fw-semibold text-dark text-hover-primary fs-6">${key.code}</a>
                        <span
                         class="sidebar-text-muted fw-semibold fs-7 my-1">${key.ecg_code_nme}</span>
                    </div>
                </div>
        `;
    })
    $('#dailCodes').html(html);
}
