<div class="widget teams form">
	<?php echo $this->Form->create('Team'); ?>
	<div class="widget-header">
		<h3><?php echo __('Add Team'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
		echo $this->Form->input('name');
		echo $this->Form->input('Discipline');
	?>
		<div class="form-actions">
					<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-success', 'div' => false)); ?>
		<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
