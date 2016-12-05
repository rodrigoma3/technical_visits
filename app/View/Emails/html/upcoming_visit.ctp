<h1><?php echo __('Hello %s!', $visit['User']['name']); ?></h1>
<br>
<h3><?php echo __('We would like to inform you that your visit on %s to %s is near.', $visit['Visit']['departure'], $visit['Visit']['destination']); ?>
<br>
<br>
<p><?php echo __('In case of doubts, please contact the system administrator.'); ?></p>
<p><?php echo __('This is an automated e-mail. Do not answer it.') ?></p>
