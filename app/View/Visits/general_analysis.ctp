<div class="widget visits form">
	<div class="widget-header">
		<h3><?php echo __('General analysis'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
		<div class="shortcuts">
			<!-- <a href="javascript:;" class="shortcut">
				<i class="shortcut-icon icon-list-alt"></i>
				<span class="shortcut-label">Apps</span>
			</a> -->
			<?php foreach ($charts as $chart): ?>
				<?php if ($chart['allow']): ?>
					<?php echo $this->Html->link(
						'<i class="shortcut-icon '.$chart['icon'].'"></i> <span class="shortcut-label">'.$chart['title'].'</span>',
						array('controller' => $chart['controller'], 'action' => $chart['action']),
						array('class' => 'shortcut', 'escape' => false)
					); ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<!-- /widget-content -->
</div>
