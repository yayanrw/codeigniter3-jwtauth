<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Helper extends CI_Model
{
    public function Authorize()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateTimestamp($headers['Authorization']);

            if ($decodedToken == false) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(401);
                echo "Token Expired";
                exit;
            }
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(401);
            echo "Unauthorized";
            exit;
        }
    }
}
