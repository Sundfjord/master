<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Team extends CI_Controller 
{

    public function __construct() {
        
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('tank_auth_groups', '', 'tank_auth');
        $this->load->model('team_m');
        $this->load->library('form_validation');
    }
    
    public function index()
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {

            $data['title'] = 'Team';
            $data['main_content'] = 'team_v';
            $data['username']	= $this->tank_auth->get_username();
            $data['coach'] = $this->tank_auth->is_admin();
            $this->load->vars($data);
            $this->load->view('includes/template');
        }
    }
    
    public function create_team() {
        
        $this->form_validation->set_rules('teamname', 'Team Name', 'trim|required|min_length[4]|max_length[50]|xss_clean|is_unique[teams.teamname]');
        $this->form_validation->set_rules('sport', 'Sport', 'required|greater_than[0]');
        
        
        if ($this->form_validation->run() === FALSE) {
            
            $this->index();
        }
        
        else {
            
            $result = $this->team_m->add_team();
            
            if ($result) {
                $this->index();
            }
        }
    }
    
    public function search_team()
    {
        $search_term = $this->input->post('teamname');

        $data['results'] = $this->team_m->search_team($search_term);

        $this->load->view('search_team_v',$data);
    }
}
