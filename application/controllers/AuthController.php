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
        $this->load->library('Helper');
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
                    'data' => $result
                ), REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Username or password is incorrect',
                    'data' => null
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } catch (\Throwable $th) {
            $this->set_response([
                'status' => FALSE,
                'message' => $th->getMessage(),
                'data' => null
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Authorized Access
    public function index_get()
    {
        try {
            $decodedToken = $this->helper->Authorize();
            $this->set_response($decodedToken, REST_Controller::HTTP_OK);
            return;
        } catch (\Throwable $th) {
            $this->set_response([
                'status' => FALSE,
                'message' => $th->getMessage()
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

/* End of file AuthController.php */
