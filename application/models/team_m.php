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
    
    public function get_page()
    {
            $id = $this->uri->segment(2);
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
        $this->db->select('id, name, description, location');
        $this->db->from('events');
        $this->db->join('events', 'episodes.event_id = events.id');
        $this->db->join('teams', 'events.team_id = teams.id');
        $this->db->where('team_id', $this->uri->segment(3));
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
        
        return $this->db->affected_rows() > 0;
    }
    
    public function remove_player($players)
    {
        $this->db->delete('plays_for', array(
            'user_id'   =>  $players,
            'team_id'   =>  $this->uri->segment(3)
        ));
        
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
    }
    
    public function jsonEvents()
    {
        $this->db->order_by('event_date', 'desc');
        $this->db->limit(7);
        $this->db->join('events', 'episodes.event_id = events.id');
        $events = $this->db->get('episodes')->result();
        
        $jsonevents = array();
        foreach ($events as $e)
        {
            $jsonevents[] = array(
                'id'            =>  $e->id,
                'event_id'      =>  $e->event_id,
                'name'          =>  $e->name,
                'description'   =>  $e->description,
                'location'      =>  $e->location,
                'start_time'    =>  $e->start_time,
                'end_time'      =>  $e->end_time
            );
        }
        return json_encode($jsonevents);
    }
    
    public function add_event()
    {
        $eventinfo = array(
            'team_id'       =>  $this->uri->segment(3),
            'name'          =>  $this->input->post('eventname'),
            'description'   =>  $this->input->post('eventdesc'),
            'location'      =>  $this->input->post('location')
        );
        
        $this->db->insert('events', $eventinfo);
        
        return $this->db->affected_rows() > 0;
    }
    
    public function add_single_episode($eventid, $start, $start_time, $end_time)
    {
        $datestring = $start->format('Y-m-d');
        $episodeinfo = array(
            'event_date'    => $datestring,
            'event_id'      => $eventid,
            'start_time'    => $start_time,
            'end_time'      => $end_time
                );
        $this->db->insert('episodes', $episodeinfo);
    }
    
    public function add_episodes($eventid, $result, $start_time, $end_time)
    {   
        $datestring = $result->format('Y-m-d');
        $episodesinfo = array(
            'event_date'    => $datestring,
            'event_id'      => $eventid,
            'start_time'    =>  $start_time,
            'end_time'      =>  $end_time
                );
        $this->db->insert('episodes', $episodesinfo); 
    }
    
}