<div class="widget disciplinesTeams view">
	<div class="widget-header">
		<h3><?php echo __('Disciplines Team'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<dl>
					<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($disciplinesTeam['DisciplinesTeam']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Team'); ?></dt>
		<dd>
			<?php echo $this->Html->link($disciplinesTeam['Team']['name'], array('controller' => 'teams', 'action' => 'view', $disciplinesTeam['Team']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discipline'); ?></dt>
		<dd>
			<?php echo $this->Html->link($disciplinesTeam['Discipline']['name'], array('controller' => 'disciplines', 'action' => 'view', $disciplinesTeam['Discipline']['id'])); ?>
			&nbsp;
		</dd>
		</dl>
		<div class="form-actions">
					<?php echo $this->Html->link(__('List Disciplines Teams'), array('action' => 'index'), array('class' => 'btn btn-success')); ?>
		<?php echo $this->Html->link(__('Edit Disciplines Team'), array('action' => 'edit', $disciplinesTeam['DisciplinesTeam']['id']), array('class' => 'btn')); ?>
		<?php echo $this->Form->postLink(__('Delete Disciplines Team'), array('action' => 'delete', $disciplinesTeam['DisciplinesTeam']['id']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $disciplinesTeam['DisciplinesTeam']['id']))); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

