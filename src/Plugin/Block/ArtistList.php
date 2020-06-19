<?php

namespace Drupal\cd_spotify_client\Plugin\Block;

use Drupal\Core\Block\BlockBase;

use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

use Drupal\cd_spotify_client;

/**
 * Provides an 'Artist List' block.
 *
 * @Block(
 *   id = "cd_spotify_client_artist_list",
 *   admin_label = @Translation("Artist List Block"),
 *   category = @Translation("cyberduck")
 * )
 */
class ArtistList extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['artist_query'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Artist search'),
      '#description' => $this->t('Enter the artist query string'),
      '#default_value' => isset($config['artist_list_block_query']) ? $config['artist_list_block_query'] : '',
    ];

    $form['artist_limit'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Maximum artists'),
      '#description' => $this->t('Enter the maxmum number of artists to return'),
      '#default_value' => isset($config['artist_list_block_limit']) ? $config['artist_list_block_limit'] : '',
    ];

    
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {

    parent::blockSubmit($form, $form_state);

    $values = $form_state->getValues();

    $this->configuration['artist_list_block_query'] = $values['artist_query'];
    $this->configuration['artist_list_block_limit'] = $values['artist_limit'];
  }  

  /**
   * {@inheritdoc}
   */
  public function build() {

    $config = $this->getConfiguration();

    if (!empty($config['artist_list_block_query'])) {
      $query = $config['artist_list_block_query'];
      $limit = $config['artist_list_block_limit'];
    } else {
      $query = $this->t('The Foo Fighters');
      $limit = 10;
    }

    $service = \Drupal::service('cd_spotify_client.spotifyclient');

    $response = $service->searchArtists($query, $limit);

    // Could (should?) use template here but for purposes of demo just do it in line.
    $output = "<ul>";

    foreach ($response->artists->items as $artist) {
      $output .= '<li><a href="/spotify/artist/' . $artist->id . '">' . $artist->name . '</a></li>';
    }

    $output .= "</ul>";

    return [
      '#type' => 'inline_template',
      '#template' => $output,
    ];
  }
}
