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

    /** USERS -------------------------------------------------------------------- */

    /**
     * user destroy
     */
    $('[data-toggle=delete]').click(function () {
        //console.log($(this));
        let id = parseInt($(this).data('id')) ? $(this).data('id') : 0;
        let name = $(this).data('name') ? $(this).data('name') : '';
        Swal.fire({
            title: 'Usunąć użytkownika ' + name + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tak',
            cancelButtonText: 'Nie'
        }).then((result) => {
            if (result.isConfirmed) {
                //console.log(id);
                if (id > 0) {
                    uniXHR({}, '/users/delete/' + id, function (data) {
                        //location.href = 'users/list';
                        window.location.reload();
                    }, 'DELETE');
                }
            }
        })

    });

    /**
     * user edit
     */
    $('[data-toggle=edit]').click(function () {
        //console.log($(this));
        let id = parseInt($(this).data('id')) ? $(this).data('id') : 0;
        let name = $(this).data('name') ? $(this).data('name') : '';


    });

    // -----------------------------------------------------------------
});


/* ----------------------------------------------------------------- */
/*
   $('[data-toggle=delete]').confirmation({
    container: 'body',
    onConfirm: function () {
        var id = parseInt($(this).closest('tr').data('id')) ? $(this).closest('tr').data('id') : 0;
        if (id > 0) {
            uniXHR({id: id}, '/articles/delete', function (data) {
                console.log(data);
                location.href = 'articles';
            });
        }
    }
});


$('[data-toggle=tocomplete]').confirmation({
    container: 'body',
    onConfirm: function () {
        //console.log(this);
        //$(this).addClass('disabled'); // Disables visually
        //$(this).prop('disabled', true); // Disables visually + functionally
        let id = parseInt($(this).closest('tr').data('id')) ? $(this).closest('tr').data('id') : 0;
        if (id > 0) {
            uniXHR({id: id}, '/articles/tocomplete', function (data) {
                console.log(data);
                location.href = 'articles';
            });
        }
    }
});


*/
