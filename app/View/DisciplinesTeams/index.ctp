<div class="widget disciplinesTeams index">
    <div class="widget-header">
		<h3><?php echo __('Disciplines Teams'); ?></h3>
	</div>
    <!-- /widget-header -->
    <div class="widget-content">
    	<table id="dataTables" class="display nowrap">
        	<thead>
            	<tr>
                    <th></th>
            	                	<th><?php echo __('id'); ?></th>
            	                	<th><?php echo __('team_id'); ?></th>
            	                	<th><?php echo __('discipline_id'); ?></th>
            	                	<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</thead>
        	<tfoot>
            	<tr>
                    <th></th>
            	            		<th><?php echo __('id'); ?></th>
            	            		<th><?php echo __('team_id'); ?></th>
            	            		<th><?php echo __('discipline_id'); ?></th>
            	            		<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</tfoot>
        	<tbody>
            	<?php foreach ($disciplinesTeams as $disciplinesTeam): ?>
	<tr>
		<td></td>
		<td><?php echo h($disciplinesTeam['DisciplinesTeam']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($disciplinesTeam['Team']['name'], array('controller' => 'teams', 'action' => 'view', $disciplinesTeam['Team']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($disciplinesTeam['Discipline']['name'], array('controller' => 'disciplines', 'action' => 'view', $disciplinesTeam['Discipline']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link('<i class="fa fa-eye"></i> '.__('View'), array('action' => 'view', $disciplinesTeam['DisciplinesTeam']['id']), array('escape' => false, 'class' => 'btn')); ?>
			<?php echo $this->Html->link('<i class="fa fa-pencil"></i> '.__('Edit'), array('action' => 'edit', $disciplinesTeam['DisciplinesTeam']['id']), array('escape' => false, 'class' => 'btn')); ?>
			<?php echo $this->Form->postLink('<i class="fa fa-trash"></i> '.__('Delete'), array('action' => 'delete', $disciplinesTeam['DisciplinesTeam']['id']), array('escape' => false, 'class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $disciplinesTeam['DisciplinesTeam']['id']))); ?>
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
        <?php echo $this->Html->link(__('New Disciplines Team'), array('action' => 'add'), array('class' => 'btn btn-success')); ?>	</div>
<!-- /widget-content -->
</div>
