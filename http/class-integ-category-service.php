<?php


class Integ_CategoryService extends Integ_AbstractAPI {
	public function upsert( array $data ) {
		$response = wp_remote_post(
			sprintf( '%s/woocommerce/webhook/categories', $this->endpoint ),
			[ 'body' => json_encode( $data ), 'headers' => $this->headers ]
		);

		return ! $this->hasResponseError( $response );
	}
}
