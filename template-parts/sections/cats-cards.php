<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$items = masar_real_terms( 4 );
if ( ! $items ) { $items = masar_arg( $args, 'items', array() ); }
if ( ! $items ) { return; }
?>
<section class="sec sec-tight">
	<div class="wrap">
		<?php masar_sec_head( $args ); ?>
		<div class="cat-cards">
			<?php foreach ( $items as $it ) : ?>
				<a class="cat-card" href="<?php echo esc_url( masar_arg( $it, 'url', '#' ) ); ?>">
					<span class="cat-card-img"><?php echo masar_media( masar_arg( $it, 'image', '' ), masar_arg( $it, 'emoji', '✦' ) ); // phpcs:ignore ?></span>
					<span class="cat-card-row"><b><?php echo esc_html( $it['label'] ); ?></b><i>←</i></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
