<?php

namespace Drupal\cd_spotify_client\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\cd_spotify_client;

class ConfigForm extends ConfigFormBase {

  public function getFormId() {
    return 'cd_spotify_client_settings_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    // Example JSON input used for both APIs
    $defaultParams = "{\r\n" .
    "  \"name\": \"Ian Mc*\"\r\n" .
    "}";
  
    $testParams = $form_state->getValue('test_parameters', $defaultParams);
    $testResponse = $form_state->getValue('test_response', '');

    $form_state->setUserInput(['test_parameters' => $testParams]);
    $form_state->setUserInput(['test_response' => $testResponse]);

    $config = $this->getConfig();

    // Spotify settings
    $form['spotify'] = [
      '#type' => 'details',
      '#title' => $this->t('Spotify client'),
      '#description' => t('Configuration for the Spotify HTTP client service.'),
      '#open' => TRUE
    ];

    $form['spotify']['spotify_client_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Client ID'),
      '#description' => $this->t('Client ID for the Spotify HTTP client service.<br>This value is the client ID from the Spotify Developers portal.'),
      '#size' => 80,
      '#default_value' => $config->get('spotify_client_id'),
      '#attributes' => ['autocomplete' => 'off', 'autocorrect' => 'off', 'autocapitalize' => 'off', 'spellcheck' => 'false'],
    ];

    $form['spotify']['spotify_client_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Client secret'),
      '#description' => $this->t('Client secret for the Spotify HTTP client service.<br>This value is the client secret from the Spotify Developers portal.'),
      '#size' => 80,
      '#default_value' => $config->get('spotify_client_secret'),
      '#attributes' => ['autocomplete' => 'off', 'autocorrect' => 'off', 'autocapitalize' => 'off', 'spellcheck' => 'false'],
    ];

    // API Tests
    $form['tests'] = [
      '#type' => 'details',
      '#title' => $this->t('Test spotify API'),
      '#description' => t('Allows testing of the spotify API.'),
      '#open' => FALSE
    ];

    $form['tests']['test_parameters'] = [
      '#type' => 'textarea',
      '#description' => $this->t('API parameters (JSON).'),
      '#cols' => 80,
      '#rows' => 8,
      '#default_value' => $testParams,
      '#attributes' => ['autocomplete' => 'off', 'autocorrect' => 'off', 'autocapitalize' => 'off', 'spellcheck' => 'false'],
    ];

    $form['tests']['test_response'] = [
      '#type' => 'textarea',
      '#description' => $this->t('API response (JSON).'),
      '#cols' => 80,
      '#rows' => 6,
      '#default_value' => $testResponse,
      '#attributes' => ['autocomplete' => 'off', 'autocorrect' => 'off', 'autocapitalize' => 'off', 'spellcheck' => 'false'],
    ];

    $form['tests']['spotify_test'] = [
      '#type' => 'submit',
      '#value' => $this->t('Test API'),
      '#submit' => array('::testSpotifyAPI'),
      '#validate' => array('::validateSpotifyAPI'),
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    parent::submitForm($form, $form_state);

    drupal_set_message($this->t('The configuration options have been saved.'));
  }

  public function validateSpotifyAPI(array &$form, FormStateInterface &$form_state) {

    $paramsJSON = trim($form_state->getValue('test_parameters', ''));

    if (!empty($paramsJSON)) {

      try {

        $params = json_decode($paramsJSON, true);

      } catch (\Throwable $th) {
        $form_state->setErrorByName('test_parameters', t('Error decoding JSON in API parameters.'));
      }

      if (empty($params)) {
        $form_state->setErrorByName('test_parameters', t('Invalid JSON in API parameters.'));
      }

    } else {
      $form_state->setErrorByName('test_parameters', t('You must enter the API test input parameter values as a JSON array.'));
    }

  }

  // Test the Spotify API
  public function testSpotifyAPI(array &$form, FormStateInterface &$form_state) {

    $service = \Drupal::service('cd_spotify_client.spotifyclient');

    $paramsJSON = trim($form_state->getValue('test_parameters', ''));

    $params = json_decode($paramsJSON, true);

    $response = $service->searchArtists($params['name'], 10);   // Wild cards allowed

    // $response = $service->getArtist($params['id']);   // 6ZNGNJuTnqXYKaIQDEAquH = Ian McNabb
    
    $json = json_encode($response, JSON_PRETTY_PRINT);

    $json = "// {$service->apiProviderName} API response...\r\n" . $json;

    $form_state->setValue('test_response', $json);

    $form_state->setRebuild();
  }
}
