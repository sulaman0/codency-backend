let locationType = 'rooms';
let status = 'active';
$(function () {
    let endPoint = $('#main-content').attr('data-href') + '?=1'
    getPageData(endPoint + `&status=active&location_type=${locationType}`, 'main-content');

    $(document).on('keyup', '.search-location', function (e) {
        getPageData(endPoint + queryString(), 'main-content');
    });

    $(document).on('change', '.location-type', function (e) {
        locationType = $(this).val();
        getPageData(endPoint + queryString(), 'main-content');
    });

    $(document).on('change', '.user-status', function (e) {
        status = $(this).val();
        getPageData(endPoint + queryString(), 'main-content');
    });

    $(document).on('click', '.location-details', function (e) {
        e.preventDefault();
        getPageData($(this).attr('href'), 'main-content');
        resetQueryString();
    });
});

function queryString() {
    return `&status=${status}&location_type=${locationType}&search=${$('.search-location').val()}`;
}

function resetQueryString() {
    $('.search-location').val('');
    locationType = '';
    status = 'active';
}

