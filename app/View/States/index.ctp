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
            	<?php foreach ($states as $state): ?>
	<tr>
		<td></td>
		<td><?php echo h($state['State']['id']); ?>&nbsp;</td>
		<td><?php echo h($state['State']['name']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link('<i class="fa fa-eye"></i> '.__('View'), array('action' => 'view', $state['State']['id']), array('escape' => false, 'class' => 'btn')); ?>
			<?php echo $this->Html->link('<i class="fa fa-pencil"></i> '.__('Edit'), array('action' => 'edit', $state['State']['id']), array('escape' => false, 'class' => 'btn')); ?>
			<?php echo $this->Form->postLink('<i class="fa fa-trash"></i> '.__('Delete'), array('action' => 'delete', $state['State']['id']), array('escape' => false, 'class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $state['State']['id']))); ?>
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
        <?php echo $this->Html->link(__('New State'), array('action' => 'add'), array('class' => 'btn btn-success')); ?>	</div>
<!-- /widget-content -->
</div>
