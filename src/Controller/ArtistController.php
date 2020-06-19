<?php

namespace Drupal\cd_spotify_client\Controller;

use Drupal\Core\Controller\ControllerBase;

use Drupal\cd_spotify_client;

/**
 * Provides route responses the Artist information page.
 */
class ArtistController extends ControllerBase {

  /**
   * Returns a page displaying infomation about an Artist.
   *
   * @return array
   *   A simple renderable array.
   */
  public function ArtistInformation($artist_id) {

    $service = \Drupal::service('cd_spotify_client.spotifyclient');

    $artist = $service->getArtist($artist_id);

    // Could just pass the artist to twig but usually prefer to maniplate results into a more specific orm required by the output
    return [
      '#theme'      => 'cd_spotify_artist_information',
      '#id'         => $artist_id,
      '#name'       => $artist->name,
      '#spotifyURL' => $artist->external_urls->spotify,
      '#followers'  => $artist->followers->total,
      '#popularity' => $artist->popularity,
      '#genres'     => implode(', ', $artist->genres),
      '#images'     => $artist->images,
    ];

  }

}