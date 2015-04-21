<?php
namespace DigitalScout\Models;

class GameWithScore extends Game {
  public $Scores; /* array[ParticipantScore] */

  public function __construct($data = null) {
    parent::__construct($data);
    if ($data === null) return;
    
    $initializeScores = function ($item) { return new ParticipantScore($item); };
    $this->Scores = array_map($initializeScores, $data["Scores"]);
  }
}


