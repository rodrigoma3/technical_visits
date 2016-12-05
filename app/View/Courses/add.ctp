<div class="widget courses form">
	<?php echo $this->Form->create('Course'); ?>
	<div class="widget-header">
		<h3><?php echo __('Add Course'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
		echo $this->Form->input('name');
		echo $this->Form->input('type_of_academic_period');
		echo $this->Form->input('amount_of_academic_periods', array('min' => 1, 'value' => 1));
	?>
		<div class="form-actions">
			<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Form->end(); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
