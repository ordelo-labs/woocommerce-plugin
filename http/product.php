<?php

class IntegProduct extends AbstractAPI
{
    /**
     * Create new product integration
     */
    public function create(array $data)
    {
        $response = wp_remote_post(
            sprintf('%s/products', $this->endpoint),
            ['body' => json_encode($data), 'headers' => $this->headers]
        );

        return !$this->hasResponseError($response);
    }

    /**
     * Update product by code
     *
     * @param   string  $id    Product Code
     * @param   array   $data  Product Data
     */
    public function update($id, array $data)
    {
        $response = wp_remote_post(
            sprintf('%s/products/%s', $this->endpoint, $id),
            ['body' => json_encode($data), 'headers' => $this->headers]
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
            sprintf('%s/products/%s', $this->endpoint, $product_sku),
            ['method' => 'DELETE', 'headers' => $this->headers]
        );
    }

    /**
     * Disable product by code
     *
     * @param string $product_sku Product Code
     */
    public function disable($product_sku)
    {
        wp_remote_request(
            sprintf('%s/products/%s', $this->endpoint, $product_sku),
            [
                'method' => 'PATCH',
                'body' => json_encode(['is_active' => false]),
                'headers' => $this->headers
            ]
        );
    }
}