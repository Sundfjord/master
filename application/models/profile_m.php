<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_m extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_userdata()
    {
        $this->db->select('username, email, gender');
        $this->db->where('id', $this->session->userdata('user_id'));
        $query = $this->db->get('users');
        
       if($query->num_rows() === 1)
                
                return $query->row();
    }
    
    public function update_profile()
    {
        $data = array(
            'username'  =>  $this->input->post('edit_username'),
            'email'     =>  $this->input->post('edit_email'),
            'gender'    =>  $this->input->post('edit_gender')
        );
        
        $this->db->where('id', $this->session->userdata('user_id'));
        $this->db->update('users', $data);
        
        return $this->db->affected_rows();
    }
    
    
    
}