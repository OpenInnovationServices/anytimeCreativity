<?php
/**
 * Script Class
 * Handles the script and style functionality of plugin
 *
 * @package Logo Showcase with Slick Slider
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Lswss_Script {

	function __construct() {

		// Action to add style at front side
		add_action( 'wp_enqueue_scripts', array($this, 'lswss_front_style_script') );
		
		// Action to add style in backend
		add_action( 'admin_enqueue_scripts', array($this, 'lswss_admin_style') );
		
		// Action to add script at admin side
		add_action( 'admin_enqueue_scripts', array($this, 'lswss_admin_script') );
	}

	/**
	 * Function to add style and script at front side
	 * 
	 * @since 1.0
	 */
	function lswss_front_style_script() {

		/* Style */
		// Registring Slick Slider CSS
		if( ! wp_style_is( 'slick-style', 'registered' ) ) {
			wp_register_style( 'slick-style', LSWSS_URL.'assets/css/slick.css', array(), LSWSS_VERSION );
		}

		// Registring Public CSS
		wp_register_style( 'lswss-public-css', LSWSS_URL.'assets/css/lswss-public.css', array(), LSWSS_VERSION );

		wp_enqueue_style( 'slick-style' );
		wp_enqueue_style( 'lswss-public-css' );


		/* Script */
		// Registring Slick Slider Script
		if( ! wp_script_is( 'jquery-slick', 'registered' ) ) {
			wp_register_script( 'jquery-slick', LSWSS_URL.'assets/js/slick.min.js', array('jquery'), LSWSS_VERSION, true );
		}

		// Registring Public Script
		wp_register_script( 'lswss-public-script', LSWSS_URL.'assets/js/lswss-public.js', array('jquery'), LSWSS_VERSION, true );
		wp_localize_script( 'lswss-public-script', 'Lswss', array(
																'is_mobile' => ( wp_is_mobile() )	? 1 : 0,
																'is_rtl' 	=> ( is_rtl() )			? 1 : 0,
															));
	}

	/**
	 * Enqueue admin styles
	 * 
	 * @since 1.0
	 */
	function lswss_admin_style( $hook ) {

		global $post_type;

		// If page is plugin post type screen then enqueue script
		if( $post_type == LSWSS_POST_TYPE ) {
			
			// Registring admin script
			wp_register_style( 'lswss-admin-style', LSWSS_URL.'assets/css/lswss-admin.css', null, LSWSS_VERSION );
			wp_enqueue_style( 'lswss-admin-style' );
		}
	}

	/**
	 * Function to add script at admin side
	 *
	 * @since 1.0
	 */
	function lswss_admin_script( $hook ) {
		
		global $post_type;
		
		if( $post_type == LSWSS_POST_TYPE ) {

			// Enqueue required inbuilt sctipt
			wp_enqueue_script( 'jquery-ui-sortable' );

			// Registring admin script
			wp_register_script( 'lswss-admin-script', LSWSS_URL.'assets/js/lswss-admin.js', array('jquery'), LSWSS_VERSION, true );
			wp_localize_script( 'lswss-admin-script', 'WplswssAdmin', array(
																	'img_edit_popup_text'	=> esc_html__('Edit Image in Popup', 'logo-showcase-with-slick-slider'),
																	'attachment_edit_text'	=> esc_html__('Edit Image', 'logo-showcase-with-slick-slider'),
																	'img_delete_text'		=> esc_html__('Remove Image', 'logo-showcase-with-slick-slider'),
																));
			wp_enqueue_script( 'lswss-admin-script' );
			wp_enqueue_media(); // For media uploader
		}
	}
}

$lswss_script = new Lswss_Script();