<div class="widget parameters-cost_per_km form">
	<?php echo $this->Form->create('Parameter'); ?>
	<div class="widget-header">
		<h3><?php echo __('Edit system parameters'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
				echo $this->Form->input('notifyPendingReport', array('type' => 'number', 'min' => 1, 'after' => ' '.__('days')));
				echo $this->Form->input('notifyUpcomingVisits', array('type' => 'number', 'min' => 1, 'after' => ' '.__('days')));
				echo $this->Form->input('updatePassword');
			?>
		<div class="form-actions">
			<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-success', 'div' => false)); ?>
			<?php echo $this->Form->end(); ?>
			<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

<?php if ($rebuilt): ?>
	<div class="widget">
		<div class="widget-header">
			<h3><?php echo __('Actions'); ?></h3>
		</div>
		<!-- /widget-header -->
		<div class="widget-content actions">
			<?php echo $this->Html->link(__('Rebuild Aco Tree (Actions & Controllers)'), array('action' => 'rebuilt'), array('class' => 'btn btn-info')); ?>
		</div>
		<!-- /widget-content -->
	</div>
<?php endif; ?>
