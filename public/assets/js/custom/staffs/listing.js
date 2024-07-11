$(function () {
    let endPoint = $('#main-content').attr('data-href') + '?=1'
    getPageData(endPoint + '&status=active&group=' + getGroupSelectedValue(), 'main-content');

    $(document).on('keyup', '.search-user', function (e) {
        getPageData(generateUrl(), 'main-content');
    });

    $(document).on('change', '.user-status', function (e) {
        getPageData(generateUrl(), 'main-content');
    });

    $(document).on('change', '.group-status', function (e) {
        getPageData(generateUrl(), 'main-content');
    });

    $(document).on('change', '.ecg-code', function (e)   {
        getPageData(generateUrl(), 'main-content');
    });

});

function getGroupSelectedValue() {
    return $('select.group-status').val();
}

function getStatusValue() {
    return $('select.user-status').val();
}

function getEcgCodeValue() {
    return $('select.ecg-code').val();
}

function getSearchKeyword() {
    return $('input.search-user').val();
}

function generateUrl() {
    let url = $('#main-content').attr('data-href') + '?=1';
    const status = getStatusValue();
    if (status) {
        url += '&status=' + status;
    }

    const group = getGroupSelectedValue();
    if (group) {
        url += '&group=' + group;
    }

    const searchVal = getSearchKeyword();
    if (searchVal) {
        url += '&search=' + searchVal;
    }

    const ecgCode = getEcgCodeValue();
    if (ecgCode) {
        url += '&ecg_code=' + ecgCode;
    }

    return url;
}
