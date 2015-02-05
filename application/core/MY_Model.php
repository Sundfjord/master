<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function add_team() {

        $teamdata = array(
            'teamname'  => $this->input->post('create_teamname'),
            'sport'     => $this->input->post('create_sport')
                );
        $this->db->insert('teams', $teamdata);

        $insertsuccess = $this->db->affected_rows();

        if ($this->db->affected_rows() === 1)
        {
            $insert_id = $this->db->insert_id();
            $this->db->set('user_id', $this->session->userdata('user_id'));
            $this->db->set('team_id', $insert_id);
            $this->db->insert('is_coach_of');

            return $insertsuccess;
        }
    }

    public function coach_leave_team($team_id)
    {
        $this->db->delete('is_coach_of', array(
           'user_id'    => $this->session->userdata('user_id'),
           'team_id'    => $team_id
        ));

        $count = $this->db->affected_rows();

        return $count;
    }

    public function get_team_by_coach()
    {
        $this->db->select('teamname, id');
        $this->db->from('is_coach_of');
        $this->db->join('teams', 'is_coach_of.team_id = teams.id');
        $this->db->where('is_coach_of.user_id', $this->session->userdata('user_id'));
        $this->db->order_by('teamname', 'asc');
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
}
