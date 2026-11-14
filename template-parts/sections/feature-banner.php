<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$bg = masar_arg( $args, 'image', '' );
?>
<section class="sec sec-tight">
	<div class="wrap">
		<div class="fbanner"<?php if ( $bg ) { echo ' style="background-image:url(' . esc_url( $bg ) . ')"'; } ?>>
			<?php if ( ! $bg ) : ?><span class="fbanner-emoji" aria-hidden="true"><?php echo masar_icon( masar_arg( $args, 'emoji', '✦' ) ); // phpcs:ignore ?></span><?php endif; ?>
			<div class="fbanner-text">
				<span class="kicker"><?php echo esc_html( masar_arg( $args, 'kicker', '' ) ); ?></span>
				<h2><?php echo esc_html( masar_arg( $args, 'title', '' ) ); ?></h2>
				<p><?php echo esc_html( masar_arg( $args, 'text', '' ) ); ?></p>
				<a class="btn btn-light" href="<?php echo esc_url( masar_arg( $args, 'url', '#' ) ); ?>"><?php echo esc_html( masar_arg( $args, 'btn', __( 'اكتشف', 'masar-altamayuz' ) ) ); ?></a>
			</div>
		</div>
	</div>
</section>
