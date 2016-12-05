<div class="widget parameters-email form">
	<?php echo $this->Form->create('Parameter'); ?>
	<div class="widget-header">
		<h3><?php echo __('Edit email parameters'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
				echo $this->Form->input('host');
				echo $this->Form->input('port', array('type' => 'number', 'min' => 1));
				echo $this->Form->input('tls', array('type' => 'checkbox'));
				echo $this->Form->input('ssl', array('type' => 'checkbox'));
				echo $this->Form->input('timeout', array('type' => 'number', 'min' => 1));
				echo $this->Form->input('username');
				echo $this->Form->input('password', array('placeholder' => __('Enter here to change the password.')));
				echo $this->Form->input('fromName');
				echo $this->Form->input('fromEmail', array('type' => 'email'));
				echo $this->Form->input('replyTo');
			?>
		<div class="form-actions">
			<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Form->end(); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
			<!-- Button to trigger modal -->
			<?php echo $this->Html->link(__('Test'), '#testEmailSending', array('class' => 'btn btn-info', 'role' => 'button', 'data-toggle' => 'modal')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

<!-- Modal -->
<div id="testEmailSending" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="testEmailSendingLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="testEmailSendingLabel"><?php echo __('Test email sending'); ?></h3>
	</div>
	<div class="modal-body">
		<?php
			echo $this->Form->create('Parameter', array('type' => 'get'));
			echo $this->Form->input('to', array('type' => 'email'));
		 ?>
	</div>
	<div class="modal-footer">
		<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-success', 'div' => false)); ?>
		<?php echo $this->Form->end(); ?>
		<?php echo $this->Form->button(__('Close'), array('data-dismiss' => 'modal', 'aria-hidden' => 'true', 'class' => 'btn')); ?>
	</div>
</div>
