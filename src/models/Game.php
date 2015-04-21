<?php
namespace DigitalScout\Models;

class Game extends ApiModel {
  /**
  * unique identifier for this game, returned during create
  */
  public $Id; /* string */
  /**
  * sport id for the type of game
  */
  public $Sport; /* string */
  /**
  * The ID of the home school
  */
  public $HomeSchoolId; /* string */
  public $Participants; /* array[Participant] */
  /**
  * DateTime of when the game occurs
  */
  public $StartTime; /* DateTime */

  public function __construct($data = null) {
    if ($data === null) return;
    
    $this->Id = isset($data["Id"]) ? $data["Id"] : null;
    $this->Sport = $data["Sport"];
    $this->HomeSchoolId = $data["HomeSchoolId"];

    $initializeParticipant = function ($participantData) { return new Participant($participantData); };
    $this->Participants = array_map($initializeParticipant, $data["Participants"]);

    $this->StartTime = ($data["StartTime"] instanceof \DateTime) ? $data["StartTime"] : new \DateTime($data["StartTime"]);    
  }  
}


