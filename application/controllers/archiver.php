<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Archiver extends MY_Archiver

{

    function __construct() {
        parent::__construct();
    }

    public function archive_attendance()

    {
		$this->team_m->archive_attendance();
    }

}