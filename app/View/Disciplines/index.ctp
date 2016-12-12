<div class="widget disciplines index">
    <div class="widget-header">
		<h3><?php echo __('Disciplines'); ?></h3>
	</div>
    <!-- /widget-header -->
    <div class="widget-content">
    	<table id="dataTables" class="display nowrap">
        	<thead>
            	<tr>
                    <th></th>
                	<th><?php echo __('Id'); ?></th>
                	<th><?php echo __('Name'); ?></th>
                	<th><?php echo __('Academic Period'); ?></th>
                	<th><?php echo __('Course'); ?></th>
                	<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</thead>
        	<tfoot>
            	<tr>
                    <th></th>
            		<th><?php echo __('Id'); ?></th>
            		<th><?php echo __('Name'); ?></th>
            		<th><?php echo __('Academic Period'); ?></th>
            		<th><?php echo __('Course'); ?></th>
            		<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</tfoot>
        	<tbody>
            	<?php foreach ($disciplines as $discipline): ?>
                	<tr>
                		<td></td>
                		<td><?php echo h($discipline['Discipline']['id']); ?>&nbsp;</td>
                		<td><?php echo h($discipline['Discipline']['name']); ?>&nbsp;</td>
                		<td><?php echo h($discipline['Discipline']['academic_period']); ?>&nbsp;</td>
                		<td>
                			<?php echo $this->Html->link($discipline['Course']['name'], array('controller' => 'courses', 'action' => 'view', $discipline['Course']['id'])); ?>
                		</td>
                		<td class="actions">
                            <?php if ($perms['DisciplinesView']): ?>
                                <?php echo $this->Html->link('<i class="fa fa-lg fa-eye"></i>&nbsp;', array('action' => 'view', $discipline['Discipline']['id']), array('escape' => false, 'title' => 'View')); ?>
                            <?php endif; ?>
                            <?php if ($perms['DisciplinesEdit']): ?>
                                <?php echo $this->Html->link('<i class="fa fa-lg fa-pencil"></i>&nbsp;', array('action' => 'edit', $discipline['Discipline']['id']), array('escape' => false, 'title' => 'Edit')); ?>
                            <?php endif; ?>
                            <?php if (empty($discipline['Visit']) && empty($discipline['Team']) && $perms['DisciplinesDelete']): ?>
                                <?php echo $this->Form->postLink('<i class="fa fa-lg fa-trash"></i>&nbsp;', array('action' => 'delete', $discipline['Discipline']['id']), array('escape' => false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # %s?', $discipline['Discipline']['id']))); ?>
                            <?php endif; ?>
                		</td>
                	</tr>
                <?php endforeach; ?>
        	</tbody>
    	</table>
    </div>
<!-- /widget-content -->
</div>

<?php if ($perms['DisciplinesAdd']): ?>
    <div class="widget">
        <div class="widget-header">
            <h3><?php echo __('Actions'); ?></h3>
        </div>
        <!-- /widget-header -->
        <div class="widget-content actions">
            <?php echo $this->Html->link(__('New Discipline'), array('action' => 'add'), array('class' => 'btn btn-success')); ?>
        </div>
        <!-- /widget-content -->
    </div>
<?php endif; ?>
