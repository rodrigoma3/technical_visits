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
		<h3><?php echo __('Course x mileage'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
        <?php echo $this->Form->input('start', ['type'=>'datetime-local']); ?>
        <?php echo $this->Form->input('end', ['type'=>'datetime-local']); ?>
        <?php echo $this->Form->input('order', ['div' => ['class' => 'input span4']]); ?>
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
            label: "<?php echo __('Mileage'); ?>",
            data: <?php echo $data; ?>,
            backgroundColor: <?php echo $backgroundColor; ?>,
            borderWidth: 1
        }]
    },
    options: {
        title: {
            display: true,
            text: "<?php echo __('Course x mileage'); ?>",
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
