<?php
/**
 * Register Post type functionality
 *
 * @package WP Slick Slider and Image Carousel
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Function to register post type
 * 
 * @package WP Slick Slider and Image Carousel
 * @since 1.0.0
 */
function wpsisac_get_slick_post_type() {
    $wpsisac_slider_labels = array(
                                'name'                  => _x( 'Slick Slider', 'wp-slick-slider-and-image-carousel' ),
                                'singular_name'         => _x( 'slick slider', 'wp-slick-slider-and-image-carousel' ),
                                'add_new'               => _x( 'Add Slide', 'wp-slick-slider-and-image-carousel' ),
                                'add_new_item'          => __( 'Add New slide', 'wp-slick-slider-and-image-carousel' ),
                                'edit_item'             => __( 'Edit Slick Slider', 'wp-slick-slider-and-image-carousel' ),
                                'new_item'              => __( 'New Slick Slider', 'wp-slick-slider-and-image-carousel' ),
                                'view_item'             => __( 'View Slick Slider', 'wp-slick-slider-and-image-carousel' ),
                                'search_items'          => __( 'Search Slick Slider', 'wp-slick-slider-and-image-carousel' ),
                                'not_found'             => __( 'No Slick Slider Items found', 'wp-slick-slider-and-image-carousel' ),
                                'not_found_in_trash'    => __( 'No Slick Slider Items found in Trash', 'wp-slick-slider-and-image-carousel' ),
                            	'featured_image' 		=> __( 'Set slider image', 'wp-slick-slider-and-image-carousel' ),
                            	'set_featured_image'	=> __( 'Set slider image' , 'wp-slick-slider-and-image-carousel' ),
                            	'remove_featured_image' => __( 'Remove slider image', 'wp-slick-slider-and-image-carousel' ),
                                '_builtin'              =>  false,
                                'parent_item_colon'     => '',
                            	'menu_name'             => _x( 'Slick Slider', 'admin menu', 'wp-slick-slider-and-image-carousel' )
                            );

  $wpsisac_slider_args = array(
                                'labels'                => $wpsisac_slider_labels,
                                'public'                => false,
                                'show_ui'               => true,
                                'show_in_menu'          => true,
                                'query_var'             => false,
                                'rewrite'               => false,
                                'capability_type'       => 'post',
                                'has_archive'           => false,
                                'hierarchical'          => false,
                            	'exclude_from_search'   => true,
                                'menu_icon'             => 'dashicons-slides',
                                'supports'              => array('title','editor','thumbnail')
                            );
    register_post_type(WPSISAC_POST_TYPE, apply_filters( 'wpsisac_get_post_type_args', $wpsisac_slider_args ));
}

// Action to register plugin post type
add_action('init', 'wpsisac_get_slick_post_type');

/**
 * Function to register taxonomy
 * 
 * @package WP Slick Slider and Image Carousel
 * @since 1.0.0
 */
function wpsisac_get_slick_taxonomy() {
    $labels = array(
                'name'              => _x( 'Category', 'wp-slick-slider-and-image-carousel' ),
                'singular_name'     => _x( 'Category', 'wp-slick-slider-and-image-carousel' ),
                'search_items'      => __( 'Search Category', 'wp-slick-slider-and-image-carousel' ),
                'all_items'         => __( 'All Category', 'wp-slick-slider-and-image-carousel' ),
                'parent_item'       => __( 'Parent Category', 'wp-slick-slider-and-image-carousel' ),
                'parent_item_colon' => __( 'Parent Category' , 'wp-slick-slider-and-image-carousel' ),
                'edit_item'         => __( 'Edit Category', 'wp-slick-slider-and-image-carousel' ),
                'update_item'       => __( 'Update Category', 'wp-slick-slider-and-image-carousel' ),
                'add_new_item'      => __( 'Add New Category', 'wp-slick-slider-and-image-carousel' ),
                'new_item_name'     => __( 'New Category Name', 'wp-slick-slider-and-image-carousel' ),
                'menu_name'         => __( 'Slider Category', 'wp-slick-slider-and-image-carousel' ),
            );

    $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'wpsisac_slider-category' ),
            );
    register_taxonomy( 'wpsisac_slider-category', array( WPSISAC_POST_TYPE ), apply_filters('wpsisac_get_registered_cat_args', $args) );
}

// Action to register plugin taxonomies
add_action( 'init', 'wpsisac_get_slick_taxonomy');