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
			<?php echo $this->Html->link('<i class="fa fa-eye"></i> '.__('View'), array('action' => 'view', $group['Group']['id']), array('escape' => false, 'class' => 'btn')); ?>
			<?php echo $this->Html->link('<i class="fa fa-pencil"></i> '.__('Edit'), array('action' => 'edit', $group['Group']['id']), array('escape' => false, 'class' => 'btn')); ?>
            <?php if (empty($group['User'])): ?>
                <?php echo $this->Form->postLink('<i class="fa fa-trash"></i> '.__('Delete'), array('action' => 'delete', $group['Group']['id']), array('escape' => false, 'class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $group['Group']['id']))); ?>
            <?php endif; ?>
            <?php echo $this->Html->link('<i class="fa fa-key"></i> '.__('Permission'), array('action' => 'permission', $group['Group']['id']), array('escape' => false, 'class' => 'btn')); ?>
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
        <?php echo $this->Html->link(__('Rebuild Aco Tree (Actions & Controllers)'), array('action' => 'rebuilt'), array('class' => 'btn btn-info')); ?>
    </div>
<!-- /widget-content -->
</div>
