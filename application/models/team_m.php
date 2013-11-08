<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Team_m extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function add_team() {
        
        $teamdata = array(
            'teamname'  => $this->input->post('teamname'),
            'sport'     => $this->input->post('sport')
                );
        $this->db->insert('teams', $teamdata);
        
        if ($this->db->affected_rows() === 1) {
            
            $insert_id = $this->db->insert_id();
            $this->db->set('user_id', $this->session->userdata('user_id'));
            $this->db->set('team_id', $insert_id);
            $success = $this->db->insert('is_coach_of');
            return $success;
            
        }
    }
    
    public function search_team($search_term='default')
    {
        // Use the Active Record class for safer queries.
        $this->db->select('teamname, id, sport');
        $this->db->from('teams');
        $this->db->like('teamname', $search_term);

        // Execute the query.
        $query = $this->db->get();

        // Return the results.
        return $query->result_array();
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
    
    public function update_team($new_teamname)
    {
        $data = array (
            'teamname' => $new_teamname);
        $this->db->where('id', $team_id);
        $this->db->update('teams', $data);
        
        
        return $this->db->affected_rows() > 0;
    }
       
        //$this->db->select('id', $this->session->userdata('id'));
        //$this->db->from('users');
        //$this->db->join('teams', 'teams.players = users.id' );
        //$this->db->where('teams', $selected_team);
        //$result = $this->db->get();   

}