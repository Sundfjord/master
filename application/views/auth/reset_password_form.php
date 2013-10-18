<?php
$this->config->load('tankstrap'); 
$tankstrap = $this->config->item('tankstrap');
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="<?php echo $tankstrap["bootstrap_path"];?>" rel="stylesheet">
        <title><?php echo $tankstrap["new_pw_page_title"];?></title>
    </head>
    <body>
	<div class="container">
            <div class="row">
                <div class="span6 offset3">
                    <div class="well">
                        <center>
                            <h2>New Password</h2>
                                    <?php echo form_open($this->uri->uri_string()); ?>
                            <div class="control-group">
                                    <?php echo form_label('New Password', $new_password['id']); ?>
                                <div class="controls">
                                    <?php echo form_password($new_password); ?>
                                    <?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                    <?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?>
                                <div class="controls">        
                                    <?php echo form_password($confirm_new_password); ?>
                                    <?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?>
                                    <p class="help-block"></p>
                                </div>
                            </div>
                            <?php echo form_submit('change', 'Change Password', 'class="btn btn-primary"'); ?>
                            <?php echo form_close(); ?>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>