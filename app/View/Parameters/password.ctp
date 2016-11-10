<div class="widget parameters-password form">
	<?php echo $this->Form->create('Parameter'); ?>
	<div class="widget-header">
		<h3><?php echo __('Edit password parameters'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
				echo $this->Form->input('size', array('type' => 'number', 'min' => 4, 'max' => 20));
				echo $this->Form->input('uppercase', array('type' => 'checkbox'));
				echo $this->Form->input('number', array('type' => 'checkbox'));
				echo $this->Form->input('symbol', array('type' => 'checkbox'));
			?>
		<div class="form-actions">
			<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
