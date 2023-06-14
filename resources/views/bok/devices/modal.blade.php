<div class="modal" tabindex="-1" id="modal-bok-updateInstallationAddress">
    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Adres instalacji urządzenia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="d-inline-block col-md-12">
                        <div class="input-group">
                            <label class="input-group-text">Urządzenie&nbsp;</label>
                            <input type="text" class="form-control" name="devName" value="" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="d-inline-block col-md-12 mt-2">
                        <div class="input-group">
                            <label class="input-group-text">Kontrahent&nbsp;</label>
                            <input type="text" class="form-control" name="custName" value="" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="d-inline-block col-md-12 mt-2">
                        <div class="input-group">
                            <label class="input-group-text">Nowy adres</label>
                            <input type="text" class="form-control" name="devAddress" data-addrId=""  data-agrItemId="" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="table-responsive mt-3 pt-1">
                        <table class="table table-striped table-sm table-hover" id="addressTable">
                            <thead>
                            <tr>
                                <th scope="col">Typ adresu</th>
                                <th scope="col">Adres domyślny</th>
                                <th scope="col">Kod</th>
                                <th scope="col">Miasto</th>
                                <th scope="col">Ulica</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                <button type="button" class="btn btn-primary" name="save">Zapisz zmiany</button>
            </div>
        </div>
    </div>
</div>
