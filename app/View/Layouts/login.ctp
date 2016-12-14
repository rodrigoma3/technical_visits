<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array(
									'templatevamp/bootstrap.min',
									'templatevamp/bootstrap-responsive.min',
									'templatevamp/font.googleapis',
									'templatevamp/font-awesome',
									'templatevamp/style',
									'templatevamp/pages/signin',
									'/DataTables-1_10_12/media/css/jquery.dataTables.min',
									'/DataTables-1_10_12/extensions/Responsive/css/responsive.dataTables.min',
									'/DataTables-1_10_12/extensions/Select/css/select.dataTables.min',
									'jsTree/style.min',
									'custom',
		));

		echo $this->Html->script(array(
									'jquery-1.12.4.min',
									'bootstrap-dropdown',
									'templatevamp/excanvas.min',
									'templatevamp/chart.min',
									'templatevamp/base',
									'templatevamp/signin',
									'/DataTables-1_10_12/media/js/jquery.dataTables.min',
									'/DataTables-1_10_12/extensions/Responsive/js/dataTables.responsive.min',
									'/DataTables-1_10_12/extensions/Select/js/dataTables.select.min',
									'jsTree/jstree.min',
									'jquery.isloading.min',
									'custom',
		));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="navbar navbar-fixed-top">
	  <div class="navbar-inner">
	    <div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
			</a>
			<?php
				echo $this->Html->link(
						__('Technical Visits'),
						array('controller' => 'posts', 'action' => 'index'),
						array('escape' => false, 'class' => 'brand')
					);
			?>
	      <div class="nav-collapse">
			<div class="pull-right">
				<?php
					if (Configure::read('Config.language') == 'pt-br') {
						echo $this->Html->image('flags-country/Brazil gray.ico', array('alt' => __('Brazil'), 'border' => '0', 'id' => 'flag-country'));
					} else {
						echo $this->Html->link(
								$this->Html->image('flags-country/Brazil.ico', array('alt' => __('Brazil'), 'border' => '0', 'id' => 'flag-country')),
								array('controller' => 'parameters', 'action' => 'set_language', 'pt-br'),
								array('escape' => false)
							);
					}
					if (Configure::read('Config.language') == 'en-us') {
						echo $this->Html->image('flags-country/United States gray.ico', array('alt' => __('United States'), 'border' => '0', 'id' => 'flag-country'));
					} else {
						echo $this->Html->link(
								$this->Html->image('flags-country/United States.ico', array('alt' => __('United States'), 'border' => '0', 'id' => 'flag-country')),
								array('controller' => 'parameters', 'action' => 'set_language', 'en-us'),
								array('escape' => false)
							);
					}
					if (Configure::read('Config.language') == 'es-es') {
						echo $this->Html->image('flags-country/Spain gray.ico', array('alt' => __('Spain'), 'border' => '0', 'id' => 'flag-country'));
					} else {
						echo $this->Html->link(
								$this->Html->image('flags-country/Spain.ico', array('alt' => __('Spain'), 'border' => '0', 'id' => 'flag-country')),
								array('controller' => 'parameters', 'action' => 'set_language', 'es-es'),
								array('escape' => false)
							);
					}
				?>
			</div>
	      </div>
	      <!--/.nav-collapse -->
	    </div>
	    <!-- /container -->
	  </div>
	  <!-- /navbar-inner -->
	</div>

	<div class="subnavbar">

	</div>

	<div class="main">
		<div class="main-inner">
			<div class="container">
				<div class="row">
					<?php echo $this->Flash->render('auth'); ?>

					<?php echo $this->Flash->render(); ?>

					<?php echo $this->fetch('content'); ?>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		var lang = "<?php echo Router::url('/locale/').Configure::read('Config.language').'.json'; ?>";
	</script>

	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
