<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$items = masar_arg( $args, 'items', array() );
if ( ! $items ) { return; }
?>
<section class="stats">
	<div class="wrap stats-grid">
		<?php foreach ( $items as $it ) { echo '<div><b>' . esc_html( $it[0] ) . '</b><small>' . esc_html( $it[1] ) . '</small></div>'; } ?>
	</div>
</section>
