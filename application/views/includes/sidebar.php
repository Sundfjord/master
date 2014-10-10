<div id="sidebar">
    
<?php if ( $coach === TRUE ) : ?>

<ul id="menu" class="nav nav-pills nav-stacked">
    <li><a href="<?php echo base_url(); ?>"><span class="glyphicon glyphicon-home"></span>Home</a></li>
        <ul id="submenu" class="nav">
            <?php if (empty($coachteam)) {?>
            <?php echo '<li><a id="home_create_team" href="#create_team_modal"><span class="glyphicon glyphicon-plus"></span>Create a team</a></li>'; ?>
            <?php } else {?>
            <?php foreach ($coachteam as $row): ?>
            <?php echo '<li><a href="http://localhost/master/index.php/team/' . $row['id'] . '">' . $row['teamname'] . '</a></li>';?> 
            <?php endforeach; 
                if(count($coachteam) <= 2) 
                {
                    echo '<li c><a id="home_create_team" href="#create_team_modal"><span class="glyphicon glyphicon-plus"></span>Create a team</a></li>';
                }
              } ?>
        </ul>
    <li><a href="<?php echo base_url(); ?>index.php/profile"><span class="glyphicon glyphicon-user"></span>My Profile</a></li>
    <li><a href="<?php echo base_url(); ?>index.php/auth/logout"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
</ul> 
            <?php else : ?>
               
<ul id="menu" class="nav nav-pills nav-stacked">
    <li><a href="<?php echo base_url(); ?>"><span class="glyphicon glyphicon-home"></span>Home</a></li>
        <ul id="submenu" class="nav">
            <?php if (empty($playerteam)) {?>
            <?php echo '<li class="team"><a id="home_join_team" href="#join_team_modal"><span class="glyphicon glyphicon-plus"></span>Join a team</a></li>';?>
            <?php } else {?>
            <?php foreach ($playerteam as $row): ?>
            <?php echo '<li class="team"><a href="http://localhost/master/index.php/team/' . $row['id'] . '">' .$row['teamname'] . '</a></li>';?> 
            <?php endforeach; 
                if(count($playerteam) <= 2) 
                {
                    echo '<li class="team"><a id="home_join_team" href="#join_team_modal"><span class="glyphicon glyphicon-plus"></span>Join a team</a></li>';
                }
              } ?>
        </ul>
    <li><a href="<?php echo base_url(); ?>index.php/profile"><span class="glyphicon glyphicon-user"></span>My Profile</a></li>
    <li><a href="<?php echo base_url(); ?>index.php/auth/logout"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
</ul>
            <?php endif; ?>
        


</div>
