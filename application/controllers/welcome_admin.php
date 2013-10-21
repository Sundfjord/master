<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth_groups', '', 'tank_auth');
	}
 
        public function index() {
            
            if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
            } else {
                $this->load->view('welcome_admin_v');
        }
}

}