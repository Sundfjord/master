<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Notification extends MY_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('When');
        $this->load->model('notification_m');
    }
    public function index()
    {
    }
    public function saveNotifications()
    {
        $teamid = 89;
        $count = 5;
    	$return = $this->notification_m->saveNotifications(5, $this->session->userdata('user_id'), $teamid, $count);
        redirect('/');
    }
    public function getNotifications()
    {
    	$user_id = $this->session->userdata('user_id');
        $response = json_encode($this->notification_m->getNotifications($user_id));
        die(var_dump($response));
        return $response;
    }
    public function removeNotifications()
    {
    	// Remove seen notifications older than 7 days
    	// Designed to be run as a daily cronjob
    }
}