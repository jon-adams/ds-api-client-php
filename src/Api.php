<?php

namespace DigitalScout;
use DigitalScout\Clients;

class Api {
	public $apiClient;
	public $log;
	public $mappings;
	public $games;

	function __construct($host, $apiKey) {
		$this->apiClient = new Http\ApiClient($host, $apiKey);
		$this->log = self::getLogger();
		$this->mappings = new Clients\MappingApi($this->apiClient);
		$this->games = new Clients\GamesApi($this->apiClient);
	}

	public function getDigitalScoutId($externalIdKey, $partnerId) {
		return new Models\Map($this->apiClient->get("/map/external/{externalIdKey}/{partnerId}", 
			[ 
				"externalIdKey" => $externalIdKey, 
				"partnerId" => $partnerId 
			]));
	}

	public static function getLogger() {
		if (\Monolog\Registry::hasLogger("DigitalScout")) {
			return \Monolog\Registry::getInstance("DigitalScout");
		} else {
			$log = new \Monolog\Logger('DigitalScout');
			$logLevel = \Monolog\Logger::INFO;
			//$logLevel = \Monolog\Logger::DEBUG;
			$handler = new \Monolog\Handler\StreamHandler('php://stdout', $logLevel);
			$handler->setFormatter(new \DigitalScout\JsonPrettyPrintFormatter());
			$log->pushHandler($handler);
			\Monolog\Registry::addLogger($log);
			return $log;
		}
	}
}

?>