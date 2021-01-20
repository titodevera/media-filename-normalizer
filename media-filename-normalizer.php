<?php
/**
* Plugin Name: Media Filename Normalizer
* Version: 1.0.0
* Author: Alberto de Vera Sevilla
* Author URI: https://albertodevera.es
* Description: Clean image filenames
* Requires at least: 5.3
* Requires PHP: 7.0
*/

namespace Media_Filename_Normalizer;

defined( 'ABSPATH' ) || exit;

define( 'MFNN_PLUGIN', plugins_url( '', __FILE__ ) );
define( 'MFNN_PLUGIN_PATH', __DIR__ );
define( 'MFNN_PLUGIN_FILE', __FILE__ );
define( 'MFNN_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

require_once 'classes/class-plugin.php';
require_once 'classes/class-file-normalizer.php';
$plugin = Plugin::get_instance();
$plugin->load_deps();
$plugin->hooks();

if ( is_admin() ) {

	require_once 'classes/class-admin-settings.php';
	new Settings();

}
