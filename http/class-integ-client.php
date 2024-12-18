<?php

require 'class-integ-abstract-api.php';
require 'class-integ-abstract-entity.php';
require 'class-integ-product-service.php';
require 'class-integ-order-service.php';


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
}
