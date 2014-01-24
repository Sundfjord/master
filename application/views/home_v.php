<div>
    <?php if ( $coach === TRUE ) : ?>
        <!-- HTML to display for coaches here -->
        <h2>Teams</h2>
        
        <ul class="team_menu">
            <?php if (empty($result)) {?>
            <?php echo '<li><a data-toggle="modal" id="create_team" data-backdrop="true" href="#create_team_modal" href="base_url(index.php/team/create_team)"><span class="glyphicon glyphicon-plus"></span>Create a team</a></li>'; ?>
            <?php } else {?><?php foreach ($result as $row): ?>
                <?php echo '<li><a href="http://localhost/master/index.php/team/' . $row['id'] . '">' .$row['teamname'] . '</a></li>';?> 
            <?php endforeach; 
                if(count($result) <= 2) 
                {
                    echo '<li><a data-toggle="modal" id="create_team" data-backdrop="true" href="#create_team_modal" href="base_url(index.php/team/create_team)"><span class="glyphicon glyphicon-plus"></span>Create a team</a></li>';
                }
            } ?>
        </ul>
    
    <?php else : ?>
        <!-- HTML to display for players here -->
        <h3>Player area</h3>
        <p> Welcome, <?php echo $username; ?> </p>
        
        <ul class="team_menu">
            <?php if (empty($plr_result)) {?>
            <?php echo '<li><a data-toggle="modal" id="join_team" data-backdrop="true" href="#join_team_modal" href="base_url(index.php/team/join_team)"><span class="glyphicon glyphicon-plus"></span>Join a team</a></li>';?>
            <?php } else {?>
            <?php foreach ($plr_result as $row): ?>
                <?php echo '<li><a href="http://localhost/master/index.php/team/' . $row['id'] . '">' .$row['teamname'] . '</a></li>';?> 
            <?php endforeach; 
                if(count($plr_result) <= 2) 
                {
                    echo '<li><a data-toggle="modal" id="join_team" data-backdrop="true" href="#join_team_modal" href="base_url(index.php/team/join_team)"><span class="glyphicon glyphicon-plus"></span>Join a team</a></li>';
                }
            } ?>
        </ul>
    <?php endif; ?>
</div>