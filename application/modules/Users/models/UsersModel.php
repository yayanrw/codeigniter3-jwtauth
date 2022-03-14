<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UsersModel extends CI_Model
{
    public function GetAll()
    {
        return $this->db->get('m_users')->result();
    }
}

/* End of file UsersModel.php */