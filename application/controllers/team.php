<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Team extends MY_Controller
{

    function __construct() {
        
        parent::__construct();
        $this->load->library('form_validation');
    }
    
    public function index()
    {
        $id = $this->uri->segment(2);
        
        $team_data['teaminfo'] = $this->team_m->get_page($id);
        $team_data['title'] = 'Team'; //title should be $teamname
        $team_data['main_content'] = 'team_v';
        $this->load->vars($team_data);
        $this->load->view('includes/template');
    }
    
    public function update_team()
    {
        $this->form_validation->set_rules('teamname', 'Team Name', 'trim|required|min_length[4]|max_length[50]|xss_clean|is_unique[teams.teamname]');
        $this->form_validation->set_rules('sport', 'Sport', 'required');
        
        if ($this->form_validation->run()) 
        {
            $update = $this->team_m->update_team();
            redirect($this->input->post('redirect'));
            return $update;
        }
        else {
            $this->load->view('fail_v');
        }
    }
    
    public function delete_team()
    {
        $this->form_validation->set_rules('delete', 'Delete', 'required|trim');
        
        if ($this->form_validation->run()) 
        {
            
            if ($this->input->post('delete') === $this->input->post('must_match_teamname')) 
            {
                
                $deleted = $this->team_m->delete_team($id);
                redirect('/');
            } 
            else 
            {
                $this->load->view('fail_v');
                
            }
        }
        else 
        {
            redirect($this->input->post('redirect'));
        }
    
    }
}