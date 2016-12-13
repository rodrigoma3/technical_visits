<div class="widget widget-nopad">
    <div class="widget-header">
        <h3> <?php echo __('Technical visits x frequency of students'); ?></h3>
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
                    <canvas id="chart-doughnut" class="chart-holder" height="150" width="325" style="width: 325px; height: 150px;"></canvas>
                </div>
            </div>
        <!-- /widget-content -->
        </div>
    </div>
</div>

<script type="text/javascript">
    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: <?php echo $data; ?>,
                backgroundColor: <?php echo $backgroundColor; ?>,
                label: "<?php echo __('Technical visits x frequency of students'); ?>",
            }],
            labels: <?php echo $labels; ?>,
        },
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: "<?php echo __('Technical visits x frequency of students'); ?>",
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    };

    var ctx = document.getElementById("chart-doughnut").getContext("2d");
    var myChart = new Chart(ctx, config);
</script>
