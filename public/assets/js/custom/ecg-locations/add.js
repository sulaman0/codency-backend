"use strict";
var KTModalCustomersAdd = function () {
    var t, e, o, n, r, i, floor, floorValidate_N, floorForm, roomForm, room, roomForm_N, editForm, editFormBtn,
        editForm_N, editModel, editModelClose;
    return {
        init: function () {
            i = new bootstrap.Modal(document.querySelector("#kt_modal_add_customer")),
                editModel = new bootstrap.Modal(document.querySelector("#kt_modal_edit_location")),
                r = document.querySelector("#kt_modal_add_customer_form"),
                floorForm = document.querySelector("#kt_modal_add_customer_form_floor"),
                editForm = document.querySelector("#kt_modal_edit_location_form"),
                roomForm = document.querySelector("#kt_modal_add_customer_form_room"),
                t = r.querySelector("#kt_modal_add_customer_submit"),
                floor = floorForm.querySelector("#kt_modal_add_customer_submit_floor"),
                room = roomForm.querySelector("#kt_modal_add_customer_form_room_submit"),
                editFormBtn = editForm.querySelector("#kt_modal_edit_location_form_submit"),
                e = r.querySelector("#kt_modal_add_customer_cancel"),
                o = $("#kt_modal_add_customer_close").on('click', (function (t) {
                    t.preventDefault(), Swal.fire({
                        text: "Are you sure you would like to cancel?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Yes, cancel it!",
                        cancelButtonText: "No, return",
                        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                    }).then((function (t) {
                        t.value ? (r.reset(), i.hide()) : ""
                    }))
                })),
                editModelClose = $("#edit_modal_close").on('click', (function (t) {
                    t.preventDefault(), Swal.fire({
                        text: "Are you sure you would like to cancel?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Yes, cancel it!",
                        cancelButtonText: "No, return",
                        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                    }).then((function (t) {
                        t.value ? (editForm.reset(), editModel.hide()) : ""
                    }))
                })),
                n = FormValidation.formValidation(r, {
                    fields: {
                        loc_name: {validators: {notEmpty: {message: "Location Name is required"}}},
                    }, plugins: {
                        trigger: new FormValidation.plugins.Trigger, bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: ""
                        })
                    }
                }), floorValidate_N = FormValidation.formValidation(floorForm, {
                fields: {
                    floor_name: {validators: {notEmpty: {message: "Floor Name is required"}}},
                }, plugins: {
                    trigger: new FormValidation.plugins.Trigger, bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: ""
                    })
                }
            }),
                roomForm_N = FormValidation.formValidation(roomForm, {
                    fields: {
                        room_name: {validators: {notEmpty: {message: "Room Name is required"}}},
                    }, plugins: {
                        trigger: new FormValidation.plugins.Trigger, bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: ""
                        })
                    }
                }), editForm_N = FormValidation.formValidation(editForm, {
                fields: {
                    name: {validators: {notEmpty: {message: "Name is required"}}},
                }, plugins: {
                    trigger: new FormValidation.plugins.Trigger, bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: ""
                    })
                }
            }),
                t.addEventListener("click", (function (e) {
                    e.preventDefault(), n && n.validate().then((function (e) {
                        if (e === "Invalid") {
                            return;
                        }
                        t.setAttribute("data-kt-indicator", "on")
                        t.disabled = !0
                        axios.post(t.closest("form").getAttribute("action"), new FormData(r)).then((function (e) {
                            if (e.data.status) {
                                parseSelectInputs(e.data.payload.buildings, e.data.payload.floors)
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
                })),
                floor.addEventListener("click", (function (e) {
                    e.preventDefault(), floorValidate_N && floorValidate_N.validate().then((function (e) {
                        alert(e)
                        if (e === "Invalid") {
                            return;
                        }
                        floor.setAttribute("data-kt-indicator", "on")
                        floor.disabled = !0
                        axios.post(floor.closest("form").getAttribute("action"), new FormData(floorForm)).then((function (e) {
                            if (e.data.status) {
                                parseSelectInputs(e.data.payload.buildings, e.data.payload.floors)
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
                            floor.removeAttribute("data-kt-indicator"), floor.disabled = !1
                        }));
                    }))
                })),
                room.addEventListener("click", (function (e) {
                    e.preventDefault(), roomForm_N && roomForm_N.validate().then((function (e) {
                        if (e === "Invalid") {
                            return;
                        }
                        room.setAttribute("data-kt-indicator", "on")
                        room.disabled = !0
                        axios.post(room.closest("form").getAttribute("action"), new FormData(roomForm)).then((function (e) {
                            if (e.data.status) {
                                $('input[name=room_name]').val('')
                                toastr.success('Location has been Created');
                                // Swal.fire({
                                //     text: "Location has been Created",
                                //     icon: "success",
                                //     buttonsStyling: !1,
                                //     confirmButtonText: "Ok, got it!",
                                //     customClass: {confirmButton: "btn btn-primary"}
                                // }).then((function (e) {
                                //     e.isConfirmed && i.hide() && r.reset()
                                //     getPageData($('#main-content').attr('data-href'), 'main-content');
                                // }))
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
                            room.removeAttribute("data-kt-indicator"), room.disabled = !1
                        }));
                    }))
                })),
                editFormBtn.addEventListener("click", (function (e) {
                    e.preventDefault(), editForm_N && editForm_N.validate().then((function (e) {
                        if (e === "Invalid") {
                            return;
                        }
                        editFormBtn.setAttribute("data-kt-indicator", "on")
                        editFormBtn.disabled = !0
                        axios.post(editFormBtn.closest("form").getAttribute("action"), new FormData(editForm)).then((function (e) {
                            if (e.data.status) {
                                parseSelectInputs(e.data.payload.buildings, e.data.payload.floors)
                                Swal.fire({
                                    text: "Location has been Updated",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {confirmButton: "btn btn-primary"}
                                }).then((function (e) {
                                    e.isConfirmed && editModel.hide() && editForm.reset()
                                    getPageData($('#main-content').attr('data-href') + '?1=1' + queryString(), 'main-content');
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
                            editFormBtn.removeAttribute("data-kt-indicator"), editFormBtn.disabled = !1
                        }));
                    }))
                }))
        }
    }
}();
KTUtil.onDOMContentLoaded((function () {
    KTModalCustomersAdd.init()
    $(document).on('click', '.edit-link', function (e) {
        e.preventDefault();
        $('#kt_modal_edit_location').modal('show');
        $('.loading-progress-div').removeClass('d-none');
        getPageData($(this).attr('href'), null, function (res) {
            let formElement = $('form#kt_modal_edit_location_form');
            $(formElement).find('input[name=id]').val(res.payload.id);
            $(formElement).find('input[name=name]').val(res.payload.name);
            $(formElement).find('input[name=loc_type]').val(res.payload.type);
        }, 'GET', false, false, false, function () {
            $('.loading-progress-div').addClass('d-none');
        });
    });
}));

function parseSelectInputs(buildings, locations) {
    let buildingHTML = `<select name="building" class="form-control form-control-solid">`;
    buildings.map(function (i, v) {
        buildingHTML += `<option ${v == 0 ? 'selected' : ''} value="${i.id}">${i.building_nme}</option>`;
    })
    buildingHTML += `<select>`;
    $('.building-select').html(buildingHTML);

    let floorHTML = `<select name="floor" class="form-control form-control-solid">`;
    locations.map(function (i, v) {
        floorHTML += `<option ${v == 0 ? 'selected' : ''} value="${i.id}">${i.floor_nme}</option>`;
    })
    floorHTML += `<select>`;
    $('.floor-select').html(floorHTML);
}
