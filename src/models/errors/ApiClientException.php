<?php 
	namespace DigitalScout\Models\Errors;

	class ApiClientException extends \Exception
	{		
		function __construct($errorResponse, $clientException = null)
		{
			parent::__construct($errorResponse->ResponseStatus->Message, $errorResponse->ResponseStatus->StatusCode, $clientException);
		}
	}
?>