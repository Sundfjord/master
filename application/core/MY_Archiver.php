<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class MY_Archiver extends CI_Controller

{
    function __construct() {

        parent::__construct();

        $this->load->model('team_m');

    }

    public function index()

    {

    }
}

