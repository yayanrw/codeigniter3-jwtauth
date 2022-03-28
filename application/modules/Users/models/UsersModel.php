<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UsersModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Helper');
    }

    public function GetAll()
    {
        return $this->db->get('m_users')->result();
    }

    public function Insert($data, $decodedToken)
    {
        $insert = array(
            'email' => $this->helper->NullSafety($data['email']),
            'username' => $this->helper->NullSafety($data['username']),
            'name' => $this->helper->NullSafety($data['name']),
            'password' => $this->helper->NullSafety(hash('sha256', md5($data['password']))),
            'time_expiration' => $this->helper->NullSafety($data['time_expiration'], 1440),
            'created_by' => $this->helper->NullSafety($decodedToken->username),
        );
        $this->db->insert('m_users', $insert);

        $user = array(
            'email' => $data['email'],
            'username' => $data['username'],
            'name' => $data['name'],
        );

        return $user;
    }
}

/* End of file UsersModel.php */