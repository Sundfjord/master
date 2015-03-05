<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="robots" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" />
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootswatch/3.0.3/journal/bootstrap.min.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url();?>css/square/green.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url();?>css/square/red.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url();?>css/rockenroll.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url();?>css/overrides.css" type="text/css" media="screen" />
    </head>

    <body>
        <div id="wrap">
            <?php $this->load->view('includes/header'); ?>
            <?php $this->load->view('includes/navbar'); ?>
            <div id="content">
                <?php $this->load->view($main_content); ?>
            </div>
            <?php $this->load->view('includes/footer'); ?>
        </div>

        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo base_url(); ?>js/icheck.js" type='text/javascript' ></script>
        <script src="<?php echo base_url(); ?>js/jquery.dataTables.js" type="text/javascript" charset="utf-8" ></script>
        <script src="<?php echo base_url(); ?>js/dataTables.bootstrap.js" type="text/javascript" charset="utf-8" ></script>
        <script src="<?php echo base_url(); ?>js/moment.js" type='text/javascript' ></script>
        <script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js" type='text/javascript' ></script>
        <script src="<?php echo base_url(); ?>js/bootstrap-datetimepicker.js" type='text/javascript' ></script>
        <script src="<?php echo base_url(); ?>js/daterangepicker.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo base_url(); ?>js/fullcalendar.js" type='text/javascript' ></script>
        <script src="<?php echo base_url(); ?>js/functions.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo base_url(); ?>js/notifications.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>






