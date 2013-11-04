<?php if ( $coach === TRUE ) : ?>

<div id="search"> 
    <?php if (empty($players)) {?>
    <div>
        <h2>Apparently, there are no players. </h2>
        <p>Ask your players to create a profile in order to start rollin'.</p>
    </div>

    <?php } else {?>

    <input type="text" class="input-medium search-query" id="search_player" autocomplete="off" placeholder="Søk eller legg til..." onfocus="if
    (this.value==this.defaultValue) this.value='';">
    
    <table id="team_table" class="table">
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
            <?php } ?>
    
</div>

<?php else : ?>

<div id="search"> 
    <?php if (empty($teams)) {?>
    <div>
        <h2>Apparently, there are no teams. </h2>
        <p>Ask your coach to add one in order to start rollin'.</p>
    </div>

    <?php } else {?>
    
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
                <td class="left"><input form="team" type="checkbox" name="team[]" id="air" value="<?php echo $team['team_id'];?>" > </td>
                <td class="middle_l"><div class="teamname"><?php echo $team['teamname'];?></div></td>
                <td class="middle_r"><div class="sport"><?php echo $team['sport'];?></div></td>
                
            </tr>
            
            <?php endforeach;?>
        </tbody>
    
    </table>
    <form id="team" action="<?php echo base_url(); ?>index.php/search/join_team" method="post">
        <button class="btn btn-info" type="submit" >Join team</button>
    </form>
    
    
            <?php } ?>
</div>

<?php endif; ?>
