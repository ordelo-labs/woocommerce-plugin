<?php


class Integ_AttributeService extends Integ_AbstractAPI {
	public function upsert( array $data ) {
		$response = wp_remote_post(
			sprintf( '%s/woocommerce/attributes', $this->endpoint ),
			[ 'body' => wp_json_encode( $data ), 'headers' => $this->headers ]
		);

		return ! $this->hasResponseError( $response );
	}
}
