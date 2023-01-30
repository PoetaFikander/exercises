$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    // -----------------------------------------------------------------

    "use strict";
    console.log('doc ready');

    /** HELPERS ----------------------------------------------------------------- */

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

    /** -------------------------------------------------------------------- */

    /**
     *
     */
    $('[data-toggle=articlesshow]').click(function () {
        let id = parseInt($(this).data('id')) ? $(this).data('id') : 0;
        //console.log(id);
        if (id > 0) {
            location.href = '/hpreport/articles/show/' + id;
        }
    });

    $('[data-toggle=weekinout]').change(function () {
        //console.log( $(this).find(":selected").val() );
        let dataFrom = $(this).find(":selected").attr("data-from");
        let dataTo = $(this).find(":selected").attr("data-to");

        //let id = parseInt($(this).data('id')) ? $(this).data('id') : 0;
        //console.log(id);
        //if (id > 0) {
        //    location.href = '/hpreport/articles/show/' + id;
        //}
    });



    // -----------------------------------------------------------------
});


