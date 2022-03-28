<?php

class AUTHORIZATION
{
    public static function validateTimestamp($token)
    {
        $CI = &get_instance();
        $token = self::validateToken($token);
        // if ($token != false && (now() - $token->timestamp < ($CI->config->item('token_timeout') * 60))) {
        if ($token != false && (now() - $token->timestamp < ($token->time_expiration * 60))) {
            return $token;
        }
        return false;
    }

    public static function validateToken($token)
    {
        $CI = &get_instance();
        return JWT::decode($token, $CI->config->item('jwt_key'), $CI->config->item('algorithm'));
    }

    public static function generateToken($data)
    {
        $CI = &get_instance();
        return JWT::encode($data, $CI->config->item('jwt_key'), $CI->config->item('algorithm'));
    }
}
