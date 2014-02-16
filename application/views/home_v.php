<h2>Teams</h2>
        
<div id="home_success" class="success">

</div>

<ul class="teams">
    <?php if ( $coach === TRUE ) : ?>
    <?php if (empty($coachteam)) {?>
    <?php echo '<li><a id="create_team" href="#create_team_modal"><span class="glyphicon glyphicon-plus"></span>Create a team</a></li>'; ?>
    <?php } else {?><?php foreach ($coachteam as $row): ?>
        <?php echo '<li><a href="http://localhost/master/index.php/team/' . $row['id'] . '">' .$row['teamname'] . '</a></li>';?> 
    <?php endforeach; 
        if(count($coachteam) <= 2) 
        {
            echo '<li><a id="create_team" href="#create_team_modal"><span class="glyphicon glyphicon-plus"></span>Create a team</a></li>';
        }
    } ?>
    <?php else : ?>
    <?php if (empty($playerteam)) {?>
    <?php echo '<li><a id="join_team" href="#join_team_modal"><span class="glyphicon glyphicon-plus"></span>Join a team</a></li>';?>
    <?php } else {?>
    <?php foreach ($playerteam as $row): ?>
        <?php echo '<li><a href="http://localhost/master/index.php/team/' . $row['id'] . '">' .$row['teamname'] . '</a></li>';?> 
    <?php endforeach; 
        if(count($playerteam) <= 2) 
        {
            echo '<li><a id="join_team" href="#join_team_modal"><span class="glyphicon glyphicon-plus"></span>Join a team</a></li>';
        }
    } ?>
    <?php endif; ?>
</ul>