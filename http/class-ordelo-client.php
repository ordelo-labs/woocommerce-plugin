<?php

require_once plugin_dir_path(__FILE__) . 'class-ordelo-abstract-api.php';
require_once plugin_dir_path(__FILE__) . 'class-ordelo-product-service.php';
require_once plugin_dir_path(__FILE__) . 'class-ordelo-order-service.php';


/**
 * The Ordelo HTTP resources.
 *
 * Defines all resources that can be used on Ordelo API.
 *
 * @package    Ordelo
 * @subpackage Ordelo/admin
 * @author     Ordelo <contato@ordelo.com.br>
 */
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
