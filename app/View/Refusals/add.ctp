<div class="widget refusals form">
	<?php echo $this->Form->create('Refusal',['url'=>'add']); ?>
	<div class="widget-header">
		<h3><?php echo __('Add Refusal'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
		// echo $this->Form->input('date');
		echo $this->Form->input('reason', ['type'=>'textarea']);
		echo $this->Form->input('type', ['type'=>'hidden']);
		echo $this->Form->input('user_id', ['type'=>'hidden']);
		echo $this->Form->input('visit_id', ['type'=>'hidden']);
	?>
		<div class="form-actions">
					<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-success', 'div' => false)); ?>
		<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
