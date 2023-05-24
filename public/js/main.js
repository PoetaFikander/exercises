// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });

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

    const uniXHR = function (o, url, callback, type = "POST") {
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

    const digitForm = function (x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    };

    //Lodash is a modern JavaScript utility library that can perform many JavaScript functionalities with very basic syntax.
    const isObjectEmpty = (objectName) => {
        return _.isEmpty(objectName);
    };

    const randStr = function (len) {
        let s = '';
        while (s.length < len) s += Math.random().toString(36).substr(2, len - s.length);
        return s;
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
     * ---------------------- PROFIT
     * =====================================================================================================
     */

        // ---- globals
    const $overlaySpinner = $("#overlay-spinner");


    /**
     * ------------------- dokumenty w modalach -------------------------
     */

    /**
     * --------- modal DataTable init
     */
        // ---- tabele w modalu zlecenia ------------------------------------
    const $wcActionTable = $('#wcActionTable');
    const wcActionTable = $wcActionTable.DataTable(
        {
            autoWidth: false,
            info: false,
            paging: false,
            sort: false,
            searching: false,
            columns: [
                {'data': 'action_name'},
                {'data': 'action_start_date', 'width': '130px'},
                {'data': 'action_end_date', 'width': '130px'},
                {'data': 'action_description'},
            ]
        }
    );

    const $wcMaterialTable = $('#wcMaterialTable');
    const wcMaterialTable = $wcMaterialTable.DataTable(
        {
            autoWidth: false,
            info: false,
            paging: false,
            sort: false,
            searching: false,
            columns: [
                {'data': 'art_code', className: 'text-nowrap'},
                {'data': 'art_name', className: 'ellipis'},
                {'data': 'quantity_ordered', className: 'text-end'},
                {'data': 'quantity_realized', className: 'text-end'},
                {'data': 'quantity_used', className: 'text-end'},
                {'data': 'price', className: 'text-end'},
            ]
        }
    );

    const $wcServiceTable = $('#wcServiceTable');
    const wcServiceTable = $wcServiceTable.DataTable(
        {
            autoWidth: false,
            info: false,
            paging: false,
            sort: false,
            searching: false,
            columns: [
                {'data': 'art_code', className: 'text-nowrap'},
                {'data': 'art_name', className: 'ellipis'},
                {'data': 'quantity', className: 'text-end'},
                {'data': 'price', className: 'text-end'},
            ]
        }
    );

    const $wcDocumentTable = $('#wcDocumentTable');
    const wcDocumentTable = $wcDocumentTable.DataTable(
        {
            autoWidth: false,
            info: false,
            paging: false,
            sort: false,
            searching: false,
            columns: [
                {'data': 'doc_no', className: 'text-nowrap'},
                {'data': 'doc_date'},
                {'data': 'cust_1_name'},
                {'data': 'doc_net_value', className: 'text-end'},
                {'data': 'doc_state_name'},
            ]
        }
    );
    // ---- end tabele w modalu zlecenia --------------------------------


    //---------- tabela z urządzeniami modal umowy
    const $agreementDevicesTable = $('#agreementDevicesTable');
    const agreementDevicesTable = $agreementDevicesTable.DataTable(
        {
            autoWidth: false,
            columns: [
                {'data': 'dev_name'},
                {'data': 'dev_serial_name'},
                {'data': 'dev_serial_no'},
                {'data': 'dev_status'},
            ]
        }
    );
    agreementDevicesTable.clear().draw();

    //---------- tabela ze stawkami
    const $agreementRatesTable = $('#agreementRatesTable');
    const agreementRatesTable = $agreementRatesTable.DataTable(
        {
            autoWidth: false,
            info: false,
            paging: false,
            sort: false,
            searching: false,
            columns: [
                {'data': 'rate_position'},
                {'data': 'art_code'},
                {'data': 'rate_rate', className: 'text-end'},
            ]
        }
    );
    agreementRatesTable.clear().draw();

    //---------- tabela z fakturami do umowy
    const $agreementInvoicesTable = $('#agreementInvoicesTable');
    const agreementInvoicesTable = $agreementInvoicesTable.DataTable(
        {
            autoWidth: false,
            columns: [
                {'data': 'billing_from'},
                {'data': 'billing_to'},
                {'data': 'doc_number_string'},
                {'data': 'doc_net_value', className: 'text-end'},
            ],
        }
    );
    agreementInvoicesTable.clear().draw();

    const $agreementHistoryTable = $('#agreementHistoryTable');
    const agreementHistoryTable = $agreementHistoryTable.DataTable(
        {
            autoWidth: false,
            columns: [
                {'data': 'object_type'},
                {'data': 'change_type'},
                {'data': 'additional_data'},
                {'data': 'employee_name'},
                {'data': 'date'},
            ]
        }
    );
    agreementHistoryTable.clear().draw();


    /**
     * --------- END modal DataTable init
     */


    const docHeader = function (h) {
        const header = {
            'netValue': {
                'value': h.doc_net_value,
                'label': 'Netto',
                'hidden': false
            },
            'grossValue': {
                'value': h.doc_gross_value,
                'label': 'Brutto',
                'hidden': false
            },
            'sourceNo': {
                'value': h.doc_source_no,
                'label': 'Numer obcy',
                'hidden': false
            },
            'customer1': {
                'value': '',
                'label': '',
                'hidden': false
            },
            'customer2': {
                'value': '',
                'label': '',
                'hidden': false
            },
            'date1': {
                'value': '',
                'label': '',
                'hidden': false
            },
            'date2': {
                'value': '',
                'label': '',
                'hidden': false
            },
            'date3': {
                'value': '',
                'label': '',
                'hidden': false
            },
            'store1': {
                'value': '',
                'label': '',
                'hidden': false
            },
            'store2': {
                'value': '',
                'label': '',
                'hidden': false
            },
            'paymentFormName': {
                'value': h.doc_payment_form_name,
                'label': 'Płatność',
                'hidden': false
            },
            'datePayment': {
                'value': h.doc_date_payment,
                'label': 'Termin',
                'hidden': false
            },
            'companyUnitName': {
                'value': h.company_unit_name,
                'label': 'Właściciel',
                'hidden': false
            },
            'assistant': {
                'value': h.doc_assistant,
                'label': 'Obsługujący',
                'hidden': false
            },
            'description': {
                'value': h.doc_description,
                'label': 'Opis',
                'hidden': false
            },
        };
        const docTypeId = parseInt(h.doc_types_id);
        switch (docTypeId) {
            case 5: // PW
                break;
            case 6: // RW
                break;
            case 7: // FZ
                break;
            case 8: // FS
                header.customer1.value = h.purchaser_name;
                header.customer1.label = 'Nabywca';
                header.customer2.value = h.recipient_name;
                header.customer2.label = 'Odbiorca';
                header.date1.value = h.doc_date;
                header.date1.label = 'Data wystawienia';
                header.date2.value = h.doc_date_selling;
                header.date2.label = 'Data sprzedaży';
                header.date3.hidden = true;
                header.store1.value = h.source_store_name;
                header.store1.label = 'Magazyn';
                header.store2.hidden = true;
                break;
            case 13: // ZS
                header.sourceNo.value = h.doc_source_no;
                header.sourceNo.label = 'Źródło';
                header.customer1.value = h.purchaser_name;
                header.customer1.label = 'Nabywca';
                header.customer2.value = h.recipient_name;
                header.customer2.label = 'Odbiorca';
                header.date1.value = h.doc_date;
                header.date1.label = 'Data wystawienia';
                header.date2.value = h.doc_date_purchase;
                header.date2.label = 'Data aktywacji';
                header.date3.value = h.doc_date_purchase;
                header.date3.label = 'Data realizacji';
                header.store1.value = h.doc_date_receipt;
                header.store1.label = 'Magazyn';
                header.store2.hidden = true;
                break;
            case 17: // MM+
                break;
            case 18: // MM-
                break;
            case 28: // WZ
                header.customer1.value = h.purchaser_name;
                header.customer1.label = 'Nabywca';
                header.customer2.value = h.recipient_name;
                header.customer2.label = 'Odbiorca';
                header.date1.value = h.doc_date;
                header.date1.label = 'Data wystawienia';
                header.date2.value = h.doc_date_storeope;
                header.date2.label = 'Data wydania';
                header.date3.hidden = true;
                header.store1.value = h.source_store_name;
                header.store1.label = 'Magazyn';
                header.store2.hidden = true;
                break;
            case 31: // PZ
                break;
            case 85: // ZWE
                header.sourceNo.hidden = true;
                header.customer1.hidden = true;
                header.customer2.hidden = true;
                header.store1.value = h.source_store_name;
                header.store1.label = 'Magazyn źródłowy';
                header.store2.value = h.target_store_name;
                header.store2.label = 'Magazyn docelowy';
                header.date1.value = h.doc_date;
                header.date1.label = 'Data wystawienia';
                header.date2.value = h.doc_date_storeope;
                header.date2.label = 'Data aktywacji rezerwacji';
                header.date3.value = h.doc_date_receipt;
                header.date3.label = 'Data realizacji';
                header.paymentFormName.hidden = true;
                header.datePayment.hidden = true;
                break;

            default:
                header.assistant.value = 'dupa z kota';
        }
        return header;
    };

    const getDocContents = function () {
        console.log('getDocContents');
        let id = parseInt($(this).data('id')) ? parseInt($(this).data('id')) : 0;
        let typesid = parseInt($(this).data('doctypeid')) ? parseInt($(this).data('doctypeid')) : 0;
        const o = {
            docId: id,
            docTypeId: typesid
        };
        console.log(o);
        if (id > 0) {
            uniXHR(o, '/profits/doc', showDoc);
        }
    };

    const showDoc = function (data) {
        console.log(data);
        const docTypeId = parseInt(data.docTypeId);

        switch (docTypeId) {
            case 1002:
                showWorkCard(data);
                break;
            case 1003:
                showAgreement(data);
                break;
            default:
                showAltumNativeDoc(data);
        }

    };

    const showAgreement = function (data) {
        //console.log(data);
        const h = data.doc.header;      // nagłówek dokumentu
        const p = data.doc.itemPar;    // zakładka parametry
        const r = data.doc.rates;    // zakładka parametry tabela stawki
        const d = data.doc.devices;    // tabela urządzenia
        const i = data.doc.invoices;    // tabela faktury
        const hi = data.doc.history;    // tabela historia

        const modalEl = document.querySelector('#showAgreementModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

        const $modal = $('#showAgreementModal');
        const $modalLabel = $('#showAgreementModalLabel');
        $modalLabel.text(h.agr_internal_no + ' - ' + h.agr_status_name);


        //---------- tabela z historią
        if (hi.length) {
            for (let n in hi) {
                let item = hi[n];
                //item.rate_rate = Number(item.rate_rate).toFixed(4);
            }
            agreementHistoryTable.clear();
            agreementHistoryTable.rows.add(hi).draw();
        }

        //---------- tabela z fakturami
        if (d.length) {
            for (let n in i) {
                let item = i[n];
                item.doc_net_value = Number(item.doc_net_value).toFixed(2);
                item.doc_number_string = '<button type="button" class="border-0" data-doctypeid="8" data-id="' + item.doc_id + '">' + item.doc_number_string + '</button>';
            }
            agreementInvoicesTable.clear();
            agreementInvoicesTable.rows.add(i).draw();
        }

        // ------ end odświerzanie eventów po paginacji
        agreementInvoicesTable.on('page', function () {
            console.log('page changed');
            $agreementInvoicesTable.off('click', 'button');
            $agreementInvoicesTable.on('click', 'button', getDocContents);
        });
        // ------ dodawanie eventów wyswietlających zawartość dokumentów
        $agreementInvoicesTable.off('click', 'button');
        $agreementInvoicesTable.on('click', 'button', getDocContents);


        //---------- tabela z urządzeniami
        if (d.length) {
            for (let n in d) {
                let item = d[n];
                //item.rate_rate = Number(item.rate_rate).toFixed(4);
            }
            agreementDevicesTable.clear();
            agreementDevicesTable.rows.add(d).draw();
        }

        //---------- tabela ze stawkami
        if (r.length) {
            for (let n in r) {
                let item = r[n];
                item.rate_rate = Number(item.rate_rate).toFixed(4);
            }
            agreementRatesTable.clear();
            agreementRatesTable.rows.add(r).draw();
        }


        // ---- nagłówek
        $('#externalNumber', $modal).val(h.agr_external_number);
        $('#purchaserName', $modal).val(h.agr_purchaser_name);
        $('#customerPersonName', $modal).val(h.agr_customer_person_name);
        $('#recipientName', $modal).val(h.agr_recipient_name);
        $('#recipientAddressData', $modal).val(h.agr_recipient_address_data);
        $('#employeeName', $modal).val(h.agr_employee_name);
        $('#departamentName', $modal).val(h.agr_departament_name);
        $('#vatDirectionName', $modal).val(h.agr_vat_direction_name);
        $('#formOfPaymentName', $modal).val(h.agr_form_of_payment_name);
        $('#termOfPayment', $modal).val(h.agr_term_of_payment);
        $('#dateOfStart', $modal).val(h.agr_date_of_start);
        $('#dateOfIssue', $modal).val(h.agr_date_of_issue);
        $('#dateOfEnd', $modal).val(h.agr_date_of_end);
        $('#billingFrequencyName', $modal).val(h.agr_billing_frequency_name);
        $('#agreementTypeName', $modal).val(h.agr_type_name);
        $('#agreementKindName', $modal).val(h.agr_kind_name);
        $('#agreementStatusName', $modal).val(h.agr_status_name);
        $('#billingTypeName', $modal).val(h.agr_billing_type_name);
        $('#agreementCurrencyName', $modal).val(h.agr_currency_name);
        $('#billingCurrencyName', $modal).val(h.agr_billing_currency_name);
        $('#invoiceSeriesName', $modal).val(h.agr_series_name);
        $('#printoutName', $modal).val(h.agr_print_name);
        $('#isValorization', $modal).prop('checked', !!(parseInt(h.agr_valorization)));
        $('#nextValorizationDate', $modal).val(h.agr_next_valorization_date);

        // ---- parametry --------------
        // ogólne
        $('#ServiceCompanyUnit', $modal).val(p.ServiceCompanyUnit);
        $('#DKSPerson', $modal).val(p.DKSPerson);
        $('#DKSTechPerson', $modal).val(p.DKSTechPerson);
        $('#InstallationAddress', $modal).val(p.InstallationAddress);
        $('#ClientPerson', $modal).val(p.ClientPerson);
        $('#ClientPersonToner', $modal).val(p.ClientPersonToner);
        //------ sla
        $('#ReactionTime', $modal).val(p.ReactionTime);
        $('#RepairTime', $modal).val(p.RepairTime);
        $('#ReplacementPartsKind', $modal).val(p.ReplacementPartsKind);
        $('#ClientWorkTime', $modal).val(p.ClientWorkTime);
        $('#ClientActualWorkTime', $modal).val(p.ClientActualWorkTime);
        //------ serwis
        $('#dipStatus', $modal).val(p.dipStatus);
        $('#CountersCheckType', $modal).val(p.CountersCheckType);
        $('#TestCopyAmount', $modal).val(p.TestCopyAmount);
        $('#BillingIfNoCounter', $modal).val(p.BillingIfNoCounter);
        //------ gwarancyjne
        $('#PrintAmount', $modal).val(p.PrintAmount);
        $('#CopyLimit', $modal).val(p.CopyLimit);
        $('#MonthsInCycle', $modal).val(p.MonthsInCycle);
        $('#GuaranteeDateDKS', $modal).val(p.GuaranteeDateDKS);
        $('#GuaranteeDateProducent', $modal).val(p.GuaranteeDateProducent);

        modal.show();
    };

    const showWorkCard = function (data) {

        const h = data.doc.header;      // nagłówek dokumentu
        const c = data.doc.contents;    // zawartość dokumentu
        const actions = data.doc.actions;
        const materials = data.doc.materials;
        const services = data.doc.services;
        const documents = data.doc.documents;

        const modalEl = document.querySelector('#showWorkCardModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

        const $modal = $('#showWorkCardModal');
        const $modalLabel = $('#showWorkCardModalLabel');
        $modalLabel.text(h.wc_no + ' - ' + h.service_no);

        // ---- nagłówek
        $('#statusNameInp').val(h.wc_status_name);
        $('#devNameInp').val(h.dev_name);
        $('#devSerialNoInp').val(h.dev_serial_no);
        $('#lastModificationDateInp').val(h.wc_last_modification_date);
        $('#servicePersonNameInp').val(h.wc_service_person_name);
        $('#faultTypeNameInp').val(h.wc_fault_type_name);
        $('#priorityNameInp').val(h.wc_priority_name);
        $('#typeNameInp').val(h.wc_type_name);
        $('#plannedRealizationTermInp').val(h.wc_planned_realization_term);

        // ---- opisy tab
        $('#faultDescriptionInp').val(h.wc_fault_description);
        $('#agrDescriptionInp').val(h.agr_description);

        // ---- parametry tab
        $('#wasDeviceWorking').prop('checked', !!(parseInt(h.wc_was_device_working)));
        $('#isDeviceWorking').prop('checked', !!(parseInt(h.wc_is_device_working)));
        $('#testCopiesAmount').val(h.wc_test_copies_amount);
        $('#drivingDistance').val(h.wc_driving_distance);
        $('#totalTime').val(Number(h.wc_total_time).toFixed(0));

        $('#counterReadingTypeName').val(h.wc_counter_reading_type_name);
        $('#replacementPartsName').val(h.agr_replacement_parts_name);
        $('#clientWorkTime').val(h.wc_client_work_time);
        $('#clientActualWorkTime').val(h.wc_client_actual_work_time);
        $('#warrantyProducer').val(h.wc_warranty_producer);
        $('#warrantyDks').val(h.wc_warranty_dks);
        $('#reactionTime').val(h.wc_reaction_time);
        $('#repairTime').val(h.wc_repair_time);

        // ---- czynności tab
        wcActionTable.clear();
        wcActionTable.rows.add(actions).draw();

        wcMaterialTable.clear().draw();
        if (materials.length) {
            for (let n in materials) {
                let item = materials[n];
                item.quantity_ordered = digitForm(Number(item.quantity_ordered).toFixed(2));
                item.quantity_realized = digitForm(Number(item.quantity_realized).toFixed(2));
                item.quantity_used = digitForm(Number(item.quantity_used).toFixed(2));
                item.price = digitForm(Number(item.price).toFixed(2));
            }
            //console.log(materials);
            wcMaterialTable.clear();
            wcMaterialTable.rows.add(materials).draw();
        }

        wcServiceTable.clear().draw();
        if (services.length) {
            for (let n in services) {
                let item = services[n];
                item.quantity = digitForm(Number(item.quantity).toFixed(2));
                item.price = digitForm(Number(item.price).toFixed(2));
            }
            //console.log(services);
            wcServiceTable.clear();
            wcServiceTable.rows.add(services).draw();
        }

        wcDocumentTable.clear().draw();
        if (documents.length) {
            for (let n in documents) {
                let item = documents[n];
                item.doc_net_value = digitForm(Number(item.doc_net_value).toFixed(2));
                item.doc_no = '<button type="button" class="border-0" data-doctypeid="' + item.doc_types_id + '" data-id="' + item.doc_id + '">' + item.doc_no + '</button>';
            }
            //console.log(documents);
            wcDocumentTable.clear();
            wcDocumentTable.rows.add(documents).draw();
        }

        $wcDocumentTable.on('click', 'button', getDocContents);

        modalEl.addEventListener('hidden.bs.modal', () => {
            //console.log('doc modal  element completely hidden!');
            $wcDocumentTable.off('click', 'button');
        });

        modal.show();

    };

    const showAltumNativeDoc = function (data) {
        // ---- natywne dokumety Altum
        const h = data.doc.header;      // nagłówek dokumentu
        const c = data.doc.contents;    // zawartość dokumentu

        const modalEl = document.querySelector('#showDocModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

        const $modal = $('#showDocModal');
        const $modalLabel = $('#showDocModalLabel');
        $modalLabel.text(h.doc_no);

        const doc = docHeader(h);
        //console.log(doc);

        for (let n in doc) {
            let i = doc[n];
            let $n = $('#' + n);
            if ($n.length) {
                $("label", $n).text(i.label);
                const inp = $('input', $n).length ? $('input', $n) : $('textarea', $n);
                inp.val(i.value);
                if (i.hidden) {
                    $n.addClass('d-none');
                } else {
                    $n.removeClass('d-none');
                }
            }
        }

        const $tbody = $('tbody', $modal);
        $tbody.html('');
        for (let n in c) {
            let item = c[n];
            let row = '<tr>';
            row += '<td>' + item.doc_item_no + '</td>';
            row += '<td class="text-nowrap">' + item.art_code + '</td>';
            row += '<td class="ellipis">' + item.art_name + '</td>';
            row += '<td class="text-end">' + Number(item.item_quantity).toFixed(1) + '</td>';
            row += '<td class="text-end">' + Number(item.item_price).toFixed(4) + '</td>';
            row += '<td class="text-end">' + Number(item.item_value).toFixed(2) + '</td>';
            row += '</tr>';
            $tbody.append(row);
        }

        modal.show();

    };

    /**
     *
     * END modale z dokumentami
     *
     *
     */




    /**
     * profit.blade
     */

    if ($('#profit').length) {

        const $profit = $('#profit');
        const profitType = parseInt($profit.data('type'));
        console.log('profitType: ' + profitType);

        const progressModalEl = document.querySelector('#contractProfitProgressModal');
        const progressModal = bootstrap.Modal.getOrCreateInstance(progressModalEl);
        const $progressModal = $('#contractProfitProgressModal');

        const $progressBar = $('.progress-bar', $progressModal);
        const $progressLabel = $('.progress-label', $progressModal);

        // ----- type 2
        let deviceTable = null;
        let $deviceTable = null;

        let summaryColl = null;
        let bsSummaryColl = null;

        let collapseDevice = null;
        let bsCollapseDevice = null;

        // ----- type 2
        let agreementTable = null;
        let $agreementTable = null;

        const showDeviceProfit = function () {
            const agrid = parseInt($(this).data('agrid'));
            const devid = parseInt($(this).data('devid'));
            location.href = '/profits/devices/profit/' + devid + '/' + agrid;
        };

        const showAgreementProfit = function () {
            console.log('showAgreementProfit')
        };

        if (profitType === 2) {

            summaryColl = document.getElementById('collapseSummary');
            bsSummaryColl = new bootstrap.Collapse(summaryColl, {
                toggle: false
            });
            //bsSummaryColl.show();

            // ---- akordion devices
            collapseDevice = document.querySelector('#collapseDevice');
            bsCollapseDevice = new bootstrap.Collapse(collapseDevice, {
                toggle: false
            });
            //bsCollapseDevice.show();

            $deviceTable = $('#deviceTable');
            deviceTable = $deviceTable.DataTable(
                {
                    "pageLength": 10,
                    autoWidth: false,
                    columns: [
                        {'data': 'dev_id'},
                        {'data': 'dev_name', 'className': 'ellipis text-nowrap'},
                        {'data': 'dev_serial_no'},
                        {'data': 'income_all', 'className': 'text-end'},
                        {'data': 'cost', 'className': 'text-end'},
                        {'data': 'profit', 'className': 'text-end'},
                        {'data': 'gp', 'className': 'text-end'},
                        {'data': 'action', 'className': 'text-center', 'orderable': false},
                    ],
                    // ---- dodawanie id dewajsa do <tr>
                    // "createdRow": function (row, data, dataIndex, cells) {
                    //     const firstTd = $(cells).get(0);
                    //     const id = parseInt($(firstTd).text());
                    //     $(row).attr('data-devid', id);
                    //     $(row).addClass('pointer');
                    // }
                }
            );
            deviceTable.draw();
            $deviceTable.off('click', 'button');
            $deviceTable.on('click', 'button', showDeviceProfit);
            bsCollapseDevice.show();
            bsSummaryColl.hide();
        }

        if (profitType === 3) {

            $agreementTable = $('#agreementTable');
            agreementTable = $agreementTable.DataTable(
                {
                    "pageLength": 10,
                    autoWidth: false,
                    columns: [
                        {'data': 'agr_no'},
                        {'data': 'agr_status_name', 'className': 'ellipis text-nowrap'},
                        {'data': 'agr_date_start'},
                        {'data': 'agr_date_end'},
                        {'data': 'agr_departament_name'},
                        {'data': 'income_all', 'className': 'text-end'},
                        {'data': 'cost', 'className': 'text-end'},
                        {'data': 'profit', 'className': 'text-end'},
                        {'data': 'gp', 'className': 'text-end'},
                        {'data': 'action', 'className': 'text-center', 'orderable': false},
                    ],
                    // ---- dodawanie id dewajsa do <tr>
                    // "createdRow": function (row, data, dataIndex, cells) {
                    //     const firstTd = $(cells).get(0);
                    //     const id = parseInt($(firstTd).text());
                    //     $(row).attr('data-devid', id);
                    //     $(row).addClass('pointer');
                    // }
                }
            );
            agreementTable.draw();

            // ------ odświerzanie eventów po paginacji
            $agreementTable.on('page.dt', function () {
                $(this).off('click', 'button.show-doc');
                $(this).on('click', 'button.show-doc', getDocContents);
            });
            $agreementTable.on('click', 'button.show-doc', getDocContents);
        }


        const showProfit = function (data) {
            console.log(data);

            // ------ aktualizacja danych akordeonu
            const workCards = data.results.workCards;
            for (let n in workCards) {
                let item = workCards[n];
                item.wc_number = '<button type="button" class="border-0"  data-doctypeid="1002" data-id="' + item.wc_id + '">' + item.wc_number + '</button>';
            }
            workCardDataTable.clear();
            workCardDataTable.rows.add(workCards).draw();

            const agrWZ = data.results.agrWZ;
            for (let n in agrWZ) {
                let item = agrWZ[n];
                if (item.zl_id > 0) {
                    item.zl_no = '<button type="button" class="border-0" data-doctypeid="' + item.zl_types_id + '" data-id="' + item.zl_id + '">' + item.zl_no + '</button>';
                }
                if (item.zs_id > 0) {
                    item.zs_no = '<button type="button" class="border-0" data-doctypeid="' + item.zs_types_id + '" data-id="' + item.zs_id + '">' + item.zs_no + '</button>';
                }
                if (item.wz_id > 0) {
                    item.wz_no = '<button type="button" class="border-0" data-doctypeid="' + item.wz_types_id + '" data-id="' + item.wz_id + '">' + item.wz_no + '</button>';
                }
                if (item.fs_id > 0) {
                    item.fs_no = '<button type="button" class="border-0" data-doctypeid="' + item.fs_types_id + '" data-id="' + item.fs_id + '">' + item.fs_no + '</button>';
                }
            }
            docTable.clear();
            docTable.rows.add(agrWZ).draw();

            const agrWZsummary = data.results.agrWZsummary;
            for (let n in agrWZsummary) {
                let item = agrWZsummary[n];
                item.item_quantity = Number(item.item_quantity).toFixed(0);
                item.item_value = Number(item.item_value).toFixed(2);
            }
            WZContentsSumTable.clear();
            WZContentsSumTable.rows.add(agrWZsummary).draw();

            const agrWZitems = data.results.agrWZitems;
            for (let n in agrWZitems) {
                let item = agrWZitems[n];
                item.item_quantity = Number(item.item_quantity).toFixed(0);
                item.item_value = Number(item.item_value).toFixed(2);
                item.item_price = Number(item.item_price).toFixed(2);
                item.item_purchase_value = Number(item.item_purchase_value).toFixed(2);
                item.item_purchase_price = Number(item.item_purchase_price).toFixed(2);
            }
            costTable.clear();
            costTable.rows.add(agrWZitems).draw();

            const incomeAddItems = data.results.incomeAddItems;
            for (let n in incomeAddItems) {
                let item = incomeAddItems[n];
                item.item_quantity = Number(item.item_quantity).toFixed(0);
                item.item_value = Number(item.item_value).toFixed(2);
                item.item_price = Number(item.item_price).toFixed(2);
                item.item_purchase_value = Number(item.item_purchase_value).toFixed(2);
                item.item_purchase_price = Number(item.item_purchase_price).toFixed(2);
            }
            incomeTable.clear();
            incomeTable.rows.add(incomeAddItems).draw();

            const agrFS = data.results.agrFS;
            for (let n in agrFS) {
                let item = agrFS[n];
                item.doc_net_value = Number(item.doc_net_value).toFixed(2);
                item.doc_number_string = '<button type="button" class="border-0" data-doctypeid="' + item.doc_types_id + '" data-id="' + item.doc_id + '">' + item.doc_number_string + '</button>';
                //item.action = '<button type="button" class="btn btn-outline-primary" data-doctypeid="8" data-id="' + item.doc_id + '"><i class="bi bi-search"></i></button>';
            }
            FSTable.clear();
            FSTable.rows.add(agrFS).draw();

            const agrFSitems = data.results.agrFSitems;
            for (let n in agrFSitems) {
                let item = agrFSitems[n];
                item.item_quantity = Number(item.item_quantity).toFixed(0);
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
                item.item_quantity = digitForm(Number(item.item_quantity).toFixed(0));
                item.item_value = digitForm(Number(item.item_value).toFixed(2));
            }
            FSContentsSumTable.clear();
            FSContentsSumTable.rows.add(agrFSsummary).draw();

            const summ = data.results.summary;
            for (let n in summ) {
                let item = summ[n];
                item.value = digitForm(Number(item.value).toFixed(2));
                if (item.name === 'gp') {
                    item.value = item.value + ' %';
                }
            }
            summaryTable.clear();
            summaryTable.rows.add(summ).draw();

            // ------ end aktualizacja danych akordeonu


            // ------ odświerzanie eventów po paginacji
            workCardDataTable.on('page', function () {
                console.log('page changed');
                $workCardTable.off('click', 'button');
                $workCardTable.on('click', 'button', getDocContents);
            });

            docTable.on('page', function () {
                console.log('page changed');
                $docTable.off('click', 'button');
                $docTable.on('click', 'button', getDocContents);
            });

            FSTable.on('page', function () {
                console.log('page changed');
                $FSTable.off('click', 'button');
                $FSTable.on('click', 'button', getDocContents);
            });
            // ------ end odświerzanie eventów po paginacji

            // ------ dodawanie eventów wyswietlających zawartość dokumentów
            $FSTable.on('click', 'button', getDocContents);
            // ------
            $docTable.on('click', 'button', getDocContents);
            // -----
            $workCardTable.on('click', 'button', getDocContents);

            // ---- kosmetyka
            const summaryColl = document.getElementById('collapseEight');
            const bsSummaryColl = new bootstrap.Collapse(summaryColl, {
                toggle: false
            });
            bsSummaryColl.show();
            $overlaySpinner.fadeOut(300);
        };

        const getDeviceProfit = function (parameters) {
            console.log(parameters);
            $overlaySpinner.fadeIn(300);
            uniXHR(parameters, '/profits/devices/profit', showProfit);
        };

        const getContractProfit = function (parameters) {
            console.log('getContractProfit param: ');
            console.log(parameters);

            let devQuantity = 0;
            let counter = 0;
            let progressWidth = 0;

            const counterId = randStr(32);
            parameters.counterId = counterId;

            const showModalEvent = function () {
                progressWidth = parseInt($progressBar.width()); // rzeczywista długość progressbara w px
                $progressLabel.text('0/' + devQuantity);
            };
            progressModalEl.addEventListener('shown.bs.modal', showModalEvent);

            const hideModalEvent = function () {
                uniXHR({counterId: counterId}, '/profits/contracts/brcount', function (data) {
                    //console.log(data);
                    $progressBar.width('100%');
                    $progressBar.text('');
                    progressModalEl.removeEventListener('shown.bs.modal', showModalEvent);
                    progressModalEl.removeEventListener('hide.bs.modal', hideModalEvent);
                    bsCollapseDevice.hide();
                    bsSummaryColl.show();
                });
            };
            progressModalEl.addEventListener('hide.bs.modal', hideModalEvent);

            progressModal.show();

            uniXHR({agrid: parameters.agrid}, '/profits/contracts/devices', function (data) {
                devQuantity = parseInt(data.dev.length);
                counter = devQuantity;

                uniXHR({counterId: counterId, devQuantity: devQuantity}, '/profits/contracts/setcount', function (data) {

                    uniXHR(parameters, '/profits/contracts/profit', function (data) {
                        console.log(data);
                        // ------------------------
                        const profits = data.results.profits;
                        //console.log(profits);
                        for (let n in profits) {
                            let item = profits[n];
                            item.income_all = Number(item.income_all).toFixed(2);
                            item.cost = Number(item.cost).toFixed(2);
                            item.profit = Number(item.profit).toFixed(2);
                            item.gp = Number(item.gp).toFixed(2);
                            item.action = '<button type="button" class="btn btn-sm fw-bold"  data-devid="' + item.dev_id + '" data-agrid="' + item.agr_id + '"><i class="bi bi-search"></i></button>';
                        }
                        deviceTable.clear();
                        deviceTable.rows.add(profits).draw();

                        $deviceTable.off('click', 'button');
                        $deviceTable.on('click', 'button', showDeviceProfit);

                        // ------------------------
                        const summ = data.results.summary;
                        for (let n in summ) {
                            let item = summ[n];
                            item.value = digitForm(Number(item.value).toFixed(2));
                            if (item.name === 'gp') {
                                item.value = item.value + ' %';
                            }
                        }
                        summaryTable.clear();
                        summaryTable.rows.add(summ).draw();

                    });

                });

            });

            const getCounter = function () {
                uniXHR({counterId: counterId}, '/profits/contracts/getcount', function (data) {
                    counter = parseInt(data.getCount.counter);
                });
            };

            let p = 0;
            let pPrev = 0;
            let pr = 0;

            let timer = setTimeout(function myTimer() {
                getCounter();

                if (devQuantity > 0) {
                    p = parseInt((100 - (counter * 100) / devQuantity));
                    pr = parseInt((p * progressWidth / 100));
                }

                if (p > pPrev) {
                    $progressBar.text(p + '%');
                    $progressBar.width(pr);
                    $progressLabel.text('Postęp: ' + (devQuantity - counter) + '/' + devQuantity);
                    pPrev = p;
                }

                if (counter <= 0) {
                    // --- sprzątamy
                    clearTimeout(timer);
                    progressModal.hide();
                } else {
                    timer = setTimeout(myTimer, 500);
                }
            }, 500);

        };

        const getCustomerProfit = function (parameters) {
            console.log(parameters);
            //$agreementTable.off('click', 'button.show-doc');
            //$agreementTable.on('click', 'button.show-doc', getDocContents);


        };

        const getProfit = function () {

            // czyszczonko
            $workCardTable.off('click', 'button');
            $FSTable.off('click', 'button');
            $docTable.off('click', 'button');
            //$agreementTable.off('click', 'button');
            //$('td.show-doc', $agreementTable).off('click', 'button');

            const $btn = $(this);
            const parameters = $btn.data();

            parameters.dateFrom = $dateFrom.val();
            parameters.dateTo = $dateTo.val();

            switch (parameters.profittype) {
                case 'device':
                    getDeviceProfit(parameters);
                    break;
                case 'contract':
                    getContractProfit(parameters);
                    break;
                case 'customer':
                    getCustomerProfit(parameters);
                    break;
                default:
                    console.log('dupa z kota');
            }

        };


        /**
         * -------------------------------------------------------------------------------------
         * definicje tabel akordeonu
         */

            // const $headingCustomer = $('#headingCustomer');
            // const $headingContract = $('#headingContract');
            // const $headingDevice = $('#headingDevice');
            //
            // $headingCustomer.parent().hide();
            // $headingContract.parent().hide();
            // $headingDevice.parent().hide();

            // const $customerTable = $('#customerTable');
            // const $contractTable = $('#contractTable');
            // const $deviceTable = $('#deviceTable');


        const $workCardTable = $('#workCardTable');
        const $docTable = $('#docTable');
        const $WZContentsSumTable = $('#WZContentsSumTable');
        const $costTable = $('#costTable');
        const $incomeTable = $('#incomeTable');
        const $FSTable = $('#FSTable');
        const $FSContentsTable = $('#FSContentsTable');
        const $FSContentsSumTable = $('#FSContentsSumTable');
        const $summaryTable = $('#summaryTable');

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

        const docTable = $docTable.DataTable(
            {
                "pageLength": 10,
                info: true,
                sort: false,
                columns: [
                    {'data': 'zl_no', 'className': 'col-1'},
                    {'data': 'zs_no', 'className': 'col-1'},
                    {'data': 'wz_no', 'className': 'col-1'},
                    {'data': 'fs_no', 'className': 'col-1'}
                ]
            }
        );

        const WZContentsSumTable = $WZContentsSumTable.DataTable(
            {
                "pageLength": 10,
                info: true,
                paging: true,
                sort: true,
                searching: true,
                order: [[2, 'desc']],
                columns: [
                    {'data': 'art_code'},
                    {'data': 'art_name', 'className': 'ellipis'},
                    {'data': 'item_quantity', 'className': 'text-end'},
                    {'data': 'item_value', 'className': 'text-end'},
                ]
            }
        );

        const costTable = $costTable.DataTable(
            {
                "pageLength": 10,
                info: true,
                columns: [
                    {'data': 'doc_date', 'className': 'text-nowrap'},
                    {'data': 'doc_no'},
                    {'data': 'art_code', 'className': 'text-nowrap'},
                    {'data': 'art_name', 'className': 'ellipis'},
                    {'data': 'item_quantity', 'className': 'text-end'},
                    {'data': 'item_purchase_price', 'className': 'text-end'},
                    {'data': 'item_purchase_value', 'className': 'text-end'}
                ]
            }
        );

        const incomeTable = $incomeTable.DataTable(
            {
                "pageLength": 10,
                info: true,
                columns: [
                    {'data': 'doc_date', 'className': 'text-nowrap'},
                    {'data': 'doc_no'},
                    {'data': 'art_code', 'className': 'text-nowrap'},
                    {'data': 'art_name', 'className': 'ellipis'},
                    {'data': 'item_quantity', 'className': 'text-end'},
                    {'data': 'item_purchase_price', 'className': 'text-end'},
                    {'data': 'item_purchase_value', 'className': 'text-end'}
                ]
            }
        );

        const FSTable = $FSTable.DataTable(
            {
                "pageLength": 10,
                info: true,
                columns: [
                    //{'data': 'doc_id'},
                    {'data': 'doc_number_string'},
                    {'data': 'doc_date', 'className': 'text-nowrap'},
                    {'data': 'doc_net_value', 'className': 'text-end'},
                    //{'data': 'action', 'className': 'text-center', 'orderable': false}
                ]
            }
        );

        const FSContentsTable = $FSContentsTable.DataTable(
            {
                "pageLength": 10,
                info: true,
                order: [[2, 'asc']],
                columns: [
                    {'data': 'doc_item_no'},
                    {'data': 'doc_date', 'className': 'text-nowrap'},
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

        const FSContentsSumTable = $FSContentsSumTable.DataTable(
            {
                "pageLength": 10,
                info: false,
                paging: false,
                sort: false,
                searching: false,
                columns: [
                    {'data': 'art_code'},
                    {'data': 'art_name', 'className': 'ellipis'},
                    {'data': 'item_quantity', 'className': 'text-end'},
                    {'data': 'item_value', 'className': 'text-end'},
                ]
            }
        );

        const summaryTable = $summaryTable.DataTable(
            {
                "pageLength": 10,
                info: false,
                paging: false,
                sort: false,
                searching: false,
                columns: [
                    {'data': 'name', 'className': 'text-end'},
                    {'data': 'value', 'className': 'text-end'},
                ]
            }
        );

        workCardDataTable.clear().draw();
        docTable.clear().draw();
        WZContentsSumTable.clear().draw();
        costTable.clear().draw();
        incomeTable.clear().draw();
        FSTable.clear().draw();
        FSContentsTable.clear().draw();
        FSContentsSumTable.clear().draw();
        summaryTable.clear().draw();

        /**
         * koniec definicja tabel akordeonu
         * ---------------------------------------------------------------------------
         */

        const $dateFrom = $('#profitDateFrom');
        const $dateTo = $('#profitDateTo');
        $dateFrom.datepicker({'language': 'pl'});
        $dateTo.datepicker({'language': 'pl'});

        switch (profitType) {
            case 1:
                break;
            case 2:
                //$headingDevice.parent().show();
                break;
            default:
        }

        const $btn = $('#btnShowProfit');
        $($btn).on('click', getProfit);
    }

    /**
     * ------------------- devices -------------------------
     * list.blade
     */

    if (('#deviceListProfit').length) {

        const $deviceListFilters = $('#deviceListFilters');

        const $table = $('#devicesListTable');
        const $tbody = $('tbody', $table);

        // DataTables init
        const dataTable = $table.DataTable(
            {
                "pageLength": 10,
                info: true,
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
                item.action = '<button type="button" class="btn btn-sm fw-bold" data-agrid="' + item.agreement_id + '" data-devid="' + item.dev_id + '"><i class="bi bi-search"></i></button>';
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
    }


    /**
     * ------------------- contracts -------------------------
     * list.blade
     */

    if (('#contractListProfit').length) {

        const $contractListFilters = $('#contractListFilters');
        const $table = $('#contractsListTable');
        const $tbody = $('tbody', $table);

        // DataTables init
        const dataTable = $table.DataTable(
            {
                "pageLength": 10,
                autoWidth: false,
                columns: [
                    {'data': 'agr_no'},
                    {'data': 'customer_name', 'className': ''},
                    {'data': 'agr_departament_name'},
                    {'data': 'agr_status_name'},
                    {'data': 'agr_date_start'},
                    {'data': 'agr_date_end'},
                    {'data': 'action', 'searchable': false, 'orderable': false}
                ]
            }
        );

        $tbody.on('click', 'button', function () {
            const agrId = parseInt($(this).data('agrid'));
            showContractProfit(agrId);
        });

        //
        const showContractProfit = function (agrId) {
            //console.log(id);
            //$headingDevice.parent().show();
            location.href = '/profits/contracts/profit/' + agrId;
        };

        // generujemy nową zawartość tabeli
        const createTable = function (data) {
            //console.log(data);

            $tbody.off('click', 'button');

            for (let n in data) {
                let item = data[n];
                item.action = '<button type="button" class="btn btn-sm fw-bold" data-agrid="' + item.agr_id + '"><i class="bi bi-search"></i></button>';
            }

            dataTable.clear();
            dataTable.rows.add(data).draw();

            $tbody.on('click', 'button', function () {
                const agrId = parseInt($(this).data('agrid'));
                showContractProfit(agrId);
            })
        };

        const searchContracts = function (e) {
            //console.log($(this));
            const $inp = $('#contractTxtSearch', $contractListFilters);
            const txtSearch = $inp.val();
            const type = $('#filter', $contractListFilters).find(':selected').val();
            const departmentId = $('#departments', $contractListFilters).find(':selected').val();
            const activeAgreement = $('#activeAgreement', $contractListFilters).prop('checked');
            const o = {
                Type: type,
                txtSearch: txtSearch,
                departmentId: departmentId,
                activeAgreement: activeAgreement
            };
            console.log(o);
            uniXHR(
                o,
                '/profits/contracts/list', function (data) {
                    console.log(data);
                    //$inp.val('');
                    createTable(data.contracts);
                }
            );
        };

        //
        $($contractListFilters).on('click', 'button', searchContracts);

    }


    /**
     * ------------------- customers -------------------------
     * list.blade
     */

    if (('#customerListProfit').length) {

        const $customerListFilters = $('#customerListFilters');
        const $table = $('#customersListTable');
        const $tbody = $('tbody', $table);

        //// ----DataTables init
        const dataTable = $table.DataTable(
            {
                "pageLength": 10,
                autoWidth: false,
                columns: [
                    {'data': 'customer_code', 'className': 'text-nowrap'},
                    {'data': 'customer_name', 'className': 'ellipis'},
                    {'data': 'customer_tin'},
                    {'data': 'customer_zipcode', 'className': 'text-nowrap'},
                    {'data': 'customer_city'},
                    {'data': 'customer_address', 'className': 'text-nowrap'},
                    {'data': 'action', 'searchable': false, 'orderable': false}
                ]
            }
        );

        $tbody.on('click', 'button', function () {
            const custid = parseInt($(this).data('custid'));
            const custtype = parseInt($(this).data('custtype'));
            showCustomerProfit(custid, custtype);
        });

        const showCustomerProfit = function (custid, custtype) {
            //console.log(custid);
            location.href = '/profits/customers/profit/' + custid + '/' + custtype;
        };

        // generujemy nową zawartość tabeli
        const createTable = function (data) {
            console.log(data);
            const customers = data.customers;
            const customerType = data.customerType;

            $tbody.off('click', 'button');
            for (let n in customers) {
                let item = customers[n];
                item.action = '<button type="button" class="btn btn-sm fw-bold" data-custtype="' + customerType + '" data-custid="' + item.customer_id + '"><i class="bi bi-search"></i></button>';
            }
            dataTable.clear();
            dataTable.rows.add(customers).draw();

            $tbody.on('click', 'button', function () {
                const custid = parseInt($(this).data('custid'));
                const custtype = parseInt($(this).data('custtype'));
                showCustomerProfit(custid, custtype);
            });
        };

        const searchCustomers = function (e) {
            //console.log($(this));
            const $inp = $('#customerTxtSearch', $customerListFilters);
            const txtSearch = $inp.val();
            const type = $('#filter', $customerListFilters).find(':selected').val();
            const customerType = $('#customerType', $customerListFilters).find(':selected').val();
            const o = {
                Type: type,
                txtSearch: txtSearch,
                customerType: customerType
            };
            //console.log(o);
            uniXHR(
                o,
                '/profits/customers/list', function (data) {
                    console.log(data);
                    //$inp.val('');
                    createTable(data);
                }
            );
        };
        //
        $customerListFilters.on('click', 'button', searchCustomers);

    }


});


