<?php

namespace DigitalScout\Clients;

use DigitalScout\Models;

class MappingApi {

  function __construct($apiClient) {
    $this->apiClient = $apiClient;
  }

  
  /**
   * getPartnerMappings
   *
   * Get partner mappings based on partner type key.
   *
   * @param string $externalIdKey The partner type key (provided by Digital Scout) (required)
   * @return array(Map)
   */
   public function getPartnerMappings($externalIdKey) {
      $mappings = $this->apiClient->get("/map/{externalIdKey}", [ "externalIdKey" => $externalIdKey ]);
      $initializeMapping = function ($mapping) { return new Models\Map($mapping); };
      return array_map($initializeMapping, $mappings);
  }
  
    /**
   * createPartnerMap
   *
   * Creates a partner map
   *
   * @param string $externalIdKey The partner type key (provided by Digital Scout) (required)
   * @param string $partnerId The partner ID (required)
   * @param string $digitalScoutId The Digital Scout resource ID (required)
   */
   public function createPartnerMap($externalIdKey, $partnerId, $digitalScoutId) {
      $this->apiClient->post("/map/{externalIdKey}", [ 
          "externalIdKey" => $externalIdKey ,
          "internalId" => $digitalScoutId,
          "externalId" => $partnerId
        ]);
  }

  /**
   * getDigitalScoutId
   *
   * Get Digital Scout ID from a partner ID
   *
   * @param string $externalIdKey The partner type key (provided by Digital Scout) (required)
   * @param string $partnerId The partner ID (required)
   * @return Map
   */
   public function getDigitalScoutId($externalIdKey, $partnerId) {
      return new Models\Map($this->apiClient->get("/map/external/{externalIdKey}/{partnerId}", 
        [ 
          "externalIdKey" => $externalIdKey, 
          "partnerId" => $partnerId 
        ]));
  }
  
  /**
   * getPartnerId
   *
   * Get partner ID from a Digital Scout ID
   *
   * @param string $externalIdKey The partner type key (provided by Digital Scout) (required)
   * @param string $digitalScoutId The Digital Scout resource ID (required)
   * @return Map
   */
  public function getPartnerId($externalIdKey, $digitalScoutId) {
      return new Models\Map($this->apiClient->get("/map/external/{externalIdKey}/{digitalScoutId}", 
        [ 
          "externalIdKey" => $externalIdKey, 
          "digitalScoutId" => $digitalScoutId 
        ]));      
  }
  


}
