<div class="widget parameters-cost_per_km form">
	<?php echo $this->Form->create('Parameter'); ?>
	<div class="widget-header">
		<h3><?php echo __('Edit cost per km parameters'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
				echo $this->Form->input('cost_per_km', array('type' => 'number', 'min' => 1, 'step' => '0.01'));
			?>
		<div class="form-actions">
			<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
