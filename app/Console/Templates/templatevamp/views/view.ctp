<div class="widget <?php echo $pluralVar; ?> view">
	<div class="widget-header">
		<h3><?php echo "<?php echo __('{$singularHumanName}'); ?>"; ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<dl>
			<?php
			foreach ($fields as $field) {
				$isKey = false;
				if (!empty($associations['belongsTo'])) {
					foreach ($associations['belongsTo'] as $alias => $details) {
						if ($field === $details['foreignKey']) {
							$isKey = true;
							echo "\t\t<dt><?php echo __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></dt>\n";
							echo "\t\t<dd>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t\t&nbsp;\n\t\t</dd>\n";
							break;
						}
					}
				}
				if ($isKey !== true) {
					echo "\t\t<dt><?php echo __('" . Inflector::humanize($field) . "'); ?></dt>\n";
					echo "\t\t<dd>\n\t\t\t<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>\n\t\t\t&nbsp;\n\t\t</dd>\n";
				}
			}
			?>
		</dl>
		<div class="form-actions">
			<?php
				echo "\t\t<?php echo \$this->Html->link(__('List " . $pluralHumanName . "'), array('action' => 'index'), array('class' => 'btn btn-success')); ?>\n";
				echo "\t\t<?php echo \$this->Html->link(__('Edit " . $singularHumanName ."'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn')); ?>\n";
				echo "\t\t<?php echo \$this->Form->postLink(__('Delete " . $singularHumanName . "'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}']))); ?>\n";
			?>
		</div>
	</div>
<!-- /widget-content -->
</div>

<?php
if (!empty($associations['hasOne'])) :
	foreach ($associations['hasOne'] as $alias => $details): ?>
	<div class="widget <?php echo $pluralVar; ?> view related">
		<div class="widget-header">
			<h3><?php echo "<?php echo __('Related " . Inflector::humanize($details['controller']) . "'); ?>"; ?></h3>
		</div>
		<!-- /widget-header -->
	<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n"; ?>
		<div class="widget-content">
			<dl>
				<?php
					foreach ($details['fields'] as $field) {
						echo "\t\t<dt><?php echo __('" . Inflector::humanize($field) . "'); ?></dt>\n";
						echo "\t\t<dd>\n\t<?php echo \${$singularVar}['{$alias}']['{$field}']; ?>\n&nbsp;</dd>\n";
					}
				?>
			</dl>
		</div>
	<?php echo "<?php endif; ?>\n"; ?>
		<div class="form-actions">
			<?php echo "<?php echo \$this->Html->link(__('Edit " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$singularVar}['{$alias}']['{$details['primaryKey']}']), array('class' => 'btn')); ?>\n"; ?>
			<?php echo "<?php echo \$this->Form->postLink(__('Delete " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'delete', \${$singularVar}['{$alias}']['{$details['primaryKey']}']), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', \${$singularVar}['{$alias}']['{$details['primaryKey']}']))); ?>\n"; ?>
		</div>
	</div>
	<?php
	endforeach;
endif;

if (empty($associations['hasMany'])) {
	$associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
	$associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
foreach ($relations as $alias => $details):
	$otherSingularVar = Inflector::variable($alias);
	$otherPluralHumanName = Inflector::humanize($details['controller']);
	?>
<div class="widget <?php echo $pluralVar; ?> view related">
	<div class="widget-header">
		<h3><?php echo "<?php echo __('Related " . $otherPluralHumanName . "'); ?>"; ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<table id="dataTables" class="display nowrap">
			<thead>
				<tr>
					<th></th>
					<?php
						foreach ($details['fields'] as $field) {
							echo "\t\t<th><?php echo __('" . Inflector::humanize($field) . "'); ?></th>\n";
						}
					?>
					<th><?php echo "<?php echo __('Actions'); ?>"; ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th></th>
					<?php
						foreach ($details['fields'] as $field) {
							echo "\t\t<th><?php echo __('" . Inflector::humanize($field) . "'); ?></th>\n";
						}
					?>
					<th><?php echo "<?php echo __('Actions'); ?>"; ?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php
				echo "\t<?php foreach (\${$singularVar}['{$alias}'] as \${$otherSingularVar}): ?>\n";
						echo "\t\t<tr>\n";
							echo "\t\t\t<td></td>\n";
							foreach ($details['fields'] as $field) {
								echo "\t\t\t<td><?php echo \${$otherSingularVar}['{$field}']; ?></td>\n";
							}

							echo "\t\t\t<td class=\"actions\">\n";
							echo "\t\t\t\t<?php echo \$this->Html->link('<i class=\"fa fa-eye\"></i> '.__('View'), array('controller' => '{$details['controller']}', 'action' => 'view', \${$otherSingularVar}['{$details['primaryKey']}']), array('escape' => false, 'class' => 'btn')); ?>\n";
							echo "\t\t\t\t<?php echo \$this->Html->link('<i class=\"fa fa-pencil\"></i> '.__('Edit'), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$otherSingularVar}['{$details['primaryKey']}']), array('escape' => false, 'class' => 'btn')); ?>\n";
							echo "\t\t\t\t<?php echo \$this->Form->postLink('<i class=\"fa fa-trash\"></i> '.__('Delete'), array('controller' => '{$details['controller']}', 'action' => 'delete', \${$otherSingularVar}['{$details['primaryKey']}']), array('escape' => false, 'class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', \${$otherSingularVar}['{$details['primaryKey']}']))); ?>\n";
							echo "\t\t\t</td>\n";
						echo "\t\t</tr>\n";

				echo "\t<?php endforeach; ?>\n";
				?>
			</tbody>
		</table>
		<div class="form-actions">
			<?php echo "<?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('class' => 'btn btn-success')); ?>"; ?>
		</div>
	</div>
<!-- /widget-content -->
</div>
<?php
endforeach;
?>
