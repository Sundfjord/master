<div>
    <?php if ( $coach === TRUE ) : ?>
        <!-- HTML to display for coaches here -->
        
        <!-- SELECT *
        FROM employee, department
        WHERE employee.DepartmentID = department.DepartmentID; -->
        <!-- <h3>Change team details</h3>
        <!-- Here must go some sort of dropdown letting the coach choose which team to change 
        <form id="input_form" action="<?php /* echo base_url('index.php/team/update_team'); ?>" method="POST">
    
            <input type="text" value="<?php echo set_value('teamname'); ?>" name="teamname" placeholder="update team name" autofocus />
            <?php echo form_error('teamname'); */ ?>
            
            <div id="knapp">
                <button class="btn btn-block btn-info" type="submit">Change</button>  
            </div>
            
        </form> --> 
    
    <?php else : ?>
        <!-- HTML to display for players here -->
        <h3>Player area</h3>
        <!-- Here goes a search in the 'team' database table -->
        <p>Below, you can search for a team to join</p>
        
        <form id="input_form" action="<?php echo base_url('index.php/team/search_team'); ?>" method="POST">
            
        <input type="text" placeholder="Team name" name="teamname">
        
        <div id="knapp">
                <button class="btn btn-block btn-info" type="submit">Search team</button>  
        </div>
            
        </form>
    <?php endif; ?>
</div>

