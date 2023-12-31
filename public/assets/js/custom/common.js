function getPageData(fetcherUrl, patch, callBackFunction = null, httpMethod = 'GET', AppendHTML = true, body = {}, shouldShowLoader = true,
                     finalCallBack = null) {
    let fetchBody = {
        method: httpMethod,
        "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content'),
    };

    if (httpMethod === 'POST') {
        fetchBody.body = body;
    }

    fetch(fetcherUrl, fetchBody).then((res) => {
        if (AppendHTML) {
            return res.text();
        } else {
            return res.json();
        }
    }).then((res) => {
        if (AppendHTML && patch) {
            let patcher = '#' + patch;
            $(patcher).html("");
            $(patcher).html(res);
        }

        if (typeof callBackFunction === 'function') {
            callBackFunction(res);
        }
        KTMenu.createInstances();

    }).finally(() => {
        if (typeof finalCallBack === 'function') {
            finalCallBack();
        }
    })
}

$(function () {
    $(document).on('click', '.page-link', function (e) {
        e.preventDefault();
        getPageData($(this).attr('href'), 'main-content');
    });

    $(document).on('click', '.delete-link', function (e) {
        e.preventDefault();
        getPageData($(this).attr('href'), null, (res) => {
            if (res.status) {
                Swal.fire({
                    text: "Changes has been saved successfully",
                    icon: "success",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {confirmButton: "btn btn-primary"}
                }).then((function (e) {
                    getPageData($('#main-content').attr('data-href'), 'main-content');
                }))
            } else {
                Swal.fire({
                    text: res.data ? res.data.message : res.message,
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {confirmButton: "btn btn-primary"}
                });
            }
        }, 'GET', null, false, false, null);
    })
});
