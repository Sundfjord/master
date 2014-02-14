<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_Controller 
{

    public function __construct() {
        
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('tank_auth_groups', '', 'tank_auth');
        //$this->load->model('message_m');
        $this->load->library('form_validation');
    }
    
    public function index()
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else 
            {
                $data['title'] = 'My Profile';
                $data['main_content'] = 'profile_v';
                $data['username'] = $this->tank_auth->get_username();
                $data['coach'] = $this->tank_auth->is_admin();
                $this->load->vars($data);
                $this->load->view('includes/template');
            }
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
    
    /*public function custom_change_password()
    {
        $this->form_validation->set_rules('custom_old_password', 'Old Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('custom_new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
        $this->form_validation->set_rules('custom_confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[custom_new_password]');
    
        if($this->form_validation->run() === FALSE) 
        {
            echo validation_errors();
        }
        else 
        { //on success
            if ($this->tank_auth->change_password(
                $this->form_validation->set_value('custom_old_password'),
                $this->form_validation->set_value('custom_new_password')))
            
            {   //success
                $this->_show_message($this->lang->line('auth_message_password_changed'));
            }
            else
            {
                echo json_encode(array(
                    "old_password"  => 'Incorrect password.'
                ));
            }
        }*/
        
        
    }