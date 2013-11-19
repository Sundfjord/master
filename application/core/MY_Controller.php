<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    
    function __construct() {
        
        parent::__construct();
        $this->load->library('tank_auth_groups', '', 'tank_auth');
        $this->load->model('team_m');
        
        if (!$this->tank_auth->is_logged_in()) 
        {
            redirect('/auth/login/');
        }
        
        else 
        {
            $data['username'] = $this->tank_auth->get_username();
            $data['coach'] = $this->tank_auth->is_admin();
            $data['result'] = $this->team_m->get_team_by_coach();
            $data['plr_result'] = $this->team_m->get_team_by_player();
            $this->load->vars($data);
            
        }
    }
    
    public function index()
    {
        
    }
    
    public function create_team() {
        
        $this->form_validation->set_rules('teamname', 'Team Name', 'trim|required|min_length[4]|max_length[50]|xss_clean'); //|is_unique[teams.teamname]
        $this->form_validation->set_rules('sport', 'Sport', 'required');
        
        
        if ($this->form_validation->run() === FALSE) {
            
            $this->index();
        }
        
        else {
            
            $result = $this->team_m->add_team();
            
            if ($result) {
                redirect('/');
                //show success message
            }
        }
    }
    
    public function get_team_by_coach()
    {
        $datas = array(
        'coach'     => $this->tank_auth->is_admin(),
        'result'    => $this->team_m->get_team_by_coach());
         
       $this->load->view('includes/sidebar', $datas);
    }
    
    public function get_team_by_playerS()
    {
        $plr_data = array(
        'coach'     => $this->tank_auth->is_admin(),
        'result'    => $this->team_m->get_team_by_player());
         
       $this->load->view('includes/sidebar', $plr_data);
    }
    
    public function search_team()
    {
        $search_term = $this->input->post('teamname');

        $data['results'] = $this->team_m->search_team($search_term);

        $this->load->view('search_team_v', $data);
    }
}
