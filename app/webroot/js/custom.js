
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
    var table = $('table#dataTables').DataTable();

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
