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
}

/* End of file AuthController.php */
