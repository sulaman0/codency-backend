"use strict";

$(function () {
    let endPoint = $('#main-content').attr('data-href') + '?=1'
    getPageData(endPoint, 'main-content');
})
