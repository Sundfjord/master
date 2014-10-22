<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_Controller
{

    public function __construct() {

        parent::__construct();
        $this->load->helper('form');
        $this->load->library('tank_auth_groups', '', 'tank_auth');
        //$this->load->model('message_m');
        $this->load->library('form_validation');
        $this->load->model('profile_m');
    }

    public function index()
    {
        $profile_data['title'] = 'My Profile';
        $profile_data['main_content'] = 'profile_v';
        $profile_data['username'] = $this->tank_auth->get_username();
        $profile_data['teams'] = $this->team_m->get_teams();
        $profile_data['coach'] = $this->tank_auth->is_admin();
        $this->load->vars($profile_data);
        $this->load->view('includes/template');

    }

    public function update_profile()
    {
        $this->form_validation->set_rules('edit_username', 'Edit Username', 'trim|required|max_length[30]|min_length[4]');
        $this->form_validation->set_rules('edit_email', 'Edit Email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_error_delimiters('', '');

        if($this->form_validation->run() === FALSE)
        {
            if($this->input->is_ajax_request())
            {
                echo json_encode(
                array (
                    "editUsernameError" =>  form_error('edit_username'),
                    "editEmailError"    =>  form_error('edit_email')
                ));
            }
            else
            {
                echo 'fuck';
            }
        }
        else
        {
            $count = $this->profile_m->update_profile();

            echo json_encode(array(
                "count" => $count
            ));
        }
    }

    public function profile_leave_team()
    {
        $team_id = $this->input->post('team_id');

        $this->db->select('group_id');
        $result = $this->db->get_where('users', array(
            'id' => $this->session->userdata('user_id')
        ));
        $row = $result->row();
        $role = $row->group_id;

        if ($role === '100')
        {
            $count = $this->profile_m->coach_leave_team($team_id);
        }
        else
        {
            $count = $this->team_m->leave_team($team_id);
        }

        echo json_encode(array(
            "count" => $count
        ));
    }

    }