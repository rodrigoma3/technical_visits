$(document).ready(function() {

    // BEGIN: dataTables
    if (lang == 'pt-br') {
        var all = 'Todos';
    } else {
        var all = 'All';
    }

    var table = $('#dataTables').DataTable({
        "language": {
            "url": langpath+lang+".json"
        },
        "scrollX": true,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, all]],
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );

        },
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        columnDefs: [{
            className: 'control',
            orderable: false,
            targets: 0
        }],
        order: [ 1, 'asc' ],
    });

    $('#dataTables tbody')
        .on( 'mouseenter', 'td:not(.child)', function () {
            var colIdx = table.cell(this).index().column;

            $( table.cells().nodes() ).removeClass( 'highlight' );
            $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
        }
    );
    // END: dataTables

} );
