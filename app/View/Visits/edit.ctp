<div class="widget visits form">
	<?php echo $this->Form->create('Visit'); ?>
	<div class="widget-header">
		<h3><?php echo __('Edit Visit'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
		echo $this->Form->input('id');
		echo $this->Form->input('departure', ['type'=>'datetime-local']);
		echo $this->Form->input('arrival', ['type'=>'datetime-local']);
		echo $this->Form->input('destination');
		echo $this->Form->input('number_of_students');
		echo $this->Form->input('refund');
		echo $this->Form->input('transport');
		echo $this->Form->input('transport_cost');
		echo $this->Form->input('distance');
		echo $this->Form->input('objective');
		echo $this->Form->input('comments');
		echo $this->Form->input('status');
		echo $this->Form->input('user_id');
		echo $this->Form->input('city_id');
		echo $this->Form->input('course');
		echo $this->Form->input('discipline_id');
		echo $this->Form->input('team_id');
	?>
		<div class="form-actions">
					<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-success', 'div' => false)); ?>
		<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
