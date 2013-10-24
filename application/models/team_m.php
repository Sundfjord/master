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
            return $teamdata;
        }
    }
    
    public function search_team($search_term='default')
    {
        // Use the Active Record class for safer queries.
        $this->db->select('teamname, sport');
        $this->db->from('teams');
        $this->db->like('teamname',$search_term);

        // Execute the query.
        $query = $this->db->get();

        // Return the results.
        return $query->result_array();
    }
}