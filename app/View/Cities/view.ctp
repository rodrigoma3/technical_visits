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
			<?php if ($city['City']['short_distance']) {
				echo __('Yes');
			} else {
				echo __('No');
			} ?>
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
