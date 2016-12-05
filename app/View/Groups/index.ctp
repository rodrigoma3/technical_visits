<div class="widget groups index">
    <div class="widget-header">
		<h3><?php echo __('Groups'); ?></h3>
	</div>
    <!-- /widget-header -->
    <div class="widget-content">
    	<table id="dataTables" class="display nowrap">
        	<thead>
            	<tr>
                    <th></th>
                	<th><?php echo __('Id'); ?></th>
                	<th><?php echo __('Name'); ?></th>
                	<th><?php echo __('Description'); ?></th>
                	<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</thead>
        	<tfoot>
            	<tr>
                    <th></th>
            		<th><?php echo __('Id'); ?></th>
            		<th><?php echo __('Name'); ?></th>
            		<th><?php echo __('Description'); ?></th>
            		<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</tfoot>
        	<tbody>
            	<?php foreach ($groups as $group): ?>
	<tr>
		<td></td>
		<td><?php echo h($group['Group']['id']); ?>&nbsp;</td>
		<td><?php echo h($group['Group']['name']); ?>&nbsp;</td>
		<td><?php echo h($group['Group']['description']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link('<i class="fa fa-lg fa-eye"></i>&nbsp;', array('action' => 'view', $group['Group']['id']), array('escape' => false, 'title' => 'View')); ?>
			<?php echo $this->Html->link('<i class="fa fa-lg fa-pencil"></i>&nbsp;', array('action' => 'edit', $group['Group']['id']), array('escape' => false, 'title' => 'Edit')); ?>
            <?php if (empty($group['User'])): ?>
                <?php echo $this->Form->postLink('<i class="fa fa-lg fa-trash"></i>&nbsp;', array('action' => 'delete', $group['Group']['id']), array('escape' => false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # %s?', $group['Group']['id']))); ?>
            <?php endif; ?>
            <?php echo $this->Html->link('<i class="fa fa-lg fa-key"></i>&nbsp;', array('action' => 'permission', $group['Group']['id']), array('escape' => false, 'title' => 'Permission')); ?>
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
        <?php echo $this->Html->link(__('New Group'), array('action' => 'add'), array('class' => 'btn btn-success')); ?>
    </div>
<!-- /widget-content -->
</div>
