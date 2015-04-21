<?php

namespace DigitalScout\Models;

class Error { 
  public $ResponseStatus;

  public function __construct($data = null) {
  	if ($data === null) return;
    $this->ResponseStatus =  new ResponseStatus($data["ResponseStatus"]);
  }
}


