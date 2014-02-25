    <div id="success" class="success">
        
    </div>
    
<div id="top" class="container-fluid">
    <div id="inner_top" class="container">
    <div class="row">
        <div class="col-xs-12">
            <h2><?php echo $teaminfo->teamname; ?> </h2>
        </div>
    </div>
        </div>
        <div class="row">
        <div class="col-sm-12">
            <?php if ( $coach === TRUE ) : ?>
            <ul id="team_tabs" class="nav nav-tabs">
                <li><a href="#schedule" data-toggle="tab"><span class="glyphicon glyphicon-calendar"></span>Schedule</a></li>
                <li><a href="#stats" data-toggle="tab"><span class="glyphicon glyphicon-stats"></span>Statistics</a></li>
                <li><a href="#manage_squad" data-toggle="tab"><span class="glyphicon glyphicon-list-alt"></span>Manage squad</a></li>
                <li><a href="#edit" data-toggle="tab"><span class="glyphicon glyphicon-edit"></span>Edit <?php echo $teaminfo->teamname; ?></a></li>
            </ul>
            <?php else : ?>
            <ul id="team_tabs" class="nav nav-tabs">
                <li><a href="#schedule" data-toggle="tab"><span class="glyphicon glyphicon-calendar"></span>Schedule</a></li>
                <li><a href="#about" data-toggle="tab"><span class="glyphicon glyphicon-info-sign"></span>About <?php echo $teaminfo->teamname; ?></a></li>
            </ul>
            <?php endif; ?>
        </div>
        
    </div>

</div>
    
