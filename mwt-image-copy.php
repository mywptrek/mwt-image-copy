<?php
/**
 * Plugin Name: MWT Image Copy to Clipboard
 * Description: A plugin that allows users to copy images from the frontend to their clipboard.
 * Version: 1.0.0
 * Author: mywptrek
 * License: GPL2
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Autoload necessary class files.
require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwt-image-copy.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwt-image-copy-settings.php';

/**
 * Initialize the plugin.
 *
 * @return void
 */
function mwt_initialize_image_copy_plugin() {
	MWT_Image_Copy::get_instance();
}
add_action( 'plugins_loaded', 'mwt_initialize_image_copy_plugin' );
