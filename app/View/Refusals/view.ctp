<div class="widget refusals view">
	<div class="widget-header">
		<h3><?php echo __('Refusal'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<dl>
					<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($refusal['Refusal']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($refusal['Refusal']['date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Reason'); ?></dt>
		<dd>
			<?php echo h($refusal['Refusal']['reason']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($refusal['Refusal']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($refusal['User']['name'], array('controller' => 'users', 'action' => 'view', $refusal['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Visit'); ?></dt>
		<dd>
			<?php echo $this->Html->link($refusal['Visit']['id'], array('controller' => 'visits', 'action' => 'view', $refusal['Visit']['id'])); ?>
			&nbsp;
		</dd>
		</dl>
		<div class="form-actions">
					<?php echo $this->Html->link(__('List Refusals'), array('action' => 'index'), array('class' => 'btn btn-success')); ?>
		<?php echo $this->Html->link(__('Edit Refusal'), array('action' => 'edit', $refusal['Refusal']['id']), array('class' => 'btn')); ?>
		<?php echo $this->Form->postLink(__('Delete Refusal'), array('action' => 'delete', $refusal['Refusal']['id']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $refusal['Refusal']['id']))); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

