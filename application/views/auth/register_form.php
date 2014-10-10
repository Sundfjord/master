<?php


$this->config->load('tankstrap'); 
$tankstrap = $this->config->item('tankstrap'); 

if ($use_username) {
	$username = array(
		'name'      => 'username',
		'id'        => 'username',
		'value'     => set_value('username'),
		'maxlength' => $this->config->item('username_max_length', 'tank_auth'),
		'size'      => 30,
	);
}
$email = array(
	'name'      => 'email',
	'id'        => 'email',
	'value'     => set_value('email'),
	'maxlength' => 80,
	'size'      => 30,
);

$role = array(
    'group_id'      => 'group_id'
);

$group_id = array(
        '0'         => 'Select a role',
        '300'       => 'Player',
        '100'       => 'Coach'
);

$password = array(
	'name'      => 'password',
	'id'        => 'password',
	'value'     => set_value('password'),
	'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
	'size'      => 30,
);
$confirm_password = array(
	'name'      => 'confirm_password',
	'id'        => 'confirm_password',
	'value'     => set_value('confirm_password'),
	'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
	'size'      => 30,
);
$captcha = array(
	'name'      => 'captcha',
	'id'        => 'captcha',
	'maxlength' => 8,
);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="robots" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link href="<?php echo $tankstrap["bootstrap_path"];?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url();?>css/overrides.css" type="text/css" media="screen" />
        <title><?php echo $tankstrap["register_page_title"];?></title>
    </head>
    <body>
        <div id="content">
	<div class="container">
            <div class="row">
                <div class="col-xs-10 col-sm-6 col-md-6 co-lg-4 col-xs-offset-1 col-sm-offset-3 col-lg-offset-4">
                    <h1>rockEnroll</h1>
                </div>
            </div>

            <div class="row">
                <div id="box" class="col-xs-10 col-sm-6 col-md-6 col-lg-4 col-xs-offset-1 col-sm-offset-3 col-lg-offset-4">
                    <h3>Register</h3>
                    <?php echo form_open($this->uri->uri_string(), 'role="form"'); ?>

	<?php if ($use_username): ?>
	<div class="form-group">
        <?php echo form_label('Full Name', $username['id'], array('class' => 'control-label')); ?>
        <?php echo form_input($username, set_value('username'), 'class="form-control"'); ?>
        <?php echo form_error('username', '<div class="alert alert-danger"><p>', '</p></div>'); ?>

    </div>
	<?php endif; ?>
    <div class="form-group">
        <?php echo form_label('Email', $email['id'], array('class' => 'control-label')); ?>
        <?php echo form_input($email, set_value('email'), 'class="form-control"'); ?>
        <?php echo form_error('email', '<div class="alert alert-danger"><p>', '</p></div>'); ?>
    </div>

    <div class="form-group">
        <?php echo form_label('Role', $role['group_id'], array('class' =>'control-label')); ?>
        <?php echo form_dropdown('group_id', $group_id, set_value('group_id'), ' class="form-control"'); ?>
        <?php echo form_error('group_id', '<div class="alert alert-danger"><p>', '</p></div>'); ?>
    </div>

    <div class="form-group">
        <?php echo form_label('Password', $password['id'], array('class' => 'control-label')); ?>
        <?php echo form_password($password, '', 'class="form-control"'); ?>
        <?php echo form_error('password', '<div class="alert alert-danger"><p>', '</p></div>'); ?>
    </div>

    <div class="form-group">
        <?php echo form_label('Confirm Password', $confirm_password['id'], array('class' => 'control-label')); ?>
        <?php echo form_password($confirm_password, '', 'class="form-control"'); ?>
        <?php echo form_error('confirm_password', '<div class="alert alert-danger"><p>', '</p></div>'); ?>
    </div>

        <?php if ($captcha_registration): ?>
	<div class="form-group">
        <?php echo form_label('Confirmation Code', $captcha['id'], array('class' => 'control-label')); ?>
        <?php echo $captcha_html; ?>

    </div>
	<div class="control-group">
        <?php echo form_label('Enter Code', $captcha['id'], array('class' => 'control-label')); ?>
        <?php echo form_input($captcha); ?>
        <?php echo form_error('captcha'); ?>

    </div>
	<?php endif; ?>
</table>
<?php echo form_submit('register', 'Register', 'class="register btn btn-lg btn-info"'); ?>
<a style="float: right;margin-top: 20px;"href="<?php echo base_url();?>index.php/auth/login">Login</a>
<?php echo form_close(); ?>
<br>
<!--<div class='info'><p class='bg-warning'><span class='glyphicon glyphicon-warning-sign'></span>Registration is temporarily unavailable.</p></div>-->

                </div>
</div>
</div>
</body>
</html>