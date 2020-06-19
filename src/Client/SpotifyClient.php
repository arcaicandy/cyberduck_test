<?php

namespace Drupal\cd_spotify_client\Client;

use Drupal\Core\Config\ConfigFactory;
use Drupal\cd_spotify_client\SpotifyClientInterface;

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyClient implements SpotifyClientInterface {

  public $accessToken;

  /**
   * Constructor.
   */
  public function __construct(ConfigFactory $config_factory) {

    $config = $config_factory->get('cd_spotify_client.settings');

    $session = new Session($config->get('spotify_client_id'), $config->get('spotify_client_secret'));
  
    $session->requestCredentialsToken();

    $this->accessToken = $session->getAccessToken();
  
  }

  /**
   * { @inheritdoc }
   */
  public function searchArtists($name, $limit) {

    try {

      $api = new SpotifyWebAPI();
      $api->setAccessToken($this->accessToken);

      $response = $api->search($name, 'artist', [ 'limit' => $limit]);

    // Would normally do more specific error handling here
    } catch (Exception $e) {

      throw $e;

    }

    return $response;
  }

  /**
   * { @inheritdoc }
   */
  public function getArtist($artistID) {

    try {

      $api = new SpotifyWebAPI();
      $api->setAccessToken($this->accessToken);

      $response = $api->getArtist($artistID);

    // Would normally do more specific error handling here
    } catch (Exception $e) {

      throw $e;

    }

    return $response;
  }
}
