<div class="widget widget-nopad">
    <div class="widget-header">
        <h3> <?php echo __('Technical visits x status'); ?></h3>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <div class="widget big-stats-container">
            <div class="widget-content">
                <?php echo __('Filters soon'); ?>
            </div>
        <!-- /widget-content -->
        </div>
    </div>
</div>

<div class="widget widget-nopad">
    <div class="widget-content">
        <div class="widget big-stats-container">
            <div class="widget-content">
                <div class="wrap-chart">
                    <canvas id="chart-bar" class="chart-holder" height="150" width="325" style="width: 325px; height: 150px;"></canvas>
                </div>
            </div>
        <!-- /widget-content -->
        </div>
    </div>
</div>

<script>
var ctx = document.getElementById("chart-bar");
var chartBar = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo $labels; ?>,
        datasets: [{
            label: "<?php echo __('Technical Visits'); ?>",
            data: <?php echo $data; ?>,
            backgroundColor: <?php echo $backgroundColor; ?>,
            borderWidth: 1
        }]
    },
    options: {
        title: {
            display: true,
            text: "<?php echo __('Technical visits x status'); ?>",
        },
        responsive: true,
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
