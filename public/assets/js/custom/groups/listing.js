$(function () {
    let endPoint = $('#main-content').attr('data-href') + '?=1'
    getPageData(endPoint, 'main-content');

    $(document).on('keyup', '.search-user', function (e) {
        getPageData(endPoint + '&search=' + $(this).val(), 'main-content');
    });

});
