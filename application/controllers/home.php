<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
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

            $data['title'] = 'Home';
            $data['main_content'] = 'home_v';
            $data['username']	= $this->tank_auth->get_username();
            $data['coach'] = $this->tank_auth->is_admin();
            $this->load->vars($data);
            $this->load->view('includes/template');
        }
    }
}