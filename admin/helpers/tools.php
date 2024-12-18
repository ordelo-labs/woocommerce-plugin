<?php

/**
 * Retrieve the product information.
 * 
 * This method will retrieve all product information
 * retrieved by woocommerce rest api.
 * 
 * ! Using the controller to get the product is not ideal.
 * 
 * TODO: Find a way of retrieving product information without using the WC_REST_Products_Controller.
 * 
 * @param WC_Product $wc_product
 * @return WC_Product
 */
function prepare_product_payload( $wc_product )
{
    return (new WC_REST_Products_Controller())
        ->get_item( [
            'id' => $wc_product->get_id(),
            'context' => false
        ] );
}