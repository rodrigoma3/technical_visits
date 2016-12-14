<div class="widget visits form">
    <?php echo $this->Form->create('Visit', array(
            'inputDefaults' => array(
                'div' => array(
                    'class' => 'input span3'
                ),
                'class' => 'form-narrow',
            ),
            'class' => 'form-inline',
            'role' => 'form'
        )
    ); ?>
	<div class="widget-header">
		<h3><?php echo __('Technical visits x long and short distance'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
        <?php echo $this->Form->input('start', ['type'=>'datetime-local']); ?>
        <?php echo $this->Form->input('end', ['type'=>'datetime-local']); ?>
        <?php echo $this->Form->button(__('Filter'), array('type' => 'submit', 'class' => 'btn btn-primary btn-filter')); ?>
        <?php echo $this->Form->end(); ?>
	</div>
	<!-- /widget-content -->
</div>

<div class="widget widget-nopad">
    <div class="widget-content">
        <div class="widget big-stats-container">
            <div class="widget-content">
                <div class="wrap-chart">
                    <canvas id="chart-area" class="chart-holder" height="150" width="325" style="width: 325px; height: 150px;"></canvas>
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
                label: "<?php echo __('Technical visits x long and short distance'); ?>",
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
                text: "<?php echo __('Technical visits x long and short distance'); ?>",
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    };

    var ctx = document.getElementById("chart-area").getContext("2d");
    var myChart = new Chart(ctx, config);
</script>
