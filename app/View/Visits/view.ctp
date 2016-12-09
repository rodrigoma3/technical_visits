<div class="widget visits view">
	<div class="widget-header">
		<h3><?php echo __('Visit'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<dl>
			<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($visit['Status']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Departure'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['departure']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Arrival'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['arrival']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Destination'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['destination']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo $this->Html->link($visit['City']['name'], array('controller' => 'cities', 'action' => 'view', $visit['City']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo $this->Html->link($visit['City']['State']['name_initial'], array('controller' => 'states', 'action' => 'view', $visit['City']['State']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Transport'); ?></dt>
		<dd>
			<?php echo h($visit['Transport']['name']); ?>
			&nbsp;
		</dd>
		<?php if ($visit['Visit']['transport'] > 1): ?>
			<dt><?php echo __('Distance'); ?></dt>
			<dd>
				<?php echo h($visit['Visit']['distance']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Transport Cost'); ?></dt>
			<dd>
				<?php echo h($visit['Visit']['transport_cost']); ?>
				&nbsp;
			</dd>
		<?php endif; ?>
		<?php if ($preApproveVisit && $visit['City']['short_distance'] == false): ?>
			<?php echo $this->Form->create('Visit', array('url' => 'pre_approve_visit/'.$visit['Visit']['id'])); ?>
			<?php echo $this->Form->input('refund', array('min' => 0, 'step' => '0.01', 'value' => '0')); ?>
		<?php else: ?>
			<dt><?php echo __('Refund'); ?></dt>
			<dd>
				<?php echo h($visit['Visit']['refund']); ?>
				&nbsp;
			</dd>
		<?php endif; ?>
		<dt><?php echo __('Objective'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['objective']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comments'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['comments']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($visit['User']['name'], array('controller' => 'users', 'action' => 'view', $visit['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Course'); ?></dt>
		<dd>
			<?php echo $this->Html->link($courses[$visit['Team']['Discipline'][0]['course_id']], array('controller' => 'courses', 'action' => 'view', $visit['Team']['Discipline'][0]['course_id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discipline'); ?></dt>
		<dd>
			<?php echo $this->Html->link($visit['Discipline']['name'], array('controller' => 'disciplines', 'action' => 'view', $visit['Visit']['discipline_id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Team'); ?></dt>
		<dd>
			<?php echo $this->Html->link($visit['Team']['name'], array('controller' => 'teams', 'action' => 'view', $visit['Team']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Number Of Students'); ?></dt>
		<dd>
			<?php echo h($visit['Visit']['number_of_students']); ?>
			&nbsp;
		</dd>
		<?php if ($visit['Visit']['report'] != ''): ?>
			<dt><?php echo __('Report'); ?></dt>
			<dd>
				<?php echo $this->Html->link($visit['Visit']['report'], array('controller' => 'visits', 'action' => 'download_report', $visit['Visit']['id']), array('escape' => false)); ?>
				&nbsp;
			</dd>
		<?php endif; ?>
		</dl>
		<div class="form-actions">
			<?php if ($approveVisit): ?>
				<?php echo $this->Form->postLink('<i class="fa fa-thumbs-o-up"></i> '.__('Approve Visit'), array('action' => 'approve_visit', $visit['Visit']['id']), array('class' => 'btn btn-success', 'confirm' => __('Are you sure you want to approve # %s?', $visit['Visit']['id']), 'escape' => false)); ?>
			<?php endif; ?>
			<?php if ($preApproveVisit): ?>
				<!-- <?php echo $this->Form->postLink('<i class="fa fa-thumbs-o-up"></i> '.__('Pre Approve Visit'), array('action' => 'pre_approve_visit', $visit['Visit']['id']), array('class' => 'btn btn-success', 'confirm' => __('Are you sure you want to approve # %s?', $visit['Visit']['id']), 'escape' => false)); ?> -->
				<?php echo $this->Form->button('<i class="fa fa-thumbs-o-up"></i> '.__('Pre Approve Visit'), array('type' => 'submit', 'class' => 'btn btn-success', 'confirm' => __('Are you sure you want to approve # %s?', $visit['Visit']['id']), 'escape' => false)); ?>
				<?php if ($visit['City']['short_distance'] == false): ?>
					<?php echo $this->Form->end(); ?>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ($approveVisit || $preApproveVisit): ?>
				<?php echo $this->Html->link('<i class="fa fa-thumbs-o-down"></i> '.__('Disapprove Visit'), array('controller' => 'refusals', 'action' => 'disapproved_visit', $visit['Visit']['id']), array('class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to disapprove # %s?', $visit['Visit']['id']), 'escape' => false)); ?>
			<?php endif; ?>
			<?php if ($approveReport): ?>
				<?php echo $this->Form->postLink('<i class="fa fa-thumbs-o-up"></i> '.__('Approve Report'), array('action' => 'approve_report', $visit['Visit']['id']), array('class' => 'btn btn-success', 'confirm' => __('Are you sure you want to approve # %s?', $visit['Visit']['id']), 'escape' => false)); ?>
				<?php echo $this->Html->link('<i class="fa fa-thumbs-o-down"></i> '.__('Disapprove Report'), array('controller' => 'refusals', 'action' => 'disapproved_report', $visit['Visit']['id']), array('class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to disapprove # %s?', $visit['Visit']['id']), 'escape' => false)); ?>
			<?php endif; ?>
			<?php if ($deliverReport): ?>
				<?php echo $this->Html->link('<i class="fa fa-paper-plane-o"></i> '.__('Deliver report'), '#deliverReport', array('class' => 'btn btn-success', 'role' => 'button', 'data-toggle' => 'modal', 'escape' => false)); ?>
			<?php endif; ?>
			<?php echo $this->Html->link(__('List Visits'), array('action' => 'index'), array('class' => 'btn btn-primary')); ?>
			<?php echo $this->Html->link(__('Edit Visit'), array('action' => 'edit', $visit['Visit']['id']), array('class' => 'btn')); ?>
			<?php echo $this->Form->postLink(__('Delete Visit'), array('action' => 'delete', $visit['Visit']['id']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $visit['Visit']['id']))); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

<div class="widget visits view related">
	<div class="widget-header">
		<h3><?php echo __('Related Refusals'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<table id="dataTables" class="display nowrap">
			<thead>
				<tr>
					<th></th>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Date'); ?></th>
					<th><?php echo __('Reason'); ?></th>
					<th><?php echo __('Type'); ?></th>
					<th><?php echo __('User'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th></th>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Date'); ?></th>
					<th><?php echo __('Reason'); ?></th>
					<th><?php echo __('Type'); ?></th>
					<th><?php echo __('User'); ?></th>
					<th></th>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($visit['Refusal'] as $refusal): ?>
					<tr>
						<td></td>
						<td><?php echo $refusal['id']; ?></td>
						<td><?php echo $refusal['created']; ?></td>
						<td><?php echo $refusal['reason']; ?></td>
						<td><?php echo $refusal_types[$refusal['type']]; ?></td>
						<td><?php echo $refusal['User']['name']; ?></td>
						<td></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
<!-- /widget-content -->
</div>

<!-- Modal -->
<div id="deliverReport" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deliverReportLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="deliverReportLabel"><?php echo __('Deliver report'); ?></h3>
	</div>
	<div class="modal-body">
		<?php
			echo $this->Form->create('Visit', array('type' => 'file', 'url' => 'deliver_report'));
			echo $this->Form->input('id', array('value' => $visit['Visit']['id']));
			echo $this->Form->file('report');
		 ?>
	</div>
	<div class="modal-footer">
		<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-success', 'div' => false)); ?>
		<?php echo $this->Form->end(); ?>
		<?php echo $this->Form->button(__('Close'), array('data-dismiss' => 'modal', 'aria-hidden' => 'true', 'class' => 'btn')); ?>
	</div>
</div>
