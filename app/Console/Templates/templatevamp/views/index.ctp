<div class="widget <?php echo $pluralVar; ?> index">
    <div class="widget-header">
		<h3><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></h3>
	</div>
    <!-- /widget-header -->
    <div class="widget-content">
    	<table id="dataTables" class="display nowrap">
        	<thead>
            	<tr>
                    <th></th>
            	<?php foreach ($fields as $field): ?>
                	<th><?php echo "<?php echo __('{$field}'); ?>"; ?></th>
            	<?php endforeach; ?>
                	<th><?php echo "<?php echo __('Actions'); ?>"; ?></th>
            	</tr>
        	</thead>
        	<tfoot>
            	<tr>
                    <th></th>
            	<?php foreach ($fields as $field): ?>
            		<th><?php echo "<?php echo __('{$field}'); ?>"; ?></th>
            	<?php endforeach; ?>
            		<th><?php echo "<?php echo __('Actions'); ?>"; ?></th>
            	</tr>
        	</tfoot>
        	<tbody>
            	<?php
            	echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
            	echo "\t<tr>\n";
                    echo "\t\t<td></td>\n";
            		foreach ($fields as $field) {
            			$isKey = false;
            			if (!empty($associations['belongsTo'])) {
            				foreach ($associations['belongsTo'] as $alias => $details) {
            					if ($field === $details['foreignKey']) {
            						$isKey = true;
            						echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
            						break;
            					}
            				}
            			}
            			if ($isKey !== true) {
            				echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
            			}
            		}

            		echo "\t\t<td class=\"actions\">\n";
            		echo "\t\t\t<?php echo \$this->Html->link('<i class=\"fa fa-eye\"></i> '.__('View'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape' => false, 'class' => 'btn')); ?>\n";
            		echo "\t\t\t<?php echo \$this->Html->link('<i class=\"fa fa-pencil\"></i> '.__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape' => false, 'class' => 'btn')); ?>\n";
            		echo "\t\t\t<?php echo \$this->Form->postLink('<i class=\"fa fa-trash\"></i> '.__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape' => false, 'class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}']))); ?>\n";
            		echo "\t\t</td>\n";
            	echo "\t</tr>\n";

            	echo "<?php endforeach; ?>\n";
            	?>
        	</tbody>
    	</table>
    </div>
<!-- /widget-content -->
</div>

<div class="widget">
	<div class="widget-header">
		<h3><?php echo "<?php echo __('Actions'); ?>"; ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content actions">
        <?php echo "<?php echo \$this->Html->link(__('New " . $singularHumanName . "'), array('action' => 'add'), array('class' => 'btn btn-success')); ?>"; ?>
	</div>
<!-- /widget-content -->
</div>
