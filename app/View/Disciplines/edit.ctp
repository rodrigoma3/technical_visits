<div class="widget disciplines form">
	<?php echo $this->Form->create('Discipline'); ?>
	<div class="widget-header">
		<h3><?php echo __('Edit Discipline'); ?></h3>
	</div>
	<!-- /widget-header -->
	<div class="widget-content">
			<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('academic_period', array('min' => 1));
		echo $this->Form->input('course_id');
		echo $this->Form->input('Team');
	?>
		<div class="form-actions">
					<?php echo $this->Form->end(array('label' => __('Submit'), 'class' => 'btn btn-success', 'div' => false)); ?>
		<?php echo $this->Html->link(__('Cancel'), $this->request->referer(), array('class' => 'btn')); ?>
		</div>
	</div>
<!-- /widget-content -->
</div>

<script type="text/javascript">
	var courses = <?php echo $coursesJson; ?>;
	$('#DisciplineCourseId').change(function(){
		setAttrMax();
	});

	setAttrMax();

	function setAttrMax(){
		var courseId = $('#DisciplineCourseId option:selected').val();
		for (var i = 0; i < courses.length; i++) {
			if(courseId === courses[i].Course.id) {
				var aoap = courses[i].Course.amount_of_academic_periods;
				if ($('#DisciplineAcademicPeriod').val() > aoap) {
					$('#DisciplineAcademicPeriod').val(aoap);
				}
				$('#DisciplineAcademicPeriod').attr('max', courses[i].Course.amount_of_academic_periods);
			}
		}
	}
</script>
