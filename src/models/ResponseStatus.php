<?php
namespace DigitalScout\Models;

class ResponseStatus {
  /**
  * The error code
  */
  public $ErrorCode; /* string */
  /**
  * A description of the error
  */
  public $Message; /* string */
  /**
  * The error stack trace
  */
  public $StackTrace; /* string */

  public $StatusCode; /* int */

  public function __construct($data = null) {
    if ($data == null) return;

    $this->ErrorCode = isset($data["ErrorCode"]) ? $data["ErrorCode"] : null;
    $this->Message = isset($data["Message"]) ? $data["Message"] : null;
    $this->StackTrace = isset($data["StackTrace"]) ? $data["StackTrace"] : null;
    $this->StatusCode = isset($data["StatusCode"]) ? $data["StatusCode"] : null;
  }
}


