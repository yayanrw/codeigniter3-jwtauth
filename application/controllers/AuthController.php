<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class AuthController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AuthModel');
    }

    // Get Token 
    public function index_post()
    {
        try {
            $data = $this->input->post();
            $result = $this->AuthModel->Auth($data);

            if ($result) {
                $this->set_response(array(
                    'status' => true,
                    'message' => 'Login success',
                    'token' => $result
                ), REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Username or password is incorrect'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            echo json_encode([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    // Authorized Access
    public function index_get()
    {
        try {
            $headers = $this->input->request_headers();
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                $decodedToken = AUTHORIZATION::validateTimestamp($headers['Authorization']);

                // return response if token is valid
                if ($decodedToken != false) {
                    $this->set_response($decodedToken, REST_Controller::HTTP_OK);
                    return;
                }
            }

            $this->set_response("Unauthorized", REST_Controller::HTTP_UNAUTHORIZED);
        } catch (\Throwable $th) {
            echo json_encode([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}

/* End of file AuthController.php */
