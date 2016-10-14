<div class="widget cities view">
	<div class="widget-header">
		<h3><?php echo __('City'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<dl>
					<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($city['City']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($city['City']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short Distance'); ?></dt>
		<dd>
			<?php echo h($city['City']['short_distance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo $this->Html->link($city['State']['name'], array('controller' => 'states', 'action' => 'view', $city['State']['id'])); ?>
			&nbsp;
		</dd>
		</dl>
		<div class="form-actions">
					<?php echo $this->Html->link(__('List Cities'), array('action' => 'index'), array('class' => 'btn btn-success')); ?>
		<?php echo $this->Html->link(__('Edit City'), array('action' => 'edit', $city['City']['id']), array('class' => 'btn')); ?>
		<?php echo $this->Form->postLink(__('Delete City'), array('action' => 'delete', $city['City']['id']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $city['City']['id']))); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

<div class="widget cities view related">
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
		<th><?php echo __('Class Id'); ?></th>
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
		<th><?php echo __('Class Id'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</tfoot>
			<tbody>
					<?php foreach ($city['Visit'] as $visit): ?>
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
			<td><?php echo $visit['class_id']; ?></td>
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
