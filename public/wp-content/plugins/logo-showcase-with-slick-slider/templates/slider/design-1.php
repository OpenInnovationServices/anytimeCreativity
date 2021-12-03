<?php
/**
 * Slider Design File 
 *
 * @package Logo Showcase with Slick Slider
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="lswss-logo-carousel-<?php echo esc_attr( $unique ); ?>" class="lswss-logo-showcase <?php echo esc_attr( $center_mode_cls ); ?>" data-conf="<?php echo htmlspecialchars(json_encode($slider_conf)); ?>">
	<?php foreach( $images as $image ) :

		$post_mata_data		= get_post($image);
		$image_lsider 		= wp_get_attachment_image_src( $image, 'large' );
		$image_link 		= get_post_meta($image, $prefix.'attachment_link',true);
		$alt_text 			= get_post_meta($image, '_wp_attachment_image_alt', true );
	?>					
		<div class="lswss-slide">
			<?php if ( ! empty( $image_link ) ) { ?>
				<a href="<?php echo esc_url( $image_link ); ?>" <?php if( $new_tab == 'true' ) { echo 'target="_blank"'; } ?>><img src="<?php echo esc_url( $image_lsider[0] ); ?>" alt="<?php echo esc_attr( $alt_text ); ?>" /></a>
			<?php } else { ?>
				<img src="<?php echo esc_url( $image_lsider[0] ); ?>" alt="<?php echo esc_attr( $alt_text ); ?>" />
			<?php }

			if( $show_title == 'true' ) { ?>
			<div class="lswss-slide-title">
				<?php echo wp_kses_post( $post_mata_data->post_title ); ?>
			</div>
			<?php }

			if( $show_description == 'true' ) { ?>
			<div class="lswss-slide-dec">
				<?php echo wp_kses_post( wpautop( wptexturize( $post_mata_data->post_content ) ) ); ?>
			</div>
			<?php } ?>
		</div>
	<?php endforeach; ?>
</div>