<?php
/**
 * Plugin generic functions file
 *
 * @package Logo Showcase with Slick Slider
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * 
 * @since 1.0
 */
function lswss_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'lswss_clean', $var );
	} else {
		$data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		return wp_unslash($data);
	}
}

/**
 * Sanitize number value and return fallback value if it is blank
 * 
 * @since 1.0
 */
function lswss_clean_number( $var, $fallback = null, $type = 'int' ) {

	$var = is_numeric( $var ) ? trim( $var ) : 0;

	if( $type == 'int' ) {
		$data = absint( $var );
	} elseif ( $type == 'number' ) {
		$data = intval( $var );
	} else {
		$data = abs( $var );
	}

	return ( empty($data) && isset($fallback) ) ? $fallback : $data;
}

/**
 * Sanitize url
 * 
 * @since 1.0
 */
function lswss_clean_url( $url ) {
	return esc_url_raw( trim( $url ) );
}

/**
 * Allow Valid Html Tags
 * It will sanitize HTML (strip script and style tags)
 *
 * @since 1.0
 */
function lswss_clean_html( $data = array() ) {

	if ( is_array( $data ) ) {

	$data = array_map( 'lswss_clean_html', $data );

	} elseif ( is_string( $data ) ) {
		$data = trim( $data );
		$data = wp_filter_post_kses( $data );
	}

	return $data;
}

/**
 * Function to unique number value
 * 
 * @since 1.0
 */
function lswss_get_unique() {
	static $unique = 0;
	$unique++;

	return $unique;
}

/**
 * Function to add array after specific key
 * 
 * @since 1.0
 */
function lswss_add_array(&$array, $value, $index, $from_last = false) {

	if( is_array($array) && is_array($value) ) {

		if( $from_last ) {
			$total_count	= count($array);
			$index			= ( !empty($total_count) && ($total_count > $index) ) ? ( $total_count-$index ): $index;
		}
		
		$split_arr	= array_splice($array, max(0, $index));
		$array		= array_merge( $array, $value, $split_arr);
	}

	return $array;
}

/**
 * Function to get display type
 * 
 * @since 1.0
 */
function lswss_display_type() {
	$display_type = array(
						'slider'	=> __('Logo Carousel', 'logo-showcase-with-slick-slider'),
						'grid'		=> __('Logo Grid', 'logo-showcase-with-slick-slider'),
					);
	return apply_filters('lswss_display_type', $display_type );
}