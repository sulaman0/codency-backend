"use strict";
let endPoint = $('#main-content').attr('data-href') + '?=1'
var KTModalCustomersAdd = function () {
    var t, e, o, n, r, i;
    return {
        init: function () {
            i = new bootstrap.Modal(document.querySelector("#kt_modal_add_customer")),
                r = document.querySelector("#kt_modal_add_customer_form"),
                t = r.querySelector("#kt_modal_add_customer_submit"),
                e = r.querySelector("#kt_modal_add_customer_cancel"),
                o = r.querySelector("#kt_modal_add_customer_close"),
                t.addEventListener("click", (function (e) {
                    e.preventDefault();
                    t.setAttribute("data-kt-indicator", "on")
                    t.disabled = !0
                    axios.post(t.closest("form").getAttribute("action"), new FormData(r)).then((function (e) {
                        // getPageData(endPoint, 'main-content');
                        i.hide();

                        if (e.data) {
                            $('#main-content').html(e.data);
                        } else {
                            Swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {confirmButton: "btn btn-primary"}
                            })
                        }

                    })).catch((function (t) {
                        Swal.fire({
                            text: t.response.data.message ? t.response.data.message : "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {confirmButton: "btn btn-primary"}
                        })
                    })).then((() => {
                        t.removeAttribute("data-kt-indicator"), t.disabled = !1
                    }));
                })),
                e.addEventListener("click", (function (t) {
                    t.preventDefault();
                    window.location.reload()
                    r.reset();
                    i.hide();
                })), o.addEventListener("click", (function (t) {
                t.preventDefault();
                r.reset();
                i.hide();
            }))
        }
    }
}();
KTUtil.onDOMContentLoaded((function () {
    KTModalCustomersAdd.init()
    getPageData(endPoint, 'main-content');
    $('input[name=date_range]').val($('[data-kt-daterangepicker="true"]').data('daterangepicker').startDate.format('YYYY-MM-DD') + '/' + $('[data-kt-daterangepicker="true"]').data('daterangepicker').endDate.format('YYYY-MM-DD'));

    $('[data-kt-daterangepicker="true"]').on('apply.daterangepicker', function (ev, picker) {
        $('input[name=date_range]')
            .val(picker.startDate.format('YYYY-MM-DD') + '/' + picker.endDate.format('YYYY-MM-DD'));
    });

}));
