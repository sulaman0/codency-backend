$(function () {
    let endPoint = $('#senders_tab_load').attr('data-href') + '?=1'
    getPageData(endPoint, 'senders_tab_load');
    getPageData($('#receiver_tab_load').attr('data-href'), 'receiver_tab_load');


    $(document).on('click', '.user-location-block', function () {
        let element = $(this);
        getPageData($(this).attr('data-href'), '', function (res) {
            const parseRes = JSON.parse(res);
            if (parseRes.status) {
                $(element).removeClass('locationBox').addClass('assignedLocation')
            }
        });
    })
});
