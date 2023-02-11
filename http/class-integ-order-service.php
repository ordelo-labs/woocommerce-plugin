<?php

class Integ_OrderService extends Integ_AbstractAPI {
	public function update( $order_id, $data ) {
		$response = wp_remote_post(
			sprintf( '%s/orders/%s', $this->endpoint, $order_id ),
			[ 'body' => json_encode( $data ), 'headers' => $this->headers ]
		);

		return ! $this->hasResponseError( $response );
	}
}