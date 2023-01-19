$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//$(document).ready(function () {

    //"use strict";
    console.log('uniXHR ready');

    let uniXHR = function (o, url, callback, type = "POST") {
        callback = $.isFunction(callback) ? callback : false;
        o = JSON.stringify(o);
        let jqXHR = $.ajax({
            url: window.location.origin + url,
            type: type,
            dataType: 'json',
            data: {json: o}
        });
        jqXHR.done(function (data) {
            if (callback) callback(data);
        });
    };



    // -----------------------------------------------------------------
//});
