<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthModel extends CI_Model
{

    public function Auth($data)
    {
        $user = $this->db->select('id, username, email, name, time_expiration')
            ->from('m_users')
            ->where('password', hash('sha256', md5($data['password'])))
            ->group_start()
            ->where('username', $data['user_id'])
            ->or_where('email', $data['user_id'])
            ->group_end()
            ->get()->row();

        if (!empty($user)) {
            $tokenData = [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'name' => $user->name,
                'timestamp' => now(),
                'time_expiration' => $user->time_expiration,
                'exp' => date('Y-m-d H:i:s', strtotime('+' . $user->time_expiration . ' minutes'))
            ];

            $data = array(
                'username' => $user->username,
                'email' => $user->email,
                'name' => $user->name,
                'exp' => date('Y-m-d H:i:s', strtotime('+' . $user->time_expiration . ' minutes')),
                'token' => AUTHORIZATION::generateToken($tokenData)
            );
            return $data;
        } else {
            return false;
        }
    }
}

/* End of file AuthModel.php */
