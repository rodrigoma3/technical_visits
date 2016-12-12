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

<!-- <div class="info-box">
    <div class="row-fluid stats-box">
        <div class="span12">
            <div class="stats-box-title">Visits by status</div>
            <div class="stats-box-all-info"><i class="icon-fa fa"></i><?php echo __('Total:'); ?> 555K</div>
            <div class="wrap-chart">
                <div class="chart" style="padding: 0px; position: relative;">
                    <canvas id="bar-chart1" class="chart-holder" height="150" width="325" style="width: 325px; height: 150px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="widget widget-nopad">
    <div class="widget-content">
        <div class="widget big-stats-container">
            <div class="widget-content">
                <div class="stats-box-title">Visits by status</div>
                <div class="stats-box-all-info"><i class="icon-fa fa"></i><?php echo __('Total:'); ?> 555K</div>
                <div class="wrap-chart">
                    <canvas id="myChart" class="chart-holder" height="150" width="325" style="width: 325px; height: 150px;"></canvas>

                </div>

            </div>
        <!-- /widget-content -->
        </div>
    </div>
</div>

<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
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
</script>
