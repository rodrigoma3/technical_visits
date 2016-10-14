<div class="widget users view">
	<div class="widget-header">
		<h3><?php echo __('User'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<dl>
					<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
			&nbsp;
		</dd>
		</dl>
		<div class="form-actions">
					<?php echo $this->Html->link(__('List Users'), array('action' => 'index'), array('class' => 'btn btn-success')); ?>
		<?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id']), array('class' => 'btn')); ?>
		<?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $user['User']['id']))); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

<div class="widget users view related">
	<div class="widget-header">
		<h3><?php echo __('Related Refusals'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<table id="dataTables" class="display nowrap">
			<thead>
				<tr>
					<th></th>
							<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Date'); ?></th>
		<th><?php echo __('Reason'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Visit Id'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th></th>
							<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Date'); ?></th>
		<th><?php echo __('Reason'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Visit Id'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</tfoot>
			<tbody>
					<?php foreach ($user['Refusal'] as $refusal): ?>
		<tr>
			<td></td>
			<td><?php echo $refusal['id']; ?></td>
			<td><?php echo $refusal['date']; ?></td>
			<td><?php echo $refusal['reason']; ?></td>
			<td><?php echo $refusal['type']; ?></td>
			<td><?php echo $refusal['user_id']; ?></td>
			<td><?php echo $refusal['visit_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link('<i class="fa fa-eye"></i> '.__('View'), array('controller' => 'refusals', 'action' => 'view', $refusal['id']), array('escape' => false, 'class' => 'btn')); ?>
				<?php echo $this->Html->link('<i class="fa fa-pencil"></i> '.__('Edit'), array('controller' => 'refusals', 'action' => 'edit', $refusal['id']), array('escape' => false, 'class' => 'btn')); ?>
				<?php echo $this->Form->postLink('<i class="fa fa-trash"></i> '.__('Delete'), array('controller' => 'refusals', 'action' => 'delete', $refusal['id']), array('escape' => false, 'class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $refusal['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
			</tbody>
		</table>
		<div class="form-actions">
			<?php echo $this->Html->link(__('New Refusal'), array('controller' => 'refusals', 'action' => 'add'), array('class' => 'btn btn-success')); ?>		</div>
	</div>
<!-- /widget-content -->
</div>
<div class="widget users view related">
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
					<?php foreach ($user['Visit'] as $visit): ?>
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
