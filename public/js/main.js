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

    /**
     * Polish translation for bootstrap-datepicker
     * Robert <rtpm@gazeta.pl>
     */
    ;(function ($) {
        $.fn.datepicker.dates['pl'] = {
            days: ["Niedziela", "Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota"],
            daysShort: ["Niedz.", "Pon.", "Wt.", "Śr.", "Czw.", "Piąt.", "Sob."],
            daysMin: ["Ndz.", "Pn.", "Wt.", "Śr.", "Czw.", "Pt.", "Sob."],
            months: ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"],
            monthsShort: ["Sty.", "Lut.", "Mar.", "Kwi.", "Maj", "Cze.", "Lip.", "Sie.", "Wrz.", "Paź.", "Lis.", "Gru."],
            today: "Dzisiaj",
            weekStart: 1,
            clear: "Wyczyść",
            format: "dd.mm.yyyy"
        };
    }(jQuery));

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
            title: 'Usunąć raport nr ' + name + ' ?',
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
        uniXHR({data: data}, '/hpreport/customers/getsfromalt', function (data) {
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
        const data = {}; // report update data
        const invent = {}; // inventory update data
        hre_table.find('tbody > tr').each(function () {
            const tr = $(this);
            const id = parseInt(tr.data('id'));
            const i = {};
            tr.find('input[type="number"]').each(function () {
                const input = $(this);
                const name = input.attr('name');
                i[name] = parseFloat(input.val());
                // inventory update
                if (name === 'iu' && input.data('fr') === 1) {
                    invent[id] = {reportId: input.data('repid'), articleId: input.data('artid'), iu: parseFloat(input.val())}
                }
            });
            i.cid = tr.find('td > input[name="customerid"]').val();
            i.ccode = tr.children('td[data-toggle="ccode"]').text();
            i.cname = tr.children('td[data-toggle="cname"]').first().text();
            i.ctin = tr.children('td[data-toggle="ctin"]').first().text();
            i.caddr = tr.children('td[data-toggle="caddr"]').first().text();
            i.ccity = tr.children('td[data-toggle="ccity"]').first().text();
            i.czip = tr.children('td[data-toggle="czip"]').first().text();
            i.ccountry = tr.children('td[data-toggle="ccountry"]').first().text();
            i.ccontract = tr.children('td[data-toggle="ccontract"]').first().text();
            i.ccontracts = tr.children('td[data-toggle="ccontracts"]').first().text();
            i.ccontracte = tr.children('td[data-toggle="ccontracte"]').first().text();
            data[id] = i;
        });
        //console.log(data);
        uniXHR({data: data, invent: invent}, '/hpreport/reports/update', function (data) {
            const mes = $('[data-toggle=hre_reportupdatemessage]');
            mes.html('');
            mes.append('<div class="text-success text-center"><h4>Zmiany zostały zapisane.</h4></div>');
            setTimeout(() => {
                $('[data-toggle=hre_reportupdatemessage]').html('');
            }, 4000)
        });

    });


    $('[data-toggle=artInpCustomer]').click(function (e) {
        e.preventDefault();
        const $btn = $(this);
        const $modal = $('#changeCustomerModal');
        const $customerName = $('#customerName', $modal);
        const $customerTin = $('#customerTin', $modal);
        const $tbody = $('[data-toggle=hre_modalcustomertbody]', $modal);

        const $tr = $btn.parents('tr');

        const modalEl = document.querySelector('#changeCustomerModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();

        const updateCustomer = function (e) {
            let id = parseInt($(this).data('id')) ? $(this).data('id') : 0;
            if (id > 0) {
                uniXHR({id: id}, '/hpreport/customers/getfromalt', function (data) {
                    //console.log(data);
                    let c = data.customer;
                    $tr.find('td > input[name="customerid"]').val(c.customer_id);
                    $tr.find('td > input[name="customer"]').val(c.customer_code);
                    $tr.children('td[data-toggle="ccode"]').text(c.customer_code);
                    $tr.children('td[data-toggle="cname"]').text(c.customer_name);
                    $tr.children('td[data-toggle="ctin"]').text(c.customer_tin);
                    $tr.children('td[data-toggle="caddr"]').text(c.customer_address);
                    $tr.children('td[data-toggle="ccity"]').text(c.customer_city);
                    $tr.children('td[data-toggle="czip"]').text(c.customer_zipcode);
                    $tr.children('td[data-toggle="ccountry"]').text(c.customer_countrycode);
                    $tr.children('td[data-toggle="ccontract"]').text(c.contract_internal_number);
                    $tr.children('td[data-toggle="ccontracts"]').text(c.contract_start_date);
                    $tr.children('td[data-toggle="ccontracte"]').text(c.contract_end_date);
                })
            }
            modal.hide();
        };

        const findCustomer = function (e) {
            let customerData = {
                'customerName': $customerName.val(),
                'customerTin': $customerTin.val(),
            };

            uniXHR({data: customerData}, '/hpreport/customers/getsfromalt', function (data) {
                //console.log(data);
                $tbody.html('');
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
                        html += '<td><button class="btn btn-sm" data-id="' + item.altum_id + '">';
                        html += '<strong><i class="bi-plus-circle fs-5 text-success"></i></strong>';
                        html += '</button></td>';
                        html += '</tr>';
                    }
                    $tbody.append(html);
                    $($tbody).on('click', 'button', updateCustomer);
                }
            });

        };

        $('[data-toggle=hre_modalcustomerbtn]', $modal).on('click', findCustomer);

        modalEl.addEventListener('hidden.bs.modal', () => {
            $tbody.html('');
            $customerName.val('');
            $customerTin.val('');
        })

    });


    /**
     *
     * ---------------------- PROFIT
     * =====================================================================================================
     *
     */

    /**
     *
     * list.blade
     */

    if (('#deviceListProfit').length) {

        //const $pdl_form_filter = $('#pdl_form_filter');
        const $deviceListFilters = $('#deviceListFilters');

        const $table = $('#devicesListTable');
        const $tbody = $('tbody', $table);

        // DataTables init
        const dataTable = $table.DataTable(
            {
                "pageLength": 10,
                info: false,
                columns: [
                    {'data': 'dev_id'},
                    {'data': 'dev_name'},
                    {'data': 'dev_serial_no'},
                    {'data': 'customer_name', 'className': 'ellipis'},
                    {'data': 'customer_tin'},
                    {'data': 'agreement_no'},
                    {'data': 'agreement_status'},
                    {'data': 'action', 'searchable': false, 'orderable': false}
                ]
            }
        );

        $tbody.on('click', 'button', function () {
            const dev_id = parseInt($(this).data('devid'));
            const agr_id = parseInt($(this).data('agrid'));
            showDeviceProfit(dev_id, agr_id);
        });

        const showDeviceProfit = function (dev_id, agr_id) {
            //console.log(id);
            location.href = '/profits/devices/profit/' + dev_id + '/' + agr_id;
        };

        // generujemy nową zawartość tabeli
        const createTable = function (data) {
            //console.log(data);
            $tbody.off('click', 'button');

            for (let n in data) {
                let item = data[n];
                item.action = '<button type="button" class="btn btn-sm fw-bold" data-agrid="' + item.agreement_id + '" data-devid="' + item.dev_id + '"><i class="bi bi-search"></button>';
            }

            dataTable.clear();
            dataTable.rows.add(data).draw();

            $tbody.on('click', 'button', function () {
                const dev_id = parseInt($(this).data('devid'));
                const agr_id = parseInt($(this).data('agrid'));
                showDeviceProfit(dev_id, agr_id);
            })
        };

        const searchDevices = function (e) {
            //console.log($(this));
            const $inp = $('input', $deviceListFilters);
            const txtSearch = $inp.val();
            const type = $('select', $deviceListFilters).find(':selected').val();
            const activeDevice = $('#activeDevice').prop('checked');
            const activeAgreement = $('#activeAgreement').prop('checked');

            uniXHR(
                {Type: type, txtSearch: txtSearch, activeDevice: activeDevice, activeAgreement: activeAgreement},
                '/profits/devices/list', function (data) {
                    console.log(data);
                    $inp.val('');
                    createTable(data.devices);
                }
            );
        };

        $($deviceListFilters).on('click', 'button', searchDevices);
        //$($deviceListFilters).on('change', 'input:checkbox', searchDevices);

    }


    /**
     *
     * profit.blade
     */

    if ($('#deviceProfit').length) {

        const $workCardTable = $('#workCardTable');
        const $docTable = $('#docTable');
        const $artTable = $('#artTable');
        const $FSTable = $('#FSTable');
        const $FSContentsTable = $('#FSContentsTable');
        const $FSContentsSumTable = $('#FSContentsSumTable');

        // DataTables init
        const workCardDataTable = $workCardTable.DataTable(
            {
                "pageLength": 10,
                info: true,
                columns: [
                    //{'data': 'wc_id'},
                    {'data': 'wc_number'},
                    {'data': 'wc_employees'},
                    {'data': 'wc_register_date'}
                ]
            }
        );
        workCardDataTable.clear().draw();

        const docTable = $docTable.DataTable(
            {
                "pageLength": 10,
                info: true,
                columns: [
                    {'data': 'zl_no', 'className': 'col-1'},
                    {'data': 'zs_no', 'className': 'col-1'},
                    {'data': 'wz_no', 'className': 'col-1'},
                    {'data': 'fs_no', 'className': 'col-1'}
                ]
            }
        );
        docTable.clear().draw();

        const artTable = $artTable.DataTable(
            {
                "pageLength": 10,
                info: true,
                columns: [
                    {'data': 'doc_date'},
                    {'data': 'doc_no'},
                    {'data': 'art_code', 'className': 'text-nowrap'},
                    {'data': 'art_name', 'className': 'ellipis'},
                    {'data': 'item_quantity', 'className': 'text-end'},
                    {'data': 'item_purchase_price', 'className': 'text-end'},
                    {'data': 'item_purchase_value', 'className': 'text-end'}
                ]
            }
        );
        artTable.clear().draw();

        const FSTable = $FSTable.DataTable(
            {
                "pageLength": 10,
                info: true,
                columns: [
                    {'data': 'doc_id'},
                    {'data': 'doc_number_string'},
                    {'data': 'doc_date'},
                    {'data': 'doc_net_value', 'className': 'text-end'}
                ]
            }
        );
        FSTable.clear().draw();

         const FSContentsTable = $FSContentsTable.DataTable(
            {
                "pageLength": 10,
                info: true,
                order: [[2, 'asc']],
                columns: [
                    {'data': 'doc_item_no'},
                    {'data': 'doc_date'},
                    {'data': 'doc_no'},
                    {'data': 'art_code'},
                    {'data': 'art_name', 'className': 'ellipis'},
                    {'data': 'item_quantity', 'className': 'text-end'},
                    {'data': 'item_price', 'className': 'text-end'},
                    {'data': 'item_value', 'className': 'text-end'},
                    {'data': 'dev_counter', 'className': 'text-end'},
                    {'data': 'service_company_unit_name'}
                ]
            }
         );
        FSContentsTable.clear().draw();

        const FSContentsSumTable = $FSContentsSumTable.DataTable(
            {
                "pageLength": 10,
                info: true,
                columns: [
                    {'data': 'art_code'},
                    {'data': 'art_name', 'className': 'ellipis'},
                    {'data': 'item_quantity', 'className': 'text-end'},
                    {'data': 'item_value', 'className': 'text-end'},
                ]
            }
        );
        FSContentsSumTable.clear().draw();


        const $btn = $('#btnShowProfit');
        const $dateFrom = $('#profitDateFrom');
        const $dateTo = $('#profitDateTo');
        $dateFrom.datepicker({'language': 'pl'});
        $dateTo.datepicker({'language': 'pl'});

        const showProfit = function (data) {
            console.log(data);

            const workCards = data.results.workCards;
            for (let n in workCards) {
                let item = workCards[n];
                item.wc_number = '<button type="button" class="border-0" data-doc="zl" data-id="' + item.wc_id + '">' + item.wc_number + '</button>';
            }
            workCardDataTable.clear();
            workCardDataTable.rows.add(workCards).draw();

            const agrWZ = data.results.agrWZ;
            for (let n in agrWZ) {
                let item = agrWZ[n];
                if (item.zl_id > 0) {
                    item.zl_no = '<button type="button" class="border-0" data-doc="zl" data-id="' + item.zl_id + '">' + item.zl_no + '</button>';
                }
                if (item.zs_id > 0) {
                    item.zs_no = '<button type="button" class="border-0" data-doc="zs" data-id="' + item.zs_id + '">' + item.zs_no + '</button>';
                }
                if (item.wz_id > 0) {
                    item.wz_no = '<button type="button" class="border-0" data-doc="wz" data-id="' + item.wz_id + '">' + item.wz_no + '</button>';
                }
                if (item.fs_id > 0) {
                    item.fs_no = '<button type="button" class="border-0" data-doc="fs" data-id="' + item.fs_id + '">' + item.fs_no + '</button>';
                }
            }
            docTable.clear();
            docTable.rows.add(agrWZ).draw();

            const agrWZitems = data.results.agrWZitems;
            artTable.clear();
            artTable.rows.add(agrWZitems).draw();

            const agrFS = data.results.agrFS;
            FSTable.clear();
            FSTable.rows.add(agrFS).draw();

            const agrFSitems = data.results.agrFSitems;
            for (let n in agrFSitems) {
                let item = agrFSitems[n];
                item.item_quantity = Number(item.item_quantity).toFixed(2);
                item.item_value = Number(item.item_value).toFixed(2);
                item.item_price = Number(item.item_price).toFixed(4);
                item.item_purchase_value = Number(item.item_purchase_value).toFixed(2);
                item.item_purchase_price = Number(item.item_purchase_price).toFixed(4);
            }
            FSContentsTable.clear();
            FSContentsTable.rows.add(agrFSitems).draw();

            const agrFSsummary = data.results.agrFSsummary;
            for (let n in agrFSsummary) {
                let item = agrFSsummary[n];
                item.item_quantity = Number(item.item_quantity).toFixed(2);
                item.item_value = Number(item.item_value).toFixed(2);
            }
            FSContentsSumTable.clear();
            FSContentsSumTable.rows.add(agrFSsummary).draw();


            $("#overlay-spinner").fadeOut(300);
        };

        const getProfit = function () {
            const devId = parseInt($btn.data('devid')) ? parseInt($btn.data('devid')) : 0;
            const agrId = parseInt($btn.data('agrid')) ? parseInt($btn.data('agrid')) : 0;
            const dateFrom = $dateFrom.val();
            const dateTo = $dateTo.val();
            const o = {
                devId: devId,
                agrId: agrId,
                dateFrom: dateFrom,
                dateTo: dateTo
            };
            $("#overlay-spinner").fadeIn(300);
            uniXHR(o, '/profits/devices/profit', showProfit);
        };

        $($btn).on('click', getProfit);

    }


});


