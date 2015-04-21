<?php
namespace DigitalScout\Clients;
use DigitalScout\Models;

class GamesApi {

  function __construct($apiClient) {
    $this->apiClient = $apiClient;
  }
  
  /**
   * updateGame
   *
   * Update a Game's details
   *
   * @param Game $game The updated game object with id of the game to be updated set to the id property. (required)
   * @return Game
   */
   public function updateGame($game) {
      return new Models\Game($this->apiClient->put("/games/{$game->Id}", (array)$game));          
  }
  
  /**
   * createGame
   *
   * Create Game
   *
   * @param Game $game Game to be created (required)
   * @return Game
   */
  public function createGame($game) {
      return new Models\Game($this->apiClient->post("/games", $game));                
  }
  
  /**
   * getGame
   *
   * Load Game
   *
   * @param string $id asdf (required)
   * @return GameWithScore
   */
  public function getGame($id) {
      return new Models\GameWithScore($this->apiClient->get("/games/{gameId}", ["gameId" => $id]));        
  }
  
  /**
   * updateGameScore
   *
   * Update game with score
   *
   * @param string $id string id of the game you are updating scores for (required)
   * @param GameScores $scoreUpdate object representing a collection of scores (required)
   * @return void
   */
 public function updateGameScore($id, $scoreUpdate) {
      $this->apiClient->put("/games/{$id}/scores", (array)$scoreUpdate);             
  }
  


}
