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
		<h3><?php echo __('Related Visits'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<table id="dataTables" class="display nowrap">
			<thead>
				<tr>
					<th></th>
							<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Departure'); ?></th>
		<th><?php echo __('Arrival'); ?></th>
		<th><?php echo __('Destination'); ?></th>
		<th><?php echo __('Number Of Students'); ?></th>
		<th><?php echo __('Daily'); ?></th>
		<th><?php echo __('Transport'); ?></th>
		<th><?php echo __('Cost Transport'); ?></th>
		<th><?php echo __('Distance'); ?></th>
		<th><?php echo __('Objective'); ?></th>
		<th><?php echo __('Comments'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('City Id'); ?></th>
		<th><?php echo __('Team Id'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th></th>
							<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Departure'); ?></th>
		<th><?php echo __('Arrival'); ?></th>
		<th><?php echo __('Destination'); ?></th>
		<th><?php echo __('Number Of Students'); ?></th>
		<th><?php echo __('Daily'); ?></th>
		<th><?php echo __('Transport'); ?></th>
		<th><?php echo __('Cost Transport'); ?></th>
		<th><?php echo __('Distance'); ?></th>
		<th><?php echo __('Objective'); ?></th>
		<th><?php echo __('Comments'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('City Id'); ?></th>
		<th><?php echo __('Team Id'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</tfoot>
			<tbody>
					<?php foreach ($team['Visit'] as $visit): ?>
		<tr>
			<td></td>
			<td><?php echo $visit['id']; ?></td>
			<td><?php echo $visit['departure']; ?></td>
			<td><?php echo $visit['arrival']; ?></td>
			<td><?php echo $visit['destination']; ?></td>
			<td><?php echo $visit['number_of_students']; ?></td>
			<td><?php echo $visit['daily']; ?></td>
			<td><?php echo $visit['transport']; ?></td>
			<td><?php echo $visit['cost_transport']; ?></td>
			<td><?php echo $visit['distance']; ?></td>
			<td><?php echo $visit['objective']; ?></td>
			<td><?php echo $visit['comments']; ?></td>
			<td><?php echo $visit['status']; ?></td>
			<td><?php echo $visit['user_id']; ?></td>
			<td><?php echo $visit['city_id']; ?></td>
			<td><?php echo $visit['team_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link('<i class="fa fa-eye"></i> '.__('View'), array('controller' => 'visits', 'action' => 'view', $visit['id']), array('escape' => false, 'class' => 'btn')); ?>
				<?php echo $this->Html->link('<i class="fa fa-pencil"></i> '.__('Edit'), array('controller' => 'visits', 'action' => 'edit', $visit['id']), array('escape' => false, 'class' => 'btn')); ?>
				<?php echo $this->Form->postLink('<i class="fa fa-trash"></i> '.__('Delete'), array('controller' => 'visits', 'action' => 'delete', $visit['id']), array('escape' => false, 'class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $visit['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
			</tbody>
		</table>
		<div class="form-actions">
			<?php echo $this->Html->link(__('New Visit'), array('controller' => 'visits', 'action' => 'add'), array('class' => 'btn btn-success')); ?>		</div>
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
		<th><?php echo __('Course Id'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th></th>
							<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Academic Period'); ?></th>
		<th><?php echo __('Course Id'); ?></th>
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
			<td><?php echo $discipline['course_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link('<i class="fa fa-eye"></i> '.__('View'), array('controller' => 'disciplines', 'action' => 'view', $discipline['id']), array('escape' => false, 'class' => 'btn')); ?>
				<?php echo $this->Html->link('<i class="fa fa-pencil"></i> '.__('Edit'), array('controller' => 'disciplines', 'action' => 'edit', $discipline['id']), array('escape' => false, 'class' => 'btn')); ?>
				<?php echo $this->Form->postLink('<i class="fa fa-trash"></i> '.__('Delete'), array('controller' => 'disciplines', 'action' => 'delete', $discipline['id']), array('escape' => false, 'class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $discipline['id']))); ?>
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
