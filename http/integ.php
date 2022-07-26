<?php

class Integ
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function products()
    {
        return new IntegProduct($this->token);
    }

    public function orders()
    {
        return new IntegOrder($this->token);
    }
}