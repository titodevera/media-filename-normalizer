<?php

namespace Media_Filename_Normalizer;

defined( 'ABSPATH' ) || exit;

class Settings {

  function __construct() {

    add_action( 'admin_init', [ $this, 'settings_init' ] );

  }

  public function settings_init() {

    register_setting(
      'media',                             // Settings page
      'mfnn-normalize-on-upload',          // Option name
      [ $this, 'sanitize' ]                // sanitize callback function
    );

    add_settings_section(
      'mfnn',                              // Section ID
      __( 'Filenames', 'mfnn' ),           // Section title
      [ $this, 'section_description' ],    // Section callback function
      'media'                              // Settings page
    );

    add_settings_field(
      'ea-google-maps-api-key',             // Field ID
      __( 'Normalize on upload', 'mfnn' ),  // Field title
      [ $this, 'settings_field_callback' ], // Field callback function
      'media',                              // Settings page
      'mfnn'                                // Section ID
    );

  }

  public function sanitize( $input ) {

    return (bool)$input;

  }

  public function section_description() {

    echo '';

  }

  public function settings_field_callback() {

    ob_start();
    ?>

    <label for="mfnn-normalize-on-upload">
      <input id="mfnn-normalize-on-upload" type="checkbox" name="mfnn-normalize-on-upload" <?php checked( get_option( 'mfnn-normalize-on-upload', 1 ), 1 ); ?>>
    </label>

    <?php
    echo ob_get_clean();

  }

}
