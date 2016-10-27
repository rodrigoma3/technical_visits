<div class="widget visits view">
	<div class="widget-header">
		<h3><?php echo __('Visit'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<dl>
					<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Departure'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['departure']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Arrival'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['arrival']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Destination'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['destination']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Number Of Students'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['number_of_students']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Refund'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['refund']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Transport'); ?></dt>
		<dd>
			<?php echo h($visit['Transport']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Transport Cost'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['transport_cost']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Distance'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['distance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Objective'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['objective']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comments'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['comments']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($visit['Status']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($visit['User']['name'], array('controller' => 'users', 'action' => 'view', $visit['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo $this->Html->link($visit['City']['name'], array('controller' => 'cities', 'action' => 'view', $visit['City']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo $this->Html->link($visit['City']['State']['name'], array('controller' => 'states', 'action' => 'view', $visit['City']['State']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Team'); ?></dt>
		<dd>
			<?php echo $this->Html->link($visit['Team']['name'], array('controller' => 'teams', 'action' => 'view', $visit['Team']['id'])); ?>
			&nbsp;
		</dd>
		</dl>
		<div class="form-actions">
					<?php echo $this->Html->link(__('List Visits'), array('action' => 'index'), array('class' => 'btn btn-success')); ?>
		<?php echo $this->Html->link(__('Edit Visit'), array('action' => 'edit', $visit['Visit']['id']), array('class' => 'btn')); ?>
		<?php echo $this->Form->postLink(__('Delete Visit'), array('action' => 'delete', $visit['Visit']['id']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $visit['Visit']['id']))); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

<div class="widget visits view related">
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
					<?php foreach ($visit['Refusal'] as $refusal): ?>
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
