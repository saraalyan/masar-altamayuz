<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$items = masar_arg( $args, 'items', array() );
if ( ! $items ) { return; }
?>
<section class="brands">
	<div class="wrap">
		<p class="brands-t"><?php echo esc_html( masar_arg( $args, 'title', __( 'شركاء النجاح', 'masar-altamayuz' ) ) ); ?></p>
		<div class="brands-row"><?php foreach ( $items as $b ) { echo '<span>' . esc_html( $b ) . '</span>'; } ?></div>
	</div>
</section>
