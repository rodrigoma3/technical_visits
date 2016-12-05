<div class="widget groups permission">
	<?php echo $this->Form->create('Group'); ?>
	<div class="widget-header">
		<h3><?php echo __('Edit permissions for ').$group['Group']['name']; ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<div id="jstree">
		</div>
		<?php
			echo $this->Form->input('allowed', array('type' => 'hidden', 'data-jstreedata' => true));
		?>
		<div class="form-actions">
			<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Form->end(); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
