$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    // -----------------------------------------------------------------

    "use strict";
    console.log('main.js loaded');

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

    //Lodash is a modern JavaScript utility library that can perform many JavaScript functionalities with very basic syntax.
    const isObjectEmpty = (objectName) => {
        return _.isEmpty(objectName);
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

    /** -------------------------------------------------------------------- */

    /**
     *
     */
    $('[data-toggle=articlesshow]').click(function () {
        let id = parseInt($(this).data('id')) ? $(this).data('id') : 0;
        console.log(id);
        if (id > 0) {
            location.href = '/hpreport/articles/show/' + id;
        }
    });

    // $('#for_year').change(function () {
    //     //console.log($(this));
    //     let year = $(this).find(':selected').val();
    //     let dateFrom = year + '-01-01';
    //     //console.log(dateFrom);
    //     location.href = '/hpreport/articles/delivery/' + dateFrom;
    // });


    $('[data-toggle=h_a_d_for_year]').change(function () {
        //console.log($(this));
        let year = $(this).find(':selected').val();
        let dateFrom = year + '-01-01';
        //console.log(dateFrom);
        location.href = '/hpreport/articles/purchases/' + dateFrom;
    });

    $('[data-toggle=h_a_d_for_week]').change(function () {
        //console.log($(this));
        let year = $('[data-toggle=h_a_d_for_year]').find(':selected').val();
        //console.log(year);
        let date = $(this).find(':selected').attr('data-from');
        let dateFrom = year + date.substring(4);
        //console.log(dateFrom);
        location.href = '/hpreport/articles/purchases/' + dateFrom;
    });


    $('[data-toggle=h_a_s_for_year]').change(function () {
        //console.log($(this));
        let year = $(this).find(':selected').val();
        let dateFrom = year + '-01-01';
        //console.log(dateFrom);
        location.href = '/hpreport/articles/sale/' + dateFrom;
    });

    $('[data-toggle=h_a_s_for_week]').change(function () {
        //console.log($(this));
        let year = $('[data-toggle=h_a_s_for_year]').find(':selected').val();
        //console.log(year);
        let date = $(this).find(':selected').attr('data-from');
        let dateFrom = year + date.substring(4);
        //console.log(dateFrom);
        location.href = '/hpreport/articles/sale/' + dateFrom;
    });


    /**
     *
     *
     *
     */

    $('[data-toggle=h_r_c_for_year]').change(function () {
        //console.log($(this));
        let year = $(this).find(':selected').val();
        uniXHR({year: year}, '/hpreport/reports/getweeks', function (data) {
            //console.log(data.weeks);
            let select = $('[data-toggle=h_r_c_for_week]');
            //console.log(select.attr('id'));
            select.html('');
            let items = data.weeks || [];
            let html = '';
            for (let n in items) {
                let item = items[n];
                html += '<option value="' + item.w_start + '">' + item.w_start + ' - ' + item.w_end + '</option>'
            }
            select.append(html);
            let year = $('[data-toggle=h_r_c_for_year]').find(':selected').val();
            let date = $('[data-toggle=h_r_c_for_week]').find(':selected').val();
            console.log(year);
            console.log(date);
            uniXHR({year: year, date: date}, '/hpreport/reports/getreportsno', function (data) {
                console.log(data.previousReports);
                let select = $('[data-toggle=h_r_c_for_reportid]');
                select.html('');
                let items = data.previousReports || [];
                let html = '';
                if (isObjectEmpty(items)) {
                    html = '<option value="-1">-- brak --</option>'
                    select.append(html);
                } else {
                    for (let n in items) {
                        let item = items[n];
                        //console.log(item);
                        html += '<option value="' + item.report_id + '">' + item.report_no + '</option>'
                    }
                    select.append(html);
                    const lastKey = Object.keys(items).pop(); // indeks ostatniego elementu w items
                    select.val(lastKey).prop('selected', true);
                }
                $('#create_report_message').remove(); // czyszczenie komunikatu
                $('.table-reports').remove(); // usuwanie tabeli z raportem
            });
        });
    });

    $('[data-toggle=h_r_c_for_week]').change(function () {
        //console.log($(this));
        let year = $('[data-toggle=h_r_c_for_year]').find(':selected').val();
        //let date = $(this).find(':selected').attr('data-from');
        let date = $(this).find(':selected').val();
        console.log(year);
        console.log(date);
        uniXHR({year: year, date: date}, '/hpreport/reports/getreportsno', function (data) {
            console.log(data.previousReports);
            let select = $('[data-toggle=h_r_c_for_reportid]');
            select.html('');
            let items = data.previousReports || [];
            let html = '';
            if (isObjectEmpty(items)) {
                html = '<option value="-1">-- brak --</option>'
                select.append(html);
            } else {
                for (let n in items) {
                    let item = items[n];
                    //console.log(item);
                    html += '<option value="' + item.report_id + '">' + item.report_no + '</option>'
                }
                select.append(html);
                const lastKey = Object.keys(items).pop(); // indeks ostatniego elementu w items
                select.val(lastKey).prop('selected', true);
            }
            $('#create_report_message').remove(); // czyszczenie komunikatu
            $('.table-reports').remove(); // usuwanie tabeli z raportem
        });
    });



    /**
     *
     */
    $('[data-toggle=reportsshow]').click(function () {
        let id = parseInt($(this).data('id')) ? $(this).data('id') : 0;
        //console.log(id);
        if (id > 0) {
            location.href = '/hpreport/reports/show/' + id;
        }
    });


    /**
     * report destroy
     */
    $('[data-toggle=reportdelete]').click(function () {
        //console.log($(this));
        let id = parseInt($(this).data('id')) ? $(this).data('id') : 0;
        let name = $(this).data('name') ? $(this).data('name') : '';
        Swal.fire({
            title: 'Usunąć raport id ' + name + ' ?',
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
                    uniXHR({}, '/hpreport/reports/destroy/' + id, function (data) {
                        //location.href = 'users/list';
                        window.location.reload();
                    }, 'DELETE');
                }
            }
        })

    });

    $('[data-toggle=h_c_l_modalcustomerbtn]').click(function (e) {
        e.preventDefault();
        //console.log($(this));
        let data = {
            'customerName': $('#customerName').val(),
            'customerTin': $('#customerTin').val(),
        };
        //console.log(data);
        uniXHR({data: data}, '/hpreport/customers/getfromalt', function (data) {
            //console.log(data);
            let tbody = $('[data-toggle=h_c_l_modalcustomertbody]');
            tbody.html('');
            let items = data.customers || [];
            let html = '';
            if (!isObjectEmpty(items)) {
                for (let n in items) {
                    let item = items[n];
                    //console.log(item);
                    html += '<tr class="align-middle">';
                    html += '<td>' + item.code + '</td>';
                    html += '<td>' + item.name + '</td>';
                    html += '<td>' + item.tin + '</td>';
                    html += '<td><button class="btn btn-sm" data-toggle="h_c_l_modalcustomeradd" data-id="' + item.altum_id + '">';
                    html += '<strong><i class="bi-plus-circle fs-5 text-success"></i></strong>';
                    html += '</button></td>';
                    html += '</tr>';
                }
                tbody.append(html);
                $('[data-toggle=h_c_l_modalcustomeradd]').click(function (e) {
                    e.preventDefault();
                    let id = parseInt($(this).data('id')) ? $(this).data('id') : 0;
                    //console.log(id);
                    if (id > 0) {
                        uniXHR({id: id}, '/hpreport/customers/add', function (data) {
                            console.log(data);
                            let div = $('[data-toggle=h_c_l_modalcustomeraddmessage]');
                            div.html('');
                            let alert = (parseInt(data.status) === 200) ? 'alert-success' : 'alert-danger';
                            let html = '<div class="alert ' + alert + '">' + data.message + '</div>';
                            div.append(html);
                            //$('[data-toggle=h_c_l_modalcustomertbody]').html('');
                        })
                    }
                })
            }
        });

    });

    /**
     * customer delete
     */
    $('[data-toggle=customerdelete]').click(function () {
        //console.log($(this));
        let id = parseInt($(this).data('id')) ? $(this).data('id') : 0;
        let name = $(this).data('name') ? $(this).data('name') : '';
        Swal.fire({
            title: 'Usunąć kontrahenta: ' + name + ' ?',
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
                    uniXHR({}, '/hpreport/customers/delete/' + id, function (data) {
                        window.location.reload();
                    }, 'DELETE');
                }
            }
        })

    });

    // podpięcie się pod event zamykający modala, przeładowują listę kontrahentów po dodaniu nowego
    const addCustomerModal = document.getElementById('addCustomerModal');
    if (!(addCustomerModal === null)) {
        addCustomerModal.addEventListener('hidden.bs.modal', () => {
            //console.log('modal element completely hidden!');
            window.location.reload();
        })
    }

    /**
     * -------------------------------------------------------------------------------------------------------
     * edycja raportu
     *
     */

    const checkReportCohesion = function (input) {
        // ---------------------------------------------------------
        // dane z inputa generującego event
        const currentInput = input;
        const currentRowId = parseInt(currentInput.data('id'));
        const articleId = parseInt(currentInput.data('artid'));

        // ---------------------------------------------------------
        // inputy w wierszu eventu
        const currentTr = currentInput.parents('tr');
        const currentInputs = new Map();
        currentInputs.set('id', currentRowId);
        currentTr.find('input[type="number"]').each(function () {
            const input = $(this);
            const name = input.attr('name');
            currentInputs.set(name, input);
        });

        // ---------------------------------------------------------
        // suma 'sales unit' dla artikla (sekcji w tabeli)
        let totalSU = 0;
        currentInput.parents('tbody').find('tr[data-artid="' + articleId + '"]').each(function () {
            totalSU += parseInt($(this).find('input[name="su"]').val());
        });

        // ---------------------------------------------------------
        // oryginalna sekcja artikla (początkowa sprzed edycji)
        const articleSection = report.get(articleId);
        // pierwszy wiersz sekcji danego artikla
        const firstRow = articleSection.entries().next().value;
        const firstRowId = parseInt(firstRow[0]);
        const orgPreviousIU = firstRow[1].get('previousIU');

        // ---------------------------------------------------------
        // pierwszy wiersz sekcji danego artikla w tabeli
        const firstInputs = new Map();
        const firstTr = currentInput.parents('tbody').find('tr[data-id="' + firstRowId + '"]');
        firstInputs.set('id', parseInt(firstTr.data('id')));
        firstTr.find('input[type="number"]').each(function () {
            const input = $(this);
            const name = input.attr('name');
            firstInputs.set(name, input);
        });
        let currentTSU = parseInt(firstInputs.get('tsu').val());
        let currentIU = parseInt(firstInputs.get('iu').val());

        // ---------------------------------------------------------
        let previousIU = currentIU - currentTSU + totalSU;

        if (previousIU !== orgPreviousIU) {
            //
            currentInput.parents('tbody').find('tr[data-artid="' + articleId + '"]').each(function () {
                const rowStatus = $(this).find('.row-status');
                rowStatus.html('');
                rowStatus.append('<i class="text-danger bi bi-exclamation-triangle fs-5 fw-bold"></i>');
            });
        } else {
            //
            currentInput.parents('tbody').find('tr[data-artid="' + articleId + '"]').each(function () {
                const rowStatus = $(this).find('.row-status');
                rowStatus.html('');
            });
        }
    };


    // konwersja tabeli HTML raportu na obiekt
    const hre_table = $('#h_r_e_table');
    const report = new Map();
    if (!(hre_table === null)) {
        let rows = new Map();
        let previousArticleId = 0;
        let articleId = 0;
        let previousIU = 0;
        let totalSU = 0;
        hre_table.find('tbody  > tr').each(function () {
            const tr = $(this);
            articleId = parseInt(tr.data('artid'));
            previousIU = parseInt(tr.data('preiu'));
            totalSU = parseInt(tr.data('totsu'));
            if (previousArticleId !== articleId) {
                rows = new Map();
            }
            const rowId = parseInt(tr.data('id'));
            const row = new Map();
            row.set('id', rowId);
            row.set('previousIU', previousIU);
            row.set('totalSU', totalSU);
            tr.find('input[type="number"]').each(function () {
                const input = $(this);
                const name = input.attr('name');
                const val = parseFloat(input.val());
                row.set(name, val);
            });
            rows.set(rowId, row);
            report.set(articleId, rows);
            previousArticleId = articleId;
        });
        //console.log(report);

        // sprawdzenie koherencji raportu
        // po polsku czy aktualny raport jest spójny z poprzednim
        hre_table.find('tbody  > tr input[name="tsu"]').each(function () {
            //console.log($(this));
            //checkReportCohesion($(this));
        });

    }

    $('[data-toggle=artInpNumber]').change(function () {
        //
        //console.log($(this));
        checkReportCohesion($(this));
    });

    $('[data-toggle=hre_reportupdate]').click(function () {
        //
        const data = {};
        hre_table.find('tbody > tr').each(function () {
            const tr = $(this);
            const id = parseInt(tr.data('id'));
            const i = {};
            tr.find('input[type="number"]').each(function () {
                const input = $(this);
                const name = input.attr('name');
                i[name] = parseFloat(input.val());
            });
            data[id] = i;
        });
        uniXHR({data: data}, '/hpreport/reports/update', function (data) {
            const mes = $('[data-toggle=hre_reportupdatemessage]');
            mes.html('');
            mes.append('<div class="text-success text-center"><h4>Zmiany zostały zapisane.</h4></div>');
            setTimeout(() => {
                $('[data-toggle=hre_reportupdatemessage]').html('');
            }, 4000)
        });

    });


});


