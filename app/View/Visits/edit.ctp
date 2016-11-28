<div class="widget visits form">
	<?php echo $this->Form->create('Visit'); ?>
	<div class="widget-header">
		<h3><?php if ($this->data['Visit']['visit_id_edit'] > 0) {
			echo __('Requested change on visit');
		} else {
			echo __('Edit Visit');
		}?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<?php
			echo $this->Form->input('id');
			if ($this->data['Visit']['visit_id_edit'] > 0) {
				echo $this->Form->input('transport', ['disabled' => ($this->data['Visit']['visit_id_edit'] > 0) ? true : false]);
			} else {
				echo $this->Form->input('transport', ['type' => 'checkbox', 'label' => __('Own transport')]);
			}
			echo $this->Form->input('departure', ['type'=>'datetime-local', 'disabled' => ($this->data['Visit']['visit_id_edit'] > 0) ? true : false]);
			echo $this->Form->input('arrival', ['type'=>'datetime-local', 'disabled' => ($this->data['Visit']['visit_id_edit'] > 0) ? true : false]);
			echo $this->Form->input('destination', ['disabled' => ($this->data['Visit']['visit_id_edit'] > 0) ? true : false]);
			echo $this->Form->input('states', ['empty' => __('(choose one)'), 'disabled' => ($this->data['Visit']['visit_id_edit'] > 0) ? true : false]);
			echo $this->Form->input('city_id', ['empty' => __('(choose a state)'), 'disabled' => ($this->data['Visit']['visit_id_edit'] > 0) ? true : false]);
			echo $this->Form->input('course', ['empty' => __('(choose one)'), 'disabled' => ($this->data['Visit']['visit_id_edit'] > 0) ? true : false]);
			echo $this->Form->input('discipline_id', ['empty' => __('(choose a course)'), 'disabled' => ($this->data['Visit']['visit_id_edit'] > 0) ? true : false]);
			echo $this->Form->input('team_id', ['empty' => __('(choose a discipline)'), 'disabled' => ($this->data['Visit']['visit_id_edit'] > 0) ? true : false]);
			echo $this->Form->input('number_of_students', ['min' => 1, 'disabled' => ($this->data['Visit']['visit_id_edit'] > 0) ? true : false]);
			echo $this->Form->input('objective', ['disabled' => ($this->data['Visit']['visit_id_edit'] > 0) ? true : false]);
			echo $this->Form->input('comments', ['disabled' => ($this->data['Visit']['visit_id_edit'] > 0) ? true : false]);
		?>
		<div class="form-actions">
			<?php if ($this->data['Visit']['visit_id_edit'] > 0): ?>
				<?php echo $this->Form->postLink('<i class="fa fa-thumbs-o-up"></i> '.__('Approve Change'), array('action' => 'approve_change', $this->data['Visit']['id']), array('class' => 'btn btn-success', 'confirm' => __('Are you sure you want to approve # %s?', $this->data['Visit']['id']), 'escape' => false)); ?>
				<?php echo $this->Html->link('<i class="fa fa-thumbs-o-down"></i> '.__('Disapprove Change'), array('controller' => 'refusals', 'action' => 'disapproved_change', $this->data['Visit']['id']), array('class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to disapprove # %s?', $this->data['Visit']['id']), 'escape' => false)); ?>
				<?php echo $this->Form->end(); ?>
			<?php else: ?>
				<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php endif; ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
