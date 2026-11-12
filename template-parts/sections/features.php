<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$items = masar_arg( $args, 'items', array() );
if ( ! $items ) { return; }
?>
<section class="features features-<?php echo esc_attr( masar_arg( $args, 'variant', 'soft' ) ); ?>">
	<div class="wrap feat-grid">
		<?php foreach ( $items as $it ) : ?>
			<div class="feat"><span><?php echo esc_html( $it[0] ); ?></span><div><b><?php echo esc_html( $it[1] ); ?></b><small><?php echo esc_html( $it[2] ); ?></small></div></div>
		<?php endforeach; ?>
	</div>
</section>
