$(function () {
    let endPoint = $('#main-content').attr('data-href') + '?=1'
    getPageData(endPoint + '&status=active', 'main-content');

    $(document).on('keyup', '.search-code', function (e) {
        getPageData(endPoint + '&search=' + $(this).val(), 'main-content');
    });

    $(document).on('change', '.ecg-code-status', function (e) {
        getPageData(endPoint + '&status=' + $(this).val(), 'main-content');
    });

});
