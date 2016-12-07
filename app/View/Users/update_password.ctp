<div class="account-container">

    <div class="content clearfix">

        <?php echo $this->Form->create('User'); ?>
        <h1><?php echo __('Update password'); ?></h1>

        <div class="login-fields">
            <p><?php echo __('Please choose your password'); ?></p>
            <?php
                echo $this->Form->input('id');
                echo $this->Form->input('name', array('label' => false, 'disabled' => true, 'class' => 'login password-field', 'div' => 'field input-prepend', 'id' => 'password', 'before' => '<span class="add-on"><i class="fa fa-user"></i></span>'));
                echo $this->Form->input('email', array('label' => false, 'disabled' => true, 'class' => 'login password-field', 'div' => 'field input-prepend', 'id' => 'password', 'before' => '<span class="add-on"><i class="fa fa-envelope"></i></span>'));
                echo $this->Form->input('password', array('label' => false, 'placeholder' => __('Password'), 'class' => 'login password-field', 'div' => 'field input-prepend', 'id' => 'password', 'before' => '<span class="add-on"><i class="fa fa-key"></i></span>'));
                echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => false, 'placeholder' => __('Confirm password'), 'class' => 'login password-field', 'div' => 'field input-prepend', 'id' => 'password', 'before' => '<span class="add-on"><i class="fa fa-key"></i></span>'));
            ?>
        </div> <!-- /login-fields -->

        <div class="login-actions">
            <?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'button btn btn-success btn-large', 'div' => false)); ?>
            <?php echo $this->Form->end(); ?>
        </div> <!-- .actions -->

    </div> <!-- /content -->

</div> <!-- /account-container -->
