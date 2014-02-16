<div>
    <h2><?php echo $teaminfo->teamname; ?> </h2>
    <h4><?php echo $teaminfo->sport; ?> team</h4>
    
    <input id="filter_id" type="hidden" name="filter_id" value="<?php echo $this->uri->segment(2); ?>">
    
    <div id="success" class="success">
        
    </div>
    
    
    <?php if ( $coach === TRUE ) : ?>
    <ul id="team_tabs" class="nav nav-tabs">
        <li><a href="#schedule" data-toggle="tab"><span class="glyphicon glyphicon-calendar"></span>Schedule</a></li>
        <li><a href="#stats" data-toggle="tab"><span class="glyphicon glyphicon-stats"></span>Statistics</a></li>
        <li><a href="#manage_squad" data-toggle="tab"><span class="glyphicon glyphicon-list-alt"></span>Manage squad</a></li>
        <li><a href="#edit" data-toggle="tab"><span class="glyphicon glyphicon-edit"></span>Edit</a></li>
    </ul>
    <?php else : ?>
    <ul id="team_tabs" class="nav nav-tabs">
        <li><a href="#schedule" data-toggle="tab"><span class="glyphicon glyphicon-calendar"></span>Schedule</a></li>
        <li><a href="#about" data-toggle="tab"><span class="glyphicon glyphicon-info-sign"></span>About</a></li>
    </ul>
    <?php endif; ?>
    <!-- Tab panes -->
    
    <br>
    
    <div id="team_content" class="tab-content">
        <div class="tab-pane fade in active" id="schedule">
            <?php if ( $coach === TRUE ) : ?>
            <div id="knapp_bar">
                <button type="button" id="add_event" class="btn btn-info" href="#add_event_modal"> <span class="glyphicon glyphicon-plus-sign"></span>Add event</button>
                <button type="button" id="edit_event" class="btn btn-default" href="#edit_event_modal"> <span class="glyphicon glyphicon-edit"></span>Edit events</button>
                <button type="button" id="delete_event" class=" btn btn-danger" href="#delete_event_modal"> <span class="glyphicon glyphicon-trash"></span>Delete event</button>
            </div>
            <?php endif; ?>
            
            <div id="calendar">
                
            </div>
                    
            <div id="event-info">
                <?php if ( $coach === TRUE ) : ?>
                <div id="coach-only">
                    
                </div>
                <?php endif; ?>
                <div id="event-details">
                    <div id='boxes-inline'>
                        <div class='loc panel panel-default'>
                            <div class='panel-heading'><span class='glyphicon glyphicon-map-marker'></span>Location</div>
                            <div class='panel-body'>
                                <p class="nomargin" id='location' type='text' name='location'></p>
                            </div>
                        </div>

                        <div class='time panel panel-default'>
                            <div class='panel-heading'><span class='glyphicon glyphicon-time'></span>Time</div>
                            <div class='panel-body'>
                                <p class="nomargin" id='time' type='text' name='time'></p>
                            </div>
                        </div>
                        
                        <div class='desc panel panel-default'>
                        <div class='panel-heading'><span class='glyphicon glyphicon-info-sign'></span>Description</div>
                        <div class='panel-body'>
                            <p class="nomargin" id='description' type='text' name='description'></p>
                        </div>
                    </div>
                    </div>
                </div>
                <div id="attendance" class="tablespan">
                    
                    <div id="attendance_select">
                    <form class="after" id="set_attendance_form" action="<?php echo base_url('index.php/team/set_attendance'); ?>" method="post">
                    <div class="hidden_id"></div>
                    <p>Will you attend?</p>
                    <label for="attend_yes">Yes</label>
                    <input type="radio" value="1" name="attendance_choice" id="attend_yes">
                    <label for="attend_no">No</label>
                    <input type="radio" value="2" name="attendance_choice" id="attend_no">
                    <!--<button class="btn" type="submit">Change attendance status</button>-->
                    </form>   
                    </div>
                    
                    <div id="attendance_tables">
                        
                    </div>
                    
                    <br>
                </div>
            </div>
            
        </div>
        
        <div class="tab-pane fade" id="stats">
            <div id="daterange" class="pull-right">
                <span class="glyphicon glyphicon-calendar"></span><span class="text"><?php echo date("F j, Y", strtotime('-30 day')); ?> - <?php echo date("F j, Y"); ?></span> <b class="caret"></b>
            </div>
            <br>
            <br>
            <div id="stats_table">
                <table id="statistics_table" class="table table-striped table-bordered dataTable" style='width: 500px;'>
                    <thead>
                        <tr class="tabellheader">
                            <th class="name" scope="col">Player Name</th>
                            <th class="number" scope="col">#</th>
                        </tr>  
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="tab-pane fade" id="about">
            <?php if (empty($squad)) {?>
            <?php } else {?>
            <table id="player_table" class="table table-striped table-bordered dataTable">
                <thead>
                    <tr> 
                        <th class="middle_l" scope="col">Name</th>
                        <th class="middle_r" scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($squad as $s):?>
                    <tr>
                            <td class="middle_l"><div class="username"><?php echo $s['username'];?></div></td>
                            <td class="middle_r"><div class="email"><?php echo $s['email'];?></div></td>
                        </tr>
            <?php endforeach;?>
                </tbody>
            </table>
            <?php } ?>
            
            <button id="leave_team" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle"></span>Leave Team</button>
        </div> 
        
        <div class="tab-pane fade" id="manage_squad"> <!--class="dataTables_wrapper"-->
        
            <?php if (empty($squad)) {?>

            <div>
                <h3>There is currently no players on <?php echo $teaminfo->teamname; ?> </h3>
                <p>Press the button below to add players.</p>
            </div>
            
            <div id="knapp">
                
                <button type="button" id="add_player" class="btn btn-info" data-target="#add_player_accordion" data-toggle="collapse" data-parent="knapp"><span class="glyphicon glyphicon-plus-sign"></span>Add more players</button>
                
            </div>
            <?php } else {?>
            
            <form id="remove_player" action="" method="post">
                
                <table id="team_table" class="table table-striped table-bordered dataTable">
                <thead>
                    <tr> 
                        <th class="left" scope="col"><input rel="popover" class="check_all" id="selectall" type="checkbox" />
                        <th class="middle_l" scope="col">Name</th>
                        <th class="middle_r" scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>	
                    <?php foreach ($squad as $s):?> 
                        <tr>
                            <td class="left"><input type="checkbox" name="squad[]" id="squadchecktest" value="<?php echo $s['id'];?>" /> </td>
                            <td class="middle_l"><div class="username"><?php echo $s['username'];?></div></td>
                            <td class="middle_r"><div class="email"><?php echo $s['email'];?></div></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            
            <div id="knapp_bar">
                <button type="button" id="add_player" class="btn btn-info" data-target="#add_player_accordion" data-toggle="collapse" data-parent="knapp_bar"><span class="glyphicon glyphicon-plus-sign"></span>Add more players<span class="caret"></span></button>
                <button class="btn btn-danger" id="removeplayersubmit" type="button" disabled><span class="glyphicon glyphicon-trash"></span>Remove Player</button>
            </div>
            
            </form>
            <?php } ?>
            
            <div id="add_player_accordion" class="collapse">
            
                <div id="search"> 
                    <?php if (empty($players)) {?>
                    <div>
                        <h2>Apparently, there are no players. </h2>
                        <p>Ask your players to create a profile in order to start rollin'.</p>
                    </div>

                    <?php } else {?>

                    <input type="text" class="input-medium search-query" id="search_player" autocomplete="off" placeholder="Søk eller legg til..." onfocus="if
                    (this.value==this.defaultValue) this.value='';">

                    <form id="add_player_form" action="" method="post">
                    <table id="team_table" class="table table-striped table-bordered dataTable">
                        <thead>
                            <tr class="tabellheader"> 
                                <th class="left" scope="col"><input rel="popover" class="check_all" id="selectall" type="checkbox" />
                                <th class="middle_l" scope="col">Name</th>
                                <th class="middle_r" scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody>	
                            <?php foreach ($players as $p):?> 
                            <tr>
                                <td class="left"><input type="checkbox" name="players[]" id="checktest" value="<?php echo $p['id'];?>" /> </td>
                                <td class="middle_l"><div class="username"><?php echo $p['username'];?></div></td>
                                <td class="middle_r"><div class="email"><?php echo $p['email'];?></div></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>

                    <button class="btn btn-info" id="addplayersubmit" type="button" disabled >Add player(s) to team</button>
                    
                    </form>
                    <?php } ?>
                
                </div>
            
            </div>
            
        </div>
        
        <div class="tab-pane fade" id="edit">

            <div id="edit_team" class="well">
                <h4>Edit team information</h4><br>
                <form id="edit_team_info" action="" method="post">

                    <div class="form-group" id="error_teaminfo">
                        <label for="teamname">Team Name:</label><br>
                        <input autofocus name="teamname" type="text" placeholder="" id="teamname" class="form-control" value="<?php echo $teaminfo->teamname; ?>">
                        <span class='help-inline' id='errorinline_teaminfo'></span>
                    </div>

                    <div class="form-group" id="error2_teaminfo">
                        <label for="sport">Sport:</label>
                        <select class ="form-control" name="sport" id="sport" value="<?php echo $teaminfo->sport; ?>">
                            <option value="0" name="choose">Choose sport</option>
                            <option value="Football" name="Football">Football</option>
                            <option value="Badminton" name="Badminton">Badminton</option>
                            <option value="Bandy" name="Bandy">Bandy</option>
                            <option value="Baseball" name="Baseball">Baseball</option>
                            <option value="Basketball" name="Basketball">Basketball</option>
                            <option value="Biathlon" name="Biathlon">Biathlon</option>
                            <option value="Cross-country" name="Cross-country">Cross-country</option>
                            <option value="Cycling" name="Cycling">Cycling</option>
                            <option value="Field hockey" name="Field hockey">Field hockey</option>
                            <option value="Handball" name="Handball">Handball</option>
                            <option value="Ice hockey" name="Ice hockey">Ice hockey</option>
                            <option value="Lacrosse" name="Lacrosse">Lacrosse</option>
                            <option value="Rugby" name="Rugby">Rugby</option>
                            <option value="Track and field" name="Track and field">Track and field</option>
                            <option value="Volleyball" name="Volleyball">Volleyball</option>
                            <option value="Water polo" name="Water polo">Water polo</option>
                        </select>
                        <span class='help-inline' id='error2inline_teaminfo'></span>
                    </div>
                    
                    <br>
                    
                    <button type="button" id="teaminfosubmit" class="btn btn-block btn-info">Save team information</button>

                </form>
            </div>
            
            <br>
            
            <div id="delete_team" class="well">
                <h4>Delete this team</h4>
                <p>Once you delete the team, there is no undo.</p>
                <form id="delete_team" action="" method="post">
                        
                        <div class="input-group" id="error_deleteteam">
                            <input type="text" class="form-control" id="delete" name="delete" placeholder="Type team name">
                            <input id="match" type="hidden" value="<?php echo $teaminfo->teamname; ?>" />
                            <span class="input-group-btn">
                                <button class="btn btn-danger" id="deleteteamsubmit" type="button">Delete team</button>
                            </span>
                            <span class='help-inline' id='errorinline_deleteteam'></span>
                        </div>
                    
                </form>
                
            </div>
        </div>
        
        </div>
    
