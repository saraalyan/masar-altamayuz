<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$items = masar_real_terms( 8 );
if ( ! $items ) { $items = masar_arg( $args, 'items', array() ); }
if ( ! $items ) { return; }
?>
<section class="sec sec-tight"<?php if ( ! empty( $args['id'] ) ) { echo ' id="' . esc_attr( $args['id'] ) . '"'; } ?>>
	<div class="wrap">
		<?php masar_sec_head( $args ); ?>
		<div class="cat-circles">
			<?php foreach ( $items as $it ) : ?>
				<a class="cat-c" href="<?php echo esc_url( masar_arg( $it, 'url', '#' ) ); ?>">
					<span class="cat-c-img"><?php echo masar_media( masar_arg( $it, 'image', '' ), masar_arg( $it, 'emoji', '✦' ) ); // phpcs:ignore ?></span>
					<b><?php echo esc_html( $it['label'] ); ?></b>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
