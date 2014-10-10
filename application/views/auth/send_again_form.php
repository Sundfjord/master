<?php
$this->config->load('tankstrap');
$tankstrap = $this->config->item('tankstrap');
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="<?php echo $tankstrap["bootstrap_path"];?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url();?>css/overrides.css" type="text/css" media="screen" />
        <title><?php echo $tankstrap["send_again_page_title"];?></title>
    </head>
    <body>
        <div id='content'>
        <div class="container">
            <div class="row">
                <div id='box' class="col-xs-10 col-sm-6 col-md-6 col-lg-4 col-xs-offset-1 col-sm-offset-3 col-lg-offset-4">
                        <center>
							<h2>Send Again</h2>
                            <?php echo form_open($this->uri->uri_string()); ?>
                            <div class="form-group">
                                <?php echo form_label('Email Address', $email['id'], array('class' => 'control-label')); ?>
                                    <?php echo form_error('email'); ?>
                                    <?php echo form_input($email, '', 'class="form-control"'); ?>
                                    <p class="help-block"></p>
                            </div>
                            <?php echo form_submit('send', 'Send', 'class="btn btn-info"'); ?>
                            <?php echo form_close(); ?>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>