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
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Enabled'); ?></dt>
		<dd>
			<?php echo h($user['Enabled']['name']); ?>
			&nbsp;
		</dd>
		</dl>
		<div class="form-actions">
			<?php echo $this->Html->link(__('List Users'), array('action' => 'index'), array('class' => 'btn btn-success')); ?>
			<?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id']), array('class' => 'btn')); ?>
			<?php if (empty($user['Visit'])): ?>
				<?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $user['User']['id']))); ?>
			<?php endif; ?>
			<?php echo $this->Html->link(__('Permission'), array('action' => 'permission', $user['User']['id']), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
