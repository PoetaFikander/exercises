
// ----- wymagany przez Laravel dla Ajax
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// modyfikacja domyślnych klas kontrolki 'Search' w DataTable
// dataTables-search-w moja klasa dodatkowa w style.css
//$.fn.DataTable.ext.classes.sFilterInput = "form-control form-control-sm dataTables-search-w";

