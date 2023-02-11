<?php

class Integ_ProductService extends Integ_AbstractAPI {
	/**
	 * Create new product integration
	 */
	public function create( $data ) {
		$response = wp_remote_post(
			sprintf( '%s/products', $this->endpoint ),
			[ 'body' => json_encode( $data ), 'headers' => $this->headers ]
		);

		return ! $this->hasResponseError( $response );
	}

	/**
	 * Update product by code
	 *
	 * @param string $product_sku Product SKU
	 * @param array $product_content Product Data
	 */
	public function update( $product_sku, $product_content ) {
		$response = wp_remote_request(
			sprintf( '%s/products/%s', $this->endpoint, $product_sku ),
			[ 'method' => 'PUT', 'body' => json_encode( $product_content ), 'headers' => $this->headers ]
		);

		return ! $this->hasResponseError( $response );
	}

	/**
	 * Delete product by code
	 *
	 * @param string $product_sku Product SKU
	 */
	public function delete( $product_sku ) {
		wp_remote_request(
			sprintf( '%s/products/%s', $this->endpoint, $product_sku ),
			[ 'method' => "DELETE", 'headers' => $this->headers ]
		);
	}

	/**
	 * Disable product by code
	 *
	 * @param string $product_sku Product Code
	 */
	public function disable( $product_sku ) {
		wp_remote_request(
			sprintf( '%s/products/%s', $this->endpoint, $product_sku ),
			[
				'method'  => 'PATCH',
				'body'    => json_encode( [ 'deleted_at' => date( 'd-m-Y h:i:s' ) ] ),
				'headers' => $this->headers
			]
		);
	}
}