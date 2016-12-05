<div class="widget teams view">
	<div class="widget-header">
		<h3><?php echo __('Team'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($team['Team']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($team['Team']['name']); ?>
				&nbsp;
			</dd>
		</dl>
		<div class="form-actions">
			<?php echo $this->Html->link(__('List Teams'), array('action' => 'index'), array('class' => 'btn btn-success')); ?>
			<?php echo $this->Html->link(__('Edit Team'), array('action' => 'edit', $team['Team']['id']), array('class' => 'btn')); ?>
			<?php echo $this->Form->postLink(__('Delete Team'), array('action' => 'delete', $team['Team']['id']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $team['Team']['id']))); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

<div class="widget teams view related">
	<div class="widget-header">
		<h3><?php echo __('Related Disciplines'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<table id="dataTables" class="display nowrap">
			<thead>
				<tr>
					<th></th>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Academic Period'); ?></th>
					<th><?php echo __('Course'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th></th>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Academic Period'); ?></th>
					<th><?php echo __('Course'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</tfoot>
			<tbody>
					<?php foreach ($team['Discipline'] as $discipline): ?>
		<tr>
			<td></td>
			<td><?php echo $discipline['id']; ?></td>
			<td><?php echo $discipline['name']; ?></td>
			<td><?php echo $discipline['academic_period']; ?></td>
			<td><?php echo $this->Html->link($discipline['Course']['name'], array('controller' => 'courses', 'action' => 'view', $discipline['Course']['id'])); ?></td>
			<td class="actions">
				<?php echo $this->Html->link('<i class="fa fa-lg fa-eye"></i>&nbsp;', array('controller' => 'disciplines', 'action' => 'view', $discipline['id']), array('escape' => false, 'title' => 'View')); ?>
				<?php echo $this->Html->link('<i class="fa fa-lg fa-pencil"></i>&nbsp;', array('controller' => 'disciplines', 'action' => 'edit', $discipline['id']), array('escape' => false, 'title' => 'Edit')); ?>
				<?php echo $this->Form->postLink('<i class="fa fa-lg fa-trash"></i>&nbsp;', array('controller' => 'disciplines', 'action' => 'delete', $discipline['id']), array('escape' => false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # %s?', $discipline['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
			</tbody>
		</table>
		<div class="form-actions">
			<?php echo $this->Html->link(__('New Discipline'), array('controller' => 'disciplines', 'action' => 'add'), array('class' => 'btn btn-success')); ?>		</div>
	</div>
<!-- /widget-content -->
</div>
