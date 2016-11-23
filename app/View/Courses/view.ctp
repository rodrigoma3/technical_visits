<div class="widget courses view">
	<div class="widget-header">
		<h3><?php echo __('Course'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<dl>
					<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($course['Course']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($course['Course']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type Of Academic Period'); ?></dt>
		<dd>
			<?php echo h($course['TypeOfAcademicPeriod']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Amount Of Academic Periods'); ?></dt>
		<dd>
			<?php echo h($course['Course']['amount_of_academic_periods']); ?>
			&nbsp;
		</dd>
		</dl>
		<div class="form-actions">
					<?php echo $this->Html->link(__('List Courses'), array('action' => 'index'), array('class' => 'btn btn-success')); ?>
		<?php echo $this->Html->link(__('Edit Course'), array('action' => 'edit', $course['Course']['id']), array('class' => 'btn')); ?>
		<?php echo $this->Form->postLink(__('Delete Course'), array('action' => 'delete', $course['Course']['id']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $course['Course']['id']))); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

<div class="widget courses view related">
	<div class="widget-header">
		<h3><?php echo __('Related Disciplines'); ?></h3>
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
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th></th>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Academic Period'); ?></th>
					<th><?php echo __('Actions'); ?></th>
				</tr>
			</tfoot>
			<tbody>
					<?php foreach ($course['Discipline'] as $discipline): ?>
		<tr>
			<td></td>
			<td><?php echo $discipline['id']; ?></td>
			<td><?php echo $discipline['name']; ?></td>
			<td><?php echo $discipline['academic_period']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link('<i class="fa fa-eye"></i> '.__('View'), array('controller' => 'disciplines', 'action' => 'view', $discipline['id']), array('escape' => false, 'class' => 'btn')); ?>
				<?php echo $this->Html->link('<i class="fa fa-pencil"></i> '.__('Edit'), array('controller' => 'disciplines', 'action' => 'edit', $discipline['id']), array('escape' => false, 'class' => 'btn')); ?>
				<?php echo $this->Form->postLink('<i class="fa fa-trash"></i> '.__('Delete'), array('controller' => 'disciplines', 'action' => 'delete', $discipline['id']), array('escape' => false, 'class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $discipline['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
			</tbody>
		</table>
		<div class="form-actions">
			<?php echo $this->Html->link(__('New Discipline'), array('controller' => 'disciplines', 'action' => 'add'), array('class' => 'btn btn-success')); ?>		</div>
	</div>
<!-- /widget-content -->
</div>
