<?php if ( $coach === TRUE ) : ?>
                
<ul>
    <li>Teams</li>
        <ul>
            <li>Superteam</li>
            <li>Megateam</li>
            <li>Gigateam</li>
            <li><a data-toggle="modal" id="create_team" data-backdrop="true" href="#create_team_modal" href="<?php echo base_url('index.php/team/create_team'); ?>">Create a team</a></li> 
        </ul>
    <li>Messages</li>
    <li>My profile</li>
    <li><a href="<?php echo base_url('index.php/auth/logout'); ?>">Logout</a></li>
</ul>
    
            <?php else : ?>
               
<ul>
    <li>Teams</li>
    <li>Messages</li>
    <li>My profile</li>
    <li><a href="<?php echo base_url('index.php/auth/logout'); ?>">Logout</a></li>
</ul>
            <?php endif; ?>

<?php /*  if (empty($result)): ?>
            <li>Create a team</li>
            <?php  else:  ?>
            <?php foreach ($result as $row): ?>
            <li><?php echo $row['teamname'];?></li>  
            <?php endforeach; ?>
            <?php endif; */ ?> 
        
        <div class="modal hide fade" id="create_team_modal" keyboard="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Create team</h4>
            </div>
            <div class="modal-body">
                
                <form id="input_form" action="<?php echo base_url('index.php/team/create_team'); ?>" method="POST">
            
                    <input type="text" value="<?php echo set_value('teamname'); ?>" name="teamname" placeholder="Team name" autofocus />
                    <?php echo form_error('teamname'); ?>
            
                    <select name="sport" id="sport" value="">
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
            
                    <!--
                    <select name="activity_days" id="activity_days" value="">
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                        <option value="7">Sunday</option>
                    </select> 
                    -->
            
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create team</button>
            </div>
            
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->