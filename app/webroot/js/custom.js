
$(window).load(function() {
    progressBar();
});

$(document).ready(function() {

    String.prototype.stripHTML = function() {return this.replace(/<.*?>/g, '');}

    $('option').each(function(index) {
        if ($(this).val() === '') {
            $(this).attr('disabled', true);
        }
    });

    $('#VisitDistance, #VisitTransport').on('change keyup', function() {
        var distance = parseFloat($('#VisitDistance').val());
        var cost = 0;
        var transport = $('#VisitTransport').val();
        if (transport === '2') {
            cost = parseFloat($('#cost_per_km_campus').html());
        } else if (transport === '3') {
            cost = parseFloat($('#cost_per_km_outsourced').html());
        }
        $('#VisitTransportCost').val(parseFloat(cost * distance).toFixed(2));
    });

    $('.btn').on('click', function() {
        $(this).children('i').remove();
        $(this).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>'+$(this).html());
    });

    $('a').on('click', function() {
        progressBar();
    });

    // BEGIN: dataTables
    var table = $('table#dataTables').DataTable({
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
            { responsivePriority: 2, targets: -1 }
        ],
        order: [ 1, 'asc' ],
        buttons: [
            'pageLength',
            {
                extend: 'colvis',
                // text: 'Show all',
                // show: ':hidden'
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
    });

    $('#dataTables tbody')
        .on( 'mouseenter', 'td:not(.child)', function () {
            var colIdx = table.cell(this).index().column;

            $( table.cells().nodes() ).removeClass( 'highlight' );
            $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
        }
    );
    // END: dataTables

    // BEGIN: bootstrap-duallistbox
    jQuery(function($){
        if ($('#duallist').length) {
            var duallist = $('#duallist').bootstrapDualListbox({
                filterOnValues: true,
            });
            $.getJSON( lang, function( data ) {
                $('#duallist').bootstrapDualListbox('setNonSelectedListLabel', data.oLocale['nonSelectedListLabel']);
                $('#duallist').bootstrapDualListbox('setSelectedListLabel', data.oLocale['selectedListLabel']);
                $('#duallist').bootstrapDualListbox('setFilterTextClear', data.oLocale['filterTextClear']);
                $('#duallist').bootstrapDualListbox('setFilterPlaceHolder', data.oLocale['filterPlaceHolder']);
                $('#duallist').bootstrapDualListbox('setMoveAllLabel', data.oLocale['moveAllLabel']);
                $('#duallist').bootstrapDualListbox('setRemoveAllLabel', data.oLocale['removeAllLabel']);
                $('#duallist').bootstrapDualListbox('setInfoText', data.oLocale['infoText']);
                $('#duallist').bootstrapDualListbox('setInfoTextFiltered', data.oLocale['infoTextFiltered']);
                $('#duallist').bootstrapDualListbox('setInfoTextEmpty', data.oLocale['infoTextEmpty']);
                $('#duallist').bootstrapDualListbox('refresh');
            });

            $('.box1').removeClass('col-md-6').addClass('span5');
            $('.box2').removeClass('col-md-6').addClass('span5');
            $('button.move').html('<i class="fa fa-arrow-right"></i>');
            $('button.moveall').html('<i class="fa fa-arrow-right"></i>&nbsp;<i class="fa fa-arrow-right"></i>');
            $('button.remove').html('<i class="fa fa-arrow-left"></i>');
            $('button.removeall').html('<i class="fa fa-arrow-left"></i>&nbsp;<i class="fa fa-arrow-left"></i>');

            //in ajax mode, remove remaining elements before leaving page
            $(document).one('ajaxloadstart.page', function(e) {
                $('#duallist').bootstrapDualListbox('destroy');
            });
        }
    });
    // END: bootstrap-duallistbox

    // BEGIN: ajax
    $(function(){
        $('#VisitStates').change(function(){
            var state = $(this).val();
            $.ajax({
                url: $(location).attr('href'),
                type: 'GET',
                data: {"state_id": state},
                success: function(data){
                    $('#VisitCityId').children('option[value!=""]').each(function(index) {
                        $(this).remove();
                    });
                    var obj = jQuery.parseJSON(data);
                    $.each(obj, function(i,v) {
                        $('#VisitCityId').append('<option value="'+i+'">'+v+'</option>');
                    });
                },
                error: function(){

                }
            });
            return false;
        });
        $('#VisitCourse').change(function(){
            var course = $(this).val();
            $.ajax({
                url: $(location).attr('href'),
                type: 'GET',
                data: {"course_id": course},
                success: function(data){
                    $('#VisitDisciplineId').children('option[value!=""]').each(function(index) {
                        $(this).remove();
                    });
                    var obj = jQuery.parseJSON(data);
                    $.each(obj, function(i,v) {
                        $('#VisitDisciplineId').append('<option value="'+i+'">'+v+'</option>');
                    });
                },
                error: function(){

                }
            });
            return false;
        });
        $('#VisitDisciplineId').change(function(){
            var discipline = $(this).val();
            $.ajax({
                url: $(location).attr('href'),
                type: 'GET',
                data: {"discipline_id": discipline},
                success: function(data){
                    $('#VisitTeamId').children('option[value!=""]').each(function(index) {
                        $(this).remove();
                    });
                    var obj = jQuery.parseJSON(data);
                    $.each(obj, function(i,v) {
                        $('#VisitTeamId').append('<option value="'+i+'">'+v+'</option>');
                    });
                },
                error: function(){

                }
            });
            return false;
        });
    });
    // END: ajax

} );

function progressBar() {
    $('body').prepend('<div class="progress progress-striped active progress-green"><div class="bar"></div></div>');
    var w = 1;
    var id = setInterval(frame, 10);
    function frame() {
        if (w >= 99) {
            clearInterval(id);
            $(document).ready(function() {
                $('.progress').remove();
            });
        } else {
            w++;
            $('.progress .bar').css('width', w + '%');
        }
    }
}
