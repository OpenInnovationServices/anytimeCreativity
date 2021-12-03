<?php/** * 'slick-slider' Design 5 Shortcodes HTML * * @package WP Slick Slider and Image Carousel * @since 1.0.0 */if ( ! defined( 'ABSPATH' ) ) {	exit; // Exit if accessed directly}?><div class="wpsisac-image-slide">	<div class="wpsisac-slide-wrap">		<div class="wpsisac-slider-content">			<h2 class="wpsisac-slide-title"><?php the_title(); ?></h2>			<?php if( $show_content ) { ?>				<div class="wpsisac-slider-short-content"><?php the_content(); ?></div>			<?php }			$sliderurl = get_post_meta( get_the_ID(),'wpsisac_slide_link', true );			if( $sliderurl != '' ) { ?>				<div class="wpsisac-readmore"><a href="<?php echo esc_url($sliderurl); ?>" class="wpsisac-slider-readmore"><?php esc_html_e( 'Read More', 'wp-slick-slider-and-image-carousel' ); ?></a></div>			<?php } ?>		</div>	</div></div>