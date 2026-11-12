<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$items = masar_arg( $args, 'items', array() );
if ( ! $items ) { return; }
$cols = count( $items ) >= 3 ? 3 : 2;
?>
<section class="sec sec-tight">
	<div class="wrap promo-grid cols-<?php echo (int) $cols; ?>">
		<?php foreach ( $items as $it ) : ?>
			<a class="promo tone-<?php echo esc_attr( masar_arg( $it, 'tone', 'mocha' ) ); ?>" href="<?php echo esc_url( masar_arg( $it, 'url', '#' ) ); ?>">
				<div class="promo-text">
					<?php if ( ! empty( $it['kicker'] ) ) : ?><span class="kicker"><?php echo esc_html( $it['kicker'] ); ?></span><?php endif; ?>
					<h3><?php echo esc_html( $it['title'] ); ?></h3>
					<?php if ( ! empty( $it['text'] ) ) : ?><p><?php echo esc_html( $it['text'] ); ?></p><?php endif; ?>
					<?php if ( ! empty( $it['badge'] ) ) : ?><b class="badge"><?php echo esc_html( $it['badge'] ); ?></b><?php endif; ?>
					<?php if ( ! empty( $it['btn'] ) ) : ?><span class="link-arrow"><?php echo esc_html( $it['btn'] ); ?> ←</span><?php endif; ?>
				</div>
				<div class="promo-media"><?php echo masar_media( masar_arg( $it, 'image', '' ), masar_arg( $it, 'emoji', '✦' ) ); // phpcs:ignore ?></div>
			</a>
		<?php endforeach; ?>
	</div>
</section>
