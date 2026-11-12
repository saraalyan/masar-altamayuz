<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$items = masar_arg( $args, 'items', array() );
if ( ! $items ) { return; }
?>
<section class="sec">
	<div class="wrap">
		<?php masar_sec_head( $args, 'آراء العملاء' ); ?>
		<div class="testi-grid">
			<?php foreach ( $items as $it ) : ?>
				<blockquote class="testi">
					<div class="stars" aria-label="5 نجوم"><?php for ( $i = 0; $i < 5; $i++ ) { echo masar_icon( 'star' ); } ?></div>
					<p>“<?php echo esc_html( $it[1] ); ?>”</p>
					<cite><span class="avatar"><?php echo esc_html( mb_substr( $it[0], 0, 1 ) ); ?></span><?php echo esc_html( $it[0] ); ?></cite>
				</blockquote>
			<?php endforeach; ?>
		</div>
	</div>
</section>
