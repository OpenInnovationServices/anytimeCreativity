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

$prefix			= LSWSS_META_PREFIX; // Metabox prefix
$gallery_imgs	= get_post_meta( $post->ID, $prefix.'gallery_id', true );
$gallery_imgs	= ( ! empty( $gallery_imgs ) && ! is_array( $gallery_imgs ) ) ? (array)$gallery_imgs : $gallery_imgs;
$no_img_cls		= ! empty( $gallery_imgs ) ? 'lswss-hide' : '';
?>

<table class="form-table lswss-post-sett-table">
	<tbody>
		<tr valign="top">
			<th scope="row">
				<label for="lswss-gallery-imgs"><?php _e('Choose Logo Images', 'logo-showcase-with-slick-slider'); ?></label>
			</th>
			<td>
				<button type="button" class="button button-secondary lswss-img-uploader" id="lswss-gallery-imgs" data-multiple="true" data-button-text="<?php esc_html_e( 'Add to Logo Showcase', 'logo-showcase-with-slick-slider' ); ?>" data-title="<?php esc_html_e( 'Add Images to Logo Showcase', 'logo-showcase-with-slick-slider' ); ?>"><i class="dashicons dashicons-format-gallery"></i> <?php esc_html_e( 'Choose Logo Images', 'logo-showcase-with-slick-slider' ); ?></button>
				<button type="button" class="button button-secondary lswss-del-gallery-imgs"><i class="dashicons dashicons-trash"></i> <?php esc_html_e( 'Remove All Logo Images', 'logo-showcase-with-slick-slider' ); ?></button><br/>

				<div class="lswss-gallery-imgs-prev lswss-imgs-preview lswss-gallery-imgs-wrp">
					<?php if( ! empty( $gallery_imgs ) ) {
						foreach ($gallery_imgs as $img_key => $img_data) {

							$attachment_url 		= wp_get_attachment_thumb_url( $img_data );
							$attachment_edit_link	= get_edit_post_link( $img_data );
					?>
							<div class="lswss-img-wrp">
								<div class="lswss-img-tools lswss-hide">
									<span class="lswss-tool-icon lswss-edit-img dashicons dashicons-edit" title="<?php esc_html_e( 'Edit Image in Popup', 'logo-showcase-with-slick-slider' ); ?>"></span>
									<a href="<?php echo esc_url( $attachment_edit_link ); ?>" target="_blank" title="<?php esc_html_e( 'Edit Image', 'logo-showcase-with-slick-slider' ); ?>"><span class="lswss-tool-icon lswss-edit-attachment dashicons dashicons-visibility"></span></a>
									<span class="lswss-tool-icon lswss-del-tool lswss-del-img dashicons dashicons-no" title="<?php esc_html_e( 'Remove Image', 'logo-showcase-with-slick-slider' ); ?>"></span>
								</div>
								<img class="lswss-img" src="<?php echo esc_url( $attachment_url ); ?>" alt="" />
								<input type="hidden" class="lswss-attachment-no" name="lswss_img[]" value="<?php echo esc_attr( $img_data ); ?>" />
							</div>
					<?php }
					} ?>
					<p class="lswss-img-placeholder <?php echo esc_attr( $no_img_cls ); ?>"><?php _e('No Logo Images', 'logo-showcase-with-slick-slider'); ?></p>
				</div><!-- end .lswss-imgs-preview -->
				<span class="description"><?php _e('Choose your desired images for logo showcase. Hold Ctrl key to select multiple images at a time.', 'logo-showcase-with-slick-slider'); ?></span>
			</td>
		</tr>
	</tbody>
</table><!-- end .lswss-post-sett-table -->