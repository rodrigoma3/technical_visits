<div class="widget refusals index">
    <div class="widget-header">
		<h3><?php echo __('Refusals'); ?></h3>
	</div>
    <!-- /widget-header -->
    <div class="widget-content">
    	<table id="dataTables" class="display nowrap">
        	<thead>
            	<tr>
                    <th></th>
            	                	<th><?php echo __('id'); ?></th>
            	                	<th><?php echo __('date'); ?></th>
            	                	<th><?php echo __('reason'); ?></th>
            	                	<th><?php echo __('type'); ?></th>
            	                	<th><?php echo __('user_id'); ?></th>
            	                	<th><?php echo __('visit_id'); ?></th>
            	                	<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</thead>
        	<tfoot>
            	<tr>
                    <th></th>
            	            		<th><?php echo __('id'); ?></th>
            	            		<th><?php echo __('date'); ?></th>
            	            		<th><?php echo __('reason'); ?></th>
            	            		<th><?php echo __('type'); ?></th>
            	            		<th><?php echo __('user_id'); ?></th>
            	            		<th><?php echo __('visit_id'); ?></th>
            	            		<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</tfoot>
        	<tbody>
            	<?php foreach ($refusals as $refusal): ?>
	<tr>
		<td></td>
		<td><?php echo h($refusal['Refusal']['id']); ?>&nbsp;</td>
		<td><?php echo h($refusal['Refusal']['date']); ?>&nbsp;</td>
		<td><?php echo h($refusal['Refusal']['reason']); ?>&nbsp;</td>
		<td><?php echo h($refusal['Refusal']['type']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($refusal['User']['name'], array('controller' => 'users', 'action' => 'view', $refusal['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($refusal['Visit']['id'], array('controller' => 'visits', 'action' => 'view', $refusal['Visit']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link('<i class="fa fa-eye"></i> '.__('View'), array('action' => 'view', $refusal['Refusal']['id']), array('escape' => false, 'class' => 'btn')); ?>
			<?php echo $this->Html->link('<i class="fa fa-pencil"></i> '.__('Edit'), array('action' => 'edit', $refusal['Refusal']['id']), array('escape' => false, 'class' => 'btn')); ?>
			<?php echo $this->Form->postLink('<i class="fa fa-trash"></i> '.__('Delete'), array('action' => 'delete', $refusal['Refusal']['id']), array('escape' => false, 'class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $refusal['Refusal']['id']))); ?>
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
        <?php echo $this->Html->link(__('New Refusal'), array('action' => 'add'), array('class' => 'btn btn-success')); ?>	</div>
<!-- /widget-content -->
</div>
