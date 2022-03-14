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
                $tokenData = [
                    'id' => $result->id,
                    'username' => $result->username,
                    'email' => $result->email,
                    'name' => $result->name,
                    'iat' => date('Y-m-d H:i:s'),
                    'exp' => date('Y-m-d H:i:s', strtotime('+1 day'))
                ];
                $token = AUTHORIZATION::generateToken($tokenData);

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
}

/* End of file AuthController.php */
