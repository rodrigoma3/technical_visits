
$(document).ready(function() {
    // var locale = [];
    // $.getJSON( lang, function( data ) {
    //     json = JSON.stringify(data.oLocale); //convert to json string
    //     // console.log(json);
    //     locale = $.parseJSON(json); //convert to javascript array
    //     // console.log(locale['All']);
    // });

    // BEGIN: dataTables
    var table = $('table#dataTables').DataTable({
        "language": {
            "url": lang
        },
        "scrollX": true,
        "lengthMenu": [10, 25, 50, -1],
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

            $.getJSON( lang, function( data ) {
                $('select[name=dataTables_length] option[value=-1]').html(data.oLocale['All']);
            });
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
            // if (true) {
            //
            // }
            var colIdx = table.cell(this).index().column;

            $( table.cells().nodes() ).removeClass( 'highlight' );
            $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
        }
    );
    // END: dataTables




} );
