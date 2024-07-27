"use strict";
var KTModalCustomersAdd = function () {
    var t, e, o, n, r, i;
    return {
        init: function () {
            i = new bootstrap.Modal(document.querySelector("#kt_modal_add_customer")), r = document.querySelector("#kt_modal_add_customer_form"), t = r.querySelector("#kt_modal_add_customer_submit"), e = r.querySelector("#kt_modal_add_customer_cancel"), o = r.querySelector("#kt_modal_add_customer_close"), n = FormValidation.formValidation(r, {
                fields: {
                    name: {validators: {notEmpty: {message: "Staff Name is required"}}},
                    email: {validators: {notEmpty: {message: "Email is required"}}},
                    designation: {validators: {notEmpty: {message: "Designation is required"}}},
                    password: {
                        validators: {
                            notEmpty: {message: "Password is required"}, minlength: 1000
                        }
                    },
                }, plugins: {
                    trigger: new FormValidation.plugins.Trigger, bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: ""
                    })
                }
            }), $(r.querySelector('[name="country"]')).on("change", (function () {
                n.revalidateField("country")
            })), t.addEventListener("click", (function (e) {
                e.preventDefault(), n && n.validate().then((function (e) {


                    if (e === "Invalid") {
                        return;
                    }

                    t.setAttribute("data-kt-indicator", "on")
                    t.disabled = !0
                    axios.post(t.closest("form").getAttribute("action"), new FormData(r)).then((function (e) {
                        if (e.data.status) {
                            i.hide();
                            r.reset();
                            Swal.fire({
                                text: "Form has been successfully submitted!",
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {confirmButton: "btn btn-primary"}
                            }).then((function (e) {
                                e.isConfirmed && i.hide() && r.reset()
                                getPageData($('#main-content').attr('data-href'), 'main-content');
                            }))

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
                }))
            })), e.addEventListener("click", (function (t) {
                t.preventDefault(), // Cancel Event.
                    Swal.fire({
                        text: "Are you sure you would like to cancel?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Yes, cancel it!",
                        cancelButtonText: "No, return",
                        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                    }).then((function (t) {
                        if (t.value) {
                            r.reset();
                            i.hide()
                        }
                    }))
            })), o.addEventListener("click", (function (t) {
                t.preventDefault(), Swal.fire({
                    text: "Are you sure you would like to cancel?",
                    icon: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Yes, cancel it!",
                    cancelButtonText: "No, return",
                    customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                }).then((function (t) {
                    t.value ? (r.reset(), i.hide()) : "cancel" === t.dismiss && Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {confirmButton: "btn btn-primary"}
                    })
                }))
            }))
        }
    }
}();
KTUtil.onDOMContentLoaded((function () {
    KTModalCustomersAdd.init()
    $(document).on('click', '.edit-link', function (e) {
        e.preventDefault();
        $('#kt_modal_add_customer').modal('show');
        $('.loading-progress-div').removeClass('d-none');
        getPageData($(this).attr('href'), null, function (res) {
            let formElement = $('form#kt_modal_add_customer_form');
            $(formElement).find('input[name=id]').val(res.payload.id);
            $(formElement).find('input[name=name]').val(res.payload.name);
            $(formElement).find('input[name=email]').val(res.payload.email);
            $(formElement).find('input[name=password]').val('testing09');
            $(formElement).find('input[name=designation]').val(res.payload.designation);
            $(formElement).find('input[name=phone]').val(res.payload.phone);
            $(formElement).find('select[name=location]').val(res.payload.location_id);
            $(formElement).find('input[name=shift_start_time]').val(res.payload.shift_start_time);
            $(formElement).find('input[name=shift_end_time]').val(res.payload.shift_end_time);
        }, 'GET', false, false, false, function () {
            $('.loading-progress-div').addClass('d-none');
        });
    });
}));
