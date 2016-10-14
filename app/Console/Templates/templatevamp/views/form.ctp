<div class="widget <?php echo $pluralVar; ?> form">
	<?php echo "<?php echo \$this->Form->create('{$modelClass}'); ?>\n"; ?>
	<div class="widget-header">
		<h3><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<?php
			echo "\t<?php\n";
			foreach ($fields as $field) {
				if (strpos($action, 'add') !== false && $field === $primaryKey) {
					continue;
				} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
					echo "\t\techo \$this->Form->input('{$field}');\n";
				}
			}
			if (!empty($associations['hasAndBelongsToMany'])) {
				foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
					echo "\t\techo \$this->Form->input('{$assocName}');\n";
				}
			}
			echo "\t?>\n";
		?>
		<div class="form-actions">
			<?php
				echo "\t\t<?php echo \$this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-success', 'div' => false)); ?>\n";
				echo "\t\t<?php echo \$this->Html->link(__('Cancel'), \$this->request->referer(), array('class' => 'btn')); ?>\n";
			?>
		</div>
	</div>
<!-- /widget-content -->
</div>
