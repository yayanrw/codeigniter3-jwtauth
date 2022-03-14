<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AuthModel');
    }

    public function Auth()
    {
        try {
            $data = $this->input->post();
            $result = $this->AuthModel->Auth($data);

            if ($result) {
                $jwtConfig = new JwtConfig();
                $jwt = new Jwt();

                $data = [
                    'id' => $result->id,
                    'username' => $result->username,
                    'email' => $result->email,
                    'name' => $result->name,
                    'iat' => date('Y-m-d H:i:s'),
                    'exp' => date('Y-m-d H:i:s', strtotime('+1 day'))
                ];

                $token = $jwt->encode($data, $jwtConfig->getSecretKey(), $jwtConfig->getAlgorithm());

                echo json_encode(array(
                    'status' => true,
                    'message' => 'Login success',
                    'token' => $token
                ));
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => 'Username or password is incorrect'
                ]);
            }
        } catch (\Throwable $th) {
            echo json_encode([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function Token()
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

    public function DecodeToken()
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
