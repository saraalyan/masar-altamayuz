<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$var   = masar_arg( $args, 'variant', 'insta' );
$items = masar_arg( $args, 'items', array() );
$imgs  = masar_arg( $args, 'images', array() );
if ( is_string( $imgs ) ) { $imgs = preg_split( '/\s+/', trim( $imgs ), -1, PREG_SPLIT_NO_EMPTY ); }
$imgs  = array_values( (array) $imgs );
$emo   = ( 'projects' === $var ) ? array( '🛋️', '🍳', '🏡', '🛁', '🪴', '🛏️', '🏺', '🕯️' ) : array( '👗', '👒', '👜', '🧥', '👠', '💍', '🧣', '🕶️' );
$tiles = count( $imgs ) >= 12 ? 12 : 6;
?>
<section class="sec sec-tight"<?php if ( ! empty( $args['id'] ) ) { echo ' id="' . esc_attr( $args['id'] ) . '"'; } ?>>
	<div class="wrap">
		<?php masar_sec_head( $args ); ?>
		<?php if ( 'projects' === $var ) : ?>
			<div class="proj-grid">
				<?php foreach ( $items as $i => $it ) : ?>
					<a class="proj" href="#"><span class="proj-img"><?php echo masar_media( isset( $imgs[ $i ] ) ? $imgs[ $i ] : '', $emo[ $i % 8 ] ); // phpcs:ignore ?></span><b><?php echo esc_html( $it[0] ); ?></b><small><?php echo esc_html( $it[1] ); ?></small></a>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<?php if ( ! empty( $args['handle'] ) ) : ?><p class="sec-sub"><bdi dir="ltr"><?php echo esc_html( $args['handle'] ); ?></bdi></p><?php endif; ?>
			<div class="insta">
				<?php
				for ( $i = 0; $i < $tiles; $i++ ) {
					$alt = isset( $imgs[ $i ] ) ? trim( masar_arg( $args, 'title', '' ) . ' ' . ( $i + 1 ) ) : '';
					echo '<span class="insta-i">' . masar_media( isset( $imgs[ $i ] ) ? $imgs[ $i ] : '', $emo[ $i % 8 ], '', $alt ) . '</span>'; // phpcs:ignore
				}
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