</div>
</div>

<div>

<!-- ADD EVENT MODAL -->
    
    <div class="modal fade" id="add_event_modal" keyboard="true" tabindex="-1" role="dialog" aria-labelledby="add_event" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add event</h4>
                </div>

                <div class="modal-body">
                    
                        <form id="add_event_form" action="" method="post">
                        <div class="form-group" id="error">
                            <label class="sr-only">Event name</label>
                            <input placeholder="Event name" id="event_name" name="eventname" class="form-control" type="text">
                            <span class='help-inline' id='errorinline'></span>
                        </div>

                        <div class="form-group" id="error2">
                            <label class="sr-only">Event description</label>
                            <input placeholder="Event description (optional)" id="event_desc" name="eventdesc" class="form-control" type="text">
                            <span class='help-inline' id='error2inline'></span>
                        </div>
                        
                        <div id="error3">
                            <label class="radio-inline">
                                <input type="radio" name="frequency" id="single" value="single"> Single session
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="frequency" id="daily" value="daily"> Daily
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="frequency" id="weekly" value="weekly" checked> Weekly
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="frequency" id="monthly" value="monthly"> Monthly
                            </label>
                            <span class='help-inline' id='error3inline'></span>
                        </div>
                            
                        <div class="form-group row">
                            <div class="col-xs-6" id="error4">
                                <label class="sr-only">Start date</label>
                                <div class="input-group date" id="start-date">
                                    <input class="form-control" name="start_date" id="start_date" placeholder="Start date" type="text">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                                    <span class='help-inline' id='error4inline'></span>
                            </div>
                            
                            <div class="col-xs-6" id="error5">
                                <label class="sr-only">End date</label>
                                <div class="input-group date" id="end-date">
                                    <input class="form-control end" name="end_date" id="end_date" placeholder="End date" type="text">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <span class='help-inline' id='error5inline'></span>
                                </div>
                            </div>
                        </div>
                            
                        <div class="form-group row">
                            <div class="col-xs-6" id="error6">
                                <label class="sr-only">Start time</label>
                                <div class="input-group date" id="start-time">
                                    <input class="form-control" name="start_time" id="start_time" placeholder="Start time" type="text">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    <span class='help-inline' id='error6inline'></span>
                                </div>
                            </div>
                        

                        
                            <div class="col-xs-6" id="error7">
                                <label class="sr-only">End time</label>
                                <div class="input-group date" id="end-time">
                                    <input class="form-control" name="end_time" id="end_time" placeholder="End time" type="text">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    <span class='help-inline' id='error7inline'></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group" id="error8">
                            <label class="sr-only">Location</label>
                            <input class="form-control" placeholder="Location" name="eventlocation" id="eventlocation" type="text">
                            <span class='help-inline' id='error8inline'></span>
                        </div>
                            
                </div>

                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                    <button class="btn btn-lg btn-info" id="addeventsubmit" type="button">Add event</button>
                </div>
                
                </form>
                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <!-- EDIT EVENT MODAL -->
    
    <div class="modal fade" id="edit_event_modal" keyboard="true" tabindex="-1" role="dialog" aria-labelledby="edit_event" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edit event</h4>
                </div>

                <div class="modal-body">
                        <?php if (empty($eventdata)) {?>
                    <div>
                        <h4>Apparently, there are no events. </h4> <br> <h4>You better add some, fool.</h4>
                        
                        
                    </div>

                    <?php } else {?>
                     <div class="panel-group" id="accordion">
                         <?php foreach ($eventdata as $row): ?>
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <?php echo '<a data-toggle="collapse" data-parent="#accordion" href="#collapse' . $row['id'] . '">' . $row['name'] . '</a>' ;?>
                          </h4>
                        </div>
                        <?php echo '<div id="collapse' . $row['id'] . '" class="panel-collapse collapse">' ;?>
                          <div class="panel-body">
                            <form id="edit_event_form" action="" method="post">

                                <div class="form-group" id="error_edit">
                                    <label class="sr-only">Event name</label>
                                    <input value="<?php echo $row['name']; ?>" placeholder="Event name" id="edited_eventname" name="edited_eventname" class="form-control" type="text">
                                    <span class='help-inline' id='errorinline_edit'></span>
                                </div>

                                <div class="form-group" id="error2_edit">
                                    <label class="sr-only">Event description</label>
                                    <input value="<?php echo $row['description']; ?>" placeholder="Event description (optional)" id="edited_eventdesc" name="edited_eventdesc" class="form-control" type="text">
                                    <span class='help-inline' id='error2inline_edit'></span>
                                </div>

                                <div class="form-group row">
                                    <div class="col-xs-6" id="error3_edit">
                                        <label class="sr-only">Start time</label>
                                        <div class="edit-start-time input-group date" id="edit-start-time">
                                            <input value="<?php echo $row['start_time']; ?>" class="form-control" id="edited_start_time" name="edited_start_time" placeholder="Start time" type="text" class="form-control">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                            <span class='help-inline' id='error3inline_edit'></span>
                                        </div>
                                    </div>

                                    <div class="col-xs-6" id="error4_edit">
                                        <label class="sr-only">End time</label>
                                        <div class="edit-end-time input-group date" id="edit-end-time">
                                            <input value="<?php echo $row['end_time']; ?>" class="form-control" id="edited_end_time"name="edited_end_time" placeholder="End time" type="text" class="form-control">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                            <span class='help-inline' id='error4inline_edit'></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" id="error5_edit">
                                    <label class="sr-only">Location</label>
                                    <input value="<?php echo $row['location']; ?>" placeholder="Location" id="edited_location" name="edited_location" class="form-control" type="text">
                                    <span class='help-inline' id='error5inline_edit'></span>
                                </div>
                                
                                <input class="event_id" type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                                
                                <br>
                                
                            <div>
                                <button class="editeventsubmit btn btn-info" id="editeventsubmit" type="button">Save changes</button>
                            </div>

                                </form>                          
                          </div>
                        </div>
                      </div>
                      
                     <?php endforeach; ?>
                    
                    </div>
                    <?php } ?>
                </div>
             
            
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-lg btn-info" type="button">Done</button>
                </div>
                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- DELETE EVENT MODAL -->
    
    <div class="modal fade" id="delete_event_modal" keyboard="true" tabindex="-3" role="dialog" aria-labelledby="delete_event" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete event</h4>
                </div>

                <div class="modal-body">                                                                        
                    <?php if (empty($eventdata)) {?>
                    <div>
                        <h4>Apparently, there are no events. </h4> <br> <h4>You better add some, fool.</h4>
                    </div>

                    <?php } else {?>
                    
                    <form id="delete_event_form" action="" method="post">
                    <table id="event_table" class="table table-striped table-bordered dataTable">
                        <thead>
                            <tr class="tabellheader"> 
                                <th class="left" scope="col"><input rel="popover" class="check_all" id="selectall" type="checkbox" />
                                <th class="middle_l" scope="col">Event Name</th>
                                <th class="middle_r" scope="col">Location</th>
                            </tr>
                        </thead>
                        <tbody>	
                            <?php foreach ($eventdata as $row):?> 
                            <tr>
                                <td class="left"><input type="checkbox" name="events[]" id="ids" value="<?php echo $row['id'];?>" /> </td>
                                <td class="middle_l"><div class="eventname"><?php echo $row['name'];?></div></td>
                                <td class="middle_r"><div class="location"><?php echo $row['location'];?></div></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                    <?php } ?>
                    <span class='help-inline' id='errorinline_delete'></span>
                </div>

                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                    <button class="btn btn-lg btn-danger" id="deleteeventsubmit" type="button" disabled>Delete event</button>
                </div>
                    </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <!-- EDIT EPISODE MODAL -->
    