<div id="container" class="container">
    
    <input id="filter_id" type="hidden" name="filter_id" value="<?php echo $this->uri->segment(2); ?>">
    <input id='user' type='hidden' name='user_id' value='<?php echo $this->session->userdata('user_id'); ?>'>
    
    <!-- Tab panes -->

    
    <div id="team_content" class="tab-content">
        <div class="tab-pane fade in active" id="schedule">
            <?php if ( $coach !== TRUE ) : ?>
            <h3 class="margin">Schedule</h3>
            <?php else : ?>
            <h3>Schedule</h3>
            <?php endif; ?>
            <div class='row'>
                <?php if ( $coach === TRUE ) : ?>
            <div id="knapp_bar" class="col-sm-12">
                <button type="button" id="add_event" class="btn btn-info" href="#add_event_modal"> <span class="glyphicon glyphicon-plus-sign"></span>Add event</button>
                <button type="button" id="edit_event" class="btn btn-default" href="#edit_event_modal"> <span class="glyphicon glyphicon-edit"></span>Edit events</button>
                <button type="button" id="delete_event" class=" btn btn-danger" href="#delete_event_modal"> <span class="glyphicon glyphicon-trash"></span>Delete events</button>
            </div>
            <?php endif; ?>
                <div id="calendar" class='col-xs-12'>
                    
                </div>
            </div>
            <div id="event-info">
                <div class='row'>
                    <div class='col-xs-12 col-md-6'>
                    
                    <div id="event-details">
                        <div class='row'>
                            <div class='col-xs-8 col-md-7'>
                                <div class='panel panel-default'>
                                    <div class='panel-heading'><span class='glyphicon glyphicon-map-marker'></span>Location</div>
                                    <div class='panel-body'>
                                        <p class="nomargin" id='location' type='text' name='location'></p>
                                    </div>
                                </div>
                            </div>

                            <div class='col-xs-4 col-md-5'>
                                <div class='panel panel-default'>
                                    <div class='panel-heading'><span class='glyphicon glyphicon-time'></span>Time</div>
                                    <div class='panel-body'>
                                        <p class="nomargin nopadding" id='time' type='text' name='time'></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xs-12'>
                                <div class='panel panel-default'>
                                    <div class='panel-heading'><span class='glyphicon glyphicon-info-sign'></span>Description</div>
                                    <div class='panel-body'>
                                        <p class="nomargin" id='description' type='text' name='description'></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                        <?php if ( $coach === TRUE ) : ?>
                    <div id="coach-only">

                    </div>
                    <?php else : ?>
                    
                    <div id="attendance_select" class='row'>
                        <form class="after" id="set_attendance_form" action="" method="post">
                            <div class='col-xs-12'>
                                <div class='attendance panel panel-default'>
                                <div id="editable" class='panel-heading'><span class='glyphicon glyphicon-question-sign'></span>Attendance status</div>
                                <div class='panel-body'>
                                    <div class='row'>
                                        <div class='col-xs-6'>
                                            <input type="radio" value="1" name="attendance_choice" id="attend_yes">
                                            <label for="attend_yes">YES</label>

                                        </div>
                                        <div class='col-xs-6'>
                                            <input type="radio" value="2" name="attendance_choice" id="attend_no">
                                            <label for="attend_no">NO</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden_id"></div>
                        </form>   
                    </div>
                        
                    <?php endif; ?>
                </div>    
                    <div class='col-xs-12 col-md-6'>
                        <div id='attendance_tables' class='row'>
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="tab-pane fade" id="stats">
            <h3>Statistics</h3>
            <div id="stats_table">
                <div class='row'>
                    <div class='col-sm-10 col-md-8 col-lg-6'>
                    <div id="daterange" class="pull-right">
                        <span class="glyphicon glyphicon-calendar"></span><span class="text"><?php echo date("F j, Y", strtotime('-30 day')); ?> - <?php echo date("F j, Y"); ?></span> <b class="caret"></b>
                    </div>
                
                    

                    <table id="statistics_table" class="table table-striped table-bordered dataTable">
                        <thead>
                            <tr class="tabellheader">
                                <th class="name" scope="col">Player Name</th>
                                <th class="email" scope="col">Email</th>
                                <th class="number" scope="col">#</th>
                            </tr>  
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                    
                    <div id="box" class="col-md-3 col-md-offset-1">
                        <p>In the table to the left, you can see an overview over who attended the most events in a certain period of time. Just pick your date range in the picker over the table, and rockEnroll will do the rest.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="about">
            <h3>About</h3>
            <div class='row'>
            <?php if (empty($squad)) {?>
            <?php } else {?>
                <div class='col-xs-6'>
                    <h4>Players</h4>
                    <table id="player_squad_table" class="table table-striped table-bordered dataTable">
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
                    </div>
            <?php } ?>
                
            <?php if (empty($staff)) {?>
            <?php } else {?>
                <div class='col-xs-6'>
                    <h4>Coaches</h4>
                    <table id="player_staff_table" class="table table-striped table-bordered dataTable">
                        <thead>
                            <tr> 
                                <th class="middle_l" scope="col">Name</th>
                                <th class="middle_r" scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php foreach ($staff as $sta):?>
                            <tr>
                                <td class="middle_l"><div class="username"><?php echo $sta['username'];?></div></td>
                                <td class="middle_r"><div class="email"><?php echo $sta['email'];?></div></td>
                            </tr>
                    <?php endforeach;?>
                        </tbody>
                    </table>
                    
                </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <div class='leave panel panel-default'>
                        <div class='panel-heading'>
                            <span class='glyphicon glyphicon-warning-sign'></span>Danger-zone
                        </div>
                        <div class='panel-body'>
                            
                            <button id="leave_team" class="btn btn-block btn-danger"><span class="glyphicon glyphicon-remove-circle"></span>Leave Team</button>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="manage_squad">
            <h3>Manage squad</h3>
            <div class="row">
            
            <?php if (empty($squad)) {?>

            
                <div class="col-sm-6">
                    <h3>There is currently no players on <?php echo $teaminfo->teamname; ?> </h3>
                    <p>Press the button below to add players.</p>
                </div>
            
            
            <?php } else {?> 
                
                <div class="col-sm-6">
                    <div id="squad">
                        
                        <h4>Players</h4>
                    <form id="remove_player" action="" method="post">
                        
                    <table id="squad_table" class="table table-striped table-bordered dataTable">
                        <thead>
                            <tr> 
                                <th class="left" scope="col"><input name="check_all_squad" id="selectall" type="checkbox" />
                                <th class="middle_l" scope="col">Name</th>
                                <th class="middle_r" scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody>	
                            <?php foreach ($squad as $s):?> 
                                <tr>
                                    <td class="left"><input class='allboxes_squad' type="checkbox" name="squad[]" id="squadchecktest" value="<?php echo $s['id'];?>" /> </td>
                                    <td class="middle_l"><div class="username"><?php echo $s['username'];?></div></td>
                                    <td class="middle_r"><div class="email"><?php echo $s['email'];?></div></td>
                                    <!-- <td class="right"><div class="role"><?php if($s['role'] === '300') {echo "Player";}else{echo "Coach";} ?></div></td> -->
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                        <button class="btn btn-danger" id="removeplayersubmit" type="button" disabled><span class="glyphicon glyphicon-trash"></span>Remove Player</button>
                    </form>
                    </div>
                    
                </div>
            <?php } ?>
            
            <?php if (empty($staff)) {?>

                <div class="col-sm-6">
                    <h3>There is currently no coaches on <?php echo $teaminfo->teamname; ?> </h3>
                    <p>Press the button below to add coaches.</p>

                    <div id="knapp">
                        <button type="button" id="add_coach" class="btn btn-info" data-target="#add_people_accordion" data-toggle="collapse" data-parent="knapp"><span class="glyphicon glyphicon-plus-sign"></span>Add more coaches</button>
                    </div>
                </div>
            
            
            <?php } else {?> 
                
                
                
                <div class="col-sm-6">
                    <div id="staff">
                        
                        <h4>Coaches</h4>
                    <form id="remove_coach" action="" method="post">
                        
                    <table id="staff_table" class="table table-striped table-bordered dataTable">
                        <thead>
                            <tr> 
                                <th class="left" scope="col"><input name="check_all_staff" type="checkbox" />
                                <th class="middle_l" scope="col">Name</th>
                                <th class="middle_r" scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody>	
                            <?php foreach ($staff as $st):?> 
                                <tr>
                                    <td class="left"><input class='allboxes_staff' type="checkbox" name="staff[]" id="staffchecktest" value="<?php echo $st['id'];?>" /> </td>
                                    <td class="middle_l"><div class="username"><?php echo $st['username'];?></div></td>
                                    <td class="middle_r"><div class="email"><?php echo $st['email'];?></div></td>
                                    <!-- <td class="right"><div class="role"><?php if($st['role'] === '300') {echo "Player";}else{echo "Coach";} ?></div></td> -->
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                        <button class="btn btn-danger" id="removecoachsubmit" type="button" disabled><span class="glyphicon glyphicon-trash"></span>Remove Coach</button>
                    </form>
                    </div>
                    
                </div>
                    
                <?php } ?>
            
            </div>
            
            <div id="knapp_bar2"> 
                <button type="button" id="add_people" class="btn btn-lg btn-info" data-target="#add_people_accordion" data-toggle="collapse" data-parent="knapp_bar"><span class="glyphicon glyphicon-plus-sign"></span>Add more people<span class="caret"></span></button>
            </div>
            
            <div id="add_people_accordion" class="collapse">
                <div class="row">
                    <?php if (empty($players)) {?>
                    
                        <div class="col-sm-6">
                            <h2>Apparently, there are no players. </h2>
                            <p>Ask your players to create a profile in order to start rollin'.</p>
                        </div>
                    
                
                    <?php } else {?>
                    
                        <div class="col-sm-6">
                            <div id="playersearch">
                                <h3>Player database</h3>

                                <form id="add_player_form" action="" method="post">
                                <table id="player_table" class="table table-striped table-bordered dataTable">
                                    <thead>
                                        <tr class="tabellheader"> 
                                            <th class="left" scope="col"></th>
                                            <th class="right" scope="col">Name</th>

                                        </tr>
                                    </thead>
                                    <tbody>	
                                        <?php foreach ($players as $p):?> 
                                        <tr>
                                            <td class="left"><input type="checkbox" name="players[]" id="checktest" value="<?php echo $p['id'];?>" /> </td>
                                            <td class="right"><div class="username"><?php echo $p['username'];?></div></td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>

                                <button class="btn btn-success" id="addplayersubmit" type="button" disabled >Add to team</button>

                                </form>
                            </div>
                    </div>
                        
                    <?php } ?>
                
                <?php if (empty($coaches)) {?>
                    
                        <div class="col-sm-6">
                            <h2>Apparently, there are no coaches. </h2>
                            <p>Ask your coaching colleagues to create a profile in order to start rollin'.</p>
                        </div>
                    
                
                    <?php } else {?>    
                
                <div class="col-sm-6">
                    <div id="coachsearch">
                        <h3>Coach database</h3>
                        <table id="coach_table" class="table table-striped table-bordered dataTable">
                            <thead>
                                <tr class="tabellheader"> 
                                    <th class="left" scope="col"></th>
                                    <th class="right" scope="col">Name</th>
                                </tr>
                            </thead>
                            <tbody>	
                                <?php foreach ($coaches as $c):?> 
                                <tr>
                                    <td class="left"><input type="checkbox" name="coaches[]" id="coachtest" value="<?php echo $c['id'];?>" /> </td>
                                    <td class="right"><div class="username"><?php echo $c['username'];?></div></td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                                
                            </table>
                            
                            <button class="btn btn-success" id="addcoachsubmit" type="button" disabled >Add to team</button>
                        </form>
                    </div>
                </div>
                    <?php } ?>
                    </div>
                </div> 
            </div>
        
        <div id="edit" class="tab-pane fade">
            <h3>Edit</h3>
                
                <div id="edit_panels" class="row">
                    
                    <div class="col-sm-9 col-md-6 col-lg-5">
                        <div id="edit_team">

                            <div class='panel panel-default'>
                                        <div class='panel-heading'>
                                            <span class='glyphicon glyphicon-edit'></span>Edit team information
                                        </div>
                                        <div class='panel-body'>
                                           <form id="edit_team_info" action="" method="post">

                                            <div class="form-group" id="error_teaminfo">
                                                <label for="teamname">Team Name:</label>
                                                <input autofocus name="teamname" type="text" placeholder="" id="teamname" class="form-control" value="<?php echo $teaminfo->teamname; ?>">
                                                <span class='help-inline' id='errorinline_teaminfo'><p class="danger"></p></span>
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
                                                <span class='help-inline' id='error2inline_teaminfo'><p class="danger"></p></span>
                                            </div>

                                            <button type="button" id="teaminfosubmit" class="btn btn-info">Save team information</button>

                                            </form> 
                                        </div>
                                    </div>


                        </div>
                    </div>

                    <div class="col-xs-9 col-md-6 col-lg-6">
                        <div id="delete_team">

                            <div class='panel panel-default'>
                                <div class='panel-heading'><span class='glyphicon glyphicon-trash'></span>Delete this team</div>
                                <div class='panel-body'>
                                    <form id="delete_team" action="" method="post">
                                    <p>Once you delete the team, there is no undo.</p>
                                    <div class="input-group" id="error_deleteteam">
                                        <input type="text" class="form-control" id="delete" name="delete" placeholder="Type team name">
                                        <input id="match" type="hidden" value="<?php echo $teaminfo->teamname; ?>" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger" id="deleteteamsubmit" type="button">Delete team</button>
                                        </span>
                                        
                                    </div>
                                    </form>
                                    <span class='help-inline' id='errorinline_deleteteam'><p class="danger"></p></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<div id="modals">
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
                        <span class='help-inline' id='errorinline'><p class="danger"></p></span>
                    </div>
                        

                    <div class="form-group" id="error2">
                        <label class="sr-only">Event description</label>
                        <input placeholder="Event description (optional)" id="event_desc" name="eventdesc" class="form-control" type="text">
                        <span class='help-inline' id='error2inline'><p class="danger"></p></span>
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
                        <span class='help-inline' id='error3inline'><p class="danger"></p></span>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-6" id="error4">
                            <label class="sr-only">Start date</label>
                            <div class="input-group date" id="start-date">
                                <input class="form-control" name="start_date" id="start_date" placeholder="Start date" type="text">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                                <span class='help-inline' id='error4inline'><p class="danger"></p></span>
                        </div>

                        <div class="col-xs-6" id="error5">
                            <label class="sr-only">End date</label>
                            <div class="input-group date" id="end-date">
                                <input class="form-control end" name="end_date" id="end_date" placeholder="End date" type="text">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                                <span class='help-inline' id='error5inline'><p class="danger"></p></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-6" id="error6">
                            <label class="sr-only">Start time</label>
                            <div class="input-group date" id="start-time">
                                <input class="form-control" name="start_time" id="start_time" placeholder="Start time" type="text">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>
                                <span class='help-inline' id='error6inline'><p class="danger"></p></span> 
                        </div>

                        <div class="col-xs-6" id="error7">
                            <label class="sr-only">End time</label>
                            <div class="input-group date" id="end-time">
                                <input class="form-control" name="end_time" id="end_time" placeholder="End time" type="text">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>
                            <span class='help-inline' id='error7inline'><p class="danger"></p></span>
                        </div>
                    </div>

                    <div class="form-group" id="error8">
                        <label class="sr-only">Location</label>
                        <input class="form-control" placeholder="Location" name="eventlocation" id="eventlocation" type="text">
                        <span class='help-inline' id='error8inline'><p class="danger"></p></span>
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
                                    <span class='help-inline' id='errorinline_edit'><p class="danger"></p></span>
                                </div>

                                <div class="form-group" id="error2_edit">
                                    <label class="sr-only">Event description</label>
                                    <input value="<?php echo $row['description']; ?>" placeholder="Event description (optional)" id="edited_eventdesc" name="edited_eventdesc" class="form-control" type="text">
                                    <span class='help-inline' id='error2inline_edit'><p class="danger"></p></span>
                                </div>

                                <div class="form-group row">
                                    <div class="col-xs-6" id="error3_edit">
                                        <label class="sr-only">Start time</label>
                                        <div class="edit-start-time input-group date" id="edit-start-time">
                                            <input value="<?php echo $row['start_time']; ?>" class="form-control" id="edited_start_time" name="edited_start_time" placeholder="Start time" type="text" class="form-control">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                            <span class='help-inline' id='error3inline_edit'><p class="danger"></p></span>
                                        </div>
                                    </div>

                                    <div class="col-xs-6" id="error4_edit">
                                        <label class="sr-only">End time</label>
                                        <div class="edit-end-time input-group date" id="edit-end-time">
                                            <input value="<?php echo $row['end_time']; ?>" class="form-control" id="edited_end_time"name="edited_end_time" placeholder="End time" type="text" class="form-control">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                            <span class='help-inline' id='error4inline_edit'><p class="danger"></p></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" id="error5_edit">
                                    <label class="sr-only">Location</label>
                                    <input value="<?php echo $row['location']; ?>" placeholder="Location" id="edited_location" name="edited_location" class="form-control" type="text">
                                    <span class='help-inline' id='error5inline_edit'><p class="danger"></p></span>
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
            </div>
        
                     
                    <?php } ?>
                    
                
    
                    
                    
                
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-lg btn-info" type="button">Done</button>
                </div>
        
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- DELETE EVENT MODAL -->
    
    <div class="modal fade" id="delete_event_modal" keyboard="true" tabindex="-1" role="dialog" aria-labelledby="delete_event" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete events</h4>
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
                                <th class="left" scope="col"><input rel="popover" name="check_all" type="checkbox" />
                                <th class="middle_l" scope="col">Event Name</th>
                                <th class="middle_r" scope="col">Location</th>
                            </tr>
                        </thead>
                        <tbody>	
                            <?php foreach ($eventdata as $row):?> 
                            <tr>
                                <td class="left"><input class="allboxes" type="checkbox" name="events[]" id="ids" value="<?php echo $row['id'];?>" /> </td>
                                <td class="middle_l"><div class="eventname"><?php echo $row['name'];?></div></td>
                                <td class="middle_r"><div class="location"><?php echo $row['location'];?></div></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                    <?php } ?>
                    <span class='help-inline' id='errorinline_delete'><p class="danger"></p></span>
                </div>

                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                    <button class="btn btn-lg btn-danger" id="deleteeventsubmit" type="button" disabled>Delete events</button>
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
                    <span class='help-inline' id='errorinline_editEp'><p class="danger"></p></span>
                </div>

                <div class="form-group" id="error2_editEp">
                    <label class="sr-only">Description</label>
                    <input id="edited_episodeDesc" value="" placeholder="Event description (optional)" name="edited_episodeDesc" class="form-control" type="text">
                    <span class='help-inline' id='error2inline_editEp'><p class="danger"></p></span>
                </div>

                <div class="form-group" id="error3_editEp">
                    <label class="sr-only">Date</label>
                        <div class="input-group date" id="edit-episode-date">
                            <input id="edited_episodeDate" value="" class="form-control" name="edited_episodeDate" placeholder="Date" type="text" class="form-control">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            <span class='help-inline' id='error3inline_editEp'><p class="danger"></p></span>
                        </div>
                </div>

                <div class="form-group row">
                    <div class="col-xs-6" id="error4_editEp">
                        <label class="sr-only">Start time</label>
                        <div class="input-group date" id="edit-episode-start-time">
                            <input id="edited_episodeStartTime" value="" class="form-control" name="edited_episodeStartTime" placeholder="Start time" type="text" class="form-control">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            <span class='help-inline' id='error4inline_editEp'><p class="danger"></p></span>
                        </div>
                    </div>

                    <div class="col-xs-6" id="error5_editEp">
                        <label class="sr-only">End time</label>
                        <div class="input-group date" id="edit-episode-end-time">
                            <input id="edited_episodeEndTime" value="" class="form-control" name="edited_episodeEndTime" placeholder="End time" type="text" class="form-control">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            <span class='help-inline' id='error5inline_editEp'><p class="danger"></p></span>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="error6_editEp">
                    <label class="sr-only">Location</label>
                    <input id="edited_episodeLocation" value="" placeholder="Location" name="edited_episodeLocation" class="form-control" type="text">
                    <span class='help-inline' id='error6inline_editEp'><p class="danger"></p></span>
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
                    <h4 class="modal-title">Delete events</h4>
                </div>

                <div id="delete_episode_modal_body "class="modal-body">
                    <form id='delete_event_episode_form' action="" method="post">
                    <input id="delete_episodeId" value="" placeholder="id" name="delete_episodeId" class="form-control" type="hidden">
                </div>
               
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="button">Nah, get me out of here!</button>
                    <button class="btn btn-info" id="deleteepisodesubmit" type="button">Yeah, let it burn!</button>
                </div>
                    </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
