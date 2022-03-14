<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Users extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index_get()
    {
        try {
            $headers = $this->input->request_headers();
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                $decodedToken = AUTHORIZATION::validateTimestamp($headers['Authorization']);

                // return response if token is valid
                if ($decodedToken != false) {
                    $data = $this->db->get('m_users')->result();
                    $this->set_response(array(
                        'status' => true,
                        'message' => 'Success',
                        'data' => $data
                    ), REST_Controller::HTTP_OK);
                    return;
                }
            }

            $this->set_response("Unauthorized", REST_Controller::HTTP_UNAUTHORIZED);
        } catch (\Throwable $th) {
            $this->set_response([
                'status' => FALSE,
                'message' => $th->getMessage()
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
