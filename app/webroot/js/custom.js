
$(window).load(function() {
    progressBar();
});

$(document).ready(function() {

    String.prototype.stripHTML = function() {return this.replace(/<.*?>/g, '');}

    disabledOptionEmpty();
    $('select').on('change', function() {
        disabledOptionEmpty();
    });

    $('#VisitDistance, #VisitTransport').on('change keyup', function() {
        var distance = parseFloat($('#VisitDistance').val());
        // console.log(distance);
        var cost = 0;
        var transport = $('#VisitTransport').val();
        // console.log(transport);
        if (transport === '2') {
            cost = parseFloat($('#costPerKmCampus').html().replace('.','').replace(',','.'));
        } else if (transport === '3') {
            cost = parseFloat($('#costPerKmOutsourced').html().replace('.','').replace(',','.'));
        }
        $('#VisitTransportCost').val(parseFloat(cost * distance).toFixed(2));
    });

    $('.btn').on('click', function() {
        var elem = $(this);
        if (!elem.is('input')) {
            elem.isLoading();
            var content = elem.html();
            elem.children('i').remove();
            elem.html('<i class="fa fa-spinner fa-pulse fa-fw"></i>'+elem.html());
            $(document).ready(function() {
                setTimeout( function(){

                    // Deactivate the loading plugin
                    elem.isLoading( "hide" );

                    elem.html(content);
                }, 500 );
            });
        }
    });

    $('a').on('click', function() {
        progressBar();
    });

    $('.form-error:first').focus();

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

        $(document).on('click', '.login-extra a[data-target]', function(e) {
       		e.preventDefault();
       		var target = $(this).data('target');
       		$('.widget-box.visible').removeClass('visible');//hide others
       		$(target).addClass('visible');//show target
       	 });
    });
    // END: bootstrap-duallistbox

    // BEGIN: ajax
    $(function(){
        $('#VisitStates').change(function(){
            var state = $(this).val();
            if (state !== null) {
                $.ajax({
                    url: $(location).attr('href'),
                    type: 'GET',
                    data: {"state_id": state},
                    success: function(data){
                        $('#VisitCityId').children('option').each(function(index) {
                            if ($(this).val() != '') {
                                $(this).remove();
                            } else {
                                $(this).html($('#VisitStates').children('option[value=""]').html());
                            }
                        });
                        var obj = jQuery.parseJSON(data);
                        $.each(obj, function(i,v) {
                            $('#VisitCityId').append('<option value="'+i+'">'+v+'</option>');
                        });
                    },
                    error: function(){

                    }
                });
            }
            return false;
        });
        $('#VisitCourse').change(function(){
            var course = $(this).val();
            if (course !== null) {
                $.ajax({
                    url: $(location).attr('href'),
                    type: 'GET',
                    data: {"course_id": course},
                    success: function(data){
                        // $('#VisitDisciplineId').children('option[value!=""]').each(function(index) {
                        //     $(this).remove();
                        // });
                        $('#VisitDisciplineId').children('option').each(function(index) {
                            if ($(this).val() != '') {
                                $(this).remove();
                            } else {
                                $(this).html($('#VisitCourse').children('option[value=""]').html());
                            }
                        });
                        var obj = jQuery.parseJSON(data);
                        $.each(obj, function(i,v) {
                            $('#VisitDisciplineId').append('<option value="'+i+'">'+v+'</option>');
                        });
                        $('#VisitDisciplineId').change();
                    },
                    error: function(){

                    }
                });
            }
            return false;
        });
        $('#VisitDisciplineId').change(function(){
            var discipline = $(this).val();
            if (discipline !== null) {
                $.ajax({
                    url: $(location).attr('href'),
                    type: 'GET',
                    data: {"discipline_id": discipline},
                    success: function(data){
                        // $('#VisitTeamId').children('option[value!=""]').each(function(index) {
                        //     $(this).remove();
                        // });
                        $('#VisitTeamId').children('option').each(function(index) {
                            if ($(this).val() != '') {
                                $(this).remove();
                            } else {
                                $(this).html($('#VisitDisciplineId').children('option[value=""]').html());
                            }
                        });
                        var obj = jQuery.parseJSON(data);
                        $.each(obj, function(i,v) {
                            $('#VisitTeamId').append('<option value="'+i+'">'+v+'</option>');
                        });
                    },
                    error: function(){

                    }
                });
            }
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
                setTimeout( function() {
                    $('.progress').remove();
                }, 200);
            });
        } else {
            w++;
            $('.progress .bar').css('width', w + '%');
        }
    }
}

function disabledOptionEmpty() {
    $('option[value=""]').each(function() {
        $(this).attr('disabled', true);
    });
}
