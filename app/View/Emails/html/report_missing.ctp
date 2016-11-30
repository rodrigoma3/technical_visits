<h1><?php echo __('Hello %s!', $v['User']['name']); ?></h1>
<br>
<h3><?php echo __('We are sorry to inform your visit on %s to %s is missing report!', $v['Visit']['departure'], $v['Visit']['destination']); ?>
<br>
<br>
<p><?php echo __('Please submit the report as soon as possible.') ?></p>
<br>
<p><?php echo __('In case of doubts, please contact the system administrator.'); ?></p>
<p><?php echo __('This is an automated e-mail. Do not answer it.') ?></p>
