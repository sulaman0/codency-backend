"use strict";
var KTModalNewTarget = function () {
    var t, e, n, a, o, i;
    return {
        init: function () {
            (a = document.querySelector("#kt_modal_new_target_form"),
                t = document.getElementById("kt_modal_new_target_submit"),
                e = document.getElementById("kt_modal_new_target_cancel"),
                n = FormValidation.formValidation(a, {
                    fields: {
                        // target_title: {validators: {notEmpty: {message: "Target title is required"}}},
                        // target_assign: {validators: {notEmpty: {message: "Target assign is required"}}},
                        // target_due_date: {validators: {notEmpty: {message: "Target due date is required"}}},
                        // target_tags: {validators: {notEmpty: {message: "Target tags are required"}}},
                        // "targets_notifications[]": {validators: {notEmpty: {message: "Please select at least one communication method"}}}
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: ""
                        })
                    }
                }), t.addEventListener("click", (function (e) {
                e.preventDefault();
                n.validate().then(function (e) {
                    if ("Invalid" === e) {
                        return
                    }
                    // Submit the form now.
                    t.setAttribute("data-kt-indicator", "on")
                    t.disabled = !0
                    axios.post(t.closest("form").getAttribute("action"), new FormData(a)).then((function (e) {
                        if (e.data.status) {
                            Swal.fire({
                                text: "Form has been successfully submitted!",
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {confirmButton: "btn btn-primary"}
                            }).then((function (e) {
                                location.href = a.getAttribute('data-kt-redirect');
                            }));
                        } else {
                            Swal.fire({
                                text: e.data.message,
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {confirmButton: "btn btn-primary"}
                            });
                        }
                    })).catch((function (t) {
                        console.log(t, "exception")
                        Swal.fire({
                            text: t.response.data.message ? t.response.data.message : "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {confirmButton: "btn btn-primary"}
                        })
                    })).finally((() => {
                        t.removeAttribute("data-kt-indicator"), t.disabled = !1
                    }));
                });

            })), e.addEventListener("click", (function (t) {
                t.preventDefault(), Swal.fire({
                    text: "Are you sure you would like to cancel?",
                    icon: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Yes, cancel it!",
                    cancelButtonText: "No, return",
                    customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                }).then((function (t) {
                    if ("cancel" !== t.dismiss) {
                        location.href = a.getAttribute('data-kt-redirect');
                    }
                }))
            })))
        }
    }
}();
KTUtil.onDOMContentLoaded((function () {
    KTModalNewTarget.init()
}));
