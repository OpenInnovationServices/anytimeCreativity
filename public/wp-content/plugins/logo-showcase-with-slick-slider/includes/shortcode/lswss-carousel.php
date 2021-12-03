<?php
/**
 * 'slick_logo_carousel' Shortcode
 * 
 * @package Logo Showcase with Slick Slider
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function lswss_render_logo_carousel( $atts, $content ) {

	// Taking some globals
	global $post;

	extract(shortcode_atts(array(
		'id' => '',
	), $atts));

	// Taking some variables
	$count			= 0;
	$design         = 'design-1';
	$prefix			= LSWSS_META_PREFIX; // Metabox prefix
	$unique 		= lswss_get_unique();
	$gallery_id 	= ! empty( $id ) ? $id	: '';

	// If no ID is passed then simply return
	if( empty( $gallery_id ) ) {
		return $content;
	}

	$display_type 		= get_post_meta( $id, $prefix.'display_type', true );
	$display_type		= ! empty( $display_type ) ? $display_type : 'slider';

	$show_title 		= get_post_meta( $gallery_id, $prefix.'show_title', true );
	$show_title 		= ($show_title == 'false') ? 'false' : 'true';

	$show_description 	= get_post_meta( $gallery_id, $prefix.'show_description', true );
	$show_description 	= ($show_description == 'true') ? 'true' : 'false';
	
	$new_tab 			= get_post_meta( $gallery_id, $prefix.'new_tab', true );
	$new_tab 			= ($new_tab == 'false') ? 'false' : 'true';	

	$logo_grid			= get_post_meta( $gallery_id, $prefix.'logo_grid', true );
	$logo_grid 			= (!empty($logo_grid)) ? $logo_grid : '4';
	
	$slide_to_show		= get_post_meta( $gallery_id, $prefix.'slide_to_show_carousel', true );
	$slide_to_show 		= (!empty($slide_to_show)) ? $slide_to_show : '3';
	
	$slide_to_column	= get_post_meta( $gallery_id, $prefix.'slide_to_column_carousel', true );
	$slide_to_column	= (!empty($slide_to_column)) ? $slide_to_column : '1';
	
	$arrow				= get_post_meta( $gallery_id, $prefix.'arrow_carousel', true );
	$arrow 				= ($arrow == 'false') ? 'false' : 'true';
	
	$pagination 		= get_post_meta( $gallery_id, $prefix.'pagination_carousel', true );
	$pagination 		= ($pagination == 'false') ? 'false' : 'true';	
	
	$speed 				= get_post_meta( $gallery_id, $prefix.'speed_carousel', true );
	$speed 				= (!empty($speed)) ? $speed : '300';

	$autoplay 			= get_post_meta( $gallery_id, $prefix.'autoplay_carousel', true );
	$autoplay 			= ($autoplay == 'false') ? 'false' : 'true';
	
	$autoplay_speed		= get_post_meta( $gallery_id, $prefix.'autoplay_speed_carousel', true );
	$autoplay_speed 	= (!empty($autoplay_speed)) ? $autoplay_speed : '3000';	

	$loop				= get_post_meta( $gallery_id, $prefix.'loop_carousel', true );
	$loop 				= ($loop == 'true') ? 'true' : 'false';

	$centermode 		= get_post_meta( $gallery_id, $prefix.'centermode_carousel', true );
	$centermode 		= ($centermode == 'true') ? 'true' : 'false';

	$space_between   	= get_post_meta( $gallery_id, $prefix.'space_between_carousel', true );
	$space_between 		= (!empty($space_between)) ? $space_between : '0';
	
	$max_height   		= get_post_meta( $gallery_id, $prefix.'max_height', true );
	$max_height 		= (!empty($max_height)) ? $max_height : '250';
	
	$slide_to_show_ipad	= get_post_meta( $gallery_id, $prefix.'ipad', true );
	$slide_to_show_ipad	= (!empty($slide_to_show_ipad)) ? $slide_to_show_ipad : 3;
	
	$slide_to_show_tablet	= get_post_meta( $gallery_id, $prefix.'tablet', true );
	$slide_to_show_tablet	= (!empty($slide_to_show_tablet)) ? $slide_to_show_tablet : 2;
	
	$slide_to_show_mobile	= get_post_meta( $gallery_id, $prefix.'mobile', true );
	$slide_to_show_mobile	= (!empty($slide_to_show_mobile)) ? $slide_to_show_mobile : 1;

	$res_width_ipad   	= 100/$slide_to_show_ipad;
	$res_width_tablet   = 100/$slide_to_show_tablet;
	$res_width_mobile   = 100/$slide_to_show_mobile;
	
	$center_mode_cls	= ($centermode == 'true') ? 'lswss-center' : '';

	// Slider configuration
	$slider_conf = compact('slide_to_show', 'slide_to_column', 'pagination', 'arrow', 'speed','autoplay','autoplay_speed','space_between','centermode','loop','slide_to_show_ipad','slide_to_show_tablet','slide_to_show_mobile');

	// Layout Path
	$display_file_path 	= LSWSS_DIR . '/templates/' .$display_type .'/'. $design . '.php';
	$display_file 		= (file_exists($display_file_path)) ? $display_file_path : '';

	// Enqueue required script
	if( $display_type == 'slider' ) {
		wp_enqueue_script( 'jquery-slick' );
		wp_enqueue_script( 'lswss-public-script' );
	}

	// Getting gallery images
	$images = get_post_meta($gallery_id, $prefix.'gallery_id', true);

	ob_start();

	if( $images ): ?>
		<style>
			#lswss-logo-carousel-<?php echo $unique; ?> .lswss-slide img{max-height:<?php echo $max_height; ?>px; }
			#lswss-logo-grid-<?php echo $unique; ?> .lswss-grid img{max-height:<?php echo $max_height; ?>px; }
			
			@media only screen and (min-width:641px) and (max-width: 768px) {
				#lswss-logo-grid-<?php echo $unique; ?> .lswss-columns{width:<?php echo $res_width_ipad ;?>%; clear:none;}
				#lswss-logo-grid-<?php echo $unique; ?> .lswss-columns:nth-child(<?php echo $slide_to_show_ipad; ?>n+1){clear:both;}
			}
			@media only screen and (min-width:481px) and (max-width: 640px) {
				#lswss-logo-grid-<?php echo $unique; ?> .lswss-columns{width:<?php echo $res_width_tablet ;?>%; clear:none;}
				#lswss-logo-grid-<?php echo $unique; ?> .lswss-columns:nth-child(<?php echo $slide_to_show_tablet; ?>n+1){clear:both;}
			}
			@media only screen and (max-width:480px) {
				#lswss-logo-grid-<?php echo $unique; ?> .lswss-columns{width:<?php echo $res_width_mobile ;?>%; clear:none;}
				#lswss-logo-grid-<?php echo $unique; ?> .lswss-columns:nth-child(<?php echo $slide_to_show_mobile; ?>n+1){clear:both;}
			}
		</style>

		<div class="lswss-wrap lswss-clearfix">			
			<?php
				// Include shortcode html file
				if( $display_file ) {
					include( $display_file );
				}
			?>
		</div>
	<?php endif;

	$content .= ob_get_clean();
	return $content;
}

// Logo Showcase Shortcode
add_shortcode( 'slick_logo_carousel', 'lswss_render_logo_carousel' );