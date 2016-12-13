<div class="widget widget-nopad">
    <div class="widget-header"> <i class="icon-fa fa fa-list-alt"></i>
        <h3> <?php echo __("Today's Stats"); ?></h3>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <div class="widget big-stats-container">
            <div class="widget-content">
                <h6 class="bigstats">
                    <?php echo __('Count of technical visits registered by status.'); ?>
                    <br>
                    <?php echo __('Mouse over statistics to see the status.'); ?>
                </h6>
                <div id="big_stats" class="cf">
                    <?php foreach ($stats as $stat): ?>
                        <div class="stat" title="<?php echo $stat['title']; ?>"> <i><?php echo $stat['percent']; ?></i> <span class="value"><?php echo $stat['quantity']; ?></span> </div>
                    <?php endforeach; ?>
                    <!-- .stat -->
                </div>
            </div>
        <!-- /widget-content -->
        </div>
    </div>
</div>

<div class="widget widget-nopad">
    <div class="widget-content">
        <div class="widget big-stats-container">
            <div class="widget-content">
                <div class="stats-box-title"><?php echo __('Technical visits by status'); ?></div>
                <div class="stats-box-all-info"><i class="icon-fa fa"></i><?php echo __('Total:'); ?> <?php echo array_sum(Set::classicExtract($stats, '{n}.quantity')); ?></div>
                <div class="wrap-chart">
                    <canvas id="visitsByStatus" class="chart-holder" height="150" width="325" style="width: 325px; height: 150px;"></canvas>

                </div>

            </div>
        <!-- /widget-content -->
        </div>
    </div>
</div>


<script>
var ctx = document.getElementById("visitsByStatus");
var visitsByStatus = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(Set::classicExtract($stats, '{n}.title')); ?>,
        datasets: [{
            label: "<?php echo __('Technical Visits'); ?>",
            data: <?php echo json_encode(Set::classicExtract($stats, '{n}.quantity')); ?>,
            backgroundColor: <?php echo json_encode(Set::classicExtract($stats, '{n}.backgroundColor')); ?>,
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

// $(document).ready(function() {
//
//     $('#fullcalendar').fullCalendar({
//         header: {
//             left: 'prev,next today',
//             center: 'title',
//             right: 'month,agendaWeek,agendaDay,listWeek'
//         },
//         defaultDate: '2016-12-12',
//         navLinks: true, // can click day/week names to navigate views
//         editable: true,
//         eventLimit: true, // allow "more" link when too many events
//         events: [
//             {
//                 title: 'All Day Event',
//                 start: '2016-12-01'
//             },
//             {
//                 title: 'Long Event',
//                 start: '2016-12-07',
//                 end: '2016-12-10'
//             },
//             {
//                 id: 999,
//                 title: 'Repeating Event',
//                 start: '2016-12-09T16:00:00'
//             },
//             {
//                 id: 999,
//                 title: 'Repeating Event',
//                 start: '2016-12-16T16:00:00'
//             },
//             {
//                 title: 'Conference',
//                 start: '2016-12-11',
//                 end: '2016-12-13'
//             },
//             {
//                 title: 'Meeting',
//                 start: '2016-12-12T10:30:00',
//                 end: '2016-12-12T12:30:00'
//             },
//             {
//                 title: 'Lunch',
//                 start: '2016-12-12T12:00:00'
//             },
//             {
//                 title: 'Meeting',
//                 start: '2016-12-12T14:30:00'
//             },
//             {
//                 title: 'Happy Hour',
//                 start: '2016-12-12T17:30:00'
//             },
//             {
//                 title: 'Dinner',
//                 start: '2016-12-12T20:00:00'
//             },
//             {
//                 title: 'Birthday Party',
//                 start: '2016-12-13T07:00:00'
//             },
//             {
//                 title: 'Click for Google',
//                 url: 'http://google.com/',
//                 start: '2016-12-28'
//             }
//         ]
//     });
//
// });
</script>
