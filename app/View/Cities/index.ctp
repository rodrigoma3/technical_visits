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
                		<td><?php echo h($city['ShortDistance']['name']); ?>&nbsp;</td>
                        <td>
                            <?php if ($perms['StatesView']): ?>
                                <?php echo $this->Html->link($city['State']['name_initial'], array('controller' => 'states', 'action' => 'view', $city['State']['id'])); ?>
                            <?php else: ?>
                                <?php echo h($city['State']['name_initial']); ?>&nbsp;
                            <?php endif; ?>
                		</td>
                		<td class="actions">
                            <?php if ($perms['CitiesView']): ?>
                                <?php echo $this->Html->link('<i class="fa fa-lg fa-eye"></i>&nbsp;', array('action' => 'view', $city['City']['id']), array('title' => __('View'), 'escape' => false)); ?>
                            <?php endif; ?>
                            <?php if ($perms['CitiesEdit']): ?>
                                <?php echo $this->Html->link('<i class="fa fa-lg fa-pencil"></i>&nbsp;', array('action' => 'edit', $city['City']['id']), array('title' => __('Edit'), 'escape' => false)); ?>
                            <?php endif; ?>
                            <?php if (empty($city['Visit']) && $perms['CitiesDelete']): ?>
                                <?php echo $this->Form->postLink('<i class="fa fa-lg fa-trash"></i>&nbsp;', array('action' => 'delete', $city['City']['id']), array('title' => __('Delete'), 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $city['City']['id']))); ?>
                            <?php endif; ?>
                		</td>
                	</tr>
                <?php endforeach; ?>
        	</tbody>
    	</table>
    </div>
<!-- /widget-content -->
</div>

<?php if ($perms['CitiesAdd']): ?>
    <div class="widget">
        <div class="widget-header">
            <h3><?php echo __('Actions'); ?></h3>
        </div>
        <!-- /widget-header -->
        <div class="widget-content actions">
            <?php echo $this->Html->link(__('New City'), array('action' => 'add'), array('class' => 'btn btn-success')); ?>
        </div>
        <!-- /widget-content -->
    </div>
<?php endif; ?>
