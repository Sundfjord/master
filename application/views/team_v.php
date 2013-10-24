<div>
    <?php if ( $coach === TRUE ) : ?>
        <!-- HTML to display for coaches here -->
        <h3>Create team</h3>
        <form id="input_form" action="<?php echo base_url('index.php/team/create_team'); ?>" method="POST">
            
            <input type="text" value="<?php echo set_value('teamname'); ?>" name="teamname" placeholder="team name" autofocus />
            <?php echo form_error('teamname'); ?>
            
            <select name="sport" id="sport" value="">
                <option value="0" selected disabled>Choose a sport</option>
                <option value="1">Association football (soccer)</option>
                <option value="2">Badminton</option>
                <option value="3">Bandy</option>
                <option value="4">Baseball</option>
                <option value="5">Basketball</option>
                <option value="6">Biathlon</option>
                <option value="7">Cross-country</option>
                <option value="8">Cycling</option>
                <option value="9">Field hockey</option>
                <option value="10">Handball</option>
                <option value="11">Ice hockey</option>
                <option value="12">Lacrosse</option>
                <option value="13">Rugby</option>
                <option value="14">Track and field</option>
                <option value="15">Volleyball</option>
                <option value="16">Water polo</option>
            </select>
            <?php echo form_error('sport'); ?>
            
            <div id="knapp">
                <button class="btn btn-block btn-info" type="submit">Create team</button>  
            </div>
            
        </form> 
    
    <?php else : ?>
        <!-- HTML to display for players here -->
        <h3>Player area</h3>
        <!-- Here goes a search in the 'team' database table -->
        <p>Below, you can search for a team to join</p>
        
        <form id="input_form" action="<?php echo base_url('index.php/team/search_team'); ?>" method="POST">
            
        <input type="text" placeholder="team name" name="teamname" value="teamname">
        
        <div id="knapp">
                <button class="btn btn-block btn-info" type="submit">Search team</button>  
        </div>
            
        </form>
        
    <?php endif; ?>
</div>