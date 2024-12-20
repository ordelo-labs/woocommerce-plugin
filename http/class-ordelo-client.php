<?php

require 'class-ordelo-abstract-api.php';
require 'class-ordelo-product-service.php';
require 'class-ordelo-order-service.php';


class Ordelo_Client
{
	private $token;

	public function __construct($token)
	{
		$this->token = $token;
	}

	public function products()
	{
		return new Ordelo_ProductService($this->token);
	}

	public function orders()
	{
		return new Ordelo_OrderService($this->token);
	}
}
