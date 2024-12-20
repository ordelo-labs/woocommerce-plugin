<?php

class Ordelo_ProductService extends Ordelo_AbstractAPI
{
	/**
	 * Create new product integration
	 */
	public function create($data)
	{
		$response = wp_remote_post(
			sprintf('%s/product', $this->endpoint),
			['body' => wp_json_encode($data), 'headers' => $this->headers]
		);

		return !$this->hasResponseError($response);
	}

	/**
	 * Update product by code
	 *
	 * @param string $product_sku Product SKU
	 * @param array $product_content Product Data
	 */
	public function update($product_sku, $product_content)
	{
		$response = wp_remote_request(
			sprintf('%s/product', $this->endpoint),
			['method' => 'PUT', 'body' => wp_json_encode($product_content), 'headers' => $this->headers]
		);

		return !$this->hasResponseError($response);
	}

	/**
	 * Delete product by code
	 *
	 * @param string $product_sku Product SKU
	 */
	public function delete($product_sku)
	{
		wp_remote_request(
			sprintf('%s/product/%s', $this->endpoint, $product_sku),
			['method' => "DELETE", 'headers' => $this->headers]
		);
	}
}
