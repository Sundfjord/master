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
        $team_data['title'] = 'Team'; //title should be $teamname
        $team_data['main_content'] = 'team_v';
        $team_data['teaminfo'] = $this->team_m->get_page($id);
        $team_data['squad'] = $this->team_m->get_squad();
        $team_data['players'] = $this->team_m->get_players();
        $this->load->vars($team_data);
        $this->load->view('includes/template');
    }
    
    public function get_squad() 
    {
        $datas = array(
        'coach'     => $this->tank_auth->is_admin(),
        'result'    => $this->team_m->get_squad());
         
        $this->load->view('team_v', $datas);
    }
    
    public function add_player()
    {
        $this->form_validation->set_rules('players', 'Players', 'required'); 

        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('fail_v');
        }
        else //success
        {
            $data = $this->input->post('players'); //this returns an array so use foreach to extract data
            
            foreach($data as $key => $players)
            {
                $this->db->where('user_id', $players);
                $exists = $this->db->get('plays_for', $this->uri->segment(3));
                    if($exists->num_rows() === 0)
                    {
                        $this->team_m->add_player($players);
                    }
                    else
                    {
                        continue;
                    }
            }

        redirect($this->input->post('redirect'));
        }    
    }
    
    public function remove_player() 
    {
        $this->form_validation->set_rules('squad', 'Squad', 'required'); 

        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('fail_v');
        }
        else //success
        {
            $data = $this->input->post('squad'); //this returns an array so use foreach to extract data
            
            foreach($data as $key => $players)
            {
                $this->team_m->remove_player($players);
            }

        redirect($this->input->post('redirect'));
        }    
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