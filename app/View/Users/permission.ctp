<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit permissions for ').$user['User']['username']; ?></legend>
        	<?php
				foreach ($perms as $perm) {
					echo $this->Form->input('perms.'.$perm, array('options' => $options, 'default' => '2'));
				}
        	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

        <li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
	</ul>
</div>
