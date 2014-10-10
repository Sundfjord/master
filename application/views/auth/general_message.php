<?php $this->config->load('tankstrap'); $tankstrap = $this->config->item('tankstrap');?>
<!DOCTYPE html>
<html lang="en">
<head>
<link href="<?php echo $tankstrap["bootstrap_path"];?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url();?>css/overrides.css" type="text/css" media="screen" />
<title><?php echo $tankstrap["general_page_title"];?></title>
</head>
<body>
    <div id="content">
        <div class="container">
            <div id="box" class="row">
                <div class="col-xs-10 col-sm-6 col-md-6 col-lg-4 col-xs-offset-1 col-sm-offset-3 col-lg-offset-4">
                    <h3><?php echo $message; ?></h3>
                </div>
            </div>
        </div>
    </div>
</body>
</html>