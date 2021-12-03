<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Logo Showcase with Slick Slider
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Lswss_Admin {

	function __construct() {

		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'lswss_post_sett_metabox') );

		// Action to save metabox
		add_action( 'save_post_'.LSWSS_POST_TYPE, array($this, 'lswss_save_metabox_value') );

		// Action to add custom column to Gallery listing
		add_filter( 'manage_'.LSWSS_POST_TYPE.'_posts_columns', array($this, 'lswss_posts_columns') );

		// Action to add custom column data to Gallery listing
		add_action('manage_'.LSWSS_POST_TYPE.'_posts_custom_column', array($this, 'lswss_post_columns_data'), 10, 2);

		// Action to add Attachment Popup HTML
		add_action( 'admin_footer', array($this, 'lswss_image_update_popup_html') );

		// Ajax call to update option
		add_action( 'wp_ajax_lswss_get_attachment_edit_form', array($this, 'lswss_get_attachment_edit_form') );

		// Ajax call to update attachment data
		add_action( 'wp_ajax_lswss_save_attachment_data', array($this, 'lswss_save_attachment_data') );
	}

	/**
	 * Post Settings Metabox
	 * 
	 * @since 1.0
	 */
	function lswss_post_sett_metabox() {	
		add_meta_box( 'lswss-post-sett', __( 'Slick Logo Showcase Images', 'logo-showcase-with-slick-slider' ), array($this, 'lswss_post_sett_mb_content'), LSWSS_POST_TYPE, 'normal', 'high' );		
		add_meta_box( 'lswss-post-slider-sett', __( 'Slick Logo Showcase Parameters', 'logo-showcase-with-slick-slider' ), array($this, 'lswss_post_slider_sett_mb_content'), LSWSS_POST_TYPE, 'normal', 'default' );
		add_meta_box( 'lswss-meta-box-shortcode', __( 'Logo Showcase Shortcode', 'logo-showcase-with-slick-slider' ), array($this, 'lswss_shortcode_display_callback'), LSWSS_POST_TYPE, 'side');		
	}

	/**
	 * Post Settings Metabox HTML
	 * 
	 * @since 1.0
	 */
	function lswss_post_sett_mb_content() {
		include_once( LSWSS_DIR .'/includes/admin/metabox/lswss-sett-metabox.php');
	}

	/**
	 * Post Settings Metabox HTML
	 * 
	 * @since 1.0
	 */
	function lswss_post_slider_sett_mb_content() {
		include_once( LSWSS_DIR .'/includes/admin/metabox/lswss-slider-parameter.php');
	}
	
	/**
	 * Meta box to display shortcode
	 *
	 * @since 1.0
	*/
	function lswss_shortcode_display_callback( $post) {
		echo "<h3>" .__( 'Shortcode', 'logo-showcase-with-slick-slider'). "</h3>";
		echo "<p>" .__( 'To display Logo Showcase, add the following shortcode to your page or post.', 'logo-showcase-with-slick-slider' ). "</p>";
		echo '<div class="lswss-shortcode-preview">[slick_logo_carousel id="'.esc_attr( $post->ID ).'"]</div>';
		echo "<h3>" .__( 'Template Code', 'logo-showcase-with-slick-slider'). "</h3>";
		echo "<p>" .__( 'If adding the Logo Showcase to your theme files, add the following template code.', 'logo-showcase-with-slick-slider' ). "</p>";
		echo '<div class="lswss-shortcode-preview">&lt;?php echo do_shortcode(\'[slick_logo_carousel id="'.esc_attr( $post->ID ).'"]\'); ?&gt;</div>';
	}

	/**
	 * Function to save metabox values
	 * 
	 * @since 1.0
	 */
	function lswss_save_metabox_value( $post_id ) {

		global $post_type;

		$registered_posts = array(LSWSS_POST_TYPE); // Getting registered post types

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                	// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )  	// Check Revision
		|| ( !current_user_can('edit_post', $post_id) )              			// Check if user can edit the post.
		|| ( !in_array($post_type, $registered_posts) ) )             			// Check if user can edit the post.
		{
		  return $post_id;
		}
		
		// Taking variables
		$prefix			= LSWSS_META_PREFIX; // Taking metabox prefix		

		// Getting Carousel Variables
		$gallery_imgs 				= ! empty( $_POST['lswss_img']) 						? array_map('lswss_clean_number', $_POST['lswss_img'])					: '';
		$display_type 				= isset($_POST[$prefix.'display_type']) 				? lswss_clean( $_POST[$prefix.'display_type'] ) 						: '';
		$show_title 				= isset($_POST[$prefix.'show_title']) 					? lswss_clean( $_POST[$prefix.'show_title'] ) 							: 'false';
		$show_description 			= isset($_POST[$prefix.'show_description']) 			? lswss_clean( $_POST[$prefix.'show_description'] ) 					: 'false';
		$new_tab 					= isset($_POST[$prefix.'new_tab']) 						? lswss_clean( $_POST[$prefix.'new_tab'] ) 								: 'false';
		$logo_grid 					= isset($_POST[$prefix.'logo_grid']) 					? lswss_clean_number( $_POST[$prefix.'logo_grid'], 4 ) 					: 4;
		$slide_to_show_carousel 	= isset($_POST[$prefix.'slide_to_show_carousel']) 		? lswss_clean_number( $_POST[$prefix.'slide_to_show_carousel'], 3 ) 	: 3;
		$slide_to_column_carousel 	= isset($_POST[$prefix.'slide_to_column_carousel']) 	? lswss_clean_number( $_POST[$prefix.'slide_to_column_carousel'], 1 ) 	: 1;
		$arrow_carousel 			= isset($_POST[$prefix.'arrow_carousel']) 				? lswss_clean( $_POST[$prefix.'arrow_carousel'] ) 						: 'true';
		$pagination_carousel 		= isset($_POST[$prefix.'pagination_carousel']) 			? lswss_clean( $_POST[$prefix.'pagination_carousel'] ) 					: 'true';
		$autoplay_carousel 			= isset($_POST[$prefix.'autoplay_carousel']) 			? lswss_clean( $_POST[$prefix.'autoplay_carousel'] ) 					: 'false';
		$speed_carousel 			= isset($_POST[$prefix.'speed_carousel']) 				? lswss_clean_number( $_POST[$prefix.'speed_carousel'], 800 ) 			: 800;
		$autoplay_speed_carousel	= isset($_POST[$prefix.'autoplay_speed_carousel']) 		? lswss_clean_number( $_POST[$prefix.'autoplay_speed_carousel'], 3000 ) : 3000;		
		$loop_carousel 				= isset($_POST[$prefix.'loop_carousel']) 				? lswss_clean( $_POST[$prefix.'loop_carousel'] ) 						: 'true';
		$centermode_carousel 		= isset($_POST[$prefix.'centermode_carousel']) 			? lswss_clean( $_POST[$prefix.'centermode_carousel'] ) 					: 'false';
		$space_between_carousel 	= isset($_POST[$prefix.'space_between_carousel']) 		? lswss_clean_number( $_POST[$prefix.'space_between_carousel'] ) 		: 0;
		$max_height 				= isset($_POST[$prefix.'max_height']) 					? lswss_clean_number( $_POST[$prefix.'max_height'], 250 ) 				: 250;
		$slide_to_show_ipad 		= isset($_POST[$prefix.'ipad']) 						? lswss_clean_number( $_POST[$prefix.'ipad'], 3 ) 						: 3;
		$slide_to_show_tablet 		= isset($_POST[$prefix.'tablet']) 						? lswss_clean_number( $_POST[$prefix.'tablet'], 2 ) 					: 2;
		$slide_to_show_mobile 		= isset($_POST[$prefix.'mobile']) 						? lswss_clean_number( $_POST[$prefix.'mobile'], 1 ) 					: 1;

		// Style option update		
		update_post_meta($post_id, $prefix.'gallery_id', $gallery_imgs);		

		// Updating Carousel settings  
		update_post_meta($post_id, $prefix.'display_type', $display_type);
		update_post_meta($post_id, $prefix.'show_title', $show_title);
		update_post_meta($post_id, $prefix.'show_description', $show_description);
		update_post_meta($post_id, $prefix.'new_tab', $new_tab);
		update_post_meta($post_id, $prefix.'logo_grid', $logo_grid);
		update_post_meta($post_id, $prefix.'slide_to_show_carousel', $slide_to_show_carousel);
		update_post_meta($post_id, $prefix.'slide_to_column_carousel', $slide_to_column_carousel);
		update_post_meta($post_id, $prefix.'arrow_carousel', $arrow_carousel);
		update_post_meta($post_id, $prefix.'pagination_carousel', $pagination_carousel);
		update_post_meta($post_id, $prefix.'speed_carousel', $speed_carousel);
		update_post_meta($post_id, $prefix.'autoplay_carousel', $autoplay_carousel);
		update_post_meta($post_id, $prefix.'autoplay_speed_carousel', $autoplay_speed_carousel);		
		update_post_meta($post_id, $prefix.'centermode_carousel', $centermode_carousel);
		update_post_meta($post_id, $prefix.'space_between_carousel', $space_between_carousel);
		update_post_meta($post_id, $prefix.'loop_carousel', $loop_carousel);
		update_post_meta($post_id, $prefix.'max_height', $max_height);
		update_post_meta($post_id, $prefix.'ipad', $slide_to_show_ipad);
		update_post_meta($post_id, $prefix.'tablet', $slide_to_show_tablet);
		update_post_meta($post_id, $prefix.'mobile', $slide_to_show_mobile);
	}

	/**
	 * Add custom column to Post listing page
	 * 
	 * @since 1.0
	 */
	function lswss_posts_columns( $columns ) {

		$new_columns['lswss_shortcode'] 	= esc_html__('Shortcode', 'logo-showcase-with-slick-slider');
		$new_columns['lswss_photos'] 		= esc_html__('Number of Logos', 'logo-showcase-with-slick-slider');

		$columns = lswss_add_array( $columns, $new_columns, 1, true );

		return $columns;
	}

	/**
	 * Add custom column data to Post listing page
	 * 
	 * @since 1.0
	 */
	function lswss_post_columns_data( $column, $post_id ) {

		// Taking some variables
		$prefix = LSWSS_META_PREFIX;

		$slider_style 	= get_post_meta( $post_id, $prefix.'design_style', true );

		switch ( $column ) {
			case 'lswss_shortcode':
				echo '<div class="lswss-shortcode-preview">[slick_logo_carousel id="'.esc_attr( $post_id ).'"]</div>';			
				break;

			case 'lswss_photos':
				$total_photos = get_post_meta( $post_id, $prefix.'gallery_id', true );
				echo ! empty( $total_photos ) ? count( $total_photos ) : '--';
				break;
		}
	}

	/**
	 * Image data popup HTML
	 * 
	 * @since 1.0
	 */
	function lswss_image_update_popup_html() {

		global $post_type;

		if( $post_type == LSWSS_POST_TYPE ) {
			include_once( LSWSS_DIR .'/includes/admin/settings/lswss-img-popup.php');
		}
	}

	/**
	 * Get attachment edit form
	 * 
	 * @since 1.0
	 */
	function lswss_get_attachment_edit_form() {

		// Taking some defaults
		$result 		= array(
								'success'	=> 0,
								'msg'		=> esc_html__('Sorry, Something happened wrong.', 'logo-showcase-with-slick-slider')
							);
		$attachment_id 	= ! empty( $_POST['attachment_id'] ) ? lswss_clean_number( $_POST['attachment_id'] ) : '';

		if( ! empty( $attachment_id ) ) {

			$attachment_post = get_post( $attachment_id );

			if( ! empty( $attachment_post ) ) {
				
				ob_start();

				// Popup Data File
				include( LSWSS_DIR . '/includes/admin/settings/lswss-img-popup-data.php' );

				$attachment_data = ob_get_clean();

				$result['success'] 	= 1;
				$result['msg'] 		= esc_html__('Attachment Found.', 'logo-showcase-with-slick-slider');
				$result['data']		= $attachment_data;
			}
		}

		wp_send_json( $result );
	}

	/**
	 * Get attachment edit form
	 * 
	 * @since 1.0
	 */
	function lswss_save_attachment_data() {

		$prefix 			= LSWSS_META_PREFIX;
		$result 			= array(
								'success'	=> 0,
								'msg'		=> esc_html__('Sorry, Something happened wrong.', 'logo-showcase-with-slick-slider')
							);
		$attachment_id 		= ! empty( $_POST['attachment_id'] ) ? lswss_clean_number( $_POST['attachment_id'] ) : '';
		$form_data 			= parse_str( $_POST['form_data'], $form_data_arr );

		// Check current user can edit the attachment or not
		if ( ! current_user_can( 'edit_post', $attachment_id ) ) {
			$result['msg'] = esc_html__('Sorry, You are not allowed to edit the media.', 'logo-showcase-with-slick-slider');
			wp_send_json( $result );
		}

		if( ! empty( $attachment_id ) && ! empty( $form_data_arr ) ) {

			// Getting attachment post
			$lswss_attachment_post = get_post( $attachment_id );

			// If post type is attachment
			if( isset($lswss_attachment_post->post_type) && $lswss_attachment_post->post_type == 'attachment' ) {
				$post_args = array(
									'ID'			=> $attachment_id,
									'post_title'	=> ! empty( $form_data_arr['lswss_attachment_title'] ) ? lswss_clean_html( $form_data_arr['lswss_attachment_title'] ) : $lswss_attachment_post->post_name,
									'post_content'	=> lswss_clean_html( $form_data_arr['lswss_attachment_desc'] ),
								);
				$update = wp_update_post( $post_args );

				if( ! is_wp_error( $update ) ) {

					update_post_meta( $attachment_id, '_wp_attachment_image_alt', lswss_clean( $form_data_arr['lswss_attachment_alt'] ) );
					update_post_meta( $attachment_id, $prefix.'attachment_link', lswss_clean_url( $form_data_arr['lswss_attachment_link'] ) );

					$result['success'] 	= 1;
					$result['msg'] 		= esc_html__('Your changes saved successfully.', 'logo-showcase-with-slick-slider');
				}
			}
		}

		wp_send_json( $result );
	}
}

$lswss_admin = new Lswss_Admin();