function getPageData(fetcherUrl, patch, callBackFunction = null, httpMethod = 'GET', AppendHTML = true, body = {}, shouldShowLoader = true, finalCallBack = null) {
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
        if (AppendHTML) {
            let patcher = '#' + patch;
            $(patcher).html("");
            $(patcher).html(res);
        }

        if (typeof callBackFunction === 'function') {
            callBackFunction(res);
        }
        KTMenu.createInstances();

    }).finally(() => {
        if (typeof callBackFunction === 'function') {
            finalCallBack();
        }
    })
}

$(function () {
    $(document).on('click', '.page-link', function (e) {
        e.preventDefault();
        getPageData($(this).attr('href'), 'main-content');
    });
});
