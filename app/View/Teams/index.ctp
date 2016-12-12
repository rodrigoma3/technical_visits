<div class="widget teams index">
    <div class="widget-header">
		<h3><?php echo __('Teams'); ?></h3>
	</div>
    <!-- /widget-header -->
    <div class="widget-content">
    	<table id="dataTables" class="display nowrap">
        	<thead>
            	<tr>
                    <th></th>
                	<th><?php echo __('id'); ?></th>
                	<th><?php echo __('name'); ?></th>
                	<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</thead>
        	<tfoot>
            	<tr>
                    <th></th>
            		<th><?php echo __('id'); ?></th>
            		<th><?php echo __('name'); ?></th>
            		<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</tfoot>
        	<tbody>
            	<?php foreach ($teams as $team): ?>
                	<tr>
                		<td></td>
                		<td><?php echo h($team['Team']['id']); ?>&nbsp;</td>
                		<td><?php echo h($team['Team']['name']); ?>&nbsp;</td>
                		<td class="actions">
                            <?php if ($perms['TeamsView']): ?>
                                <?php echo $this->Html->link('<i class="fa fa-lg fa-eye"></i>&nbsp;', array('action' => 'view', $team['Team']['id']), array('escape' => false, 'title' => 'View')); ?>
                            <?php endif; ?>
                            <?php if ($perms['TeamsEdit']): ?>
                                <?php echo $this->Html->link('<i class="fa fa-lg fa-pencil"></i>&nbsp;', array('action' => 'edit', $team['Team']['id']), array('escape' => false, 'title' => 'Edit')); ?>
                            <?php endif; ?>
                            <?php if ($perms['TeamsDelete']): ?>
                                <?php echo $this->Form->postLink('<i class="fa fa-lg fa-trash"></i>&nbsp;', array('action' => 'delete', $team['Team']['id']), array('escape' => false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # %s?', $team['Team']['id']))); ?>
                            <?php endif; ?>
                		</td>
                	</tr>
                <?php endforeach; ?>
        	</tbody>
    	</table>
    </div>
<!-- /widget-content -->
</div>

<?php if ($perms['TeamsAdd']): ?>
    <div class="widget">
        <div class="widget-header">
            <h3><?php echo __('Actions'); ?></h3>
        </div>
        <!-- /widget-header -->
        <div class="widget-content actions">
            <?php echo $this->Html->link(__('New Team'), array('action' => 'add'), array('class' => 'btn btn-success')); ?>
        </div>
        <!-- /widget-content -->
    </div>
<?php endif; ?>
