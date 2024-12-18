<?php

abstract class Integ_AbstractAPI
{

	/**
	 * Default request headers
	 *
	 * @var array
	 */
	protected $headers = [
		'Content-Type' => 'application/json',
		'Accept' => 'application/json'
	];

	/**
	 * Api Endpoint
	 *
	 * @var string
	 */
	protected $endpoint = 'https://eoljopqu5ec71b1.m.pipedream.net';

	public function __construct($token)
	{
		$this->headers['Authorization'] = "Bearer $token";
	}

	public function hasResponseError($response)
	{
		if (is_wp_error($response) || !is_array($response)) {
			error_log("[integ.app] could not call integ API, error: " . json_encode($response));

			return true;
		}

		if ($response["http_response"]->get_status() !== 200) {
			error_log("[integ.app] integ API returned an error: " . json_encode($response));

			return true;
		}

		return false;
	}
}
