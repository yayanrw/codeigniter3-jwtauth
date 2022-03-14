<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthModel extends CI_Model
{

    public function Auth($data)
    {
        $user = $this->db->select('id, username, email, name')
            ->from('m_users')
            ->where('password', hash('sha256', md5($data['password'])))
            ->group_start()
            ->where('username', $data['user_id'])
            ->or_where('email', $data['user_id'])
            ->group_end()
            ->get()->row();

        if (!empty($user)) {
            return $user;
        } else {
            return false;
        }
    }
}

/* End of file AuthModel.php */
