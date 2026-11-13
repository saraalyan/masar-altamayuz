<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$var   = masar_arg( $args, 'variant', 'insta' );
$items = masar_arg( $args, 'items', array() );
$emo   = ( 'projects' === $var ) ? array( '🛋️', '🍳', '🏡', '🛁', '🪴', '🛏️', '🏺', '🕯️' ) : array( '👗', '👒', '👜', '🧥', '👠', '💍', '🧣', '🕶️' );
?>
<section class="sec sec-tight"<?php if ( ! empty( $args['id'] ) ) { echo ' id="' . esc_attr( $args['id'] ) . '"'; } ?>>
	<div class="wrap">
		<?php masar_sec_head( $args ); ?>
		<?php if ( 'projects' === $var ) : ?>
			<div class="proj-grid">
				<?php foreach ( $items as $i => $it ) : ?>
					<a class="proj" href="#"><span class="proj-img"><?php echo masar_media( '', $emo[ $i % 8 ] ); // phpcs:ignore ?></span><b><?php echo esc_html( $it[0] ); ?></b><small><?php echo esc_html( $it[1] ); ?></small></a>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<?php if ( ! empty( $args['handle'] ) ) : ?><p class="sec-sub"><bdi dir="ltr"><?php echo esc_html( $args['handle'] ); ?></bdi></p><?php endif; ?>
			<div class="insta">
				<?php for ( $i = 0; $i < 6; $i++ ) { echo '<span class="insta-i">' . masar_media( '', $emo[ $i ] ) . '</span>'; } // phpcs:ignore ?>
			</div>
		<?php endif; ?>
	</div>
</section>
