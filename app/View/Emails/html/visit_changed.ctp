<h1><?php echo __('%s has edited a visit!', $v['User']['name']); ?></h1>
<br>
<h3><?php echo __('The visit on %s to %s has been changed.', $v['Visit']['departure'], $v['Visit']['destination']); ?></h3>
<br>
<br>
<br>
<p><?php echo __('In case of doubts, please contact the teacher: %s', $v['User']['email']); ?></p>
<p><?php echo __('This is an automated e-mail. Do not answer it.') ?></p>
