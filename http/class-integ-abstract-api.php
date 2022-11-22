<?php

abstract class Integ_AbstractAPI
{
    /**
     * Request headers
     *
     * @var array
     */
    protected $headers;

    /**
     * Api Endpoint
     *
     * @var string
     */
    protected $endpoint = 'https://www.integ.app/api';

    public function __construct($token)
    {
        $this->headers = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json'
        ];
    }

    public function hasResponseError($response)
    {
        if (is_wp_error($response) || !is_array($response)) {
            error_log("[integ.app] could not get integ, error: " . json_encode($response));
            return true;
        }

        if ($response["http_response"]->get_status() !== 200) {
            error_log("[integ.app] could not get integ, error: " . json_encode($response));
            return true;
        }

        return false;
    }
}
