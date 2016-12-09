<div class="widget cities form">
	<?php echo $this->Form->create('City'); ?>
	<div class="widget-header">
		<h3><?php echo __('Edit Cities Short Distance'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<?php
			echo $this->Form->input('cities', array('label' => false, 'id' => 'duallist', 'size' => '10', 'multiple' => true));
		?>
		<div class="form-actions">
			<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Form->end(); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
