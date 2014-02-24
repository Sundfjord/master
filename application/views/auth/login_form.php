<?php $this->config->load('tankstrap'); $tankstrap = $this->config->item('tankstrap');?>
<!DOCTYPE html>
<html lang="en">
<link href="<?php echo $tankstrap["bootstrap_path"];?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="screen" />
<title><?php echo $tankstrap["login_page_title"];?></title>

<?php
$login = array(
    'name' => 'login',
    'id' => 'login',
    'value' => set_value('login'),
    'maxlength' => 80,
    'size' => 30,
);
if ($login_by_username AND $login_by_email) {
    $login_label = 'Email or Username';
} else if ($login_by_username) {
    $login_label = 'Login';
} else {
    $login_label = 'Email';
}
$password = array(
    'name' => 'password',
    'id' => 'password',
    'size' => 30,
);
$remember = array(
    'name' => 'remember',
    'id' => 'remember',
    'value' => 1,
    'checked' => set_value('remember'),
    'style' => 'margin:0;padding:0',
);
$captcha = array(
    'name' => 'captcha',
    'id' => 'captcha',
    'maxlength' => 8,
);
?>
<div id="content">
<div class="container">
    <div class="row">
        <div class="col-xs-10 col-sm-6 col-md-6 col-lg-4 col-xs-offset-1 col-sm-offset-3 col-lg-offset-4">
        <h1>rockEnroll</h1>    
        </div>
    </div>
        <div class="row">
        <div id="box" class="col-xs-10 col-sm-6 col-md-6 col-lg-4 col-xs-offset-1 col-sm-offset-3 col-lg-offset-4">
            
                    <h3>Login</h3>
            <?php echo form_open($this->uri->uri_string()); ?>
            <form role="form">
                <div class="form-group">
                    <?php echo form_label($login_label, $login['id'], array('class' =>'control-label')); ?>
                    <?php echo form_input($login['id'], set_value('login'), 'id="' . $login['id'] . '" class="form-control col-xs-8"'); ?>
                    <?php echo form_error($login['name'], '<div class="alert alert-danger"><p>', '</p></div>'); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
                    
                </div>
                <div class="form-group">
                    <?php echo form_label('Password', $password['id'], array('class' =>'control-label')); ?>
                    <?php echo form_password($password['id'], '', 'id="' . $password['id'] . '" class="form-control col-xs-8"'); ?>
                    <?php echo form_error($password['name'], '<div class="alert alert-danger"><p>', '</p></div>'); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Remember Me', $remember['id'], array('class' =>'sr-only')); ?>
                    <?php echo form_checkbox($remember); ?> Remember me
                    
                </div>   
                <div class="form-group">
                    <?php echo anchor('/auth/forgot_password/', 'Forgot password'); ?>&nbsp; | &nbsp;<?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register'); ?>
                </div>
                <div class="form-group">
                    
                        <?php echo form_submit('submit', 'Login', 'class="login btn btn-info"'); ?>
                                    
                </div>
                        <?php echo form_close(); ?>
        </div>
        </div>
</div>
    </div>