var visibilityFalse = [];

$(document).ready(function() {

    $.extend( true, $.fn.dataTable.defaults, {
        "language": {
            "url": lang
        },
        "scrollX": true,
        "lengthMenu": [[10, 25, 50, -1], ["10", "25", "50", function ( dt, button, config ) { return dt.i18n( 'oLocale.all', 'All' ); }]],
        initComplete: function () {
            var qtdColumns = this.api().columns().count();
            this.api().columns().every( function () {
                var column = this;
                if (column.index() !== 0 && column.index() !== (qtdColumns-1)) {
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
                    var texts = [];
                    column.data().unique().sort().each( function ( d, j ) {
                        var i = d.stripHTML();
                        if (texts.indexOf(i) === -1) {
                            texts.push(i);
                            select.append( '<option value="'+i+'">'+i+'</option>' );
                        }
                    } );
                }
            } );
        },
        colReorder: true,
        dom: 'Bfrtip',
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        columnDefs: [
            {
                className: 'control',
                orderable: false,
                targets: 0
            },
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: -1 },
            {
                targets: visibilityFalse,
                visible: false
            }
        ],
        order: [ 1, 'asc' ],
        buttons: [
            'pageLength',
            {
                extend: 'colvis',
                columns: ':not(:first-child)+:not(:last-child)',
                postfixButtons: [
                    'colvisRestore',
                    {
                        extend: 'colvisGroup',
                        text: function ( dt, button, config ) {
                            return dt.i18n( 'oLocale.showAll', 'Show all' );
                        },
                        show: ':hidden'
                    },
                    {
                        extend: 'colvisGroup',
                        text: function ( dt, button, config ) {
                            return dt.i18n( 'oLocale.showNone', 'Show none' );
                        },
                        hide: ':visible,:hidden'
                    }
                ],
                // collectionLayout: 'fixed three-column'
            },
            {
                extend: 'collection',
                text: function ( dt, button, config ) {
                    return dt.i18n( 'oLocale.export', 'Export' );
                },
                autoClose: true,
                buttons: [
                    {
                        extend: 'copy',
                        target: ':visible',
                        exportOptions: {
                            columns: ':not(:last-child)+:not(:last-child)',
                        }
                    },
                    {
                        extend: 'csv',
                        target: ':visible',
                        exportOptions: {
                            columns: ':not(:last-child)+:not(:last-child)',
                        }
                    },
                    {
                        extend: 'excel',
                        target: ':visible',
                        exportOptions: {
                            columns: ':not(:last-child)+:not(:last-child)',
                        }
                    },
                    {
                        extend: 'pdf',
                        target: ':visible',
                        exportOptions: {
                            columns: ':not(:last-child)+:not(:last-child)',
                        }
                    },
                    {
                        extend: 'print',
                        target: ':visible',
                        exportOptions: {
                            columns: ':not(:last-child)+:not(:last-child)',
                        }
                    }
                ]
            },
            {
                text: function ( dt, button, config ) {
                    return dt.i18n( 'oLocale.resetColReorder', 'Reset column order' );
                },
                action: function ( e, dt, node, config ) {
                    dt.colReorder.reset();
                }
            }
        ],
    } );
});
