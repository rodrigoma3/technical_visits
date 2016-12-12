<div class="widget states index">
    <div class="widget-header">
		<h3><?php echo __('States'); ?></h3>
	</div>
    <!-- /widget-header -->
    <div class="widget-content">
    	<table id="dataTables" class="display nowrap">
        	<thead>
            	<tr>
                    <th></th>
                	<th><?php echo __('Id'); ?></th>
                	<th><?php echo __('Name'); ?></th>
                	<th><?php echo __('Initials'); ?></th>
                	<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</thead>
        	<tfoot>
            	<tr>
                    <th></th>
            		<th><?php echo __('Id'); ?></th>
            		<th><?php echo __('Name'); ?></th>
            		<th><?php echo __('Initials'); ?></th>
            		<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</tfoot>
        	<tbody>
            	<?php foreach ($states as $state): ?>
                	<tr>
                		<td></td>
                		<td><?php echo h($state['State']['id']); ?>&nbsp;</td>
                		<td><?php echo h($state['State']['name']); ?>&nbsp;</td>
                		<td><?php echo h($state['State']['initials']); ?>&nbsp;</td>
                		<td class="actions">
                            <?php if ($perms['StatesView']): ?>
                                <?php echo $this->Html->link('<i class="fa fa-lg fa-eye"></i>&nbsp;', array('action' => 'view', $state['State']['id']), array('escape' => false, 'title' => 'View')); ?>
                            <?php endif; ?>
                            <?php if ($perms['StatesEdit']): ?>
                                <?php echo $this->Html->link('<i class="fa fa-lg fa-pencil"></i>&nbsp;', array('action' => 'edit', $state['State']['id']), array('escape' => false, 'title' => 'Edit')); ?>
                            <?php endif; ?>
                            <?php if (empty($state['City']) && $perms['StatesDelete']): ?>
                                <?php echo $this->Form->postLink('<i class="fa fa-lg fa-trash"></i>&nbsp;', array('action' => 'delete', $state['State']['id']), array('escape' => false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # %s?', $state['State']['id']))); ?>
                            <?php endif; ?>
                		</td>
                	</tr>
                <?php endforeach; ?>
        	</tbody>
    	</table>
    </div>
<!-- /widget-content -->
</div>

<?php if ($perms['StatesAdd']): ?>
    <div class="widget">
        <div class="widget-header">
            <h3><?php echo __('Actions'); ?></h3>
        </div>
        <!-- /widget-header -->
        <div class="widget-content actions">
            <?php echo $this->Html->link(__('New State'), array('action' => 'add'), array('class' => 'btn btn-success')); ?>
        </div>
        <!-- /widget-content -->
    </div>
<?php endif; ?>
