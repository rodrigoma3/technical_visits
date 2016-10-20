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
	        <ul class="nav pull-right">
	          <li class="dropdown" id="fat-menu">
				  <?php echo $this->Html->link(
				  		__('Welcome, ').$this->Session->read('Auth.User.name').'<b class="caret"></b>',
						'#',
						array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false, 'role' => 'button', 'id' => 'drop3', 'aria-haspopup' => 'true', 'aria-expanded' => 'false')
					); ?>
				<ul class="dropdown-menu" aria-labelledby="drop3">
	              <li><?php echo $this->Html->link(__('Profile'), array('controller' => 'users', 'action' => 'view', $this->Session->read('Auth.User.id'))); ?></li>
	              <li><?php echo $this->Html->link(__('Logout'), array('controller' => 'users', 'action' => 'logout')); ?></li>
	            </ul>
	          </li>
	        </ul>
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

	<div class="subnavbar">
		<?php if (!empty($menus)): ?>
			<div class="subnavbar-inner">
				<div class="container">
					<ul class="mainnav">
						<?php foreach ($menus as $menu): ?>
							<?php if ($menu['allow']): ?>
								<li <?php if ($this->params['controller'] == $menu['controller']) echo 'class="active"'; ?>>
									<?php
									echo $this->Html->link(
										$menu['icon'].'<span>'.$menu['title'].'</span>',
										array('controller' => $menu['controller'], 'action' => $menu['action']),
										array('escape' => false)
									);
									?>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>
				<!-- /container -->
			</div>
		<?php endif; ?>
	<!-- /subnavbar-inner -->
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
		var lang = "<?php echo Router::url('/DataTables-1_10_12/locale/').Configure::read('Config.language').'.json'; ?>";
	</script>


	<?php if (isset($jstreeData)) { ?>
	    <script type="text/javascript">
	        $(function () { $('#jstree').jstree({
	            "checkbox" : {
	                "keep_selected_style" : false
	            },
	            "plugins" : [ "checkbox" ],
	            'core' : {
	                'data' : <?php echo $jstreeData; ?>
	            },
	        }); });

	        $('#jstree').on("changed.jstree", function (e, data) {
	        //   console.log('Selected: '+data.selected);
	        //   console.log('input antes: '+$('input[data-jstreedata]').val());
			  $('input[data-jstreedata]').val(data.selected);
			//   console.log('input depois: '+$('input[data-jstreedata]').val());
	        });

	    </script>
	<?php } ?>

	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
