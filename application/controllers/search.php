<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller 
{

    public function __construct() {
        
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('tank_auth_groups', '', 'tank_auth');
        $this->load->model('search_m');
        $this->load->library('form_validation');
    }
    
    public function index()
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else 
            {
                //$data['title'] = 'Search';
                $data['main_content'] = 'team_v';
                $data['username'] = $this->tank_auth->get_username();
                $data['coach'] = $this->tank_auth->is_admin();
                $data['teams'] = $this->search_m->get_teams();
		$data['players'] = $this->search_m->get_players();
                //$data['coaches'] = $this->search_m->get_coaches();
                $this->load->vars($data);
                $this->load->view('includes/template');	
            }
    }
    
    public function join_team()
    {
        $data = $this->input->post('team'); //this returns an array so use foreach to extract data

        foreach( $data as $key => $value)
        {
            $this->search_m->join_team($value);
        }
        
        $this->index();
    }

}