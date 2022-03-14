<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Users extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UsersModel');
        $this->load->library('Helper');
    }

    public function index_get()
    {
        try {
            $this->helper->Authorize();
            $data = $this->UsersModel->GetAll();
            $this->set_response(array(
                'status' => true,
                'message' => 'Success',
                'data' => $data
            ), REST_Controller::HTTP_OK);
            return;
        } catch (\Throwable $th) {
            $this->set_response([
                'status' => FALSE,
                'message' => $th->getMessage()
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
