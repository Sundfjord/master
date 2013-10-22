<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="robots" content="noindex">
        <script src="<?php echo base_url(); ?>js/jquery.js" type="text/javascript" charset="utf-8"></script>
        <link rel="stylesheet" href="<?php echo base_url();?>/css/style.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url();?>/css/bootstrap.css" type="text/css" media="screen" />
    </head>
    
    <body>
        <div id="wrapper">
            <div id="header">
                <?php $this->load->view('includes/header'); ?>
            </div><!--header-->
               
            <div id="sidebar">
                <?php $this->load->view('includes/sidebar'); ?>
            </div><!--sidebar-->
            
            <div id="content">
                <?php $this->load->view($main_content); ?>
            </div><!--Content-->

            <div id="footer">
                <?php $this->load->view('includes/footer'); ?>
            </div><!--footer-->

        </div><!--Wrapper-->
    </body>
</html> 






