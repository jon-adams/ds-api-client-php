<?php
namespace DigitalScout\Models;

class Participant extends ApiModel {
  /**
  * school's identifier
  */
  public $SchoolId; /* string */
  /**
  * Team level (Varsity, JV, etc)
  */
  public $Level; /* string */
  /**
  * Team gender
  */
  public $Gender; /* string */

  public function __construct($data = null) {
    if ($data === null) return;
    $this->SchoolId = $data["SchoolId"];
    $this->Level = $data["Level"];
    $this->Gender = $data["Gender"];
  }
}


