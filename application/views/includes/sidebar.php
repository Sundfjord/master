<div id="sidebar">

<?php if ( $coach === TRUE ) : ?>

<ul id="menu" class="nav nav-pills nav-stacked">
    <li><a href="<?php echo base_url(); ?>"><span class="glyphicon glyphicon-list"></span>My Teams</a></li>
        <ul id="submenu" class="nav">
            <?php if (empty($result)) {?>
            <?php echo '<li><a data-toggle="modal" id="create_team" data-backdrop="true" href="#create_team_modal" href="base_url(index.php/team/create_team)"><span class="glyphicon glyphicon-plus"></span>Create a team</a></li>'; ?>
            <?php } else {?>
            <?php foreach ($result as $row): ?>
            <?php echo '<li><a href="http://localhost/master/index.php/team/' . $row['id'] . '">' . $row['teamname'] . '</a></li>';?> 
            <?php endforeach; 
                if(count($result) <= 2) 
                {
                    echo '<li><a data-toggle="modal" id="create_team" data-backdrop="true" href="#create_team_modal" href="base_url(index.php/team/create_team)"><span class="glyphicon glyphicon-plus"></span>Create a team</a></li>';
                }
              } ?>
        </ul>
    <li><a href="<?php echo base_url(); ?>index.php/message"><span class="glyphicon glyphicon-envelope"></span>Messages</a></li>
    <li><a href="<?php echo base_url(); ?>index.php/profile"><span class="glyphicon glyphicon-user"></span></i>My Profile</a></li>
    <li><a href="<?php echo base_url(); ?>index.php/auth/logout"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
</ul> 
    
            <?php else : ?>
               
<ul id="menu" class="nav nav-pills nav-stacked">
    <li><a href="<?php echo base_url(); ?>"><span class="glyphicon glyphicon-list"></span>My Teams</a></li>
        <ul id="submenu" class="nav">
            <?php if (empty($plr_result)) {?>
            <?php echo '<li><a href="http://localhost/master/index.php/team/' . $row['id'] . '">' .$row['teamname'] . '</a></li>';?>
            <?php } else {?>
            <?php foreach ($plr_result as $row): ?>
            <?php echo '<li><a href="http://localhost/master/index.php/team/' . $row['id'] . '">' .$row['teamname'] . '</a></li>';?> 
            <?php endforeach; 
                if(count($result) <= 2) 
                {
                    echo '<li><a data-toggle="modal" id="join_team" data-backdrop="true" href="#join_team_modal" href="base_url(index.php/team/join_team)"><span class="glyphicon glyphicon-plus"></span>Join a team</a></li>';
                }
              } ?>
        </ul>
    <li><a href="<?php echo base_url(); ?>index.php/message"><span class="glyphicon glyphicon-envelope"></span>Messages</a></li>
    <li><a href="<?php echo base_url(); ?>index.php/profile"><span class="glyphicon glyphicon-user"></span></i>My Profile</a></li>
    <li><a href="<?php echo base_url(); ?>index.php/auth/logout"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
</ul>
            <?php endif; ?>
        
<div class="modal fade" id="create_team_modal" keyboard="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Create team</h4>
            </div>
            <div class="modal-body">
                
                <form id="input_form" action="<?php echo base_url('index.php/team/create_team'); ?>" method="POST">
                    <div class="form-group">
                        <label for="teamname">Team Name</label>
                        <input type="text" class="form-control" value="<?php echo set_value('teamname'); ?>" name="teamname" placeholder="Team name" autofocus />
                        <?php echo form_error('teamname'); ?>
                        
                        <label for="sport">Sport</label>
                        <select class ="form-control" name="sport" id="sport" value="">
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create team</button>
            </div>
            
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="join_team_modal" keyboard="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Join team</h4>
            </div>
            <div class="modal-body">
                
                <input type="text" class="input-medium search-query" id="search_team" autocomplete="off" placeholder="Søk eller legg til..." onfocus="if
                (this.value===this.defaultValue) this.value='';">
    
                <table id="team_table" class="table">
                    <thead>
                        <tr class="tabellheader"> 
                            <th class="left" scope="col"><input rel="popover" class="check_all" id="selectall" type="hidden" />
                            <th class="middle_l" scope="col">Team Name</th>
                            <th class="middle_r" scope="col">Sport</th>
                            <th class="right" scope="col">Coach</th>
                        </tr>
                    </thead>
                    <tbody>	
            
                    <?php foreach ($teams as $team):?>
                        <tr>
                            <td class="left"><input form="team" type="checkbox" name="team[]" id="air" value="<?php echo $team['id'];?>" > </td>
                            <td class="middle_l"><div class="teamname"><?php echo $team['teamname'];?></div></td>
                            <td class="middle_r"><div class="sport"><?php echo $team['sport'];?></div></td>
                            <td class="middle_r"><div class="sport"><?php echo $team['coach'];?></div></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                
            </div>
            <div class="modal-footer">
                <form id="team" action="<?php echo base_url(); ?>index.php/team/join_team" method="post">
                    <button class="btn btn-info" type="submit">Join team</button>
                </form>
            </div>
            
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>
