"use strict";

$(function () {
    let endPoint = $('#main-content').attr('data-href') + '?=1'
    getPageData(endPoint, 'main-content');

    // setInterval(function () {
    //     getPageData(endPoint, 'main-content');
    // }, 20000);
})
