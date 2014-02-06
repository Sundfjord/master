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
        <link href="<?php echo $tankstrap["bootstrap_path"];?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="screen" />
        <title><?php echo $tankstrap["register_page_title"];?></title>
    </head>
    <body>
	<div class="container">
		<div class="row">
			<center><h2>Register</h2></center>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>

	<?php if ($use_username): ?>
	<div class="control-group">
        <?php echo form_label('Full Name', $username['id'], array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo form_input($username); ?>
            <?php echo form_error('username', '<div class="alert alert-error">', '</div>'); ?>
        </div>
    </div>
	<?php endif; ?>
    <div class="control-group">
        <?php echo form_label('Email', $email['id'], array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo form_input($email); ?>
            <?php echo form_error('email', '<div class="alert alert-error">', '</div>'); ?>
        </div>
    </div>
                                        
    <div class="control-group">
        <?php echo form_label('Role', $role['group_id'], array('class' =>'control-label')); ?>                                  
        <div class="controls">
            <?php echo form_dropdown('group_id', $group_id, '0', 'id="role"'); ?>
            <?php echo form_error('group_id', '<div class="alert alert-error">', '</div>'); ?>   
        </div>
    </div>                                    
                                        
    <div class="control-group">
        <?php echo form_label('Password', $password['id'], array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo form_password($password); ?>
            <?php echo form_error('password', '<div class="alert alert-error">', '</div>'); ?>   
        </div>
    </div>
    
    <div class="control-group">
        <?php echo form_label('Confirm Password', $confirm_password['id'], array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo form_password($confirm_password); ?>
            <?php echo form_error('confirm_password', '<div class="alert alert-error">', '</div>'); ?>
        </div>
    
    </div>
	<?php if ($captcha_registration): ?>
	<div class="control-group">
        <?php echo form_label('Confirmation Code', $captcha['id'], array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $captcha_html; ?>
            
        </div>
    </div>	
	<div class="control-group">
        <?php echo form_label('Enter Code', $captcha['id'], array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo form_input($captcha); ?>
            <?php echo form_error('captcha'); ?>
        </div>
    </div>
	<?php endif; ?>
</table>
<?php echo form_submit('register', 'Register', 'class="register btn btn-primary"'); ?>
<?php echo form_close(); ?>


</div>
</div>
</body>
</html>