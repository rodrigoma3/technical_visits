<div class="widget states form">
	<?php echo $this->Form->create('State'); ?>
	<div class="widget-header">
		<h3><?php echo __('Add State'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
		echo $this->Form->input('name');
	?>
		<div class="form-actions">
					<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-success', 'div' => false)); ?>
		<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
