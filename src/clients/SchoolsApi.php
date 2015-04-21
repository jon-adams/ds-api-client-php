<?php

namespace DigitalScout\Clients;
use DigitalScout\Models;


class SchoolsApi {

  function __construct($apiClient) {
    $this->apiClient = $apiClient;
  }

  
  /**
   * searchSchools
   *
   * Seach Schools
   *
   * @param string $q Search query term to return school information (required)
   * @return array[School]
   */
   public function searchSchools($q) {
    return $this->apiClient->get("/schools", [ "q" => $q ]);
  }
  


}
