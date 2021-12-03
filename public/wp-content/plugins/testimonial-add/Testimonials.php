<?php
/*
Plugin Name: Testimonial Slider
Description: Create beautiful testimonials, sliders and lists. 
Author: Web-Settler
Plugin URI: http://web-settler.com/testimonials-plugin/
Author URI: http://web-settler.com/testimonials-plugin/
Version: 3.5.8.3
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: http://web-settler.com/testimonials-plugin/
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include 'tss_includes.php';
include 'Ask-Rev.php';

register_activation_hook(__FILE__, 'tss_plugin_activation');
add_action('admin_init', 'tss_plugin_redirect_activation');

function tss_plugin_activation() {
    add_option('tss_plugin_activation_check_option', true);
}

function tss_plugin_redirect_activation() {
if (get_option('tss_plugin_activation_check_option', false)) {
    delete_option('tss_plugin_activation_check_option');
    if(!isset($_GET['activate-multi']))
    {
        wp_redirect("edit.php?post_type=tss_slider&page=tss_slider");
        exit();
    }
 }
}



?>