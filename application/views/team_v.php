<div>
    <?php if ( $coach === TRUE ) : ?>
        
    <h2><?php echo $teaminfo->teamname; ?> </h2>
    <h4><?php echo $teaminfo->sport; ?> team</h4>
    
    
    <ul id="team_tabs" class="nav nav-tabs">
        <li><a href="#schedule" data-toggle="tab"><span class="glyphicon glyphicon-calendar"></span>Schedule</a></li>
        <li><a href="#stats" data-toggle="tab"><span class="glyphicon glyphicon-stats"></span>Statistics</a></li>
        <li><a href="#manage_squad" data-toggle="tab"><span class="glyphicon glyphicon-list-alt"></span>Manage squad</a></li>
        <li><a href="#edit" data-toggle="tab"><span class="glyphicon glyphicon-edit"></span>Edit</a></li>
    </ul>
    
    <!-- Tab panes -->
    
    <br>
    
    <div id="team_content" class="tab-content">
        <div class="tab-pane fade in active" id="schedule">
            <div id="knapp_bar">
                <button type="button" id="add_event" class="btn btn-info" href="#add_event_modal"> <span class="glyphicon glyphicon-plus-sign"></span>Add event</button>
                <button type="button" id="edit_event" class="btn btn-default" href="#edit_event_modal"> <span class="glyphicon glyphicon-edit"></span>Edit events</button>
                <button type="button" id="delete_event" class="btn btn-danger" href="#delete_event_modal"> <span class="glyphicon glyphicon-trash"></span>Delete event</button>
            </div>
            <div id="calendar">
                
            </div>
        </div>
        
        <div class="tab-pane fade" id="stats">
            <p>More content</p>
        </div>
        
        <div class="tab-pane fade" id="manage_squad" class="dataTables_wrapper">
        
            <?php if (empty($squad)) {?>
            
            <div>
                <h3>There is currently no players on <?php echo $teaminfo->teamname; ?> </h3>
                <p>Press the button below to add players.</p>
            </div>
            
            <div id="knapp">
                
                <button type="button" id="add_player" class="btn btn-info" data-target="#add_player_accordion" data-toggle="collapse" data-parent="knapp"><span class="glyphicon glyphicon-plus-sign"></span>Add more players</button>
                
            </div>
            
            <?php } else {?>
            
            <form id="remove_player" action="<?php echo base_url('index.php/team/remove_player/'. $teaminfo->id); ?>" method="post">
                
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
                            <td class="left"><input type="checkbox" name="squad[]" value="<?php echo $s['id'];?>" /> </td>
                            <td class="middle_l"><div class="username"><?php echo $s['username'];?></div></td>
                            <td class="middle_r"><div class="email"><?php echo $s['email'];?></div></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            
            <div id="knapp_bar">
                <button type="button" id="add_player" class="btn btn-info" data-target="#add_player_accordion" data-toggle="collapse" data-parent="knapp_bar"><span class="glyphicon glyphicon-plus-sign"></span>Add more players</button>
                <button class="btn btn-danger" type="submit"><span class="glyphicon glyphicon-trash"></span>Remove Player</button>
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

                    <form id="add_player_form" action="<?php echo base_url('index.php/team/add_player/'. $teaminfo->id); ?>" method="post">
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
                                <td class="left"><input type="checkbox" name="players[]" id="air" value="<?php echo $p['id'];?>" /> </td>
                                <td class="middle_l"><div class="username"><?php echo $p['username'];?></div></td>
                                <td class="middle_r"><div class="email"><?php echo $p['email'];?></div></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>

                    <button class="btn btn-info" type="submit" >Add player(s) to team</button>
                    
                    </form>
                    <?php } ?>
                
                </div>
            
            </div>
            
        </div>
        
        <div class="tab-pane fade" id="edit">

            <div id="edit_team" class="well">
                <h4>Edit team information</h4><br>
                <form id="edit_team_info" action="<?php echo base_url('index.php/team/update_team/'. $teaminfo->id); ?>" method="post">

                    <div class="form-group">
                        <label for="teamname">Team Name:</label><br>
                        <input autofocus name="teamname" type="text" placeholder="<?php echo $teaminfo->teamname; ?>" class="form-control" value="<?php echo set_value('teamname'); ?>">
                        <input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" />
                    </div>

                    <div class="form-group">
                        <select class ="form-control" name="sport" id="sport" value="<?php echo set_value('sport'); ?>">
                            <option value="0" name="choose" selected>Choose sport</option>
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
                        <?php echo form_error('sport'); ?>
                       
                    </div>
                    
                    <br>
                    
                    <button type="submit" class="btn btn-block btn-info">Save team information</button>

                </form>
            </div>
            
            <br>
            
            <div id="delete_team" class="well">
                <h4>Delete this team</h4>
                <p>Once you delete the team, there is no undo.</p>
                <form id="delete_team" action="<?php echo base_url('index.php/team/delete_team/'.$teaminfo->id); ?>" method="post">
                        
                        <div class="input-group">
                            <input type="text" class="form-control" name="delete" placeholder="Type team name">
                            <input name="must_match_teamname" type="hidden" value="<?php echo $teaminfo->teamname; ?>" />
                            <input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" />
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="submit">Delete team</button>
                            </span>
                        </div>
                    
                </form>
                
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
                    
                        <form id="add_event_form" action="<?php echo base_url('index.php/team/add_event/'.$teaminfo->id); ?>" method="post">
                        <div class="form-group">
                            <label class="sr-only">Event name</label>
                            <input placeholder="Event name" id="event_name" name="eventname" class="form-control" type="text">
                        </div>

                        <div class="form-group">
                            <label class="sr-only">Event description</label>
                            <input placeholder="Event description (optional)" name="eventdesc" class="form-control" type="text">
                        </div>
                        
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
                            
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label class="sr-only">Start date</label>
                                <div class="input-group date" id="start-date">
                                    <input class="form-control" name="start_date" placeholder="Start date" type="text">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                        
                            <div class="col-xs-6">
                                <label class="sr-only">End date</label>
                                <div class="input-group date" id="end-date">
                                    <input class="form-control" name="end_date" placeholder="End date" type="text">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                            
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label class="sr-only">Start time</label>
                                <div class="input-group date" id="start-time">
                                    <input class="form-control" name="start_time" placeholder="Start time" type="text">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                        

                        
                            <div class="col-xs-6">
                                <label class="sr-only">End time</label>
                                <div class="input-group date" id="end-time">
                                    <input class="form-control" name="end_time" placeholder="End time" type="text">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="sr-only">Location</label>
                            <input class="form-control" placeholder="Location" name="location" type="text">
                        </div>
                            
                </div>

                <div class="modal-footer">
                    <button class="btn btn-lg btn-info" type="submit">Add event</button>
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
                            <form id="edit_event_form" action="<?php echo base_url('index.php/team/edit_event/'.$row['id']); ?>" method="post">

                                <div class="form-group">
                                    <label class="sr-only">Event name</label>
                                    <input value="<?php echo $row['name']; ?>" placeholder="Event name" id="event_name" name="edited_eventname" class="form-control" type="text">
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">Event description</label>
                                    <input value="<?php echo $row['description']; ?>" placeholder="Event description (optional)" name="edited_eventdesc" class="form-control" type="text">
                                </div>

                                <div class="form-group row">
                                    <div class="col-xs-6">
                                        <label class="sr-only">Start time</label>
                                        <div class="input-group date" id="edit-start-time">
                                            <input value="<?php echo $row['start_time']; ?>" class="form-control" name="edited_start_time" placeholder="Start time" type="text" class="form-control">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                        </div>
                                    </div>

                                    <div class="col-xs-6">
                                        <label class="sr-only">End time</label>
                                        <div class="input-group date" id="edit-end-time">
                                            <input value="<?php echo $row['end_time']; ?>" class="form-control" name="edited_end_time" placeholder="End time" type="text" class="form-control">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">Location</label>
                                    <input value="<?php echo $row['location']; ?>" placeholder="Location" name="edited_location" class="form-control" type="text">
                                </div>

                            <div>
                                <button class="btn btn-info" type="submit">Save changes</button>
                            </div>

                                </form>                          
                          </div>
                        </div>
                      </div>
                      
                      
                         <?php endforeach; ?>
                    </div>
                    
                </div>
             
               
                <div class="modal-footer">
                    <button class="btn btn-lg btn-info" type="button">Done</button>
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
                    <form id="delete_event_form" action="<?php echo base_url('index.php/team/delete_event'); ?>" method="post">
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
                                <td class="left"><input type="checkbox" name="events[]" id="air" value="<?php echo $row['id'];?>" /> </td>
                                <td class="middle_l"><div class="eventname"><?php echo $row['name'];?></div></td>
                                <td class="middle_r"><div class="location"><?php echo $row['location'];?></div></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                    
                </div>

                <div class="modal-footer">
                    <button class="btn btn-lg btn-info" type="submit">Delete event</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
    <?php else : ?>
        
    <!-- Player stuff -->
    
    <?php endif; ?>

