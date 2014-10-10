<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    function __construct() {

        parent::__construct();
        $this->load->library('tank_auth_groups', '', 'tank_auth');
        $this->load->model('team_m');
        $this->load->model('profile_m');

        if (!$this->tank_auth->is_logged_in())
        {
            redirect('/auth/login/');
        }

        else
        {
            $data['username'] = $this->tank_auth->get_username();
            $data['userdata'] = $this->profile_m->get_userdata();
            $data['coach'] = $this->tank_auth->is_admin();
            $data['coachteam'] = $this->team_m->get_team_by_coach();
            $data['playerteam'] = $this->team_m->get_team_by_player();
            $this->load->vars($data);
        }
    }

    public function index()
    {

    }

    public function create_team() {

        $this->form_validation->set_rules('create_teamname', 'Team Name', 'trim|required|min_length[4]|max_length[30]|xss_clean'); //|is_unique[teams.teamname]
        $this->form_validation->set_rules('create_sport', 'Sport', 'trim|callback_check_default');
        $this->form_validation->set_message('check_default', 'Please choose a sport');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() === FALSE)
        {
            if($this->input->is_ajax_request())
            {
                echo json_encode(
                array (
                    "createteamnameError" =>  form_error('create_teamname'),
                    "createsportError"    =>  form_error('create_sport')
                ));
            }
            else
            {
                echo 'fuck';
            }
        }
        else
        {
            $count = $this->team_m->add_team();

            echo json_encode(array(
               "count"  => $count
            ));
        }

    }

    public function check_default($sportstring)
    {
        if ($sportstring === '0')
        {
            return false;
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

    public function coach_leave_team()
    {
        $count = $this->profile_m->coach_leave_team($team_id);

        echo json_encode(array(
           "count"  => $count
        ));
    }
}
