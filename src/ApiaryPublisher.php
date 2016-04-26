<?php

namespace Mangoweb\ApiaryPublisher;

use RuntimeException;


class ApiaryPublisher
{

	/** @var string */
	private $apiName;

	/** @var string */
	private $apiToken;


	/**
	 * @param string $apiName  e.g. 'pollsapi' for docs.pollsapi.apiary.io
	 * @param string $apiToken see https://login.apiary.io/tokens
	 */
	public function __construct($apiName, $apiToken)
	{
		$this->apiName = $apiName;
		$this->apiToken = $apiToken;
	}


	/**
	 * Publish blueprint to Apiary
	 *
	 * @see    http://docs.apiary.apiary.io/#reference/blueprint/publish-blueprint/publish-blueprint
	 *
	 * @param  string $blueprintCode
	 * @return mixed
	 * @throws RuntimeException
	 */
	public function publish($blueprintCode)
	{
		$rawResponse = @file_get_contents("https://api.apiary.io/blueprint/publish/{$this->apiName}", NULL, stream_context_create([
			'http' => [
				'method' => 'POST',
				'header' => [
					'Content-type: application/json; charset=utf-8',
					"Authentication:Token {$this->apiToken}",
				],
				'content' => json_encode(['code' => $blueprintCode]),
			],
		]));

		if ($rawResponse === FALSE) {
			$detail = error_get_last()['message'];
			throw new RuntimeException("Failed to publish blueprint to Apiary: $detail");
		}

		$response = json_decode($rawResponse);
		if (json_last_error() !== JSON_ERROR_NONE) {
			$detail = json_last_error_msg();
			throw new RuntimeException("Failed to decode Apiary response: $detail");
		}

		return $response;
	}

}
