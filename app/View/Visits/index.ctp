<div class="widget visits index">
    <div class="widget-header">
		<h3><?php echo __('Visits'); ?></h3>
	</div>
    <!-- /widget-header -->
    <div class="widget-content">
    	<table id="dataTables" class="display nowrap">
        	<thead>
            	<tr>
                    <th></th>
                	<th><?php echo __('Id'); ?></th>
                    <th><?php echo __('Status'); ?></th>
                    <th><?php echo __('Created'); ?></th>
                    <th><?php echo __('Modified'); ?></th>
                    <th><?php echo __('Destination'); ?></th>
                	<th><?php echo __('Departure'); ?></th>
                	<th><?php echo __('Arrival'); ?></th>
                	<th><?php echo __('Transport'); ?></th>
                    <th><?php echo __('Transport Cost'); ?></th>
                	<th><?php echo __('User'); ?></th>
                	<th><?php echo __('City'); ?></th>
                    <th><?php echo __('State'); ?></th>
                	<th><?php echo __('Course'); ?></th>
                	<th><?php echo __('Discipline'); ?></th>
                	<th><?php echo __('Team'); ?></th>
                	<th><?php echo __('Students'); ?></th>
                	<th><?php echo __('Refund'); ?></th>
                    <th><?php echo __('Objective'); ?></th>
                    <th><?php echo __('Comments'); ?></th>
                	<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</thead>
        	<tfoot>
            	<tr>
                    <th></th>
            		<th><?php echo __('id'); ?></th>
                    <th><?php echo __('status'); ?></th>
                    <th><?php echo __('created'); ?></th>
                    <th><?php echo __('modified'); ?></th>
                    <th><?php echo __('destination'); ?></th>
            		<th><?php echo __('departure'); ?></th>
            		<th><?php echo __('arrival'); ?></th>
            		<th><?php echo __('transport'); ?></th>
            		<th><?php echo __('transport_cost'); ?></th>
            		<th><?php echo __('user_id'); ?></th>
            		<th><?php echo __('city_id'); ?></th>
            		<th><?php echo __('state_id'); ?></th>
            		<th><?php echo __('course_id'); ?></th>
            		<th><?php echo __('discipline_id'); ?></th>
            		<th><?php echo __('team_id'); ?></th>
            		<th><?php echo __('number_of_students'); ?></th>
            		<th><?php echo __('refund'); ?></th>
            		<th><?php echo __('objective'); ?></th>
            		<th><?php echo __('comments'); ?></th>
            		<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</tfoot>
        	<tbody>
            	<?php foreach ($visits as $visit): ?>
	<tr>
		<td></td>
		<td><?php echo h($visit['Visit']['id']); ?>&nbsp;</td>
        <td><?php echo h($visit['Status']['name']); ?>&nbsp;</td>
        <td><?php echo h($visit['Visit']['created']); ?>&nbsp;</td>
        <td><?php echo h($visit['Visit']['modified']); ?>&nbsp;</td>
        <td><?php echo h($visit['Visit']['destination']); ?>&nbsp;</td>
		<td><?php echo h($visit['Visit']['departure']); ?>&nbsp;</td>
		<td><?php echo h($visit['Visit']['arrival']); ?>&nbsp;</td>
		<td><?php echo h($visit['Transport']['name']); ?>&nbsp;</td>
        <td><?php echo h($visit['Visit']['transport_cost']); ?>&nbsp;</td>
		<td>
            <?php if ($perms['UsersView']): ?>
                <?php echo $this->Html->link($visit['User']['name'], array('controller' => 'users', 'action' => 'view', $visit['User']['id'])); ?>
            <?php else: ?>
                <?php echo h($visit['User']['name']); ?>&nbsp;
            <?php endif; ?>
		</td>
		<td>
            <?php if ($perms['CitiesView']): ?>
                <?php echo $this->Html->link($visit['City']['name'], array('controller' => 'cities', 'action' => 'view', $visit['City']['id'])); ?>
            <?php else: ?>
                <?php echo h($visit['City']['name']); ?>&nbsp;
            <?php endif; ?>
        </td>
		<td>
            <?php if ($perms['StatesView']): ?>
                <?php echo $this->Html->link($visit['City']['State']['name_initial'], array('controller' => 'states', 'action' => 'view', $visit['City']['State']['id'])); ?>
            <?php else: ?>
                <?php echo h($visit['City']['State']['name_initial']); ?>&nbsp;
            <?php endif; ?>
		</td>
        <td>
            <?php if ($perms['CoursesView']): ?>
                <?php echo $this->Html->link($courses[$visit['Team']['Discipline'][0]['course_id']], array('controller' => 'courses', 'action' => 'view', $visit['Team']['Discipline'][0]['course_id'])); ?>
            <?php else: ?>
                <?php echo h($courses[$visit['Team']['Discipline'][0]['course_id']]); ?>&nbsp;
            <?php endif; ?>
		</td>
        <td>
            <?php if ($perms['DisciplinesView']): ?>
                <?php echo $this->Html->link($visit['Discipline']['name'], array('controller' => 'disciplines', 'action' => 'view', $visit['Visit']['discipline_id'])); ?>
            <?php else: ?>
                <?php echo h($visit['Discipline']['name']); ?>&nbsp;
            <?php endif; ?>
		</td>
		<td>
            <?php if ($perms['TeamsView']): ?>
                <?php echo $this->Html->link($visit['Team']['name'], array('controller' => 'teams', 'action' => 'view', $visit['Team']['id'])); ?>
            <?php else: ?>
                <?php echo h($visit['Team']['name']); ?>&nbsp;
            <?php endif; ?>
		</td>
        <td><?php echo h($visit['Visit']['number_of_students']); ?>&nbsp;</td>
        <td><?php echo h($visit['Visit']['refund']); ?>&nbsp;</td>
        <td><?php echo h($visit['Visit']['objective']); ?>&nbsp;</td>
        <td><?php echo h($visit['Visit']['comments']); ?>&nbsp;</td>
		<td class="actions">
            <?php if ($perms['VisitsCopy']): ?>
                <?php echo $this->Html->link('<i class="fa fa-lg fa-copy"></i>&nbsp;', array('action' => 'copy', $visit['Visit']['id']), array('escape' => false, 'title' => __('Copy'))); ?>
            <?php endif; ?>
            <?php if ($perms['VisitsView']): ?>
                <?php echo $this->Html->link('<i class="fa fa-lg fa-eye"></i>&nbsp;', array('action' => 'view', $visit['Visit']['id']), array('escape' => false, 'title' => __('View'))); ?>
            <?php endif; ?>
            <?php if ($visit['Visit']['user_id'] == $this->Session->read('Auth.User.id') && $visit['Visit']['status'] < 4): ?>
                <?php if ($perms['VisitsEdit']): ?>
                    <?php echo $this->Html->link('<i class="fa fa-lg fa-pencil"></i>&nbsp;', array('action' => 'edit', $visit['Visit']['id']), array('escape' => false, 'title' => __('Edit'))); ?>
                <?php endif; ?>
                <?php if ($perms['RefusalsCancel']): ?>
                    <?php echo $this->Html->link('<i class="fa fa-lg fa-trash"></i>&nbsp;', array('controller' => 'refusals', 'action' => 'cancel', $visit['Visit']['id']), array('escape' => false, 'confirm' => __('Are you sure you want to cancel # %s?', $visit['Visit']['id']), 'title' => __('Cancel'))); ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($visit['Visit']['status'] < 9 && $perms['VisitsInformationUpdate']): ?>
                <?php echo $this->Html->link('<i class="fa fa-lg fa-pencil-square-o"></i>&nbsp;', array('action' => 'information_update', $visit['Visit']['id']), array('escape' => false, 'title' => __('Update information'))); ?>
            <?php endif; ?>
            <?php if (in_array($visit['Visit']['status'], array(1,4,6,8)) && $perms['VisitsTransportUpdate']): ?>
                <?php echo $this->Html->link('<i class="fa fa-lg fa-truck"></i>&nbsp;', array('action' => 'transport_update', $visit['Visit']['id']), array('escape' => false, 'title' => __('Transport'))); ?>
            <?php endif; ?>
            <?php if (in_array($visit['Visit']['status'], array(3,4,5)) && $perms['RefusalsInvalidateVisit']): ?>
                <?php echo $this->Html->link('<i class="fa fa-lg fa-ban"></i>&nbsp;', array('controller' => 'refusals', 'action' => 'invalidate_visit', $visit['Visit']['id']), array('escape' => false, 'title' => __('Invalidate visit'))); ?>
            <?php endif; ?>
        </td>
	</tr>
<?php endforeach; ?>
        	</tbody>
    	</table>
    </div>
<!-- /widget-content -->
</div>

<?php if ($perms['VisitsAdd']): ?>
    <div class="widget">
    	<div class="widget-header">
    		<h3><?php echo __('Actions'); ?></h3>
    	</div>
    	<!-- /widget-header -->
    	<div class="widget-content actions">
                <?php echo $this->Html->link(__('New Visit'), array('action' => 'add'), array('class' => 'btn btn-success')); ?>	</div>
    <!-- /widget-content -->
    </div>
<?php endif; ?>

<script type="text/javascript">
    // Hide a columns
    visibilityFalse = [3,4,9,16,17,18,19];
</script>
