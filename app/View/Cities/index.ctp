<div class="widget cities index">
    <div class="widget-header">
		<h3><?php echo __('Cities'); ?></h3>
	</div>
    <!-- /widget-header -->
    <div class="widget-content">
    	<table id="dataTables" class="display nowrap">
        	<thead>
            	<tr>
                    <th></th>
                	<th><?php echo __('Id'); ?></th>
                	<th><?php echo __('Name'); ?></th>
                	<th><?php echo __('Short Distance'); ?></th>
                	<th><?php echo __('State'); ?></th>
                	<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</thead>
        	<tfoot>
            	<tr>
                    <th></th>
            		<th><?php echo __('Id'); ?></th>
            		<th><?php echo __('Name'); ?></th>
            		<th><?php echo __('Short Distance'); ?></th>
            		<th><?php echo __('State'); ?></th>
            		<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</tfoot>
        	<tbody>
            	<?php foreach ($cities as $city): ?>
                	<tr>
                		<td></td>
                		<td><?php echo h($city['City']['id']); ?>&nbsp;</td>
                		<td><?php echo h($city['City']['name']); ?>&nbsp;</td>
                        <td>
                            <?php if ($city['City']['short_distance']) {
                                echo __('Yes');
                            } else {
                                echo __('No');
                            } ?>
                        </td>
                		<td>
                			<?php echo $this->Html->link($city['State']['name'], array('controller' => 'states', 'action' => 'view', $city['State']['id'])); ?>
                		</td>
                		<td class="actions">
                			<?php echo $this->Html->link('<i class="fa fa-eye"></i> '.__('View'), array('action' => 'view', $city['City']['id']), array('escape' => false, 'class' => 'btn')); ?>
                			<?php echo $this->Html->link('<i class="fa fa-pencil"></i> '.__('Edit'), array('action' => 'edit', $city['City']['id']), array('escape' => false, 'class' => 'btn')); ?>
                			<?php echo $this->Form->postLink('<i class="fa fa-trash"></i> '.__('Delete'), array('action' => 'delete', $city['City']['id']), array('escape' => false, 'class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $city['City']['id']))); ?>
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
        <?php echo $this->Html->link(__('New City'), array('action' => 'add'), array('class' => 'btn btn-success')); ?>	</div>
<!-- /widget-content -->
</div>
