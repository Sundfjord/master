<div id="profile">
    <h2><?php echo $userdata->username;?></h2>
    <!--<div id="profile_image">
        <img class="profile" src="<?php echo base_url();?>img/icon-user-default.png">
        <a class="btn btn-primary" href="<?php echo base_url();?>index.php/profile/change_picture" role="button">Change picture</a>
    </div> -->
    
    <div id="profile_success" class="success">
        
    </div>
    
    <div id="profile_personalia">

        <!-- <ul id="info-tabs" class="nav nav-tabs">
            <li><a href="#personal" data-toggle="tab"><span class="glyphicon glyphicon-info-sign"></span>Personal information</a></li>
            <li><a href="#password" data-toggle="tab"><span class="glyphicon glyphicon-lock"></span>Change password</a></li>
        </ul> 
        <div id="info-content" class="tab-content"> 
        <div class="tab-pane fade in active" id="personal"> -->
            
            <form id="update_profile" role="form" action="" method="post">
              
              <div class="form-group" id="error_updateprofile">
                  <label class="control-label" for="edit_username">Name:</label><br>
                <input autofocus class="form-control input-sm" id="edit_name" name="edit_username" type="text" value="<?php echo $userdata->username; ?>">
                <span class='help-inline' id='errorinline_updateprofile'></span>
              </div>
                <br>  
              <div class="form-group" id="error2_updateprofile">
                <label for="edit_email" class="control-label">Email:</label>
                <input class="form-control input-sm" id="edit_email" name="edit_email" type="text" value="<?php echo $userdata->email; ?>">
                <span class='help-inline' id='error2inline_updateprofile'></span>
              </div>
                <br>
              <div>
                <button id="profileinfosubmit" type="button" class="btn btn-block btn-success">Save changes</button>
              </div>
            
            </form>
            
        </div>
        
        <!-- <div class="tab-pane fade" id="password"> 
            
            <form id="update_password" class="form-horizontal" action="<?php echo base_url('index.php/profile/custom_change_password'); ?>" method="post">
              <div class="form-group">
                <label for="custom_old_password" class="col-sm-2 control-label">Old password:</label>
                <div class="col-sm-5">
                  <input class="form-control input-sm" id="custom_old_password" type="password">
                </div>
                <span class='help-inline' id='errorinline_updatepassword'><?php echo form_error('custom_old_password'); ?></span>
              </div>
              <div class="form-group">
                <label for="custom_new_password" class="col-sm-2 control-label">New password:</label>
                <div class="col-sm-5">
                  <input class="form-control input-sm" id="custom_new_password" type="password">
                </div>
                <span class='help-inline' id='error2inline_updatepassword'><?php echo form_error('custom_new_password'); ?></span>
              </div>
                <div class="form-group">
                <label for="custom_confirm_new_password" class="col-sm-2 control-label">New password confirmation:</label>
                <div class="col-sm-5">
                  <input class="form-control input-sm" id="custom_confirm_new_password" type="password">
                </div>
                <span class='help-inline' id='error3inline_updatepassword'><?php echo form_error('custom_confirm_new_password'); ?></span>
                </div>
                <br>
                <div>
                    <button id="updatepasswordsubmit" type="submit" class="btn btn-success">Change password</button>
                </div>
            </form>
            
        </div> -->   
        </div>
        
    </div>
</div>


