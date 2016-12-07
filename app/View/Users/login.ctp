<div id="login-box" class="widget-box visible">
    <div class="account-container">

        <div class="content clearfix">

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
                <?php echo $this->Form->button(__('Login'), array('type' => 'submit', 'class' => 'button btn btn-success btn-large', 'div' => false)); ?>
                <?php echo $this->Form->end(); ?>
            </div> <!-- .actions -->

        </div> <!-- /content -->

    </div> <!-- /account-container -->

    <div class="login-extra">
        <?php echo $this->Html->link(__('Reset Password'), array('#'), array('data-target' => '#forgot-box')); ?>
        <!-- <a href="#">Reset Password</a> -->
    </div> <!-- /login-extra -->
</div>

<div id="forgot-box" class="widget-box">
    <div class="account-container">

        <div class="content clearfix">

            <?php echo $this->Form->create('User', array('url' => 'reset_password')); ?>
            <h1><?php echo __('Retrieve Password'); ?></h1>

            <div class="login-fields">
                <p><?php echo __('Enter your email and to receive instructions'); ?></p>
                <?php echo $this->Form->input('email', array('label' => false, 'placeholder' => __('E-mail'), 'class' => 'login username-field', 'div' => 'field input-prepend', 'id' => 'username', 'before' => '<span class="add-on"><i class="fa fa-envelope"></i></span>', 'autofocus' => true)); ?>
            </div> <!-- /login-fields -->

            <div class="login-actions">
                <?php echo $this->Form->button(__('Send Me!'), array('type' => 'submit', 'class' => 'button btn btn-primary btn-large', 'div' => false)); ?>
                <?php echo $this->Form->end(); ?>
            </div> <!-- .actions -->
        </div> <!-- /content -->

    </div> <!-- /account-container -->

        <div class="login-extra">
            <?php echo $this->Html->link(__('Back to Login'), array('#'), array('data-target' => '#login-box')); ?>
            <!-- <a href="#">Reset Password</a> -->
        </div> <!-- /login-extra -->
    </div>
</div>
