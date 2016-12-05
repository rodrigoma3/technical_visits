<div class="widget states view">
	<div class="widget-header">
		<h3><?php echo __('State'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($state['State']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($state['State']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Initials'); ?></dt>
			<dd>
				<?php echo h($state['State']['initials']); ?>
				&nbsp;
			</dd>
		</dl>
		<div class="form-actions">
			<?php echo $this->Html->link(__('List States'), array('action' => 'index'), array('class' => 'btn btn-success')); ?>
			<?php echo $this->Html->link(__('Edit State'), array('action' => 'edit', $state['State']['id']), array('class' => 'btn')); ?>
			<?php echo $this->Form->postLink(__('Delete State'), array('action' => 'delete', $state['State']['id']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $state['State']['id']))); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

<div class="widget states view related">
	<div class="widget-header">
		<h3><?php echo __('Related Cities'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<table id="dataTables" class="display nowrap">
			<thead>
				<tr>
					<th></th>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Short Distance'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th></th>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Short Distance'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</tfoot>
			<tbody>
					<?php foreach ($state['City'] as $city): ?>
		<tr>
			<td></td>
			<td><?php echo h($city['id']); ?></td>
			<td><?php echo h($city['name']); ?></td>
			<td>
				<?php if ($city['short_distance']) {
					echo __('Yes');
				} else {
					echo __('No');
				} ?>
			</td>
			<td class="actions">
				<?php echo $this->Html->link('<i class="fa fa-lg fa-eye"></i>&nbsp;', array('controller' => 'cities', 'action' => 'view', $city['id']), array('escape' => false, 'title' => 'View')); ?>
				<?php echo $this->Html->link('<i class="fa fa-lg fa-pencil"></i>&nbsp;', array('controller' => 'cities', 'action' => 'edit', $city['id']), array('escape' => false, 'title' => 'Edit')); ?>
				<?php echo $this->Form->postLink('<i class="fa fa-lg fa-trash"></i>&nbsp;', array('controller' => 'cities', 'action' => 'delete', $city['id']), array('escape' => false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # %s?', $city['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
			</tbody>
		</table>
		<div class="form-actions">
			<?php echo $this->Html->link(__('New City'), array('controller' => 'cities', 'action' => 'add'), array('class' => 'btn btn-success')); ?>		</div>
	</div>
<!-- /widget-content -->
</div>
