<div class="widget groups view">
	<div class="widget-header">
		<h3><?php echo __('Group'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<dl>
					<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($group['Group']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($group['Group']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($group['Group']['description']); ?>
			&nbsp;
		</dd>
		</dl>
		<div class="form-actions">
					<?php echo $this->Html->link(__('List Groups'), array('action' => 'index'), array('class' => 'btn btn-success')); ?>
		<?php echo $this->Html->link(__('Edit Group'), array('action' => 'edit', $group['Group']['id']), array('class' => 'btn')); ?>
		<?php echo $this->Form->postLink(__('Delete Group'), array('action' => 'delete', $group['Group']['id']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $group['Group']['id']))); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

<div class="widget groups view related">
	<div class="widget-header">
		<h3><?php echo __('Related Users'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<table id="dataTables" class="display nowrap">
			<thead>
				<tr>
					<th></th>
							<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Password'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th></th>
							<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Password'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</tfoot>
			<tbody>
					<?php foreach ($group['User'] as $user): ?>
		<tr>
			<td></td>
			<td><?php echo $user['id']; ?></td>
			<td><?php echo $user['name']; ?></td>
			<td><?php echo $user['email']; ?></td>
			<td><?php echo $user['password']; ?></td>
			<td><?php echo $user['group_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link('<i class="fa fa-eye"></i> '.__('View'), array('controller' => 'users', 'action' => 'view', $user['id']), array('escape' => false, 'class' => 'btn')); ?>
				<?php echo $this->Html->link('<i class="fa fa-pencil"></i> '.__('Edit'), array('controller' => 'users', 'action' => 'edit', $user['id']), array('escape' => false, 'class' => 'btn')); ?>
				<?php echo $this->Form->postLink('<i class="fa fa-trash"></i> '.__('Delete'), array('controller' => 'users', 'action' => 'delete', $user['id']), array('escape' => false, 'class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $user['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
			</tbody>
		</table>
		<div class="form-actions">
			<?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add'), array('class' => 'btn btn-success')); ?>		</div>
	</div>
<!-- /widget-content -->
</div>
