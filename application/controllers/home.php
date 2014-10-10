<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller 
{

    function __construct() {
        
        parent::__construct();
        $this->load->library('form_validation');
        
    }
    
    function index()
    {
        $home_data['title'] = 'Home';
        $home_data['main_content'] = 'home_v';
        $home_data['teams'] = $this->team_m->get_teams();
        $this->load->vars($home_data);
        $this->load->view('includes/template');
    }

}