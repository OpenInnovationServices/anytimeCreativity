<?php
/**
 * Handles Post Setting metabox HTML
 *
 * @package Logo Showcase with Slick Slider
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$prefix = LSWSS_META_PREFIX; // Metabox prefix

// Carousel Variables
$display_type_list 			= lswss_display_type();
$display_type 				= get_post_meta( $post->ID, $prefix.'display_type', true );
$display_type 				= ! empty( $display_type ) ? $display_type : 'slider';

$logo_grid					= get_post_meta( $post->ID, $prefix.'logo_grid', true );
$slide_to_show_carousel 	= get_post_meta( $post->ID, $prefix.'slide_to_show_carousel', true );
$slide_to_column_carousel 	= get_post_meta( $post->ID, $prefix.'slide_to_column_carousel', true );
$arrow_carousel 			= get_post_meta( $post->ID, $prefix.'arrow_carousel', true );
$pagination_carousel 		= get_post_meta( $post->ID, $prefix.'pagination_carousel', true );

$autoplay_carousel 			= get_post_meta( $post->ID, $prefix.'autoplay_carousel', true );
$autoplay_speed_carousel	= get_post_meta( $post->ID, $prefix.'autoplay_speed_carousel', true );
$loop_carousel 				= get_post_meta( $post->ID, $prefix.'loop_carousel', true );
$speed_carousel 			= get_post_meta( $post->ID, $prefix.'speed_carousel', true );

$centermode_carousel 		= get_post_meta( $post->ID, $prefix.'centermode_carousel', true );
$space_between_carousel 	= get_post_meta( $post->ID, $prefix.'space_between_carousel', true );

$show_title 				= get_post_meta( $post->ID, $prefix.'show_title', true ); 
$max_height 				= get_post_meta( $post->ID, $prefix.'max_height', true );
$show_description 			= get_post_meta( $post->ID, $prefix.'show_description', true );
$new_tab 					= get_post_meta( $post->ID, $prefix.'new_tab', true );
$new_tab 					= ( $new_tab == 'true' ) ? 'true' : 'false';
$show_description 			= ( $show_description == 'true' ) ? 'true' : 'false';

$ipad 						= get_post_meta( $post->ID, $prefix.'ipad', true );
$tablet 					= get_post_meta( $post->ID, $prefix.'tablet', true );
$mobile 					= get_post_meta( $post->ID, $prefix.'mobile', true );

if( $display_type == 'grid' ) {
	$display_slider_setting = 'display:none;';
	$display_grid_setting	= 'display:table;';
} else {
	$display_slider_setting = 'display:table;';
	$display_grid_setting	= 'display:none;';
}
?>

<div class="lswss-mb-tabs-wrp">
	<div id="lswss-sdetails" class="lswss-sdetails lswss-tab-cnt lswss-carousel">

		<table class="form-table lswss-sdetails-tbl">
			<tbody>
				<tr valign="top">
					<td scope="row" colspan="2" class="heading-td">
						<h4><?php _e('Display Type', 'logo-showcase-with-slick-slider') ?></h4>
					</td>
				</tr>
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Select Display Type', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<select name="<?php echo esc_attr( $prefix ); ?>display_type" class="lswss-select-box lswss-display-type" id="lswss-display-type">
							<?php
							if( ! empty( $display_type_list ) ) {
								foreach ($display_type_list as $key => $value) {
									echo '<option value="'.esc_attr( $key ).'" '.selected( $display_type, esc_attr( $key ) ).'>'.esc_html( $value ).'</option>';
								}
							}
							?>
						</select>
						<br />
						<span class="description"><?php _e('Select logo showcase display type.', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Logo Title', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>show_title" value="true" <?php checked( 'true', $show_title ); ?> /><?php _e( 'True', 'logo-showcase-with-slick-slider' ); ?></span>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>show_title" value="false" <?php checked( 'false', $show_title ); ?> /><?php _e( 'False', 'logo-showcase-with-slick-slider' ); ?></span><br/>
						<span class="description"><?php _e('Enable title for each logo.', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Logo Description', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>show_description" value="true" <?php checked( 'true', $show_description ); ?> /><?php _e( 'True', 'logo-showcase-with-slick-slider' ); ?></span>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>show_description" value="false" <?php checked( 'false', $show_description ); ?> /><?php _e( 'False', 'logo-showcase-with-slick-slider' ); ?></span><br/>
						<span class="description"><?php _e('Enable description for each logo.', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Logo Link Behaviour', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>new_tab" value="false" <?php checked( 'false', $new_tab ); ?> /><?php _e( 'Same Tab', 'logo-showcase-with-slick-slider' ); ?></span>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>new_tab" value="true" <?php checked( 'true', $new_tab ); ?> /><?php _e( 'New Tab', 'logo-showcase-with-slick-slider' ); ?></span><br/>
						<span class="description"><?php _e('Open logo link in a new tab or not.', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
			</tbody>
		</table>

		<!-- Grid Settings -->
		<table class="form-table lswss-sdetails-tbl lswss-grid-setting" style="<?php echo esc_attr( $display_grid_setting ); ?>">
			<tbody>
				<tr valign="top">
					<td scope="row" colspan="2" class="heading-td">
						<h4><?php _e('Grid Setting', 'logo-showcase-with-slick-slider') ?></h4>
					</td>
				</tr>
				<!--grid -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Number of Grid', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<input type="text" name="<?php echo esc_attr( $prefix ); ?>logo_grid" value="<?php echo esc_attr( $logo_grid ); ?>" /><br/>
						<span class="description"><?php _e('Display number of logo in a row. e.g. 4', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
			</tbody>
		</table>

		<!-- Slider Settings -->
		<table class="form-table lswss-sdetails-tbl lswss-slider-setting" style="<?php echo esc_attr( $display_slider_setting ); ?>">
			<tbody>
				<tr valign="top">
					<td scope="row" colspan="2" class="heading-td">
						<h4><?php _e('Slider Settings', 'logo-showcase-with-slick-slider') ?></h4>
					</td>
				</tr>
				<!--Slide To Show -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Slide To Show', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<input type="text" name="<?php echo esc_attr( $prefix ); ?>slide_to_show_carousel" value="<?php echo esc_attr( $slide_to_show_carousel ); ?>" /><br/>
						<span class="description"><?php _e('Enter number of logos per view (Logos visible at the same time on slider container).', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>	
				<!--Slide To Scroll -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Slide To Scroll', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<input type="text" name="<?php echo esc_attr( $prefix ); ?>slide_to_column_carousel" value="<?php echo esc_attr( $slide_to_column_carousel ); ?>" /><br/>
						<span class="description"><?php _e('Set numbers of logos to define and enable group sliding.', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- Arrows & Dots Settings -->
		<table class="form-table lswss-sdetails-tbl lswss-slider-setting" style="<?php echo esc_attr( $display_slider_setting ); ?>">
			<tbody>
				<tr valign="top">
					<td scope="row" colspan="2" class="heading-td">
						<h4><?php _e('Arrows & Dots Settings', 'logo-showcase-with-slick-slider') ?></h4>
					</td>
				</tr>
				<!-- Arrows -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Arrows', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>arrow_carousel" value="true" <?php checked( 'true', $arrow_carousel ); ?> /><?php _e( 'True', 'logo-showcase-with-slick-slider' ); ?></span>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>arrow_carousel" value="false" <?php checked( 'false', $arrow_carousel ); ?> /><?php _e( 'False', 'logo-showcase-with-slick-slider' ); ?></span><br/>
						<span class="description"><?php _e('Enable Arrows for logos slider', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
				<!-- Dots -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Dots', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>pagination_carousel" value="true" <?php checked( 'true', $pagination_carousel ); ?> /><?php _e( 'True', 'logo-showcase-with-slick-slider' ); ?></span>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>pagination_carousel" value="false" <?php checked( 'false', $pagination_carousel ); ?> /><?php _e( 'False', 'logo-showcase-with-slick-slider' ); ?></span><br/>
						<span class="description"><?php _e('Display logos paginations', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- Autoplay and Speed Settings -->
		<table class="form-table lswss-sdetails-tbl lswss-slider-setting" style="<?php echo esc_attr( $display_slider_setting ); ?>">
			<tbody>
				<tr valign="top">
					<td scope="row" colspan="2" class="heading-td">
						<h4><?php _e('Autoplay and Speed Settings', 'logo-showcase-with-slick-slider') ?></h4>
					</td>
				</tr>
				<!-- Autoplay -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Autoplay', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>autoplay_carousel" value="true" <?php checked( 'true', $autoplay_carousel ); ?> /><?php _e( 'True', 'logo-showcase-with-slick-slider' ); ?></span>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>autoplay_carousel"  value="false" <?php checked( 'false', $autoplay_carousel ); ?> /><?php _e( 'False', 'logo-showcase-with-slick-slider' ); ?></span><br/>
						<span class="description"><?php _e('Enable Autoplay for Slider', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
				<!-- Autoplay Speed -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Autoplay Speed', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<input type="text" name="<?php echo esc_attr( $prefix ); ?>autoplay_speed_carousel" value="<?php echo esc_attr( $autoplay_speed_carousel ); ?>" /><br/>
						<span class="description"><?php _e('Delay between transitions (in ms). If this parameter is not specified, auto play will be disabled', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
				<!-- Speed -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Speed', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<input type="text" name="<?php echo esc_attr( $prefix ); ?>speed_carousel" value="<?php echo esc_attr( $speed_carousel ); ?>" /><br/>
						<span class="description"><?php _e('Duration of transition between slides (in ms)', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
				<!-- Loop -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Loop', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>loop_carousel" value="true" <?php checked( 'true', $loop_carousel ); ?> /><?php _e( 'True', 'logo-showcase-with-slick-slider' ); ?></span>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>loop_carousel" value="false" <?php checked( 'false', $loop_carousel ); ?> /><?php _e( 'False', 'logo-showcase-with-slick-slider' ); ?></span><br/>
						<span class="description"><?php _e('Set to true to enable continuous loop mode', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- Center Mode -->
		<table class="form-table lswss-sdetails-tbl lswss-slider-setting" style="<?php echo esc_attr( $display_slider_setting ); ?>">
			<tbody>
				<tr valign="top">
					<td scope="row" colspan="2" class="heading-td">
						<h4><?php _e('Center Mode', 'logo-showcase-with-slick-slider') ?></h4>
					</td>
				</tr>
				<!--Center Mode -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Center Mode', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>centermode_carousel" value="true" <?php checked( 'true', $centermode_carousel ); ?> /><?php _e( 'True', 'logo-showcase-with-slick-slider' ); ?></span>
						<span><input type="radio" name="<?php echo esc_attr( $prefix ); ?>centermode_carousel" value="false" <?php checked( 'false', $centermode_carousel ); ?> /><?php _e( 'False', 'logo-showcase-with-slick-slider' ); ?></span><br/>
						<span class="description"><?php _e('If true, then active slide will be centered, not always on the left side.', 'logo-showcase-with-slick-slider'); ?></span>
						<em style="color:red"><?php _e('NOTE: If you are using center mode is "true" then please use "Slide To Show" an ODD number eg 1,3,5,7 for better ouput.', 'logo-showcase-with-slick-slider'); ?></em>
					</td>
				</tr>
				<!--Center Mode Padding -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Center Mode Padding', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<input type="text" name="<?php echo esc_attr( $prefix ); ?>space_between_carousel" value="<?php echo esc_attr( $space_between_carousel ); ?>" /> <?php _e('Px', 'logo-showcase-with-slick-slider'); ?><br/>
						<span class="description"><?php _e('Padding from Left and Right in px if Center Mode is "True".', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
			</tbody>
		</table>

		<!-- Media Height Setting -->
		<table class="form-table lswss-sdetails-tbl lswss-common-setting">
			<tbody>
				<tr valign="top">
					<td scope="row" colspan="2" class="heading-td">
						<h4><?php _e('Media Height Setting', 'logo-showcase-with-slick-slider') ?></h4>
					</td>
				</tr>
				<!--Maximum Width -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Maximum Width', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<em style="font-size:14px;"><?php _e('Maximum Width is added 100% for better output.', 'logo-showcase-with-slick-slider'); ?></em>
					</td>
				</tr>
				<!--Maximum Height -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Maximum Height', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<input type="text"  name="<?php echo esc_attr( $prefix ); ?>max_height" value="<?php echo esc_attr( $max_height ); ?>" /><br/>
						<span class="description"><?php _e('Enter maximum height for logo image. e.g. 200', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
			</tbody>
		</table>

		<!-- Mobile Settings -->
		<table class="form-table lswss-sdetails-tbl lswss-common-setting">
			<tbody> 
				<tr valign="top">
					<td scope="row" colspan="2" class="heading-td">
						<h4><?php _e('Mobile Settings', 'logo-showcase-with-slick-slider') ?></h4>					
					</td>
				</tr>
				<!--iPad -->
				<tr valign="top">
				    <td scope="row">
						<label><?php _e('Logo To Show in iPad', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<input type="text" name="<?php echo esc_attr( $prefix ); ?>ipad" value="<?php echo esc_attr( $ipad ); ?>" /><br/>
						<span class="description"><?php _e('Enter number of logos per view in iPad (Logos visible at the same time on slider container).', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
				<!--Tablet -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Logo To Show in Tablet', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<input type="text" name="<?php echo esc_attr( $prefix ); ?>tablet" value="<?php echo esc_attr( $tablet ); ?>" /><br/>
						<span class="description"><?php _e('Enter number of logos per view in tablet (Logos visible at the same time on slider container).', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
				<!--Mobile -->
				<tr valign="top">
					<td scope="row">
						<label><?php _e('Logo To Show in Mobile', 'logo-showcase-with-slick-slider'); ?></label>
					</td>
					<td>
						<input type="text" name="<?php echo esc_attr( $prefix ); ?>mobile" value="<?php echo esc_attr( $mobile ); ?>" /><br/>
						<span class="description"><?php _e('Enter number of logos per view in Mobile (Logos visible at the same time on slider container).', 'logo-showcase-with-slick-slider'); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>