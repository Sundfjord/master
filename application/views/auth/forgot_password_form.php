<?php
$this->config->load('tankstrap'); 
$tankstrap = $this->config->item('tankstrap');
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Email';
} else {
	$login_label = 'Email';
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="<?php echo $tankstrap["bootstrap_path"];?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url();?>css/overrides.css" type="text/css" media="screen" />
        <title><?php echo $tankstrap["forgot_page_title"];?></title>
    </head>
    <body>
        <div id="content">
            <div class="container">
                <div class="row">
                    <div id="box" class="col-xs-10 col-sm-6 col-md-6 col-lg-4 col-xs-offset-1 col-sm-offset-3 col-lg-offset-4">
                        <h3>Reset Password</h3>
                        <?php echo form_open($this->uri->uri_string()); ?>
                        <div class="form-group">
                            <?php echo form_label($login_label, $login['id'], array('class' => 'control-label')); ?>

                                <?php echo form_input($login, '', 'class="form-control"'); ?>
                                <?php echo form_error('login', '<div class="alert alert-danger"><p>', '</p></div>'); ?>
                                <p class="help-block"></p>

                        </div>

                        <?php echo form_submit('reset', 'Get A New Password', 'class="btn btn-block btn-info"'); ?>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>