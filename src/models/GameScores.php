<?php
namespace DigitalScout\Models;

class GameScores extends ApiModel {
  public $Scores; /* array[ParticipantScore] */

  public function __construct($data = null) {
    if ($data === null) return;
    $initializeScores = function ($item) { return new ParticipantScore($item); };
    $this->Scores = array_map($initializeScores, $data["Scores"]);
  }
}


