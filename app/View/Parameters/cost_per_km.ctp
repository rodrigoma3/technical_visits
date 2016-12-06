<div class="widget parameters-cost_per_km form">
	<?php echo $this->Form->create('Parameter'); ?>
	<div class="widget-header">
		<h3><?php echo __('Edit cost per km parameters'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
				echo $this->Form->input('costPerKmCampus', array('type' => 'number', 'min' => 1, 'step' => '0.01'));
				echo $this->Form->input('costPerKmOutsourced', array('type' => 'number', 'min' => 1, 'step' => '0.01'));
			?>
		<div class="form-actions">
			<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Form->end(); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
