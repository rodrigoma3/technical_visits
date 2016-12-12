<div class="widget disciplines view">
	<div class="widget-header">
		<h3><?php echo __('Discipline'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($discipline['Discipline']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($discipline['Discipline']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Academic Period'); ?></dt>
		<dd>
			<?php echo h($discipline['Discipline']['academic_period']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Course'); ?></dt>
		<dd>
			<?php if ($perms['CoursesView']): ?>
				<?php echo $this->Html->link($discipline['Course']['name'], array('controller' => 'courses', 'action' => 'view', $discipline['Course']['id'])); ?>
			<?php else: ?>
				<?php echo h($discipline['Course']['name']); ?>
				&nbsp;
			<?php endif; ?>
		</dd>
		</dl>
		<div class="form-actions">
			<?php if ($perms['DisciplinesIndex']): ?>
				<?php echo $this->Html->link(__('List Disciplines'), array('action' => 'index'), array('class' => 'btn btn-success')); ?>
			<?php endif; ?>
			<?php if ($perms['DisciplinesEdit']): ?>
				<?php echo $this->Html->link(__('Edit Discipline'), array('action' => 'edit', $discipline['Discipline']['id']), array('class' => 'btn')); ?>
			<?php endif; ?>
			<?php if (empty($discipline['Visit']) && empty($discipline['Team']) && $perms['DisciplinesDelete']): ?>
				<?php echo $this->Form->postLink(__('Delete Discipline'), array('action' => 'delete', $discipline['Discipline']['id']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $discipline['Discipline']['id']))); ?>
			<?php endif; ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

<div class="widget disciplines view related">
	<div class="widget-header">
		<h3><?php echo __('Related Teams'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<table id="dataTables" class="display nowrap">
			<thead>
				<tr>
					<th></th>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th></th>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($discipline['Team'] as $team): ?>
					<tr>
						<td></td>
						<td><?php echo $team['id']; ?></td>
						<td><?php echo $team['name']; ?></td>
						<td class="actions">
							<?php if ($perms['TeamsView']): ?>
								<?php echo $this->Html->link('<i class="fa fa-lg fa-eye"></i>&nbsp;', array('controller' => 'teams', 'action' => 'view', $team['id']), array('escape' => false, 'title' => 'View')); ?>
							<?php endif; ?>
							<?php if ($perms['TeamsEdit']): ?>
								<?php echo $this->Html->link('<i class="fa fa-lg fa-pencil"></i>&nbsp;', array('controller' => 'teams', 'action' => 'edit', $team['id']), array('escape' => false, 'title' => 'Edit')); ?>
							<?php endif; ?>
							<?php if (empty($team['Visit']) && $perms['TeamsDelete']): ?>
								<?php echo $this->Form->postLink('<i class="fa fa-lg fa-trash"></i>&nbsp;', array('controller' => 'teams', 'action' => 'delete', $team['id']), array('escape' => false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # %s?', $team['id']))); ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php if ($perms['TeamsAdd']): ?>
			<div class="form-actions">
				<?php echo $this->Html->link(__('New Team'), array('controller' => 'teams', 'action' => 'add'), array('class' => 'btn btn-success')); ?>
			</div>
		<?php endif; ?>
	</div>
<!-- /widget-content -->
</div>
