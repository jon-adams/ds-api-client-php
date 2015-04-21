<?php
namespace DigitalScout\Models;

class School extends ApiModel { 
  /**
  * Unique identifier representing school
  */
  public $Id; /* string */
  /**
  * Name of school
  */
  public $Name; /* string */
  /**
  * 2 Letter State abbreviation for the state the school belongs to.
  */
  public $StateCode; /* string */
  /**
  * State Name
  */
  public $StateName; /* string */
  /**
  * City where the school is located
  */
  public $City; /* string */
  /**
  * Postal code
  */
  public $PostalCode; /* string */
  /**
  * Primary mascot for the school
  */
  public $Mascot; /* string */

  public function __construct($data = null) {
    if ($data === null) return;
    
    $this->Id = $data["Id"];
    $this->Name = $data["Name"];
    $this->StateCode = $data["StateCode"];
    $this->StateName = $data["StateName"];
    $this->City = $data["City"];
    $this->PostalCode = $data["PostalCode"];
    $this->Mascot = $data["Mascot"];
  }
}


