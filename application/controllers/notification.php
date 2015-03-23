<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Notification extends MY_Controller
{
    function __construct() {
        parent::__construct();
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
        echo $response;
    }
    // Let's see if we can make a function that concatenates notifications, so that
    // instead of one notification per player attending a particular episode,
    // we make one notification saying these three players are going to the event
    public function concatNotifications()
    {

    }
    // Function that marks notification as seen
    public function markNotificationAsRead($id)
    {

    }
    public function removeNotifications()
    {
    	// Remove seen notifications older than 7 days
    	// Designed to be run as a daily cronjob
    }
}