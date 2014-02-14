<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="robots" content="noindex">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" />
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url();?>css/jquery.dataTables.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url();?>css/dataTables.bootstrap.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap-datepicker.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap-datetimepicker.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url();?>css/daterangepicker-bs3.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url();?>css/fullcalendar.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="screen" />
        <script src="<?php echo base_url(); ?>js/jquery.js" type="text/javascript" charset="utf-8"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo base_url(); ?>js/jquery.dataTables.js" type="text/javascript" charset="utf-8" ></script>
        <script src="<?php echo base_url(); ?>js/dataTables.bootstrap.js" type="text/javascript" charset="utf-8" ></script>
        <script src="<?php echo base_url(); ?>js/moment.js" type='text/javascript' ></script>
        <script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js" type='text/javascript' ></script>
        <script src="<?php echo base_url(); ?>js/bootstrap-datetimepicker.js" type='text/javascript' ></script>
        <script src="<?php echo base_url(); ?>js/daterangepicker.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo base_url(); ?>js/fullcalendar.js" type='text/javascript' ></script> 
        <script src="<?php echo base_url(); ?>js/functions.js" type="text/javascript" charset="utf-8"></script>
    </head>
    
    <body>
        
        <?php   $this->load->view('includes/header'); ?>

        <?php   $this->load->view('includes/sidebar'); ?>

                <div id="content">
                    <?php $this->load->view($main_content); ?>
                </div>
                
                <?php $this->load->view('includes/footer'); ?>

    </body>
    
</html>
        
   






