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
			<?php if ($perms['GroupsIndex']): ?>
				<?php echo $this->Html->link(__('List Groups'), array('action' => 'index'), array('class' => 'btn btn-success')); ?>
			<?php endif; ?>
			<?php if ($perms['GroupsEdit']): ?>
				<?php echo $this->Html->link(__('Edit Group'), array('action' => 'edit', $group['Group']['id']), array('class' => 'btn')); ?>
			<?php endif; ?>
			<?php if (empty($group['User']) && $perms['GroupsDelete']): ?>
				<?php echo $this->Form->postLink(__('Delete Group'), array('action' => 'delete', $group['Group']['id']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $group['Group']['id']))); ?>
			<?php endif; ?>
			<?php if ($perms['GroupsPermission']): ?>
				<?php echo $this->Html->link(__('Permission'), array('action' => 'permission', $group['Group']['id']), array('class' => 'btn')); ?>
			<?php endif; ?>
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
					<th><?php echo __('Enabled'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th></th>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Email'); ?></th>
					<th><?php echo __('Enabled'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($users as $user): ?>
					<tr>
						<td></td>
						<td><?php echo $user['User']['id']; ?></td>
						<td><?php echo $user['User']['name']; ?></td>
						<td><?php echo $user['User']['email']; ?></td>
						<td>
							<?php if ($perms['UsersAllowAccess']): ?>
								<?php echo $this->Form->postLink($user['Enabled']['name'], array('controller' => 'users', 'action' => 'allow_access', $user['User']['id'])); ?>
							<?php else: ?>
								<td><?php echo $user['Enabled']['name']; ?></td>
							<?php endif; ?>
						</td>
						<td class="actions">
							<?php if ($perms['UsersView']): ?>
								<?php echo $this->Html->link('<i class="fa fa-lg fa-eye"></i>&nbsp;', array('controller' => 'users', 'action' => 'view', $user['User']['id']), array('escape' => false, 'title' => 'View')); ?>
							<?php endif; ?>
							<?php if ($perms['UsersEdit']): ?>
								<?php echo $this->Html->link('<i class="fa fa-lg fa-pencil"></i>&nbsp;', array('controller' => 'users', 'action' => 'edit', $user['User']['id']), array('escape' => false, 'title' => 'Edit')); ?>
							<?php endif; ?>
							<?php if (empty($user['Visit']) && $perms['UsersDelete']): ?>
								<?php echo $this->Form->postLink('<i class="fa fa-lg fa-trash"></i>&nbsp;', array('controller' => 'users', 'action' => 'delete', $user['User']['id']), array('escape' => false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # %s?', $user['User']['id']))); ?>
							<?php endif; ?>
							<?php if ($perms['UsersPermission']): ?>
								<?php echo $this->Html->link('<i class="fa fa-lg fa-key"></i>&nbsp;', array('controller' => 'users', 'action' => 'permission', $user['User']['id']), array('escape' => false, 'title' => 'Permission')); ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php if ($perms['UsersAdd']): ?>
			<div class="form-actions">
				<?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add'), array('class' => 'btn btn-success')); ?>
			</div>
		<?php endif; ?>
	</div>
<!-- /widget-content -->
</div>