<div class="modal fade" id="edit_episode_modal" keyboard="true" tabindex="-1" role="dialog" aria-labelledby="edit_episode" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edit event</h4>
                </div>

                <div class="modal-body">
                        
                    <form id="edit_episode_form" action="" method="post">

                        <div class="form-group" id="error_editEp">
                            <label class="sr-only">Name</label>
                            <input id="edited_episodeName" value="" placeholder="Event name" name="edited_episodeName" class="form-control" type="text">
                            <span class='help-inline' id='errorinline_editEp'></span>
                        </div>

                        <div class="form-group" id="error2_editEp">
                            <label class="sr-only">Description</label>
                            <input id="edited_episodeDesc" value="" placeholder="Event description (optional)" name="edited_episodeDesc" class="form-control" type="text">
                            <span class='help-inline' id='error2inline_editEp'></span>
                        </div>
                        
                        <div class="form-group" id="error3_editEp">
                            <label class="sr-only">Date</label>
                                <div class="input-group date" id="edit-episode-date">
                                    <input id="edited_episodeDate" value="" class="form-control" name="edited_episodeDate" placeholder="Date" type="text" class="form-control">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <span class='help-inline' id='error3inline_editEp'></span>
                                </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-6" id="error4_editEp">
                                <label class="sr-only">Start time</label>
                                <div class="input-group date" id="edit-episode-start-time">
                                    <input id="edited_episodeStartTime" value="" class="form-control" name="edited_episodeStartTime" placeholder="Start time" type="text" class="form-control">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    <span class='help-inline' id='error4inline_editEp'></span>
                                </div>
                            </div>

                            <div class="col-xs-6" id="error5_editEp">
                                <label class="sr-only">End time</label>
                                <div class="input-group date" id="edit-episode-end-time">
                                    <input id="edited_episodeEndTime" value="" class="form-control" name="edited_episodeEndTime" placeholder="End time" type="text" class="form-control">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    <span class='help-inline' id='error5inline_editEp'></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="error6_editEp">
                            <label class="sr-only">Location</label>
                            <input id="edited_episodeLocation" value="" placeholder="Location" name="edited_episodeLocation" class="form-control" type="text">
                            <span class='help-inline' id='error6inline_editEp'></span>
                        </div>
                        
                        <input id="edited_episodeId" value="" name="edited_episodeId"  type="hidden">
                       
                </div>
               
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                    <button class="btn btn-info" id="editepisodesubmit" type="button">Save changes</button>
                </div>
            </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
        <!-- DELETE EPISODE MODAL -->
    
<div class="modal fade" id="delete_episode_modal" keyboard="true" tabindex="-1" role="dialog" aria-labelledby="delete_episode" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete event</h4>
                </div>

                <div id="delete_episode_modal_body "class="modal-body">
                    
                    <form id='delete_event_episode_form' action="" method="post">
                    <input id="delete_episodeId" value="" placeholder="id" name="delete_episodeId" class="form-control" type="hidden">
                    
                </div>
               
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="button">Nah, cancel this shite</button>
                    <button class="btn btn-info" id="deleteepisodesubmit" type="button">Yeah, let it burn!</button>
                </div>
                    </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<div class="modal fade bs-modal-sm" id="leave_team_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Wait, whaat?</h4>
      </div>
      <div class="modal-body">
          <p>Are you sure you want to leave <?php echo $teaminfo->teamname; ?>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default" data-dismiss="modal">Actually, no</button>
        <button id="leaveteamsubmit" type="button" class="btn btn-danger">Yeah, screw you guys</button>
      </div>
    </div><!-- /.modal-content -->
  </div>
</div>