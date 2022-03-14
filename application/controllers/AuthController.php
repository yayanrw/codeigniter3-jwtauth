<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthController extends CI_Controller
{
    public function index()
    {
        echo 'AuthController';
    }

    public function token()
    {
        $jwt = new JWT();

        $jwtSecretKey = 'my_secret_key';
        $data = array(
            'userId' => 145,
            'email' => 'yayanrw@gmail.com',
            'userType' => 'admin'
        );

        $token = $jwt->encode($data, $jwtSecretKey, 'HS256');
        echo $token;
    }

    public function decode_token()
    {
        $token = $this->uri->segment(3);

        $jwt = new JWT();
        $jwtSecretKey = 'my_secret_key';
        $decoded_token = $jwt->decode($token, $jwtSecretKey, 'HS256');

        $token = $jwt->jsonEncode($decoded_token);
        echo $token;
    }
}

/* End of file AuthController.php */
