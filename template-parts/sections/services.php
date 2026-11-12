<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$items = masar_arg( $args, 'items', array() );
if ( ! $items ) { return; }
?>
<section class="sec">
	<div class="wrap">
		<?php masar_sec_head( $args, 'خدماتنا' ); ?>
		<div class="svc-grid">
			<?php foreach ( $items as $it ) : ?>
				<div class="svc"><span class="svc-ico"><?php echo masar_icon( $it[0] ); // phpcs:ignore ?></span><h3><?php echo esc_html( $it[1] ); ?></h3><p><?php echo esc_html( $it[2] ); ?></p><a class="link-arrow" href="#">اعرف أكثر ←</a></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
