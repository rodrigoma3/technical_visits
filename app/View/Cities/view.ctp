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
			<?php echo h($city['ShortDistance']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php if ($perms['StatesView']): ?>
				<?php echo $this->Html->link($city['State']['name_initial'], array('controller' => 'states', 'action' => 'view', $city['State']['id'])); ?>
			<?php else: ?>
				<?php echo h($city['State']['name_initial']); ?>
				&nbsp;
			<?php endif; ?>
		</dd>
		</dl>
		<div class="form-actions">
			<?php if ($perms['CitiesIndex']): ?>
				<?php echo $this->Html->link(__('List Cities'), array('action' => 'index'), array('class' => 'btn btn-success')); ?>
			<?php endif; ?>
			<?php if ($perms['CitiesEdit']): ?>
				<?php echo $this->Html->link(__('Edit City'), array('action' => 'edit', $city['City']['id']), array('class' => 'btn')); ?>
			<?php endif; ?>
			<?php if (empty($city['Visit']) && $perms['CitiesDelete']): ?>
				<?php echo $this->Form->postLink(__('Delete City'), array('action' => 'delete', $city['City']['id']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $city['City']['id']))); ?>
			<?php endif; ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
