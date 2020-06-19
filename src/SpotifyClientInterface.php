<?php

namespace Drupal\cd_spotify_client;

interface SpotifyClientInterface {

  /**
   * Search Spotify catalog for matching artists request
   *
   * @param $query
   *   Query value for spotify search
   * @param $limit
   *   Maximum values to return
   * @return object
   *   \GuzzleHttp\Psr7\Response
   */
  public function searchArtists($query, $limit);

  /**
   * Simple get track request
   *
   * @param $id
   *   Artist ID for Spotify API URI being called.
   * @return object
   *   \GuzzleHttp\Psr7\Response
   */
   public function getArtist($id);

}
