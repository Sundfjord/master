<?php if ( $coach === TRUE ) : ?>

<ul id="menu" class="nav nav-pills nav-stacked">
    <li data-toggle="collapse" data-target="#submenu"><a href="#"><span class="glyphicon glyphicon-list"></span>My Teams<span style="float:right; "class="glyphicon glyphicon-chevron-down"></span></a></li>
        <ul id="submenu" class="nav nav-list collapse">
            <?php foreach ($result as $row): ?>
            <?php echo '<li><a href="team/id=' . $row['id'] . '">' .$row['teamname'] . '</a></li>';?> 
            <?php endforeach; ?>
            <li><a data-toggle="modal" id="create_team" data-backdrop="true" href="#create_team_modal" href="<?php echo base_url('index.php/team/create_team'); ?>"><span class="glyphicon glyphicon-plus"></span>Create a team</a></li>
        </ul>
    <li><a href="<?php echo base_url(); ?>index.php/message"><span class="glyphicon glyphicon-envelope"></span>Messages</a></li>
    <li><a href="<?php echo base_url(); ?>index.php/profile"><span class="glyphicon glyphicon-user"></span></i>My Profile</a></li>
    <li><a href="<?php echo base_url(); ?>index.php/auth/logout"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
</ul> 
    
            <?php else : ?>
               
<ul class="nav nav-pills nav-stacked">
    <li data-toggle="collapse" data-target="#test"><a href="#"><i class="icon-list"></i>My Teams</a></li>
        <ul class="nav nav-list collapse" id="test">
            <li><a href="<?php echo base_url(); ?>">Epic United</a></li>
            <li><a href="<?php echo base_url(); ?>">Awesome Rovers</a></li>
            <li><a href="<?php echo base_url(); ?>">Boston Fuckups</a></li>
            <li><a data-toggle="modal" id="create_team" data-backdrop="true" href="#create_team_modal" href="<?php echo base_url('index.php/team/create_team'); ?>"><i class="icon-plus"></i>Create a team</a></li> 
        </ul>
    <li><a href="<?php echo base_url(); ?>index.php/message"><i class="icon-envelope"></i>Messages</a></li>
    <li><a href="<?php echo base_url(); ?>index.php/profile"><i class="icon-user"></i>My Profile</a></li>
    <li><a href="<?php echo base_url(); ?>index.php/auth/logout"><i class="icon-off"></i>Logout</a></li>
</ul>
            <?php endif; ?>

<?php /*  if (empty($result)): ?>
            <li>Create a team</li>
            <?php  else:  ?>
            <?php foreach ($result as $row): ?>
            <li><?php echo $row['teamname'];?></li>  
            <?php endforeach; ?>
            <?php endif; */ ?> 
        
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