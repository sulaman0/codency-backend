$(function () {
    let endPoint = $('#senders_tab_load').attr('data-href') + '?=1'
    getPageData(endPoint, 'senders_tab_load');
    getPageData($('#receiver_tab_load').attr('data-href'), 'receiver_tab_load');
});
