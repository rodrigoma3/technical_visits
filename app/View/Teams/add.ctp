<div class="widget teams form">
	<?php echo $this->Form->create('Team'); ?>
	<div class="widget-header">
		<h3><?php echo __('New Team'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<?php
			echo $this->Form->input('name');
			echo $this->Form->input('Discipline', array('id' => 'duallist', 'size' => '10'));
		?>
		<div class="form-actions">
			<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Form->end(); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
