<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Team extends MY_Controller
{
    function __construct() {
        
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('When');
    }
    
    public function index()
    {
        $id = $this->uri->segment(2);
        $team_data['title'] = 'Team'; //title should be $teamname
        $team_data['main_content'] = 'team_v';
        $team_data['teaminfo'] = $this->team_m->get_page($id);
        $team_data['teams'] = $this->team_m->get_teams();
        $team_data['squad'] = $this->team_m->get_squad();
        $team_data['staff'] = $this->team_m->get_staff();
        $team_data['coaches'] = $this->team_m->get_coaches();
        $team_data['players'] = $this->team_m->get_players();
        $team_data['eventdata'] = $this->team_m->getTeamEvents();
        $this->load->vars($team_data);
        $this->load->view('includes/template');
    }
    
    public function get_squad() 
    {
       redirect($this->input->post('squad_redirect'));
    }
    
    public function getTeamEvents()
    {
        $eventdata = $this->team_m->getTeamEvents();
        
        $this->load->view('team_v', $eventdata);
    }
    
    public function add_player()
    {
        $data = $this->input->post('players'); //this returns an array so use foreach to extract data
            
        foreach($data as $key => $players)
        {
            $this->db->where('user_id', $players);
            $exists = $this->db->get_where('plays_for', array(
                'team_id' => $this->uri->segment(3)) 
                    );
                if($exists->num_rows() === 0)
                {
                    $this->team_m->add_player($players);
                }
                else
                {
                    continue;
                }

        }
        $count = count($data);
        echo json_encode(array(
            "count" => $count     
        ));
    }
    
    public function add_coach()
    {
        $data = $this->input->post('coaches');
        
        foreach ($data as $key => $coaches)
        {
            $this->db->where('user_id', $coaches);
            $exists = $this->db->get_where('is_coach_of', array(
                'team_id'   => $this->uri->segment(3)
                ));
            if($exists->num_rows() === 0)
            {
                $this->team_m->add_coach($coaches);
            }
            else 
            {
                continue;
            }
        }
        $count = count($data);
        echo json_encode(array(
            "count" => $count     
        ));
    }
    
    public function remove_player() 
    {
        $data = $this->input->post('squad'); //this returns an array so use foreach to extract data

        foreach($data as $key => $players)
        {
            $this->team_m->remove_player($players);
        }

        $count = count($data);
        echo json_encode(array(
            "count" => $count
        ));
            
    }
    
    public function remove_coach() 
    {
        $data = $this->input->post('staff'); //this returns an array so use foreach to extract data

        foreach($data as $key => $coaches)
        {
            $this->team_m->remove_coach($coaches);
        }

        $count = count($data);
        echo json_encode(array(
            "count" => $count
        ));
            
    }
    
    public function update_team()
    {
        $this->form_validation->set_rules('teamname', 'Team Name', 'trim|min_length[4]|max_length[50]|xss_clean|required');
        $this->form_validation->set_rules('sport', 'Sport', 'trim|callback_check_default');
        $this->form_validation->set_message('check_default', 'Please choose a sport.');
        $this->form_validation->set_error_delimiters('', '');
        
        if($this->form_validation->run() === FALSE) {
            if($this->input->is_ajax_request()) {
                echo json_encode( 
                array (
                    "teamnameError" =>  form_error('teamname'),
                    "sportError"    =>  form_error('sport')
                ));
            }
            else
            {
                echo 'fuck';
            }
            
        }
        else 
        {
            $count = $this->team_m->update_team();
            echo json_encode(array(
                "count" => $count
            ));
        }
    }
    
    public function check_default($sportstring)
    {
        if ($sportstring === '0')
        {
            return false;
        }
    }
    
    public function delete_team()
    {
        $this->form_validation->set_rules('deletion', 'Delete', 'required|trim');
        $this->form_validation->set_error_delimiters('', '');
        
        if ($this->form_validation->run() === FALSE) 
        {
            echo json_encode(array(
                "deleteError"   => form_error('deletion')
            ));
            
        }
        else //on success
            {
                if ($this->input->post('deletion') === $this->input->post('match')) 
                {
                    $count = $this->team_m->delete_team();
                    echo json_encode(array(
                        "count" => $count
                    ));
                } 
                else 
                {
                    echo json_encode(array(
                       "matchError" => 'Your input did not match team name. Try again.' 
                    ));   
                }
        }
        
    }
    
    public function join_team()
    {
        $data = $this->input->post('teams'); //this returns an array of teams so use foreach to extract data

        foreach( $data as $key => $value)
        {
            $this->db->where('user_id', $value);
            $exists = $this->db->get_where('plays_for', array(
                'team_id'   => $this->uri->segment(3)
                ));
            if($exists->num_rows() === 0)
            {
                $this->team_m->join_team($value);
            }
            else 
            {
                continue;
            }
        }
        
            
        
        $count = count($data);
        
        echo json_encode(array(
           "count"  =>  $count 
        ));
    }
    
    public function leave_team()
    {
        $count = $this->team_m->leave_team();
        
        echo json_encode(array(
            "count" => $count
        ));
    }
    
    public function json()//$team_id='' )
    {
        echo $this->team_m->jsonEvents();
    }
    
    public function add_event()
    {
        $this->form_validation->set_rules('eventname', 'Event Name', 'required|max_length[25]|min_length[3]');
        $this->form_validation->set_rules('eventdesc', 'Event Description', 'max_length[140]');
        $this->form_validation->set_rules('frequency', 'Frequency', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_compareToNow');
        if($this->input->post('frequency') !== 'single') 
        {
            $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_compareDates');
        }
        $this->form_validation->set_rules('start_time', 'Start Time', 'required');
        $this->form_validation->set_rules('end_time', 'End Time', 'required|callback_compareTimes|callback_minDuration');
        $this->form_validation->set_rules('eventlocation', 'Location', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');
        
        if($this->form_validation->run() === FALSE) {

            if($this->input->is_ajax_request()) {
                echo json_encode( 
                array (
                    "times"         => $this->compareTimes(),
                    "nameerror"     =>  form_error('eventname'),
                    "descerror"     =>  form_error('eventdesc'),
                    "freqerror"     =>  form_error('frequency'),
                    "stdateerror"   =>  form_error('start_date'),
                    "enddateerror"  =>  form_error('end_date'),
                    "sttimeerror"   =>  form_error('start_time'),
                    "endtimeerror"  =>  form_error('end_time'),
                    "locerror"      =>  form_error('eventlocation')
                    )
                );
            }
            else
            {
                echo 'fuck';
            }
        }
        
        else { //on success
            $start_date = $this->input->post('start_date');
            //convert to valid MYSQL date format
            $start = date("Y-m-d", strtotime($start_date));
            
            $this->input->post('end_time');
            
            $teamid = $this->uri->segment(3);
            //Insert event information into Events table
            $this->team_m->add_event($teamid);
            
            $eventid = $this->db->insert_id();
            
            if($this->input->post('frequency') === 'single') 
            { 
                $r  = new When();
                $r  ->recur($start, 'daily')
                    ->count(1)
                    ->wkst(1);
                
                while($result = $r->next())
                    {
                        $this->team_m->add_episodes($eventid, $result, $teamid);
                    }
                    
                    $count = count($r);
                    echo json_encode(array(
                        "count" => $count
                    ));
            }
            else 
            {   
                $teamid = $this->uri->segment(3);
                $end_date = $this->input->post('end_date');
                //convert to valid MYSQL date format
                $end = date("Y-m-d", strtotime($end_date));

                    $r  = new When();
                    $r  ->recur($start, $this->input->post('frequency'))
                        ->until($end)
                        ->wkst(1);
                    
                    while($result = $r->next())
                    {
                        $this->team_m->add_episodes($eventid, $result, $teamid);
                    }
                    
                    $count = count($r);
                    echo json_encode(array(
                        "count" => $count
                    ));
            }
        } 
    }
    
    public function compareDates()
    {
        $start = strtotime($this->input->post('start_date'));
        $end = strtotime($this->input->post('end_date'));
        
        if($start > $end)
        {
            $this->form_validation->set_message('compareDates', 'Your end date must be after your start date');
            return false;
        }
        else 
        {
            return true;
        }
    }
    
    public function compareTimes()
    {
        $start = strtotime($this->input->post('start_time'));
        $end = strtotime($this->input->post('end_time'));
        
        if($start > $end)
        {
            $this->form_validation->set_message('compareTimes', 'Your end time must be after your start time');
            
            return false;
        }
        else
        {
            return true;
        } 
    }
    
    public function compareEditedTimes()
    {
        $start = strtotime($this->input->post('edited_start_time'));
        $end = strtotime($this->input->post('edited_end_time'));
        
        if($start > $end)
        {
            $this->form_validation->set_message('compareEditedTimes', 'Your end time must be after your start time');
            
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function compareToNow()
    {
        $tempnow = date('d-m-Y H:i');
        $space = " ";
        //need to make sure $comparison matches $now
        $tempcomparison = $this->input->post('start_date') . $space . $this->input->post('start_time');
        
        $now = strtotime($tempnow);
        $comparison = strtotime($tempcomparison);
        
        if ($now > $comparison)
        {
            $this->form_validation->set_message('compareToNow', 'Your start time must be later than the current time');
            return false;
        }
    }
    
    public function minDuration() {
        $tempStartTime = $this->input->post('start_time');
        $tempEndTime = $this->input->post('end_time');
        $startTime = strtotime($tempStartTime);
        $endTime = strtotime($tempEndTime);
                
        $event_length = 15;
        
        $minimum = strtotime("+$event_length minutes", $startTime);
        
        if ($minimum > $endTime) 
        {
            $this->form_validation->set_message('minDuration', 'Your event must last at least 15 minutes');
            return false;
        }
        
    }
    
    public function edit_event()
    {
        $this->form_validation->set_rules('edited_eventname', 'Event Name', 'required|max_length[25]|min_length[6]');
        $this->form_validation->set_rules('edited_eventdesc', 'Event Description', 'max_length[140]');
        $this->form_validation->set_rules('edited_start_time', 'Start Time', 'required');
        $this->form_validation->set_rules('edited_end_time', 'End Time', 'required|compareEditedTimes');
        $this->form_validation->set_rules('edited_location', 'Location', 'required');
        $this->form_validation->set_error_delimiters('', '');
        
        if($this->form_validation->run() === FALSE) {
            if($this->input->is_ajax_request()) {
                echo json_encode( 
                array (
                    "edit_nameerror"     =>  form_error('edited_eventname'),
                    "edit_descerror"     =>  form_error('edited_eventdesc'),
                    "edit_stTimeError"   =>  form_error('edited_start_time'),
                    "edit_endTimeError"  =>  form_error('edited_end_time'),
                    "edit_locerror"      =>  form_error('edited_location')
                    ));
            }
            else
            {
                echo 'fuck';
            }
            
        }
        else 
        { //on success
            $count = $this->team_m->edit_event();
            
            echo json_encode(array(
                "count" => $count
            ));
        }
        
    }
    
    public function delete_event()
    {
        $this->form_validation->set_rules('events', 'Events', 'required'); 
        $this->form_validation->set_message('required', 'You have to check an event');
        $this->form_validation->set_error_delimiters('', '');
        
        if ($this->form_validation->run() === FALSE) 
        {
            if($this->input->is_ajax_request()) 
            {
                echo json_encode(array(
                   "counterror"  => form_error('events') 
                ));
            }
            else
            {
                echo 'fuck';
            }
            
        }
        else //success
        {
            $data = $this->input->post('events'); //this returns an array so use foreach to extract data

            foreach($data as $key => $events)
            {
                $this->team_m->delete_event($events);
            }

            $count = count($data);
            
            echo json_encode(array(
                "count" =>  $count
            ));
        }   
    }
    
    public function edit_episode()
    {
        $this->form_validation->set_rules('edited_episodeName', 'Episode Name', 'required|max_length[25]|min_length[6]');
        $this->form_validation->set_rules('edited_episodeDesc', 'Episode Description', 'max_length[140]');
        $this->form_validation->set_rules('edited_episodeDate', 'Episode Date', 'required');
        $this->form_validation->set_rules('edited_episodeStartTime', 'Episode Start Time', 'required');
        $this->form_validation->set_rules('edited_episodeEndTime', 'Episode End Time', 'required');
        $this->form_validation->set_rules('edited_episodeLocation', 'Episode Location', 'required');
        $this->form_validation->set_error_delimiters('', '');
        
        if($this->form_validation->run() === FALSE) {
            if($this->input->is_ajax_request()) {
                echo json_encode( 
                array (
                    "episodeNameError"      =>  form_error('edited_episodeName'),
                    "episodeDescError"      =>  form_error('edited_episodeDesc'),
                    "episodeDateError"      =>  form_error('edited_episodeDate'),
                    "episodeStartTimeError" =>  form_error('edited_episodeStartTime'),
                    "episodeEndTimeError"   =>  form_error('edited_episodeEndTime'),
                    "episodeLocationError"  =>  form_error('edited_episodeLocation')
                    )
                );
            }
            else
            {
                echo 'fuck';
            }
            
        }
        else 
        { //on success
            $id = $this->uri->segment(3);
            $edited_date = $this->input->post('edited_episodeDate');
            //convert to valid MYSQL date format
            $date = date("Y-m-d", strtotime($edited_date));
            
            $count = $this->team_m->edit_episode($id, $date);
           
            echo json_encode(array(
                "count" => $count 
            ));
        }   
    }
    
    public function delete_episode()
    {
        $id = $this->input->post('delete_episodeId');
        
        $count = $this->team_m->delete_episode($id);
        
        echo json_encode(array(
            "count" => $count
        ));
    }
    
    public function get_attendance() 
    {
        $epId = $this->input->post('episode_id');
        
        $attending = $this->team_m->get_attending($epId);
        
        //$prewrapping = "<div class='row'>";
        
        if($attending->num_rows() > 0) 
        {
            $attending_output = "<div class='col-xs-12 col-md-4'><table id='attending_table'class='table table-striped table-bordered dataTable'><thead><tr class='tabellheader'><th class='attending' scope='col'><span class='glyphicon glyphicon-thumbs-up'></span>Attending</th></tr></thead><tbody>\n";
            foreach ($attending->result_array() as $row) 
            {
                $attending_output .= "<tr><td class='middle'><div class='username'>{$row['username']}</div></td></tr>\n";
            }
            $attending_output .= "</tbody></table></div>\n";
        }
        else 
        {
            $attending_output = "<div class='col-xs-12 col-md-4'><table id='attending_table' class='table table-striped table-bordered dataTable'><thead><tr class='tabellheader'><th class='attending' scope='col'><span class='glyphicon glyphicon-thumbs-up'></span>Attending</th></tr></thead><tbody>\n";
            $attending_output .= "<tr><td class='middle'><div class='username'>None</div></td></tr>\n";
            $attending_output .= "</tbody></table></div>\n";
        }
        
        $notattending = $this->team_m->get_not_attending($epId);
        
        if($notattending->num_rows() > 0) 
        {
            $notattending_output = "<div class='col-xs-12 col-md-4'><table id='not_attending_table' class='table table-striped table-bordered dataTable'><thead><tr class='tabellheader'><th class='not_attending' scope='col'><span class='glyphicon glyphicon-thumbs-down'></span>Not Attending</th></tr></thead><tbody>\n";
            foreach ($notattending->result_array() as $row) 
            {
                $notattending_output .= "<tr><td class='middle'><div class='username'>{$row['username']}</div></td></tr>\n";
            }
            $notattending_output .= "</tbody></table></div>\n";
        }
        else 
        {
            $notattending_output = "<div class='col-xs-12 col-md-4'><table id='not_attending_table' class='table table-striped table-bordered dataTable'><thead><tr class='tabellheader'><th class='not_attending' scope='col'><span class='glyphicon glyphicon-thumbs-down'></span>Not Attending</th></tr></thead><tbody>\n";
            $notattending_output .= "<tr><td class='middle'><div class='username'>None</div></td></tr>\n";
            $notattending_output .= "</tbody></table></div>\n";
        }
        
        $notresponding = $this->team_m->get_not_responding($epId);
        
        if($notresponding->num_rows() > 0) 
        {
            $notresponding_output = "<div class='col-xs-12 col-md-4'><table id='not_responded_table' class='table table-striped table-bordered dataTable'><thead><tr class='tabellheader'><th class='not_responded' scope='col'><span class='glyphicon glyphicon-question-sign'></span>Has Not Responded</th></tr></thead><tbody>\n";
            foreach ($notresponding->result_array() as $row) 
            {
                $notresponding_output .= "<tr><td class='middle'><div class='username'>{$row['username']}</div></td></tr>\n";
            }
            $notresponding_output .= "</tbody></table></div>\n";
        }
        else 
        {
            $notresponding_output = "<div class='col-xs-12 col-md-4'><table id='not_responded_table' class='table table-striped table-bordered dataTable'><thead><tr class='tabellheader'><th class='not_responded' scope='col'><span class='glyphicon glyphicon-question-sign'></span>Has Not Responded</th></tr></thead><tbody>\n";
            $notresponding_output .= "<tr><td class='middle'><div class='username'>None</div></td></tr>\n";
            $notresponding_output .= "</tbody></table></div>\n";
        }
        
        //$postwrapping = "</div>";
        
        $attendance_result = /*$prewrapping .*/ $attending_output . $notattending_output . $notresponding_output /*. $postwrapping*/; 
        
        echo $attendance_result;
    }
    
    public function set_attendance() 
    {   
        $ep_id = $this->input->post('episode_id');
        $status = $this->input->post('attendance_choice');

        $count= $this->team_m->set_attendance($ep_id, $status);

        echo json_encode(array(
           "count"  =>  $count
        ));
    }
    
    public function get_statistics() 
    {
        $team_id = $this->input->post('team_id');
        $startrange = $this->input->post('startrange');
        $endrange = $this->input->post('endrange');
        
        $statistics = $this->team_m->get_statistics($team_id, $startrange, $endrange);
        
        header('Content-Type: application/json');
        echo json_encode($statistics);
    }
    
    public function archive_attendance()
    {
        $result = $this->team_m->archive_attendance();
    }
    
}