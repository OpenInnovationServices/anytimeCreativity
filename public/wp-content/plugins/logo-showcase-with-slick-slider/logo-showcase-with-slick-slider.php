<?php
/**
 * Plugin Name: Logo Showcase with Slick Slider
 * Plugin URI: https://premium.infornweb.com
 * Description: Create clients or sponsor's logo Slider, Logo Carousel, Logo Grid for your website or for your clients. Display Logo Showcase with simple shortcode and settings. No Coding Required!
 * Author: InfornWeb
 * Text Domain: logo-showcase-with-slick-slider
 * Domain Path: /languages/
 * Version: 1.2.6
 * Author URI: https://premium.infornweb.com
 *
 * @package WordPress
 * @author InfornWeb
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if( ! defined( 'LSWSS_VERSION' ) ) {
	define( 'LSWSS_VERSION', '1.2.6' ); // Version of plugin
}
if( ! defined( 'LSWSS_DIR' ) ) {
    define( 'LSWSS_DIR', dirname( __FILE__ ) ); // Plugin dir
}
if( ! defined( 'LSWSS_URL' ) ) {
    define( 'LSWSS_URL', plugin_dir_url( __FILE__ ) ); // Plugin url
}
if( ! defined( 'LSWSS_POST_TYPE' ) ) {
    define( 'LSWSS_POST_TYPE', 'lswss_gallery' ); // Plugin post type
}
if( ! defined( 'LSWSS_META_PREFIX' ) ) {
    define( 'LSWSS_META_PREFIX', '_lswss_' ); // Plugin metabox prefix
}

/**
 * Load Text Domain
 * This gets the plugin ready for translation
 * 
 * @since 1.0
 */
function lswss_load_textdomain() {
	load_plugin_textdomain( 'logo-showcase-with-slick-slider', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}
add_action('plugins_loaded', 'lswss_load_textdomain');

/**
 * Activation Hook
 * Register plugin activation hook.
 * 
 * @since 1.0
 */
register_activation_hook( __FILE__, 'lswss_install' );

/**
 * Deactivation Hook
 * Register plugin deactivation hook.
 * 
 * @since 1.0
 */
register_deactivation_hook( __FILE__, 'lswss_uninstall');

/**
 * Plugin Setup (On Activation)
 * 
 * Does the initial setup, set default values for the plugin options.
 *
 * @since 1.0
 */
function lswss_install() {
    
    // Register post type function
    lswss_register_post_type();

    // IMP need to flush rules for custom registered post type
    flush_rewrite_rules();
}

/**
 * Plugin Setup (On Deactivation)
 * 
 * Delete  plugin options.
 * 
 * @since 1.0
 */
function lswss_uninstall() {
    
    // IMP need to flush rules for custom registered post type
    flush_rewrite_rules();
}

// Functions File
require_once( LSWSS_DIR . '/includes/lswss-functions.php' );

// Plugin Post Type File
require_once( LSWSS_DIR . '/includes/lswss-post-types.php' );

// Script File
require_once( LSWSS_DIR . '/includes/class-lswss-script.php' );

// Admin Class File
require_once( LSWSS_DIR . '/includes/admin/class-lswss-admin.php' );

// Shortcode File
require_once( LSWSS_DIR . '/includes/shortcode/lswss-carousel.php' );