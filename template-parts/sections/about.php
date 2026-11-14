<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<section class="sec"<?php if ( ! empty( $args['id'] ) ) { echo ' id="' . esc_attr( $args['id'] ) . '"'; } ?>>
	<div class="wrap about">
		<div class="about-media"><?php echo masar_media( masar_arg( $args, 'image', '' ), masar_arg( $args, 'emoji', '✦' ), '', masar_arg( $args, 'title', '' ) ); // phpcs:ignore ?></div>
		<div class="about-text">
			<?php if ( ! empty( $args['kicker'] ) ) : ?><span class="kicker"><?php echo esc_html( $args['kicker'] ); ?></span><?php endif; ?>
			<h2><?php echo esc_html( masar_arg( $args, 'title', __( 'من نحن', 'masar-altamayuz' ) ) ); ?></h2>
			<?php echo wp_kses_post( wpautop( esc_html( masar_arg( $args, 'text', '' ) ) ) ); ?>
			<?php if ( ! empty( $args['btn'] ) ) : ?><a class="link-arrow" href="<?php echo esc_url( masar_arg( $args, 'url', '#' ) ); ?>"><?php echo esc_html( $args['btn'] ); ?> ←</a><?php endif; ?>
		</div>
	</div>
</section>
