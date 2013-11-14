<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Team_m extends MY_Model {
    
    function __construct() {
        parent::__construct();
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
    
    public function get_page()
    {
            $id = $this->uri->segment(2);
            $this->db->select('id, teamname, sport');
            $this->db->where('id', $id);
            
            $query = $this->db->get('teams', 1);
            
            if($query->num_rows() === 1)
                
                return $query->row();
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
    
}