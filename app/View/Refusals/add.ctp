<div class="widget refusals form">
	<?php echo $this->Form->create('Refusal', ['url' => 'add']); ?>
	<div class="widget-header">
		<h3><?php echo __('New Refusal'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
				echo $this->Form->input('reason');
				echo $this->Form->input('type', ['type'=>'hidden']);
				echo $this->Form->input('visit_id', ['type'=>'hidden']);
			?>
		<div class="form-actions">
			<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-success', 'div' => false, 'confirm' => __('Are you sure you want to continue?'))); ?>
			<?php echo $this->Form->end(); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
