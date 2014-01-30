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
        $team_data['players'] = $this->team_m->get_players();
        $team_data['eventdata'] = $this->team_m->getTeamEvents();
        $this->load->vars($team_data);
        $this->load->view('includes/template');
    }
    
    public function get_squad() 
    {
        $datas = array(
        'coach'     => $this->tank_auth->is_admin(),
        'result'    => $this->team_m->get_squad()
                );
         
        $this->load->view('team_v', $datas);
    }
    
    public function getTeamEvents()
    {
        $eventdata = $this->team_m->getTeamEvents();
        
        $this->load->view('team_v', $eventdata);
    }
    
    public function add_player()
    {
        $this->form_validation->set_rules('players', 'Players', 'required'); 

        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('fail_v');
        }
        else //success
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
        redirect($this->input->post('redirect'));
        }    
    }
    
    public function remove_player() 
    {
        $this->form_validation->set_rules('squad', 'Squad', 'required'); 

        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('fail_v');
        }
        else //success
        {
            $data = $this->input->post('squad'); //this returns an array so use foreach to extract data
            
            foreach($data as $key => $players)
            {
                $this->team_m->remove_player($players);
            }

        redirect($this->input->post('redirect'));
        }    
    }
    
    public function update_team()
    {
        $this->form_validation->set_rules('teamname', 'Team Name', 'trim|required|min_length[4]|max_length[50]|xss_clean|is_unique[teams.teamname]');
        $this->form_validation->set_rules('sport', 'Sport', 'required');
        
        if ($this->form_validation->run()) 
        {
            $update = $this->team_m->update_team();
            redirect($this->input->post('redirect'));
            return $update;
        }
        else {
            $this->load->view('fail_v');
        }
    }
    
    public function delete_team()
    {
        $this->form_validation->set_rules('delete', 'Delete', 'required|trim');
        
        if ($this->form_validation->run()) 
        {
            if ($this->input->post('delete') === $this->input->post('must_match_teamname')) 
            {
                $deleted = $this->team_m->delete_team();
                redirect('/');
            } 
            else 
            {
                $this->load->view('fail_v');     
            }
        }
        else 
        {
            redirect($this->input->post('redirect'));
        }
    }
    
    public function join_team()
    {
        $data = $this->input->post('team'); //this returns an array of teams so use foreach to extract data

        foreach( $data as $key => $value)
        {
            $this->team_m->join_team($value);
        }
        
        redirect('/');
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
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        if($this->input->post('frequency') !== 'single') 
        {
            $this->form_validation->set_rules('end_date', 'End Date', 'required');
        }
        $this->form_validation->set_rules('start_time', 'Start Time', 'required');
        $this->form_validation->set_rules('end_time', 'End Time', 'required');
        $this->form_validation->set_rules('location', 'Location', 'required');
        
        
        if($this->form_validation->run() === FALSE) {
            $this->load->view('fail_v');
            
        }
        else { //on success
            $start_date = $this->input->post('start_date');
            //convert to valid MYSQL date format
            $start = date("Y-m-d", strtotime($start_date));
            
            $this->input->post('end_time');
            
            //Insert event information into Events table
            $this->team_m->add_event();
            
            $eventid = $this->db->insert_id();
            
            $teamid = $this->uri->segment(3);
            
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
                    
                    redirect('/');
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
                    
                    redirect('/');
            }
        } 
    }
    
    public function edit_event()
    {
        $this->form_validation->set_rules('edited_eventname', 'Event Name', 'required|max_length[25]|min_length[6]');
        $this->form_validation->set_rules('edited_eventdesc', 'Event Description', 'max_length[140]');
        $this->form_validation->set_rules('edited_start_time', 'Start Time', 'required');
        $this->form_validation->set_rules('edited_end_time', 'End Time', 'required');
        $this->form_validation->set_rules('edited_location', 'Location', 'required');
        
        if($this->form_validation->run() === FALSE) {
            $this->load->view('fail_v');
            
        }
        else 
        { //on success
           $this->team_m->edit_event();
        }
        
        redirect('/');
    }
    
    public function delete_event()
    {
        $this->form_validation->set_rules('events', 'Events', 'required'); 

        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('fail_v');
        }
        else //success
        {
            $data = $this->input->post('events'); //this returns an array so use foreach to extract data
            
            foreach($data as $key => $events)
            {
                $this->team_m->delete_event($events);
            }

        redirect('/');
        }   
    }
    
    public function edit_episode()
    {
        $id = $this->input->post('edited_episodeId');
        
        $this->form_validation->set_rules('edited_episodeName', 'Episode Name', 'required|max_length[25]|min_length[6]');
        $this->form_validation->set_rules('edited_episodeDesc', 'Episode Description', 'max_length[140]');
        $this->form_validation->set_rules('edited_episodeDate', 'Episode Date', 'required');
        $this->form_validation->set_rules('edited_episodeStartTime', 'Episode Start Time', 'required');
        $this->form_validation->set_rules('edited_episodeEndTime', 'Episode End Time', 'required');
        $this->form_validation->set_rules('edited_episodeLocation', 'Episode Location', 'required');
        
        if($this->form_validation->run() === FALSE) {
            $this->load->view('fail_v');
            
        }
        else 
        { //on success
            
            $edited_date = $this->input->post('edited_episodeDate');
            //convert to valid MYSQL date format
            $date = date("Y-m-d", strtotime($edited_date));
            
            $this->team_m->edit_episode($id, $date);
           
            redirect('/');
        }   
    }
    
    public function delete_episode()
    {
        $id = $this->input->post('delete_episodeId');
        
        $this->team_m->delete_episode($id);
        
        redirect('/');
    }
    
    public function get_attendance() 
    {
        $epId = $this->input->post('epId');
        
        $attending = $this->team_m->get_attending($epId);
        
        if($attending->num_rows() > 0) 
        {
            $attending_output = "<table id='attending_table'class='table table-striped table-bordered dataTable'><thead><tr class='tabellheader'><th class='attending' scope='col'>Attending</th></tr></thead><tbody>\n";
            foreach ($attending->result_array() as $row) 
            {
                $attending_output .= "<tr><td class='middle'><div class='username'>{$row['username']}</div></td></tr>\n";
            }
            $attending_output .= "</tbody></table>\n";
        }
        else 
        {
            $attending_output = "<table id='attending_table' class='table table-striped table-bordered dataTable'><thead><tr class='tabellheader'><th class='attending' scope='col'>Attending</th></tr></thead><tbody>\n";
            $attending_output .= "<tr><td class='middle'><div class='username'>None</div></td></tr>\n";
            $attending_output .= "</tbody></table>\n";
        }
        
        $notattending = $this->team_m->get_not_attending($epId);
        
        if($notattending->num_rows() > 0) 
        {
            $notattending_output = "<table id='not_attending_table' class='table table-striped table-bordered dataTable'><thead><tr class='tabellheader'><th class='not_attending' scope='col'>Not Attending</th></tr></thead><tbody>\n";
            foreach ($notattending->result_array() as $row) 
            {
                $notattending_output .= "<tr><td class='middle'><div class='username'>{$row['username']}</div></td></tr>\n";
            }
            $notattending_output .= "</tbody></table>\n";
        }
        else 
        {
            $notattending_output = "<table id='not_attending_table' class='table table-striped table-bordered dataTable'><thead><tr class='tabellheader'><th class='not_attending' scope='col'>Not Attending</th></tr></thead><tbody>\n";
            $notattending_output .= "<tr><td class='middle'><div class='username'>None</div></td></tr>\n";
            $notattending_output .= "</tbody></table>\n";
        }
        
        $notresponding = $this->team_m->get_not_responding($epId);
        
        if($notresponding->num_rows() > 0) 
        {
            $notresponding_output = "<table id='not_responded_table' class='table table-striped table-bordered dataTable'><thead><tr class='tabellheader'><th class='not_responded' scope='col'>Has Not Responded</th></tr></thead><tbody>\n";
            foreach ($notresponding->result_array() as $row) 
            {
                $notresponding_output .= "<tr><td class='middle'><div class='username'>{$row['username']}</div></td></tr>\n";
            }
            $notresponding_output .= "</tbody></table>\n";
        }
        else 
        {
            $notresponding_output = "<table id='not_responded_table' class='table table-striped table-bordered dataTable'><thead><tr class='tabellheader'><th class='not_responded' scope='col'>Has Not Responded</th></tr></thead><tbody>\n";
            $notresponding_output .= "<tr><td class='middle'><div class='username'>None</div></td></tr>\n";
            $notresponding_output .= "</tbody></table>\n";
        }
        
        $attendance_result = $attending_output . $notattending_output . $notresponding_output; 
        
        echo $attendance_result;
    }
    
    public function set_attendance() 
    {   
        $this->form_validation->set_rules('attendance_choice', '', 'required|greater_than[0]');
        
        if($this->form_validation->run() === FALSE) 
        {
            $this->load->view('fail_v');
        } 
        
        else 
        {
            $ep_id = $this->input->post('ep-id');
            $status = $this->input->post('attendance_choice');
        
            $this->team_m->set_attendance($ep_id, $status);
        
            redirect('/');
        }
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