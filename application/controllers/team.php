<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Team extends CI_Controller 
{

    function __construct() {
        
        parent::__construct();
       
        $this->load->library('tank_auth_groups', '', 'tank_auth');
    }
    
    function index()
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
}