<div class="widget users index">
    <div class="widget-header">
		<h3><?php echo __('Users'); ?></h3>
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
                	<th><?php echo __('Group'); ?></th>
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
            		<th><?php echo __('Group'); ?></th>
            		<th><?php echo __('Enabled'); ?></th>
            		<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</tfoot>
        	<tbody>
            	<?php foreach ($users as $user): ?>
	<tr>
		<td></td>
		<td><?php echo h($user['User']['id']); ?></td>
		<td><?php echo h($user['User']['name']); ?></td>
		<td><?php echo h($user['User']['email']); ?></td>
		<td>
			<?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Form->postLink($user['Enabled']['name'], array('action' => 'allow_access', $user['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link('<i class="fa fa-lg fa-eye"></i>&nbsp;', array('action' => 'view', $user['User']['id']), array('escape' => false, 'title' => 'View')); ?>
			<?php echo $this->Html->link('<i class="fa fa-lg fa-pencil"></i>&nbsp;', array('action' => 'edit', $user['User']['id']), array('escape' => false, 'title' => 'Edit')); ?>
            <?php if (empty($user['Visit'])): ?>
                <?php echo $this->Form->postLink('<i class="fa fa-lg fa-trash"></i>&nbsp;', array('action' => 'delete', $user['User']['id']), array('escape' => false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # %s?', $user['User']['id']))); ?>
            <?php endif; ?>
            <?php echo $this->Html->link('<i class="fa fa-lg fa-key"></i>&nbsp;', array('action' => 'permission', $user['User']['id']), array('escape' => false, 'title' => 'Permission')); ?>
		</td>
	</tr>
<?php endforeach; ?>
        	</tbody>
    	</table>
    </div>
<!-- /widget-content -->
</div>

<div class="widget">
	<div class="widget-header">
		<h3><?php echo __('Actions'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content actions">
        <?php echo $this->Html->link(__('New User'), array('action' => 'add'), array('class' => 'btn btn-success')); ?>	</div>
<!-- /widget-content -->
</div>
