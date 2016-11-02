<?php echo $this->Form->create('User'); ?>
<h1><?php echo __('Login'); ?></h1>

<div class="login-fields">
    <p><?php echo __('Please provide your details'); ?></p>
    <?php
        echo $this->Form->input('email', array('label' => false, 'placeholder' => __('E-mail'), 'class' => 'login username-field', 'div' => 'field input-prepend', 'id' => 'username', 'before' => '<span class="add-on"><i class="fa fa-envelope"></i></span>', 'autofocus' => true));
        echo $this->Form->input('password', array('label' => false, 'placeholder' => __('Password'), 'class' => 'login password-field', 'div' => 'field input-prepend', 'id' => 'password', 'before' => '<span class="add-on"><i class="fa fa-key"></i></span>'));
    ?>
</div> <!-- /login-fields -->

<div class="login-actions">
    <span class="login-checkbox">
        <?php
            echo $this->Form->input('remember_me', array('label' => __('Keep me signed in'), 'type' => 'checkbox', 'class' => 'field login-checkbox'));
        ?>
    </span>
    <?php echo $this->Form->end(array('label' => __('Login'), 'class' => 'button btn btn-success btn-large', 'div' => false)); ?>
</div> <!-- .actions -->
