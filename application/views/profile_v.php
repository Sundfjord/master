<div id="profile" class="container">
    <div id="profile_success" class="success">
    </div>
    <h3><?php echo $userdata->username;?></h3>
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
            <div class='panel panel-default'>
                <div class='panel-heading'>
                    <span class='glyphicon glyphicon-edit'></span>Edit profile information
                </div>
                <div class='panel-body'>
                    <div id="profile_personalia">
                        <form id="update_profile" role="form" action="" method="post">
                        <div class="form-group" id="error_updateprofile">
                            <label class="control-label" for="edit_username">Name:</label>
                            <input autofocus class="form-control input-sm" id="edit_name" name="edit_username" type="text" value="<?php echo $userdata->username; ?>">
                            <span class='help-inline' id='errorinline_updateprofile'><p class="danger"></p></span>
                        </div>
                        <div class="form-group" id="error2_updateprofile">
                            <label for="edit_email" class="control-label">Email:</label>
                            <input class="form-control input-sm" id="edit_email" name="edit_email" type="text" value="<?php echo $userdata->email; ?>">
                            <span class='help-inline' id='error2inline_updateprofile'><p class="danger"></p></span>
                        </div>
                        <div>
                            <button id="profileinfosubmit" type="button" class="btn btn-success">Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-6" col-lg-7>
            <div class='panel panel-default'>
                <div class='panel-heading'>
                    <span class='glyphicon glyphicon-th-list'></span>Your teams
                </div>
                <div class='panel-body'>
                    <? // If role is player/coach ?>
                    <?php if ( $playercoach === true ) :
                        echo '<p>Below, you\'ll find a list of the teams you are registered as coach of or playing for. If you want to stop coaching them,
                        but are unable to click the button, it means you need to add another coach to take over before you leave, or delete the team altogether.</p>';
                echo '</div>'; // panel-body
                        $playercoachteam = array_merge($playerteam, $coachteam);
                        /*foreach($playercoachteam as $k => $v)
                        {
                            foreach($playercoachteam as $key => $value)
                            {
                                if($k != $key && $v['team_id'] == $value['team_id'])
                                {
                                     unset($playercoachteam[$k]);
                                }
                            }
                        }*/
                        $playerteamlist = array();
                        foreach($playerteam as $pt) {
                            $playerteamlist[] = $pt['team_id'];
                        }
                        //if (empty($playercoachteam)) {
                        if (empty($playerteam) && empty($coachteam)) {
                            echo '<p>You are currently not a member of any team</p>';
                        } else {
                            echo '<ul class="list-group heading">
                                    <li class="list-group-item"><p style="margin: 0;"><b>Player :</b></p></li>
                                </ul>';
                            echo '<ul class="list-group">';
                                foreach ($playerteam as $row) :
                                    echo
                                    '<li class="list-group-item">
                                        <p>'.$row['teamname'].'
                                            <input type="hidden" class="team_id" value="'.$row['team_id'].'">
                                            <a href="#profile_leave_team_modal" class="leaveteam player btn btn-sm btn-danger pull-right" role="button"><span class="glyphicon glyphicon-remove-circle"></span>Leave team</a>

                                        </p>
                                    </li>';
                                endforeach;
                            echo '</ul>';
                            echo '<ul class="list-group heading">
                                    <li class="list-group-item"><p style="margin: 0;"><b>Coach :</b></p></li>
                                </ul>';
                            echo '<ul class="list-group">';
                                foreach ($coachteam as $row) :
                                    echo
                                    '<li class="list-group-item">
                                        <p>'.$row['teamname'].'
                                            <input type="hidden" class="nrOfCoaches" value="'.$row['coachcount'].'">
                                            <input type="hidden" class="team_id" value="'.$row['team_id'].'">
                                            <a href="#profile_leave_team_modal" class="leaveteam coach disabledcheck btn btn-sm btn-danger pull-right" role="button"><span class="glyphicon glyphicon-remove-circle"></span>Leave team</a>

                                        </p>
                                    </li>';
                                endforeach;
                            echo '</ul>';
                        }
                    // If role is coach
                    elseif ( $coach === true ) :
                        echo '<p>Below, you\'ll find a list of the teams you are registered as coach of. If you want to leave one of them,
                            but are unable to click the button, it means you need to add another coach to take over before you leave.</p>';
                echo '</div>'; // panel-body
                         if (empty($coachteam)) {
                            echo 'You are currently not coaching any teams';
                        } else {
                            echo '<ul class="list-group">';
                            foreach ($coachteam as $row) :
                                echo
                                '<li class="list-group-item"><p>'.$row['teamname'].'<input type="hidden" class="nrOfCoaches" value="'.$row['coachcount'].'"><input type="hidden" class="team_id" value="'.$row['team_id'].'"><a href="#profile_leave_team_modal" class="leaveteam disabledcheck btn btn-sm btn-danger pull-right" role="button"><span class="glyphicon glyphicon-remove-circle"></span>Leave team</a></p></li>';
                            endforeach;
                            echo '</ul>';
                         }
                    // If role is player
                    else :
                        echo '<p>Below, you\'ll find a list of the teams you currently play for. </p>';
                echo '</div>'; // panel-body
                         if (empty($playerteam)) {
                            echo 'You are currently not playing for any team';
                        } else {
                        echo '<ul class="list-group">';
                         foreach ($playerteam as $row):
                            echo
                            '<li class="list-group-item"><p>'.$row['teamname'].'<input type="hidden" class="nrOfCoaches" value="'.$row['coachcount'].'"><input type="hidden" class="team_id" value="'.$row['team_id'].'"><a href="#profile_leave_team_modal" class="leaveteam btn btn-sm btn-danger pull-right" role="button"><span class="glyphicon glyphicon-remove-circle"></span>Leave team</a></p></li>';
                        endforeach;
                        echo '</ul>';
                        }
                    endif; ?>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade bs-modal-sm" id="profile_leave_team_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Wait, whaat?</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to leave this team?</p>
                <input type="hidden" id="teamid" value="">
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default" data-dismiss="modal">Actually, no</button>
                <button id="profileleaveteamsubmit" type="button" class="btn btn-danger">Yeah, screw'em!</button>
            </div>
        </div><!-- /modal-content -->
    </div><!-- /.moda-dialog -->
</div><!-- /.modal -->

            <!--
            <ul id="info-tabs" class="nav nav-tabs">
                <li><a href="#personal" data-toggle="tab"><span class="glyphicon glyphicon-info-sign"></span>Personal information</a></li>
                <li><a href="#password" data-toggle="tab"><span class="glyphicon glyphicon-lock"></span>Change password</a></li>
            </ul>
            <div id="info-content" class="tab-content">

            <div class="tab-pane fade in active" id="personal">
                <div id="profile_image">
                    <img class="profile" src="<?php echo base_url();?>img/icon-user-default.png">
                    <a class="btn btn-primary" href="<?php echo base_url();?>index.php/profile/change_picture" role="button">Change picture</a>
                </div>

            <div class="tab-pane fade" id="password">

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
                <div>
                    <button id="updatepasswordsubmit" type="submit" class="btn btn-success">Change password</button>
                </div>
                </form>
            </div>
            -->