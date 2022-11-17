<?php

namespace App\Service;

class Token
{
    private $token;

    public function __construct($key)
    {
        $this->token = password_hash($key, PASSWORD_DEFAULT);
    }

    public function getToken()
    {
        return $this->token;
    }

    public function isValid($formToken, $key): bool
    {
        // token existe
        if(null == $formToken) {
            return false;
        }

        // token est valide (verify password)
        if(!password_verify($key, $formToken)) {
            return false;
        }

        return true;
    }
}
