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
						echo $this->Html->image('flags-country/Brazil gray.ico', array('alt' => 'Brazil', 'border' => '0', 'id' => 'flag-country'));
					} else {
						echo $this->Html->link(
								$this->Html->image('flags-country/Brazil.ico', array('alt' => 'Brazil', 'border' => '0', 'id' => 'flag-country')),
								array('controller' => 'groups', 'action' => 'set_language', 'pt-br'),
								array('escape' => false)
							);
					}
					if (Configure::read('Config.language') == 'en-us') {
						echo $this->Html->image('flags-country/United States gray.ico', array('alt' => 'Estados Unidos', 'border' => '0', 'id' => 'flag-country'));
					} else {
						echo $this->Html->link(
								$this->Html->image('flags-country/United States.ico', array('alt' => 'Estados Unidos', 'border' => '0', 'id' => 'flag-country')),
								array('controller' => 'groups', 'action' => 'set_language', 'en-us'),
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


	<?php echo $this->Flash->render('auth'); ?>

	<?php echo $this->Flash->render(); ?>

	<div class="account-container">

		<div class="content clearfix">

			<?php echo $this->fetch('content'); ?>

		</div> <!-- /content -->

	</div> <!-- /account-container -->

	<div class="login-extra">
		<?php echo $this->Html->link(__('Reset Password'), array('controller' => 'users', 'action' => 'reset_password')); ?>
		<!-- <a href="#">Reset Password</a> -->
	</div> <!-- /login-extra -->

	<script type="text/javascript">
		var lang = "<?php echo Configure::read('Config.language'); ?>";
		var langpath = "<?php echo Router::url('/DataTables-1_10_12/languages/'); ?>";
	</script>

	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
