<?php

class JwtConfig
{
    private $secretKey = 'my_secret_key';
    private $algorithm = 'HS256';

    public function getSecretKey()
    {
        return $this->secretKey;
    }

    public function getAlgorithm()
    {
        return $this->algorithm;
    }
}
