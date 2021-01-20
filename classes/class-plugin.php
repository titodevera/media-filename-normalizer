<?php

namespace Media_Filename_Normalizer;

defined( 'ABSPATH' ) || exit;

final class Plugin {

  private static $instance = null;

  function __construct() {}

  function __clone() {}

  function __wakeup() {}

  public function hooks() {

    add_action( 'plugins_loaded', [ $this, 'i18n' ] );
    add_filter( 'plugin_action_links_' . MFNN_PLUGIN_BASENAME, [ $this, 'add_action_links' ] );

  }

  public function load_deps() {

    //empty

  }

  /**
  * Registers text domain path
  */
  public function i18n() {

    load_plugin_textdomain( 'media-filename-normalizer', false, dirname( plugin_basename( MFNN_PLUGIN_FILE ) ) . '/lang/' );

  }

  public function add_action_links( $links ) {

    $new_link = '<a href="' . esc_url( admin_url( 'options-media.php' ) ) . '">';
    $new_link.= esc_html__( 'Settings' );
    $new_link.= '</a>';
    $links[]  = $new_link;
    return $links;

  }

  public static function get_instance() {

    if ( ! self::$instance instanceof self ) self::$instance = new self();
    return self::$instance;

  }

}
