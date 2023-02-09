<?php


class Integ_CategoryService extends Integ_AbstractAPI
{
    public function upsert(array $data)
    {
        // TODO: receive a list of products categories
        // and send the values to the API.
        $response = wp_remote_post(
            sprintf('%s/categories', $this->endpoint),
            ['body' => json_encode($data), 'headers' => $this->headers]
        );

        return !$this->hasResponseError($response);
    }
}
