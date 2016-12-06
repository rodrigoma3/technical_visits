<div class="widget visits form">
	<?php echo $this->Form->create('Visit'); ?>
	<div class="widget-header">
		<h3><?php echo __('Transport update'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('status', ['disabled' => true]);
			echo $this->Form->input('departure', ['type'=>'datetime-local', 'disabled' => true]);
			echo $this->Form->input('arrival', ['type'=>'datetime-local', 'disabled' => true]);
			echo $this->Form->input('destination', ['disabled' => true]);
			echo $this->Form->input('state', ['disabled' => true]);
			echo $this->Form->input('city_id', ['disabled' => true]);
			echo $this->Form->input('course', ['disabled' => true]);
			echo $this->Form->input('discipline_id', ['disabled' => true]);
			echo $this->Form->input('team_id', ['disabled' => true]);
			echo $this->Form->input('number_of_students', ['disabled' => true]);
			echo $this->Form->input('objective', ['disabled' => true]);
			echo $this->Form->input('comments', ['disabled' => true]);
			echo $this->Form->input('transport', ['empty' => __('(choose one)')]);
			echo $this->Form->input('distance', ['min' => 1, 'after' => '<span class="add-on">km</span>', 'div' => 'input text input-prepend input-append', 'escape' => false]);
			echo $this->Form->input('transport_cost', ['readonly' => true, 'between' => '<span class="add-on add-on-left">R$</span>', 'div' => 'input text input-prepend input-append', 'escape' => false, 'after' => '<p class="help-block">'.$costPerKm.'</p>']);
		?>
		<div class="form-actions">
			<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Form->end(); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

<div class="widget visits transport_update related">
    <div class="widget-header">
		<h3><?php echo __('Visits on departure date'); ?></h3>
	</div>
    <!-- /widget-header -->
    <div class="widget-content">
    	<table id="dataTables" class="display nowrap">
        	<thead>
            	<tr>
                    <th></th>
                	<th><?php echo __('Id'); ?></th>
                    <th><?php echo __('Status'); ?></th>
                    <th><?php echo __('Destination'); ?></th>
                	<th><?php echo __('Departure'); ?></th>
                	<th><?php echo __('Arrival'); ?></th>
                	<th><?php echo __('Transport'); ?></th>
                	<th><?php echo __('User'); ?></th>
                	<th><?php echo __('City'); ?></th>
                    <th><?php echo __('State'); ?></th>
                	<th><?php echo __('Course'); ?></th>
                	<th><?php echo __('Discipline'); ?></th>
                	<th><?php echo __('Team'); ?></th>
                	<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</thead>
        	<tfoot>
            	<tr>
                    <th></th>
            		<th><?php echo __('id'); ?></th>
                    <th><?php echo __('status'); ?></th>
                    <th><?php echo __('destination'); ?></th>
            		<th><?php echo __('departure'); ?></th>
            		<th><?php echo __('arrival'); ?></th>
            		<th><?php echo __('transport'); ?></th>
            		<th><?php echo __('user_id'); ?></th>
            		<th><?php echo __('city_id'); ?></th>
            		<th><?php echo __('state_id'); ?></th>
            		<th><?php echo __('course_id'); ?></th>
            		<th><?php echo __('discipline_id'); ?></th>
            		<th><?php echo __('team_id'); ?></th>
            		<th><?php echo __('Actions'); ?></th>
            	</tr>
        	</tfoot>
        	<tbody>
            	<?php foreach ($visits as $visit): ?>
	<tr>
		<td></td>
		<td><?php echo h($visit['Visit']['id']); ?>&nbsp;</td>
        <td><?php echo h($visit['Status']['name']); ?>&nbsp;</td>
        <td><?php echo h($visit['Visit']['destination']); ?>&nbsp;</td>
		<td><?php echo h($visit['Visit']['departure']); ?>&nbsp;</td>
		<td><?php echo h($visit['Visit']['arrival']); ?>&nbsp;</td>
		<td><?php echo h($visit['Transport']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($visit['User']['name'], array('controller' => 'users', 'action' => 'view', $visit['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($visit['City']['name'], array('controller' => 'cities', 'action' => 'view', $visit['City']['id'])); ?>
    </td>
		<td>
      <?php echo $this->Html->link($visit['City']['State']['initials'], array('controller' => 'states', 'action' => 'view', $visit['City']['State']['id'])); ?>
		</td>
    <td>
			<?php echo $this->Html->link($courses[$visit['Team']['Discipline'][0]['course_id']], array('controller' => 'courses', 'action' => 'view', $visit['Team']['Discipline'][0]['course_id'])); ?>
		</td>
    <td>
			<?php echo $this->Html->link($visit['Discipline']['name'], array('controller' => 'disciplines', 'action' => 'view', $visit['Visit']['discipline_id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($visit['Team']['name'], array('controller' => 'teams', 'action' => 'view', $visit['Team']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link('<i class="fa fa-lg fa-eye"></i>&nbsp;', array('action' => 'view', $visit['Visit']['id']), array('escape' => false, 'title' => __('View'))); ?>
			<?php echo $this->Html->link('<i class="fa fa-lg fa-pencil"></i>&nbsp;', array('action' => 'edit', $visit['Visit']['id']), array('escape' => false, 'title' => __('Edit'))); ?>
			<?php echo $this->Html->link('<i class="fa fa-lg fa-copy"></i>&nbsp;', array('action' => 'copy', $visit['Visit']['id']), array('escape' => false, 'title' => __('Copy'))); ?>
			<?php echo $this->Html->link('<i class="fa fa-lg fa-trash"></i>&nbsp;', array('controller' => 'refusals','action' => 'cancel', $visit['Visit']['id']), array('escape' => false, 'confirm' => __('Are you sure you want to cancel # %s?', $visit['Visit']['id']), 'title' => __('Cancel'))); ?>
			<?php echo $this->Html->link('<i class="fa fa-lg fa-truck"></i>&nbsp;', array('action' => 'transport_update', $visit['Visit']['id']), array('escape' => false, 'title' => __('Transport'))); ?>
        </td>
	</tr>
<?php endforeach; ?>
        	</tbody>
    	</table>
    </div>
<!-- /widget-content -->
</div>
