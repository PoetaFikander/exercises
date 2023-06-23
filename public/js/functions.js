//// ------------------- narzędzia -----

// nakładka na jquery ajax
function ax(o, url, callback, type = "POST") {

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

    jqXHR.fail(function (data) {
        console.log('ajax fail');
    });
}

//Lodash is a modern JavaScript utility library that can perform many JavaScript functionalities with very basic syntax.
const isObjectEmpty = (objectName) => {
    return _.isEmpty(objectName);
};

// wyświetla komunikaty np. ajax
function showMessage($box, message, c = 'alert alert-success') {
    $box.addClass(c);
    $box.text(message);
    $box.show("slow").delay(5000).hide("slow", () => {
        $box.text('');
        $box.removeClass(c);
    });
}

// formatuje liczby np. dodaje spacje
function digitForm(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}




//// ------------------- obsługa modala wyświetlającego zlecenie  -----

function showWorkCard(params, sourceModal = null, callback = null) {
    console.log('showWorkCard params:');
    console.log(params);

    // musi być załadowany html modala
    const workCardModalId = 'modal-workCard';
    const modalEl = document.getElementById(workCardModalId);
    const modal = new bootstrap.Modal(modalEl, {});
    const $modal = $('#' + workCardModalId);

    const $modalHeaderText = $('#modal-header-text', $modal);
    const $tab0 = $('#wc-tab-0', $modal);
    const $tab1 = $('#wc-tab-1', $modal);
    const $tab2 = $('#wc-tab-2', $modal);
    const $tab3 = $('#wc-tab-3', $modal);
    const $tab4 = $('#wc-tab-4', $modal);
    const $tab5 = $('#wc-tab-5', $modal);
    const $tab6 = $('#wc-tab-6', $modal);

    const $actionTable = $('#actionTable', $tab3);
    const actionTable = $actionTable.DataTable(
        {
            paging: false,
            autoWidth: false,
            searching: false,
            ordering: false,
            info: false,
            rowId: 'wc_id',
            columns: [
                {'data': 'action_name'},
                {'data': 'action_start_date'},
                {'data': 'action_end_date'},
                {'data': 'action_description'},
            ]
        }
    );

    const $materialTable = $('#materialTable', $tab4);
    const materialTable = $materialTable.DataTable(
        {
            paging: false,
            autoWidth: false,
            searching: false,
            ordering: false,
            info: false,
            rowId: 'wc_id',
            columns: [
                {'data': 'art_code'},
                {'data': 'art_name'},
                {'data': 'quantity_ordered'},
                {'data': 'quantity_realized'},
                {'data': 'quantity_used'},
                {'data': 'price'},
            ]
        }
    );

    const $servicelTable = $('#servicelTable', $tab5);
    const servicelTable = $servicelTable.DataTable(
        {
            paging: false,
            autoWidth: false,
            searching: false,
            ordering: false,
            info: false,
            rowId: 'wc_id',
            columns: [
                {'data': 'art_code'},
                {'data': 'art_name'},
                {'data': 'quantity'},
                {'data': 'price'},
            ]
        }
    );

    const $docTable = $('#docTable', $tab6);
    const docTable = $docTable.DataTable(
        {
            paging: false,
            autoWidth: false,
            searching: false,
            ordering: false,
            info: false,
            rowId: 'doc_id',
            columns: [
                {'data': 'doc_no'},
                {'data': 'doc_date'},
                {'data': 'cust_1_name', 'className': 'ellipis text-nowrap'},
                {'data': 'doc_net_value'},
                {'data': 'doc_state_name'},
            ]
        }
    );

    const modalClean = function () {
        console.log('modal workCard hidden');
        modalEl.removeEventListener('hidden.bs.modal', modalClean);
        modal.dispose();
        actionTable.destroy();
        materialTable.destroy();
        servicelTable.destroy();
        docTable.destroy();
        if (!!sourceModal) sourceModal.show();
    };
    modalEl.addEventListener('hidden.bs.modal', modalClean);

    ax(
        {wcId: params.wcId},
        '/ax/getWorkCard',
        function (result) {
            console.log(result);

            const h = result.header;
            h.wc_total_time = Number(h.wc_total_time).toFixed(0);
            h.wc_driving_distance = Number(h.wc_driving_distance).toFixed(0);
            h.wc_test_copies_amount = Number(h.wc_test_copies_amount).toFixed(0);
            h.wc_reaction_time = Number(h.wc_reaction_time).toFixed(0);
            h.wc_repair_time = Number(h.wc_repair_time).toFixed(0);
            h.wc_was_device_working = parseInt(h.wc_was_device_working) === 1 ? 'tak' : 'nie';
            h.wc_is_device_working = parseInt(h.wc_is_device_working) === 1 ? 'tak' : 'nie';

            const a = result.actions;
            const m = result.materials;
            const s = result.services;
            const d = result.documents;

            // ------ header
            let headerTex = '\xa0\xa0\xa0\xa0\xa0\xa0' + h.wc_no;
            headerTex += '\xa0\xa0\xa0\xa0\xa0dla:\xa0' + h.cust_name;
            $('.modal-title', $modalHeaderText).text(headerTex);
            // ------ tab0
            $tab0.find('input[type=text]').each(function () {
                    const $this = $(this);
                    $this.val(h[$this.attr('name')]);
                }
            );
            // ------ tab1
            $tab1.find('textarea').each(function () {
                    const $this = $(this);
                    $this.val(h[$this.attr('name')]);
                }
            );
            // ------ tab2
            $tab2.find('input[type=text]').each(function () {
                    const $this = $(this);
                    $this.val(h[$this.attr('name')]);
                }
            );
            // ------ tab3
            actionTable.clear();
            actionTable.rows.add(a).draw();
            // ------ tab4
            materialTable.clear();
            materialTable.rows.add(m).draw();
            // ------ tab5
            servicelTable.clear();
            servicelTable.rows.add(s).draw();
            // ------ tab6
            docTable.clear();
            docTable.rows.add(d).draw();

            //-----------------------------------------------
            modal.show();
            if (!!sourceModal) sourceModal.hide();
        }
    );

}

//// ------------------- end obsługa modala wyświetlającego zlecenie  -----




export {ax, isObjectEmpty, showMessage, digitForm, showWorkCard}


// ---------------------      testy
// function smallText(txt) {
//     return txt.toLowerCase();
// }
//
// function bigText(txt) {
//     return txt.toUpperCase();
// }
//
// function mixText(txt) {
//     return [...txt].map((el, i) => i%2 === 0 ? el.toLowerCase() : el.toUpperCase());
// }

//export { smallText, bigText, mixText }
