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
        <link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="screen" />
        <title><?php echo $tankstrap["new_pw_page_title"];?></title>
    </head>
    <body>
        <div id="content">
            <div class="container">
                <div class="row">
                    <div id="box" class="col-xs-10 col-sm-6 col-md-6 col-lg-4 col-xs-offset-1 col-sm-offset-3 col-lg-offset-4">
                        <h3>New Password</h3>
                                <?php echo form_open($this->uri->uri_string()); ?>
                        <div class="form-group">
                                <?php echo form_label('New Password', $new_password['id']); ?>
                            
                                <?php echo form_password($new_password, '', 'class="form-control"'); ?>
                                <?php echo form_error($new_password['name'], '<div class="alert alert-danger"><p>', '</p></div>'); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?>
                            
                        </div>

                        <div class="form-group">
                                <?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?>
                                  
                                <?php echo form_password($confirm_new_password, '', 'class="form-control"'); ?>
                                <?php echo form_error($confirm_new_password['name'], '<div class="alert alert-danger"><p>', '</p></div>'); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?>
                                <p class="help-block"></p>
                            
                        </div>
                        <?php echo form_submit('change', 'Change Password', 'class="btn btn-info"'); ?>
                        <?php echo form_close(); ?>
                    
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>