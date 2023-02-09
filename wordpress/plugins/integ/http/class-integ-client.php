<?php

require 'class-integ-abstract-api.php';
require 'class-integ-abstract-entity.php';
require 'class-integ-product-service.php';
require 'class-integ-order-service.php';
require 'class-integ-category-service.php';


class Integ_Client
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function products()
    {
        return new Integ_ProductService($this->token);
    }

    public function orders()
    {
        return new Integ_OrderService($this->token);
    }

    public function categories()
    {
        return new Integ_CategoryService($this->token);
    }

    public function attributes()
    {
        return new Integ_AttributeService($this->token);
    }
}
