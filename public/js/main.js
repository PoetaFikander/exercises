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
     * edycja raportu
     *
     */

        // konwersja tabeli HTML raportu na obiekt
    const hre_table = $('#h_r_e_table');
    const report = new Map();
    if (!(hre_table === null)) {
        let rows = new Map();
        let previousArticleId = 0;
        let articleId = 0;
        let previousIU = 0;
        let totalSU = 0;
        hre_table.find('tbody  > tr').each(function (i) {
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
            tr.find('input[type="number"]').each(function (j) {
                const input = $(this);
                const name = input.attr('name');
                const val = parseFloat(input.val());
                row.set(name, val);
            });
            rows.set(rowId, row);
            report.set(articleId, rows);
            previousArticleId = articleId;
        });
        console.log(report);
    }

    const checkReportCohesion = function(input){
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


    $('[data-toggle=artInpNumber]').change(function () {
        //
        //console.log($(this));

        checkReportCohesion($(this));

        // // ---------------------------------------------------------
        // // dane z inputa generującego event
        // const currentInput = $(this);
        // const currentRowId = parseInt(currentInput.data('id'));
        // const articleId = parseInt(currentInput.data('artid'));
        //
        // // ---------------------------------------------------------
        // // inputy w wierszu eventu
        // const currentTr = currentInput.parents('tr');
        // const currentInputs = new Map();
        // currentInputs.set('id', currentRowId);
        // currentTr.find('input[type="number"]').each(function () {
        //     const input = $(this);
        //     const name = input.attr('name');
        //     currentInputs.set(name, input);
        // });
        //
        // // ---------------------------------------------------------
        // // suma 'sales unit' dla artikla (sekcji w tabeli)
        // let totalSU = 0;
        // currentInput.parents('tbody').find('tr[data-artid="' + articleId + '"]').each(function () {
        //     totalSU += parseInt($(this).find('input[name="su"]').val());
        // });
        //
        // // ---------------------------------------------------------
        // // oryginalna sekcja artikla (początkowa sprzed edycji)
        // const articleSection = report.get(articleId);
        // // pierwszy wiersz sekcji danego artikla
        // const firstRow = articleSection.entries().next().value;
        // const firstRowId = parseInt(firstRow[0]);
        // const orgPreviousIU = firstRow[1].get('previousIU');
        //
        // // ---------------------------------------------------------
        // // pierwszy wiersz sekcji danego artikla w tabeli
        // const firstInputs = new Map();
        // const firstTr = currentInput.parents('tbody').find('tr[data-id="' + firstRowId + '"]');
        // firstInputs.set('id', parseInt(firstTr.data('id')));
        // firstTr.find('input[type="number"]').each(function () {
        //     const input = $(this);
        //     const name = input.attr('name');
        //     firstInputs.set(name, input);
        // });
        // let currentTSU = parseInt(firstInputs.get('tsu').val());
        // let currentIU = parseInt(firstInputs.get('iu').val());
        //
        // // ---------------------------------------------------------
        // let previousIU = currentIU - currentTSU + totalSU;
        //
        // //console.log(orgPreviousIU);
        // //console.log(previousIU);
        //
        // if (previousIU !== orgPreviousIU) {
        //     //
        //     currentInput.parents('tbody').find('tr[data-artid="' + articleId + '"]').each(function () {
        //         const rowStatus = $(this).find('.row-status');
        //         rowStatus.html('');
        //         rowStatus.append('<i class="text-danger bi bi-exclamation-triangle fs-5 fw-bold"></i>');
        //     });
        // } else {
        //     //
        //     currentInput.parents('tbody').find('tr[data-artid="' + articleId + '"]').each(function () {
        //         const rowStatus = $(this).find('.row-status');
        //         rowStatus.html('');
        //     });
        // }


        // ----------------------------------------------
        // ----------------------------------------------
        // ----------------------------------------------
        // // oryginalna sekcja artikla (początkowa sprzed edycji)
        // const articleSection = report.get(articleId);
        //
        // // wartości wyjściowe sprzed zmiany
        // const orgRow = articleSection.get(currentRowId);
        // const orgTSU = orgRow.get('tsu');
        // const orgIU = orgRow.get('iu');
        // const orgSU = orgRow.get('su');
        //
        // // walidacja wejść - wykrywam globalnie, koryguję tylko źródłowy input
        // if (isNaN(currentTSU) || isNaN(currentIU) || isNaN(currentSU)) {
        //     currentInput.val(orgRow.get(currentName));
        // }
        //
        // // pierwszy wiersz sekcji danego artikla
        // const firstRow = articleSection.entries().next().value;
        // const firstRowId = parseInt(firstRow[0]);
        // //console.log(firstRow);
        // const orgPreviousIU = firstRow[1].get('previousIU');
        // const orgTotalSU = firstRow[1].get('totalSU');
        //
        // // pierwszy wiersz sekcji danego artikla w tabeli
        // const firstInputs = new Map();
        // const firstTr = currentInput.parents('tbody').find('tr[data-id="' + firstRowId + '"]');
        // firstInputs.set('id', parseInt(firstTr.data('id')));
        // firstTr.find('input[type="number"]').each(function () {
        //     const input = $(this);
        //     const name = input.attr('name');
        //     firstInputs.set(name, input);
        // });
        // //console.log(firstInputs.get('id'));
        //
        // // suma 'sales unit' dla artikla (sekcji w tabeli)
        // let totalSU = 0;
        // currentInput.parents('tbody').find('tr[data-artid="' + articleId + '"]').each(function () {
        //     totalSU += parseInt($(this).find('input[name="su"]').val());
        // });
        // //console.log(orgTotalSU);
        // //console.log(totalSU);
        //
        // /**
        //  * założenia
        //  *
        //  * previousIU - stała !!!
        //  *
        //  * IU nie może być mniejsze od 0
        //  * SU nie może być mniejsze od 1
        //  *
        //  * SU nie może być większe od IU + TSU
        //  *
        //  * TSU nie może być mniejsze do IU ???
        //  *
        //  * zmiana TSU zmienia IU - wzrost->wzrost
        //  * zmiana SU zmienia IU - wzrost->spadek
        //  * zmiana IU zmienia TSU - wzrost->wzrost
        //  *
        //  * IU = previousIU + TSU - totalSU
        //  *
        //  * TSU = IU - previousIU + totalSU ????
        //  * totalSU = previousIU + TSU - UI ????
        //  *
        //  */
        //
        // let diff = 0;
        // let newVal = 0;
        // let tempTSU = 0;
        // let tempIU = 0;
        // let tempSU = 0;
        // let result = false;
        //
        // switch (currentName) {
        //     case 'tsu':
        //         tempTSU = currentTSU;
        //         diff = currentTSU - currentPrevTSU;
        //         tempIU = currentIU + diff;
        //         tempSU = currentSU;
        //         if (tempIU >= 0) {
        //             //
        //             result = true;
        //         }
        //         break;
        //     case 'iu':
        //         //console.log(currentName);
        //         // tempIU = currentIU;
        //         //
        //         // diff = currentIU - orgIU;
        //         // tempTSU = orgTSU + diff;
        //         //
        //         // tempSU = currentSU;
        //         // if(tempIU >= 0){
        //         //     result = true;
        //         // }
        //         break;
        //     case 'su':
        //         tempSU = currentSU;
        //
        //         if (tempSU >= 1) {
        //             //
        //             diff = currentSU - currentPrevSU;
        //             tempIU = currentIU - diff;
        //
        //             if(tempIU >= 0){
        //                 //
        //                 tempTSU = currentTSU;
        //                 result = true;
        //             } else {
        //                 //
        //                 tempIU = 0;
        //                 tempTSU = currentTSU + diff;
        //                 result = true;
        //             }
        //         }
        //         break;
        //     default:
        //         console.log('dupa z kota');
        // }
        // console.log(diff);
        //
        // if (result) {
        //     inputTSU.val(tempTSU);
        //     inputIU.val(tempIU);
        //     inputSU.val(tempSU);
        //     inputTSU.data('prevval', tempTSU);
        //     inputIU.data('prevval', tempIU);
        //     inputSU.data('prevval', tempSU);
        // } else {
        //     inputTSU.val(currentPrevTSU);
        //     inputIU.val(currentPrevIU);
        //     inputSU.val(currentPrevSU);
        // }
        //

        // // ----------------------------------------------
        // // --- przeliczmy całą sekcję edytowanego artikla
        //
        // // oryginalna sekcja artikla
        // const articleSection = report.get(articleId);
        //
        // // pierwszy wiersz sekcji danego artikla
        // const firstRow = articleSection.entries().next().value;
        // const firstRowId = parseInt(firstRow[0]);
        // // pierwszy input iu w tabeli dla danego artikla
        // const firstInputIU = currentInput.parents('tbody').find('tr[data-id="' + firstRowId + '"] input[name="iu"]');
        // //console.log(firstInputIU);
        //
        // let totalSU = 0; // suma 'sales unit' dla artikla (sekcji)
        // for (const [key, value] of articleSection) {
        //     //console.log(`${value}`);
        //     totalSU += value.get('su');
        // }
        // const orgTotalSU = totalSU;
        //
        // // wartości wyjściowe sprzed zmiany
        // const orgRow = articleSection.get(currentId);
        // const orgTSU = orgRow.get('tsu');
        // const orgIU = orgRow.get('iu');
        // const orgSU = orgRow.get('su');
        //
        // // walidacja jak nie numerek to oryginalny numerek
        // let currentVal = parseInt(currentInput.val());
        // if (isNaN(currentVal)) {
        //     currentVal = orgRow.get(currentName);
        //     currentInput.val(currentVal);
        // }
        //
        //
        // // założenie ogólne: zmiany na raporcie nie mogą zmienić pierwotnej wartości iu
        // let diff = 0;
        // let newVal = 0;
        //
        // const inputTSU = currentInputs.get('tsu');
        // const inputIU = currentInputs.get('iu');
        // const inputSU = currentInputs.get('su');
        //
        // switch (currentName) {
        //     // założenie: zmiana tsu wpływa bezpośrednio tylko na iu
        //     case 'tsu':
        //         diff = currentVal - orgTSU;
        //         newVal = orgIU + diff;
        //         if (newVal >= 0 && currentVal > 0) {
        //             inputIU.val(newVal);
        //         } else {
        //             inputTSU.val(orgTSU);
        //             inputIU.val(orgIU);
        //         }
        //         break;
        //     // założenie: zmiana ui wpływa bezpośrednio tylko na tsu
        //     case 'iu':
        //         diff = currentVal - orgIU;
        //         if (currentVal < 0) {
        //             inputIU.val(orgIU);
        //         }
        //         newVal = orgTSU + diff;
        //         if (newVal >= 0) {
        //             inputTSU.val(newVal);
        //         } else {
        //             inputTSU.val(orgTSU);
        //             inputIU.val(orgIU);
        //         }
        //         break;
        //     // założenie: zmiana su wpływa bezpośrednio tylko na iu
        //     case 'su':
        //         if (currentVal < 1) {
        //             inputSU.val(1);
        //         }
        //
        //         diff = currentVal - orgSU;
        //         //firstInputIU
        //         newVal = orgIU - diff;
        //         firstInputIU.val(newVal);
        //
        //         break;
        //     default:
        //         console.log('dupa z kota');
        // }
        //
        // //console.log(diff);


    });


});


