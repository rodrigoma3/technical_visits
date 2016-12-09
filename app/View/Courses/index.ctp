<div class="widget courses index">
    <div class="widget-header">
		<h3><?php echo __('Courses'); ?></h3>
	</div>
    <!-- /widget-header -->
    <div class="widget-content">
    	<table id="dataTables" class="display nowrap">
        	<thead>
            	<tr>
                    <th></th>
                	<th><?php echo __('Id'); ?></th>
                	<th><?php echo __('Name'); ?></th>
                	<th><?php echo __('Type of Academic Period'); ?></th>
                	<th><?php echo __('Amount of Academic Periods'); ?></th>
                	<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</thead>
        	<tfoot>
            	<tr>
                    <th></th>
                	<th><?php echo __('Id'); ?></th>
                	<th><?php echo __('Name'); ?></th>
                	<th><?php echo __('Type of Academic Period'); ?></th>
                	<th><?php echo __('Amount of Academic Periods'); ?></th>
            		<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</tfoot>
        	<tbody>
            	<?php foreach ($courses as $course): ?>
	<tr>
		<td></td>
		<td><?php echo h($course['Course']['id']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['name']); ?>&nbsp;</td>
		<td><?php echo h($course['TypeOfAcademicPeriod']['name']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['amount_of_academic_periods']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link('<i class="fa fa-lg fa-eye"></i>&nbsp;', array('action' => 'view', $course['Course']['id']), array('title' => 'View', 'escape' => false)); ?>
			<?php echo $this->Html->link('<i class="fa fa-lg fa-pencil"></i>&nbsp;', array('action' => 'edit', $course['Course']['id']), array('title' => 'Edit', 'escape' => false)); ?>
            <?php if (empty($course['Discipline'])): ?>
                <?php echo $this->Form->postLink('<i class="fa fa-lg fa-trash"></i>&nbsp;', array('action' => 'delete', $course['Course']['id']), array('title' => 'Delete', 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $course['Course']['id']))); ?>
            <?php endif; ?>
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
        <?php echo $this->Html->link(__('New Course'), array('action' => 'add'), array('class' => 'btn btn-success')); ?>	</div>
<!-- /widget-content -->
</div>
