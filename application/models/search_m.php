<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_m extends MY_Model {
    
    function __construct() {
        parent::__construct();
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
        
    public function get_coaches() 
    {
        // Fetch coaches from database
        $this->db->select('id, username, email');
        $this->db->from('users');
        $this->db->where('group_id', '100');
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

        // Returns coaches
        return $statuser;
    }
    
    public function join_team($value)
    {      
                $this->db->set('user_id', $this->session->userdata('user_id'));
                $this->db->set('team_id', $value);
                $this->db->insert('plays_for');
    }
}