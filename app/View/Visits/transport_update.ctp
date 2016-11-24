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
			echo $this->Form->input('transport_cost', ['readonly' => true, 'between' => '<span class="add-on add-on-left">R$</span>', 'div' => 'input text input-prepend input-append', 'escape' => false, 'after' => '<p class="help-block">'.$cost_per_km.'</p>']);
		?>
		<div class="form-actions">
			<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
