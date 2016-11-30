<h1><?php echo __('Hello %s!', $v['User']['name']); ?></h1>
<br>
<h3><?php echo __('We are sorry to inform your submitted report for the visit on %s to %s has been desaproved due to:', $v['Visit']['departure'], $v['Visit']['destination']); ?>
<br>
<?php echo '"'.$reason.'"'; ?></h3>
<br>
<p><?php echo __('Please resubmit the report accordingly.') ?></p>
<br>
<p><?php echo __('In case of doubts, please contact the system administrator: %s', $adminEmail); ?></p>
<p><?php echo __('This is an automated e-mail. Do not answer it.') ?></p>
