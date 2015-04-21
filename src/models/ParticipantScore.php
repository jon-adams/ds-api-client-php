<?php
namespace DigitalScout\Models;

class ParticipantScore extends ApiModel { 
  /**
  * school's identifier
  */
  public $SchoolId; /* string */
  /**
  * value for the score
  */
  public $Score; /* int */
  /**
  * the period of the game the sore is for
  */
  public $Period; /* string */
  /**
  * this flag tells the digital scout system that this is a final score update and shouldn't be put into a period score (in practice this will be associated with a 0 for period.)
  */
  public $IsFinal; /* boolean */

  public function __construct($data = null) {
    if ($data === null) return;
    $this->SchoolId = $data["SchoolId"];
    $this->Score = $data["Score"];
    $this->Period = $data["Period"];
    $this->IsFinal = isset($data["IsFinal"]) ? $data["IsFinal"] : false;
  }
}


