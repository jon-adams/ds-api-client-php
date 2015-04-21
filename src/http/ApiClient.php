<?php

namespace DigitalScout\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use DigitalScout\Models\Errors;

class ApiClient {
	public $host;
	public $apiKey;
	public $apiVersion = "1.2";
	public $client;
	private $log;

	function __construct($host, $apiKey) {
		$this->host = $host;
		$this->apiKey = $apiKey;
		$this->client = new Client();
		$this->log = \DigitalScout\Api::getLogger();
	}

	public function get($path, $params = null) {
		return $this->runRequest("GET", $path, $params);
	}

	public function post($path, $params = null) {
		return $this->runRequest("POST", $path, $params);
	}

	public function put($path, $params = null) {
		return $this->runRequest("PUT", $path, $params);
	}

	public static function toPathValue($value) {
		return rawUrlEncode($value);
	}

	private function runRequest($method, $path, $params = null) {		
		$uri = "http://{$this->host}/v{$this->apiVersion}/partner{$path}";		

		$payload = [
			'headers' => [
				'User-Agent' => 'digitalscout-php-client',
				'Content-Type' => 'application/json',
				'Accept' => 'application/json',
				'X-API-KEY' => $this->apiKey
			]
		];

		$sanitized = $this->sanitizeForSerialization($params);

		if ($params != null) {
			//replace any path params and remove from params array
			foreach ($sanitized as $paramKey => $paramValue) {
				if (is_scalar($paramValue) && stripos($uri, "{" . $paramKey . "}") !== false) {
					$uri = str_ireplace("{" . $paramKey . "}", self::toPathValue($paramValue), $uri);
					unset($sanitized[$paramKey]);
				}	
			}

			if ($method == 'GET') {
				$payload['query'] = $sanitized;
			} else if ($method == 'POST' || $method == 'PUT') {
				$payload['json'] = $sanitized;
			}
		}

		$this->log->addDebug("Making API request", ["method" => $method, "uri" => $uri, "payload" => $payload]);
		try {
			$request = $this->client->createRequest($method, $uri, $payload);

			$response = $this->client->send($request);
			/*$code = $response->getStatusCode();
			$reason = $response->getReasonPhrase();
			$body = $response->getBody();*/
			$json = $response->json();
			return $json;
		} catch (ClientException $e) {
			try {
				$errorResponse = new \DigitalScout\Models\Error($e->getResponse()->json());
				$errorResponse->ResponseStatus->StatusCode = $e->getCode();
			} catch (\Exception $e2) {
				$errorResponse = new \DigitalScout\Models\Error(["ResponseStatus" => [ "StatusCode" => $e->getCode(), "Message" => $e->getMessage()]]);
			}
			if ($errorResponse->ResponseStatus->StatusCode == 401) {
				throw new Errors\UnauthorizedException($errorResponse);
			} else if ($errorResponse->ResponseStatus->StatusCode == 403) {
				throw new Errors\ForbiddenException($errorResponse);				
			} else if ($errorResponse->ResponseStatus->StatusCode == 422) {
				throw new Errors\UnprocessableEntityException($errorResponse);				
			} else if ($errorResponse->ResponseStatus->StatusCode == 404) {
				throw new Errors\NotFoundException($errorResponse);				
			} else {
				throw new Errors\ApiClientException($errorResponse);				
			}
		} catch (ServerException $e) {
			try {
				$errorResponse = new \DigitalScout\Models\Error($e->getResponse()->json());
			} catch (\Exception $e2) {
				$errorResponse = new \DigitalScout\Models\Error(["ResponseStatus" => [ "ErrorCode" => $e->getCode(), "Message" => $e->getMessage()]]);
			}
			throw new Errors\ApiClientException($errorResponse, $e);					
		} catch (\Exception $e) {
			try {
				$errorResponse = new \DigitalScout\Models\Error($e->getResponse()->json());
			} catch (\Exception $e2) {
				$errorResponse = new \DigitalScout\Models\Error(["ResponseStatus" => [ "ErrorCode" => $e->getCode(), "Message" => $e->getMessage()]]);
			}
			throw new Errors\ApiClientException($errorResponse, $e);			
		}
	}

	/**
   * Build a JSON POST object
   */
	protected function sanitizeForSerialization($data) {
		if (is_scalar($data) || null === $data) {
			$sanitized = $data;
		} else if ($data instanceof \DateTime) {
			$sanitized = $data->format(\DateTime::ISO8601);
		} else if (is_array($data)) {
			foreach ($data as $property => $value) {
				$data[$property] = $this->sanitizeForSerialization($value);
			}
			$sanitized = $data;
		} else if (is_object($data)) {
			$values = array();
			foreach ($data as $key => $value) {
				$values[$key] = $this->sanitizeForSerialization($value);
			}
			$sanitized = $values;
		} else {
			$sanitized = (string)$data;
		}

		return $sanitized;
	}
}

?>