<div class="widget disciplinesTeams form">
	<?php echo $this->Form->create('DisciplinesTeam'); ?>
	<div class="widget-header">
		<h3><?php echo __('Edit Disciplines Team'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
		echo $this->Form->input('id');
		echo $this->Form->input('team_id');
		echo $this->Form->input('discipline_id');
	?>
		<div class="form-actions">
					<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-success', 'div' => false)); ?>
		<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
