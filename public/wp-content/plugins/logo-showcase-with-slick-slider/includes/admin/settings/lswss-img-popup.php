<?php
/**
 * Image Data Popup
 *
 * @package Logo Showcase with Slick Slider
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="lswss-img-data-wrp lswss-hide">
	<div class="lswss-img-data-cnt">

		<div class="lswss-img-cnt-block">
			<div class="lswss-popup-close lswss-popup-close-wrp"><img src="<?php echo esc_url( LSWSS_URL ); ?>assets/images/close.png" alt="<?php _e('Close (Esc)', 'logo-showcase-with-slick-slider'); ?>" title="<?php esc_html_e( 'Close (Esc)', 'logo-showcase-with-slick-slider' ); ?>" /></div>

			<div class="lswss-popup-body-wrp">
			</div><!-- end .lswss-popup-body-wrp -->
			
			<div class="lswss-img-loader"><?php _e('Please Wait', 'logo-showcase-with-slick-slider'); ?> <span class="spinner"></span></div>

		</div><!-- end .lswss-img-cnt-block -->

	</div><!-- end .lswss-img-data-cnt -->
</div><!-- end .lswss-img-data-wrp -->
<div class="lswss-popup-overlay"></div>