<?php

/**
 * The Ordelo HTTP order resource
 *
 * Defines all resources that can be used to call ordelo order API.
 *
 * @package     Ordelo
 * @subpackage  Ordelo/admin
 * @author      Ordelo <contato@ordelo.com.br>
 */
class Ordelo_OrderService extends Ordelo_AbstractAPI
{
	public function update($order_id, $data)
	{
		$response = wp_remote_request(
			sprintf('%s/orders/%s', $this->endpoint, $order_id),
			['method' => 'PUT', 'body' => json_encode($data), 'headers' => $this->headers]
		);

		return !$this->hasResponseError($response);
	}
}