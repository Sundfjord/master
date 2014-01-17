<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Team_m extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function search_team($search_term='default')
    {
        $this->db->select('teamname, id, sport');
        $this->db->from('teams');
        $this->db->like('teamname', $search_term);

        $query = $this->db->get();

        return $query->result_array();
    }
    
    public function get_page($id)
    {
            $this->db->select('id, teamname, sport');
            $this->db->where('id', $id);
            
            $query = $this->db->get('teams', 1);
            
            if($query->num_rows() === 1)
                
                return $query->row();
    }
    
    public function get_teams()
    {
        // Fetch all teams in the database
        $this->db->select('teams.id AS id, 
                           teams.teamname AS teamname, 
                           teams.sport AS sport');
        $this->db->select('users.username AS username');
        $this->db->from('is_coach_of');
        $this->db->join('teams', 'is_coach_of.team_id = teams.id');
        $this->db->join('users', 'is_coach_of.user_id = users.id');
        
        $query = $this->db->get();
        $query->result_array(); 

        // Storing in array
        $statuser = array();
        foreach ($query->result_array() as $team)
        {	
                $statuser[] = array(
                    'id'        =>  $team['id'],
                    'teamname'  =>  $team['teamname'],
                    'sport'     =>  $team['sport'],
                    'coach'     =>  $team['username']
                        );
        }

        // Returns teams
        return $statuser;
    }
    
    public function update_team()
    {
        $data = array (
            'teamname'  => $this->input->post('teamname'),
            'sport'     => $this->input->post('sport'));
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('teams', $data);
        
        
        return $this->db->affected_rows() > 0;
    }
       
    public function delete_team() {
        
        $this->db->where('id', $this->uri->segment(3));
        $this->db->delete('teams');
        
        return true;
    }
    
    public function get_squad()
    {
        $this->db->select('username, id, email');
        $this->db->from('plays_for');
        $this->db->join('users', 'plays_for.user_id = users.id');
        $this->db->where('plays_for.team_id', $this->uri->segment(2));
        $this->db->order_by('username', 'asc');
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $v)
            {
                $data[] = array(
                    'id'        =>  $v['id'],
                    'username'  =>  $v['username'],
                    'email'     =>  $v['email']
                    );
            }
            return $data;
        }
    }
    
    public function getTeamEvents()
    {
        $this->db->select('id, name, description, location, start_time, end_time');
        $this->db->from('events');
        $this->db->where('team_id', $this->uri->segment(2));
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $v)
            {
                $start_time = substr($v['start_time'], 0, -3);
                $end_time = substr($v['end_time'], 0, -3);
                
                $data[] = array(
                    'id'            =>  $v['id'],
                    'name'          =>  $v['name'],
                    'description'   =>  $v['description'],
                    'location'      =>  $v['location'],
                    'start_time'    =>  $start_time,
                    'end_time'      =>  $end_time
                    );
            }
            return $data;
        }
    }
    
    public function get_players()
    {		
        // Fetch players from database
        $this->db->select('id, username, email');
        $this->db->from('users');
        $this->db->where('group_id', '300');
        $this->db->order_by('username asc');
        $query = $this->db->get();
        $query->result_array(); 

        // Store in array
        $statuser = array();
        foreach ($query->result_array() as $v)
        {	
                $statuser[] = array(
                    'id'        =>  $v['id'],
                    'username'  =>  $v['username'],
                    'email'     =>  $v['email']
                    );
        }

        // Returns players
        return $statuser;
    }
    
    public function add_player($players)
    {
        $this->db->set('user_id', $players);
        $this->db->set('team_id', $this->uri->segment(3));
        $this->db->insert('plays_for');
        
        $this->db->select('id');
        $this->db->from('events');
        $this->db->where('team_id', $this->uri->segment(3));
        $eventids = $this->db->get();
        
        $eventarray = array();
        foreach ($eventids->result_array() as $id) 
            {
                $eventarray[] = $id['id'];
            }
        
        $this->db->select('id');
        $this->db->from('episodes');
        $this->db->where_in('event_id', $eventarray);
        $episodes = $this->db->get();

        if ($episodes->num_rows() > 0)

        foreach ($episodes->result_array() as $row) 
            {
                $attendanceinsert = array(
                    'user_id'       =>  $players,
                    'episode_id'    =>  $row['id'],
                    'is_attending'  =>  0
                    );

                    $this->db->insert('attendance_status', $attendanceinsert);
            }

        return $this->db->affected_rows() > 0;
        
     }
   
    public function remove_player($players)
    {
        $this->db->delete('plays_for', array(
            'user_id'   =>  $players,
            'team_id'   =>  $this->uri->segment(3)
        ));
        
        $this->db->select('id');
        $this->db->from('events');
        $this->db->where('team_id', $this->uri->segment(3));
        $eventids = $this->db->get();
        
        $eventarray = array();
        foreach ($eventids->result_array() as $id) 
            {
                $eventarray[] = $id['id'];
            }
        
        $this->db->select('id');
        $this->db->from('episodes');
        $this->db->where_in('event_id', $eventarray);
        $episodes = $this->db->get();
        
        foreach ($episodes->result_array() as $row) 
            {
                $this->db->where('episode_id' , $row['id']);
                $this->db->where('user_id', $players);
                $this->db->delete('attendance_status');
            }
        
        return $this->db->affected_rows() > 0;
    }
    
    public function get_team_by_coach()
    {
        $this->db->select('teamname, id');
        $this->db->from('is_coach_of');
        $this->db->join('teams', 'is_coach_of.team_id = teams.id');
        $this->db->where('is_coach_of.user_id', $this->session->userdata('user_id'));
        $this->db->order_by('teamname', 'asc');
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    
    public function get_team_by_player()
    {
        $this->db->select('teamname, id');
        $this->db->from('plays_for');
        $this->db->join('teams', 'plays_for.team_id = teams.id');
        $this->db->where('plays_for.user_id', $this->session->userdata('user_id'));
        $this->db->order_by('teamname', 'asc');
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    
    public function join_team($value)
    {      
        $this->db->set('user_id', $this->session->userdata('user_id'));
        $this->db->set('team_id', $value);
        $this->db->insert('plays_for');
        
        $this->db->select('id');
        $this->db->from('events');
        $this->db->where('team_id', $value);
        $eventids = $this->db->get();
        
        $eventarray = array();
        foreach ($eventids->result_array() as $id) 
            {
                $eventarray[] = $id['id'];
            }
        
        $this->db->select('id');
        $this->db->from('episodes');
        $this->db->where_in('event_id', $eventarray);
        $episodes = $this->db->get();

        if ($episodes->num_rows() > 0)

        foreach ($episodes->result_array() as $row) 
            {
                $attendanceinsert = array(
                    'user_id'       =>  $this->session->userdata('user_id'),
                    'episode_id'    =>  $row['id'],
                    'is_attending'  =>  0
                    );

                    $this->db->insert('attendance_status', $attendanceinsert);
            }

        return $this->db->affected_rows() > 0;
    }
    
    public function jsonEvents()
    {
        $this->db->select('episodes.id, team_id, event_id, 
                           event_date, name, description, location, start_time, end_time, 
                           altered_name, altered_description, altered_location, altered_start_time, altered_end_time, is_altered,
                           ');
        $this->db->order_by('event_date', 'asc');
        $this->db->join('events', 'episodes.event_id = events.id');
        $events = $this->db->get('episodes');
        
        $jsonevents = array();
        
        foreach ($events->result_array() as $e)
        {
            $nullcheck = $e['is_altered'];
            if($nullcheck === '0')
            {
                $jsonevents[] = array(
                    'id'            =>  $e['id'],
                    'event_id'      =>  $e['event_id'],
                    'team'          =>  $e['team_id'],
                    'start'         =>  $e['event_date'] . " " . $e['start_time'],
                    'date'          =>  $e['event_date'],
                    'title'         =>  $e['name'],
                    'description'   =>  $e['description'],
                    'location'      =>  $e['location'],
                    'start_time'    =>  $e['start_time'],
                    'end_time'      =>  $e['end_time']
                );  
            }
            else
            {
                 $jsonevents[] = array(
                    'id'            =>  $e['id'],
                    'event_id'      =>  $e['event_id'],
                    'team'          =>  $e['team_id'],
                    'start'         =>  $e['event_date'] . " " . $e['altered_start_time'],
                    'date'          =>  $e['event_date'],
                    'title'         =>  $e['altered_name'],
                    'description'   =>  $e['altered_description'],
                    'location'      =>  $e['altered_location'],
                    'start_time'    =>  $e['altered_start_time'],
                    'end_time'      =>  $e['altered_end_time']
                );
            }
        }
        
        return json_encode($jsonevents); 
    }
    
    public function add_event()
    {
        $eventinfo = array(
            'team_id'       =>  $this->uri->segment(3),
            'name'          =>  $this->input->post('eventname'),
            'description'   =>  $this->input->post('eventdesc'),
            'location'      =>  $this->input->post('location'),
            'start_time'    =>  $this->input->post('start_time'),
            'end_time'      =>  $this->input->post('end_time')
        );
        
        $this->db->insert('events', $eventinfo);
        
        return $this->db->affected_rows() > 0;
    }
    
    public function add_single_episode($eventid, $start, $teamid)
    {
        $datestring = $start->format('Y-m-d');
        $episodeinfo = array(
            'event_date'    => $datestring,
            'event_id'      => $eventid,
                );
        $this->db->insert('episodes', $episodeinfo);
        
        $episodeid = $this->db->insert_id();
        
        $this->db->select('user_id')->from('plays_for')->where('team_id',$teamid);
        $eventplayers = $this->db->get();
        
        if ($eventplayers->num_rows() > 0)
        
        foreach ($eventplayers->result_array() as $row) 
            {
                $attendanceinsert = array(
                    'user_id'       =>  $row['user_id'],
                    'episode_id'    =>  $episodeid,
                    'is_attending'  =>  0
                    );
                
                    $this->db->insert('attendance_status', $attendanceinsert);
            }
    }
    
    public function add_episodes($eventid, $result, $teamid)
    {   
        $datestring = $result->format('Y-m-d');
        $episodesinfo = array(
            'event_date'    => $datestring,
            'event_id'      => $eventid,
                );
        $this->db->insert('episodes', $episodesinfo);
        
        $episodeid = $this->db->insert_id();
        
        $this->db->select('user_id')->from('plays_for')->where('team_id',$teamid);
        $eventplayers = $this->db->get();
        
        if ($eventplayers->num_rows() > 0)
        
        foreach ($eventplayers->result_array() as $row) 
            {
                $attendanceinsert = array(
                    'user_id'       =>  $row['user_id'],
                    'episode_id'    =>  $episodeid,
                    'is_attending'  =>  0
                    );
                
                    $this->db->insert('attendance_status', $attendanceinsert);
            }
    }
    
    public function edit_event() //$date should be available
    {
        $updateinfo = array(
            'name'          =>  $this->input->post('edited_eventname'),
            'description'   =>  $this->input->post('edited_eventdesc'),
            'location'      =>  $this->input->post('edited_location'),
            'start_time'    =>  $this->input->post('edited_start_time'),
            'end_time'      =>  $this->input->post('edited_end_time') 
        );
        
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('events', $updateinfo);
    }
    
    public function delete_event($events)
    {
        $this->db->where('id', $events);
        $this->db->delete('events');
        
        return $this->db->affected_rows() > 0;
    }
    
    public function edit_episode($id, $date)
    {
        
        $updateinfo = array(
            'event_date'            =>  $date,
            'altered_name'          =>  $this->input->post('edited_episodeName'),
            'altered_description'   =>  $this->input->post('edited_episodeDesc'),
            'altered_location'      =>  $this->input->post('edited_episodeLocation'),
            'altered_start_time'    =>  $this->input->post('edited_episodeStartTime'),
            'altered_end_time'      =>  $this->input->post('edited_episodeEndTime'),
            'is_altered'            =>  1
        );
        
        $this->db->join('events', 'episodes.event_id = events.id');
        $this->db->where('id', $id);
        $this->db->update('episodes', $updateinfo);

        
    }
    
    public function delete_episode($id) 
    {
        $this->db->where('id', $id);
        $this->db->delete('episodes');
        
        return $this->db->affected_rows() > 0;
    }
    
    public function set_attendance($ep_id, $status)
    {
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->where('episode_id', $ep_id);
        $exists = $this->db->get('attendance_status');
        
        if($exists->num_rows() !== 0) 
        {
            $this->db->set('is_attending', $status);
            $this->db->where('user_id', $this->session->userdata('user_id')); 
            $this->db->where('episode_id', $ep_id); 
            
            $this->db->update('attendance_status');
        
            return $this->db->affected_rows() > 0;
        }
        else
        {
            $info = array(
                'user_id' => $this->session->userdata('user_id'),
                'episode_id' => $ep_id,
                'is_attending'  => $status
                );
            $this->db->insert('attendance_status', $info);
            
            return $this->db->affected_rows() > 0;
        }    
    }
    
    public function get_attending($epId) 
    {
        $this->db->select('username');
        $this->db->where('episode_id', $epId); 
        $this->db->where('is_attending', 1);
        $this->db->join('users', 'attendance_status.user_id = users.id');
        $this->db->join('episodes', 'attendance_status.episode_id = episodes.id');
        $attending = $this->db->get('attendance_status');
        
        return $attending;
    }
    
    public function get_not_attending($epId) 
    {
        $this->db->select('username');
        $this->db->where('episode_id', $epId); 
        $this->db->where('is_attending', 2);
        $this->db->join('users', 'attendance_status.user_id = users.id');
        $this->db->join('episodes', 'attendance_status.episode_id = episodes.id');
        $notattending = $this->db->get('attendance_status');
        
        return $notattending;
    }
    
    public function get_not_responding($epId) 
    {
        $this->db->select('username');
        $this->db->where('episode_id', $epId);
        $this->db->where('is_attending', 0);
        $this->db->join('users', 'attendance_status.user_id = users.id');
        $this->db->join('episodes', 'attendance_status.episode_id = episodes.id');
        $notresponding = $this->db->get('attendance_status');
        
        return $notresponding;
    }
    
}