<div class="widget users permission">
	<?php echo $this->Form->create('User'); ?>
	<div class="widget-header">
		<h3><?php echo __('Edit permissions for ').$user['User']['name']; ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<?php
			foreach ($actions as $action) {
				echo $this->Form->input('perms.'.$action, array('options' => $perms, 'default' => '2'));
			}
		?>
		<div class="form-actions">
			<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
