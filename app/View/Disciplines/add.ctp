<div class="widget disciplines form">
	<?php echo $this->Form->create('Discipline'); ?>
	<div class="widget-header">
		<h3><?php echo __('Add Discipline'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
		echo $this->Form->input('name');
		echo $this->Form->input('academic_period');
		echo $this->Form->input('course_id');
		echo $this->Form->input('Team');
	?>
		<div class="form-actions">
					<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-success', 'div' => false)); ?>
		<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
