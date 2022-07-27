<?php

class Integ_OrderService extends Integ_AbstractAPI
{
    public function update(array $data)
    {
        $response = wp_remote_post(
            sprintf('%s/orders', $this->endpoint),
            ['body' => json_encode($data), 'headers' => $this->headers]
        );

        return !$this->hasResponseError($response);
    }
}