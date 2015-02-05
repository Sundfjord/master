<div id="home_success" class="success"></div>
<div class="home jumbotron">
    <div class="container">
        <h1>Your teams</h1>
        <p>Below you'll find your teams. rockEnroll!</p>
    </div>
</div>
<div id="container" class="container">
    <div class="row">

        <ul class="teams">
            <?php if ( $playercoach === true) :
                $playercoachteam = array_merge($playerteam, $coachteam);
                foreach($playercoachteam as $k => $v)
                        {
                            foreach($playercoachteam as $key => $value)
                            {
                                if($k != $key && $v['team_id'] == $value['team_id'])
                                {
                                     unset($playercoachteam[$k]);
                                }
                            }
                        }
                if (empty($playercoachteam)) {
                    echo '<li class="teamlist"><center><a id="create_or_join_team" href="#team_modal"><span class="glyphicon glyphicon-plus"></span><h5>Create or join a team</h5></a></center></li>';
                } else {
                    foreach ($playercoachteam as $row) :
                        echo
                            '<li class="teamlist">
                                <h4>' .$row['teamname'] .'</h4>
                                <ul class="teamdetails">
                                    <li><p class="infolabel">Sport:</p><p class="infosport"> ' .$row['sport'] . '</p></li>
                                    <li><p class="infolabel">Coach:</p><p class="infocoach"> ' .$row['coach'] . '</p></li>
                                    <li><p class="infolabel">Players:</p><p class="infovalue"> ' .$row['count'] . ' players</p></li>
                                </ul>
                                <center><a href="'. base_url() .'index.php/team/' . $row['team_id'] . '" id="gototeam" class="btn btn-info" role="button">Go to team</a></button></center>
                            </li>';
                    endforeach;
                    if (count($playercoachteam) <= 2) {
                        echo '<li class="teamlist"><center><a id="create_or_join_team" href="#team_modal"><span class="glyphicon glyphicon-plus"></span><h5>Create or join a team</h5></a></center></li>';
                    }
                }
            elseif ( $coach === TRUE ) :
                if (empty($coachteam)) {
                    echo '<li class="teamlist"><center><a id="create_team" href="#create_team_modal"><span class="glyphicon glyphicon-plus"></span><h5>Create a team</h5></a></center></li>';
                } else {
                    foreach ($coachteam as $row):
                        echo
                            '<li class="teamlist">
                                <h4>' .$row['teamname'] .'</h4>
                                <ul class="teamdetails">
                                    <li><p class="infolabel">Sport:</p><p class="infosport"> ' .$row['sport'] . '</p></li>
                                    <li><p class="infolabel">Coach:</p><p class="infocoach"> ' .$row['coach'] . '</p></li>
                                    <li><p class="infolabel">Players:</p><p class="infovalue"> ' .$row['count'] . ' players</p></li>
                                </ul>
                                <center><a href="'. base_url() .'index.php/team/' . $row['team_id'] . '" id="gototeam" class="btn btn-info" role="button">Go to team</a></button></center>
                            </li>';
                    endforeach;
                    if(count($coachteam) <= 2)
                    {
                        echo '<li class="teamlist"><center><a id="create_team" href="#create_team_modal"><span class="glyphicon glyphicon-plus"></span><h5>CREATE A TEAM</h5></a></center></li>';
                    }
                }
            else :
                if (empty($playerteam)) {
                    echo '<li class="teamlist"><center><a id="join_team" href="#join_team_modal"><span class="glyphicon glyphicon-plus"></span><h5>Join a team</h5></a></center></li>';
                } else {
                foreach ($playerteam as $row):
                    echo
                    '<li class="teamlist">
                                <h4>' .$row['teamname'] .'</h4>
                                <ul class="teamdetails">
                                    <li><p class="infolabel">Sport:</p><p class="infosport"> ' .$row['sport']. '</p></li>
                                    <li><p class="infolabel">Coach:</p><p class="infocoach"> ' .$row['coach']. '</p></li>
                                    <li><p class="infolabel">Players:</p><p class="infovalue"> ' .$row['count']. ' players</p></li>
                                </ul>
                                <center><a href="'. base_url() .'index.php/team/' . $row['team_id'] . '" id="gototeam" class="btn btn-info" role="button">Go to team</a></center>

                            </li>'
                            ;
                endforeach;
                    if(count($playerteam) <= 2)
                    {
                        echo '<li class="teamlist"><center><a id="join_team" href="#join_team_modal"><span class="glyphicon glyphicon-plus"></span><h5>JOIN A TEAM</h5></a></center></li>';
                    }
                }
            endif; ?>
        </ul>
        </div>
    </div>
</div>