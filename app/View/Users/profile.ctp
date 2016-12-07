<div class="widget users form">
	<?php echo $this->Form->create('User'); ?>
	<div class="widget-header">
		<h3><?php echo __('Edit User'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('name');
			echo $this->Form->input('email');
			echo $this->Form->input('current_password', array('type' => 'password'));
			echo $this->Form->input('password', array('placeholder' => 'If you do not change leave blank.'));
			echo $this->Form->input('confirm_password', array('type' => 'password'));
			echo $this->Form->input('group', array('disabled' => true));
		?>
		<div class="form-actions">
			<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Form->end(); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
