<div class="widget courses form">
	<?php echo $this->Form->create('Course'); ?>
	<div class="widget-header">
		<h3><?php echo __('Edit Course'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('type_of_academic_period');
		echo $this->Form->input('amount_of_academic_periods', array('min' => $maxAcademicPeriod));
	?>
		<div class="form-actions">
			<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Form->end(); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
