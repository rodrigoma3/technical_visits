<div class="widget visits form">
	<?php echo $this->Form->create('Visit'); ?>
	<div class="widget-header">
		<h3><?php echo __('Edit Visit'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('transport', ['type' => 'checkbox', 'label' => __('Own transport')]);
			echo $this->Form->input('departure', ['type'=>'datetime-local', 'min' => date('Y-m-d\TH:i', strtotime('+ 1 day'))]);
			echo $this->Form->input('arrival', ['type'=>'datetime-local', 'min' => date('Y-m-d\TH:i', strtotime('+ 1 day'))]);
			echo $this->Form->input('destination');
			echo $this->Form->input('city_id', ['empty' => __('(choose one)')]);
			echo $this->Form->input('course', ['empty' => __('(choose one)')]);
			echo $this->Form->input('discipline_id', ['empty' => __('(choose a course before)')]);
			echo $this->Form->input('team_id', ['empty' => __('(choose a discipline before)')]);
			echo $this->Form->input('number_of_students', ['min' => 1]);
			echo $this->Form->input('objective');
			echo $this->Form->input('comments');
		?>
		<div class="form-actions">
			<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Form->end(); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
