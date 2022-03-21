<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Helper
{
    public function Authorize()
    {
        $headers = apache_request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $token = explode(' ', $headers['Authorization']);
            $decodedToken = AUTHORIZATION::validateTimestamp($token[1]);

            if ($decodedToken == false) {
                header("Content-type: application/json; charset=utf-8");
                http_response_code(401);
                echo json_encode(array(
                    'status' => false,
                    'message' => 'Token is invalid'
                ));
                exit;
            }
        } else {
            header("Content-type: application/json; charset=utf-8");
            http_response_code(401);
            echo json_encode(array(
                'status' => false,
                'message' => 'Unauthorized'
            ));
            exit;
        }
    }
}
