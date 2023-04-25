export function DataTables(id,columns){
    $(document).ready(function () {
// Setup - add a text input to each footer cell
    $(id + ` thead tr`)
        .clone(true)
        .addClass('filters')
        .appendTo(id +' thead');

        let table = $(id).DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            initComplete: function () {
                let api = this.api();
    
                // For each column
                api
                    .columns(columns)
                    .eq(0)
                    .each(function (colIdx) {
                        // Set the header cell to contain the input element
                        let cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        let title = $(cell).text();
                        $(cell).html('<input type="text" placeholder="' + title + '" />');
    
                        // On every keypress in this input
                        $(
                            'input',
                            $('.filters th').eq($(api.column(colIdx).header()).index())
                        )
                            .off('keyup change')
                            .on('change', function (e) {
                                // Get the search value
                                $(this).attr('title', $(this).val());
                                let regexr = '({search})'; //$(this).parents('th').find('select').val();
    
                                let cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search(
                                        this.value != ''
                                            ? regexr.replace('{search}', '(((' + this.value + ')))')
                                            : '',
                                        this.value != '',
                                        this.value == ''
                                    )
                                    .draw();
                            })
                            .on('keyup', function (e) {
                                e.stopPropagation();
    
                                $(this).trigger('change');
                                $(this)
                                    .focus()[0]
                                    .setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });
            },
        });
    });
}